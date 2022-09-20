<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Incidente;
use App\Models\SECliente;
use App\Models\SGAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;

class Atenciones extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {
        $cod_user = "";
        if (session('rol') == "SK") {
            $cod_user = " and a.cod_usr_crea = ".session('idUser');
        }
        $act = Consulta::selecciona('sgkma_actividad',['id','dsc_actividad'],[['flg_activo','=',1]]);
        $t_sop = Consulta::selecciona('sgkma_tipo_soporte',['id','dsc_tipo_soporte'],[['flg_activo','=',1]]);
        $cli = SECliente::where('flg_activo',1)->whereNotIn('id', [1])->get();
        $t_ate = Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion'],[['flg_activo','=',1]]);
        $s = ['a.id','i.titulo','ac.dsc_actividad','s.dsc_tipo_soporte','c.dsc_cliente','a.fch_atencion','a.hra_inicio','a.hra_fin','a.tiempo_hora','u.dsc_usuario'];
        $tables = [
            'sgkma_incidentes as i'=>['a.idIncidencia','=','i.id'],
            'sgkma_actividad as ac'=>['a.cod_actividad','=','ac.id'],
            'sgkma_tipo_soporte as s'=>['a.cod_soporte','=','s.id'],
            'sgkma_cliente as c'=>['a.cod_cliente','=','c.id'],
            'sgkma_usuario as u'=>['a.cod_usr_crea','=','u.id']
        ];
        $w = "a.fch_atencion between '".date('Y-m-01')."' and '".date('Y-m-t')."'".$cod_user;
        $ate = Consulta::union('sgkma_atenciones as a',$tables,$s,$w,'a.fch_atencion');
        $hra_fin= new DateTime();
        $hra_fin->modify('+5 minute');
        $horaInicio = new DateTime(date('H:i:s'));
        $horaTermino = new DateTime($hra_fin->format('H:i:s'));
        $fch_hra_fin = $hra_fin->format('Y-m-d H:i:s');
        $interval = $horaInicio->diff($horaTermino);
        // dd($interval->format('%H:%i:%s'));
        return view('atenciones',compact('act','t_sop','cli','t_ate','ate','fch_hra_fin','interval'));
    }

    public function getSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            if (!empty($re->inc)) {
                $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$re->id],['flg_activo','=',1]]);
                $data['eq'] = Consulta::selecciona('sgkca_equipo',['id','dsc_equipo'],[['cod_cliente','=',$re->id]]);
                return $data;
            }
            return Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$re->id],['flg_activo','=',1]]);
        }
    }

    public function getUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$re->cli],['idSucursal','=',$re->suc],['flg_activo','=',1]]);
        }
    }

    public function incidenciaCliente(Request $re) {
        if ($re->isMethod('POST')) {
            return Incidente::select('id','titulo')->where('idCliente',$re->id)->whereRaw('(estado = 1 or estado = 2)')->get();
        }
    }

    public function getSucursalUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $inc = Incidente::select('titulo','idSucursal','idUsuario')->where('id',$re->inc)->where('idCliente',$re->cli)->first();
            $data['inc'] = $inc->titulo;
            $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['id','=',$inc->idSucursal]]);
            $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['id','=',$inc->idUsuario]]);
            return $data;
        }
    }

    public function saveAtencion(Request $re) {
        if ($re->isMethod('POST')) {
            
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                // 'cod_actividad' => 'required|integer',
                'cod_soporte' => 'required|integer',
                'cod_cliente' => 'required|integer',
                'cod_sucursal' => 'required|integer',
                // 'cod_atencion' => 'required|integer',
                'usuario' => 'required|string',
                'daterange' => 'required|string',
                'evento' => 'required|string'
            ]);
            
            if ($v->fails()) {
                // return $v->errors();
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            
            try {
                $num_dia = Consulta::selecciona('sgkma_dias_atenciones',['dias'],[['id','=',1]]);
                $f_act = date_create(date('Y-m-d'));
                $f_ate = date_create($re->fch_atencion);
                $dias = date_diff($f_act, $f_ate);
                
                if (!empty($re->xid)) {
                    $ate = SGAtencion::select('fch_atencion')->where('id',$re->xid)->first();
                    $f_at = date_create($ate->fch_atencion);
                    $dif = date_diff($f_act, $f_at);
                    if ($dif->d > $num_dia[0]->dias) {
                        return ['confirm'=>0,'msg'=>'No puedes guardar con mas de '.$num_dia[0]->dias.' dia(s) de antiguedad'];
                    }
                    $id = $re->xid;
                    unset($re['_token']);
                    unset($re['xid']);
                    SGAtencion::where('id',$id)->update($re->all());
                    return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                }

                if ($dias->d > $num_dia[0]->dias) {
                    return ['confirm'=>0,'msg'=>'No puedes guardar con mas de '.$num_dia[0]->dias.' dia(s) de antiguedad'];
                }

                if (!empty($re->inc)) {
                    $data = ['idCliente'=>$re->cod_cliente,'idSucursal'=>$re->cod_sucursal,'idUsuario'=>$re->usuario,'idTipoIncidencia'=>1,'fch_crea'=>date('Y-m-d'),'tiempo_hora'=>date('H:i:s'),'titulo'=>$re->evento,'obs'=>$re->evento,'estado'=>2,'cod_usr_crea'=>$idUser];
                    $re['idIncidencia'] = Consulta::ingreso('sgkma_incidentes',$data);
                }
                // if ($re->hra_inicio > $re->hra_fin) {
                //     return ['confirm'=>0,'msg'=>'La hora Final no puede ser menor a la hora Inicial'];
                // }
                $fechas = explode(" - ",$re->daterange);
                $fch_hra_atencion = explode(" ",$fechas[0]);
                $fch_hra_fin = explode(" ",$fechas[1]);
                $re['fch_atencion'] = $fch_hra_atencion[0];
                $re['hra_inicio'] = $fch_hra_atencion[1];
                $re['fch_atencion_fin'] = $fch_hra_fin[0];
                $re['hra_fin'] = $fch_hra_fin[1];
                $a = SGAtencion::create($re->all());
                $horaInicio = new DateTime($fechas[0]);
                $horaTermino = new DateTime($fechas[1]);
                $interval = $horaInicio->diff($horaTermino);
                // dd($interval);
                if ($interval->format('%d') > 0) {
                    $hras = $interval->format('%d') * 24;
                    $hra = $hras + substr($interval->format('%H:%i:%s'),0,2);
                    $tiempo_hora = $hra.substr($interval->format('%H:%i:%s'),2,8);
                } else {
                    $tiempo_hora = $interval->format('%H:%i:%s');
                }
                // dd($tiempo_hora);
                $a->tiempo_hora = $tiempo_hora;
                $a->cod_usr_crea = $idUser;
                $a->save();
                if (!empty($re->idIncidencia)) {
                    Consulta::actualiza('sgkma_incidentes',['estado'=>2],[['id','=',$re->idIncidencia]]);
                }
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function obtener(Request $re) {
        if ($re->isMethod('POST')) {
            $ate = SGAtencion::where('id',$re->id)->first();
            $data['ate'] = $ate;
            $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$ate->cod_cliente],['flg_activo','=',1]]);
            $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$ate->cod_cliente],['idSucursal','=',$ate->cod_sucursal],['flg_activo','=',1]]);
            $data['inc'] = Incidente::select('id','titulo')->where('idCliente',$ate->cod_cliente)->whereRaw('(estado = 1 or estado = 2)')->get();
            $data['tat'] = Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion'],[['flg_activo','=',1]]);
            return $data;
        }
    }

    public function search(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "SK") {
                    $re['cod_user'] = session('idUser');
                }
                $re['op'] = 2;
                return Consulta::filtro($re->all());
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function diferentHora(Request $re) {
        if ($re->isMethod('POST')) {
            // dd($re->fec_hra);
            $fechas = explode(" - ",$re->fec_hra);
            $hra_ini = explode(" ",$fechas[0]);
            $hra_fin = explode(" ",$fechas[1]);
            if (($hra_ini[0] == $hra_fin[0]) && ($hra_ini[1] > $hra_fin[1])) {
                return 'Inválido';
            }
            $horaInicio = new DateTime($fechas[0]);
            $horaTermino = new DateTime($fechas[1]);
            $interval = $horaInicio->diff($horaTermino);
            // dd($interval);
            if ($interval->format('%d') > 0) {
                $hras = $interval->format('%d') * 24;
                $hra = $hras + substr($interval->format('%H:%i:%s'),0,2);
                $tiempo_hora = $hra.substr($interval->format('%H:%i:%s'),2,8);
            } else {
                $tiempo_hora = $interval->format('%H:%i:%s');
            }
            return $tiempo_hora;
        }
    }
}
