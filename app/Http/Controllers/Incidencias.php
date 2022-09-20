<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Incidente;
use App\Models\SECliente;
use App\Models\SEEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Incidencias extends Controller
{
    protected $user_session;
    protected $rol;
    public function __construct() {
        // $this->middleware('admin');
        $this->middleware('autenticado');
    }
    
    public function index() {
        $this->user_session = session('rol');
        $cc = '';
        $estados = SEEstado::where('cod_tabla','INC')->orderBy('orden')->get();
        $tarjetas = [];
        if ($this->user_session === 'AD' || $this->user_session === 'US') {
            $w = "i.fch_crea between '".date('Y-m-01')."' and '".date('Y-m-t')."' and i.idCliente = ".session('idCliente');
            $cli = SECliente::where('flg_activo',1)->where('id', session('idCliente'))->get();
            $suc = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',session('idCliente')],['flg_activo','=',1]]);
            $cc = 1;
            $soporte = [];
            foreach ($estados as $e) {
                $tarjetas[$e->dsc_estado]['color'] = $e->color;
                $tarjetas[$e->dsc_estado]['cantidad'] = Incidente::whereBetween('fch_crea', [date('Y-m-01'), date('Y-m-t')])->where('idCliente',session('idCliente'))->where('estado',$e->id)->count();
            }
        } else {
            $w = "i.fch_crea between '".date('Y-m-01')."' and '".date('Y-m-t')."'";
            $cli = SECliente::where('flg_activo',1)->whereNotIn('id', [1])->get();
            $suc = [];
            $soporte = Consulta::selecciona('sgkma_usuario',['id','dsc_usuario'],'(rol = 4 or rol = 5)');
            foreach ($estados as $e) {
                $tarjetas[$e->dsc_estado]['color'] = $e->color;
                $tarjetas[$e->dsc_estado]['cantidad'] = Incidente::whereBetween('fch_crea', [date('Y-m-01'), date('Y-m-t')])->where('estado',$e->id)->count();
            }
        }
        $tables = [
                    'sgkma_cliente as cli'=>['i.idCliente','=','cli.id'],
                    'sgkma_tipo_atencion as ta'=>['ta.id','=','i.idTipoIncidencia'],
                    'sgkma_estado as e'=>['e.id','=','i.estado']
                ];
        $left = ['sgkma_usuario as u'=>['i.usu_soporte','=','u.id']];
        $s = ['i.*','cli.dsc_cliente','ta.dsc_tipo_atencion','e.dsc_estado','u.dsc_usuario'];
        $inc = Consulta::union('sgkma_incidentes as i',$tables,$s,$w,'',$left);
        $act = Consulta::selecciona('sgkma_actividad',['id','dsc_actividad'],[['id','=',1]]);
        $t_ate = Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion'],[['flg_activo','=',1]]);
        $t_sop = Consulta::selecciona('sgkma_tipo_soporte',['id','dsc_tipo_soporte'],[['flg_activo','=',1]]);
        // dd($tarjetas);
        return view('incidentes',compact('cli','inc','estados','cc','suc','soporte','t_ate','act','t_sop','tarjetas'));
    }

    public function saveIncidencia(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'idSucursal' => 'required|integer',
                'idUsuario' => 'required|string',
                'idTipoIncidencia' => 'required|integer',
                'fch_crea' => 'required|date',
                'tiempo_hora' => 'required|date_format:H:i',
                'titulo' => 'required|string'
            ]);
            if ($v->fails()) {
                // return $v->errors();
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }

            try {
                if (!empty($re->xid)) {
                    $inc = Incidente::select('estado')->where('id',$re->xid)->first();
                    if ($inc->estado != 1) {
                        return ['confirm'=>0,'msg'=>'Solo se actualiza en estado Pendiente'];
                    }
                    $id = $re->xid;
                    unset($re['_token']);
                    unset($re['xid']);
                    Incidente::where('id',$id)->update($re->all());
                    return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                }
                $a = Incidente::create($re->all());
                $a->cod_usr_crea = $idUser;
                $a->estado = 17;
                $a->save();
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$re->cli],['idSucursal','=',$re->suc],['flg_activo','=',1]]);
        }
    }

    public function editaIncidencia(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $inc = Incidente::where('id',$re->id)->first();
                $data['inc'] = $inc;
                $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$inc->idCliente],['flg_activo','=',1]]);
                $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$inc->idCliente],['idSucursal','=',$inc->idSucursal],['flg_activo','=',1]]);
                $data['eq'] = Consulta::selecciona('sgkca_equipo',['id','dsc_equipo'],[['cod_cliente','=',$inc->idCliente]]);
                return $data;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function obtenerIncidencia(Request $re) {
        if ($re->isMethod('POST')) {
            $inc = Incidente::where('id',$re->id)->first();
            $data['inc'] = $inc;
            $data['cliente'] = SECliente::select('id','dsc_cliente')->where('id',$inc->idCliente)->first();
            $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['id','=',$inc->idSucursal]]);
            $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['id','=',$inc->idUsuario]]);
            return $data;
        }
    }

    public function detalle(Request $re) {
        if ($re->isMethod('POST')) {
            $s = ['a.id','i.titulo','s.dsc_tipo_soporte','c.dsc_cliente','a.fch_atencion','a.hra_inicio','a.hra_fin','a.tiempo_hora','u.dsc_usuario'];
            $tables = [
                'sgkma_incidentes as i'=>['a.idIncidencia','=','i.id'],
                // 'sgkma_actividad as ac'=>['a.cod_actividad','=','ac.id'],
                'sgkma_tipo_soporte as s'=>['a.cod_soporte','=','s.id'],
                'sgkma_cliente as c'=>['a.cod_cliente','=','c.id'],
                'sgkma_usuario as u'=>['a.cod_usr_crea','=','u.id']
            ];
            $w = [['a.idIncidencia','=',$re->id]];
            $deta = Consulta::union('sgkma_atenciones as a',$tables,$s,$w);
            if (count($deta) > 0) {
                $div = '<table class="table mb-0">';
                $div .= '<thead class="thead-light">';
                $div .= '<tr>';
                $div .= '<th class="text-center">#</th>';
                $div .= '<th class="text-center">INCIDENTE</th>';
                // $div .= '<th class="text-center">ACTIVIDAD</th>';
                $div .= '<th class="text-center">TIPO SOPORTE</th>';
                $div .= '<th class="text-center">CLIENTE</th>';
                $div .= '<th class="text-center">FECHA</th>';
                $div .= '<th class="text-center">HORA INICIO</th>';
                $div .= '<th class="text-center">HORA FIN</th>';
                $div .= '<th class="text-center">TIEMPO ATENDIDO</th>';
                $div .= '<th class="text-center">ATENDIDO POR</th>';
                $div .= '</tr>';
                $div .= '</thead>';
                $div .= '<tbody>';
                $i = 1;
                foreach ($deta as $d) {
                    $div .= '<tr>';
                    $div .= '<td class="text-center">'.$i.'</td>';
                    $div .= '<td>'.$d->titulo.'</td>';
                    // $div .= '<td>'.$d->dsc_actividad.'</td>';
                    $div .= '<td>'.$d->dsc_tipo_soporte.'</td>';
                    $div .= '<td>'.$d->dsc_cliente.'</td>';
                    $div .= '<td>'.$d->fch_atencion.'</td>';
                    $div .= '<td>'.$d->hra_inicio.'</td>';
                    $div .= '<td>'.$d->hra_fin.'</td>';
                    $div .= '<td>'.$d->tiempo_hora.'</td>';
                    $div .= '<td>'.$d->dsc_usuario.'</td>';
                    $div .= '</tr>';
                    $i++;
                }
                $div .= '</tbody>';
                $div .= '</table>';
            } else {
                $div = '<div class="alert alert-danger">No hay datos a mostrar</div>';
            }
            return $div;
        }
    }

    public function cerrarIncidencia(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $idUser = session('idUser');
                $data = ['estado'=>3,'cod_usr_cierra'=>$idUser];
                $act = Consulta::actualiza('sgkma_incidentes',$data,[['id','=',$re->id]]);
                if ($act > 0) {
                    return ['confirm'=>1,'msg'=>"Incidencia cerrado satisfactoriamente"];
                } else {
                    return ['confirm'=>0,'msg'=>"Error incidencia no cerrado"];
                }
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function search(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $re['op'] = 1;
                return Consulta::filtro($re->all());
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
}
