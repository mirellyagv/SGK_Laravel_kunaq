<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\SECliente;
use App\Models\SEEstado;
use App\Models\SEMarca;
use App\Models\SEModelo;
use App\Models\SEPeriferico;
use App\Models\SGEquipo;
use App\Models\SGSucursal;
use Carbon\Carbon;
// use Facade\Ignition\Exceptions\ViewExceptionWithSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Configuracion extends Controller
{
    private $moneda;
    public function __construct() {
        $this->middleware('admin');
        $this->moneda = Consulta::selecciona('sgkma_moneda',['id','dsc_moneda','dsc_abrev'],[['flg_activo','=',1]]);
    }

    public function index() {
        return view('configuracion');
    }
    // METODOS CLIENTE
    public function misClientes() {
        $cli = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->orderBy('dsc_cliente')->get();
        $suc = SGSucursal::clienteSucursal();
        $t = ['sgkma_cliente as c'=>['c.id','=','cu.cod_cliente'],'sgkma_sucursal as s'=>['s.id','=','cu.idSucursal']];
        $s = ['cu.id','cu.nombres','cu.apellidos','cu.cargo','c.dsc_cliente','s.dsc_sucursal','cu.flg_activo','cu.user_kunaq','cu.telefono','cu.email'];
        $order = ['asc'=>'cu.nombres'];
        $usu = Consulta::union('sgkma_cliente_usuarios as cu',$t,$s,'',$order);
        return view('configuracion/clientes',compact('cli','suc','usu'));
    }

    public function manCliente(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_cliente' => 'required|string',
                'dsc_ruc' => 'required|numeric|digits:11',
                'fch_inicio' => 'required|date',
                'fch_vencimiento' => 'required|date'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }

            try {
                $cons = Consulta::selecciona('sgkma_cliente',['dsc_ruc'],[['dsc_ruc','=',$re->dsc_ruc]]);
                
                if ($re->fch_inicio >= $re->fch_vencimiento) {
                    return ['confirm'=>0,'msg'=>'La fecha inicio no puede ser mayor o igual a la fecha fin'];
                }

                if (!empty($re->xid)) {
                    if ($cons[0]->dsc_ruc != $re->dsc_ruc) {
                        $cons = Consulta::selecciona('sgkma_cliente',['dsc_ruc'],[['dsc_ruc','=',$re->dsc_ruc]]);
                        if (count($cons) > 0) {
                            return ['confirm'=>0,'msg'=>'Número de ruc ya existe ingrese otro!'];
                        }
                    }
                    $data = ['dsc_cliente'=>$re->dsc_cliente,'dsc_ruc'=>$re->dsc_ruc,'telefono'=>$re->telefono,'email'=>$re->email,'observaciones'=>$re->observaciones,'direccion'=>$re->direccion,'fch_inicio'=>$re->fch_inicio,'fch_vencimiento'=>$re->fch_vencimiento,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    if (!empty($re->contacto)) {
                        Consulta::actualiza('sgkma_cliente_usuarios',['user_kunaq' => null],[['cod_cliente','=',$re->xid],['user_kunaq','=',1]]);
                        Consulta::actualiza('sgkma_cliente_usuarios',['user_kunaq' => 1],[['id','=',$re->contacto],['cod_cliente','=',$re->xid]]);
                    }
                    $save_cli = SECliente::where('id',$re->xid)->update($data);
                    if ($save_cli > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    } else {
                        return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                    }
                }
                if (count($cons) > 0) {
                    return ['confirm'=>0,'msg'=>'Número de ruc ya existe ingrese otro!'];
                }

                $c = SECliente::create($re->all());
                $c->cod_usr_crea = $idUser;
                $c->save();
                $lastId = $c->id;
                if ($lastId) {
                    $ser = Consulta::selecciona('sgkma_servicio',['id','dsc_servicio'],[['flg_activo','=',1]]);
                    if (count($ser) > 0) {
                        foreach ($ser as $s) {
                            $data = ['idCliente'=>$lastId,'idServicio'=>$s->id,'flg_activo'=>false,'cod_usr_registro'=>$idUser];
                            Consulta::ingreso2('sgkma_cliente_servicio',$data);
                        }
                    }
                    
                }
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getCliente(Request $re) {
        if ($re->isMethod('POST')) {
            $data['cli'] = SECliente::where('id',$re->id)->get();
            $data['con'] = Consulta::selecciona('sgkma_cliente_usuarios',['nombres','apellidos','cargo','telefono','email'],'cod_cliente = '.$re->id.' and user_kunaq = 1');
            $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos','cargo'],'cod_cliente = '.$re->id.' and user_kunaq is null');
            return $data;
        }
    }

    public function desactivarCliente(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SECliente::where('id',$re->id)->update(['flg_activo' => 0,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function activarCliente(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SECliente::where('id',$re->id)->update(['flg_activo' => 1,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function filtroCliente(Request $re) {
        if ($re->isMethod('POST')) {
            return SECliente::where('flg_activo',$re->c_estado)->whereNotIn('id',[1])->orderBy('dsc_cliente')->get();
        }
    }
    // METODOS CLIENTE - SUCURSAL
    public function manSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_cliente' => 'required|integer',
                'dsc_sucursal' => 'required|string',
                'dsc_direccion' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }

            try {
                if ($re->s_xid) {
                    $data = ['cod_cliente'=>$re->cod_cliente,'dsc_sucursal'=>$re->dsc_sucursal,'dsc_direccion'=>$re->dsc_direccion,'observaciones'=>$re->observaciones,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    $save_suc = SGSucursal::where('id',$re->s_xid)->update($data);
                    if ($save_suc > 0) {
                        foreach ($re->ubi as $u) {
                            if ($u) {
                                Consulta::ingreso2('sgkma_ubicaciones',['cod_cliente'=>$re->cod_cliente,'cod_sucursal'=>$re->s_xid,'dsc_ubicaciones'=>$u]);
                            }
                        }
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    } else {
                        return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                    }
                }
                $c = SGSucursal::create($re->all());
                $c->cod_usr_crea = $idUser;
                $c->save();
                if ($c->id) {
                    foreach ($re->ubi as $u) {
                        if ($u) {
                            Consulta::ingreso2('sgkma_ubicaciones',['cod_cliente'=>$re->cod_cliente,'cod_sucursal'=>$c->id,'dsc_ubicaciones'=>$u]);
                        }
                    }
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Error no se guardaron los datos'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            $suc = SGSucursal::where('id',$re->id)->get();
            $data['suc'] = $suc;
            $data['ubi'] = Consulta::selecciona('sgkma_ubicaciones',['id','dsc_ubicaciones'],[['cod_cliente','=',$suc[0]->cod_cliente],['cod_sucursal','=',$suc[0]->id]],'dsc_ubicaciones');
            return $data;
        }
    }

    public function desactivarSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SGSucursal::where('id',$re->id)->update(['flg_activo' => 0,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function activarSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SGSucursal::where('id',$re->id)->update(['flg_activo' => 1,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function filtroSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            return SGSucursal::clienteSucursal($re->s_cod_cliente);
        }
    }

    public function updateUbicacion(Request $re) {
        if ($re->isMethod('POST')) {
            $up = Consulta::actualiza('sgkma_ubicaciones',['dsc_ubicaciones'=>$re->text],[['id','=',$re->id]]);
            if ($up > 0) {
                return ['confirm'=>1,'msg'=>'Se actualizó satisfactoriamente'];
            }
            return ['confirm'=>0,'msg'=>'No se actualizó'];
        }
    }

    public function deleteUbicacion(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $eq_ubi = Consulta::selecciona('sgkca_equipo',['cod_ubicacion'],[['cod_ubicacion','=',$re->id]]);
                if (count($eq_ubi) > 0) {
                    return ['confirm'=>0,'msg'=>'No se puede eliminar esta ubicación tiene un equipo asignado'];
                }
                $del = Consulta::elimina('sgkma_ubicaciones',[['id','=',$re->id]]);
                if ($del > 0) {
                    return ['confirm'=>1,'msg'=>'Se eliminó satisfactoriamente'];
                }
                return ['confirm'=>0,'msg'=>'No se elimino consulte con su administrador'];
            } catch (\Throwable $e) {
                return 'Comuniquese cno su administrador';
            }
        }
    }
    // METODOS CLIENTE - USUARIO
    public function clienteSucursal(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$re->id],['flg_activo','=',1]]);
        }
    }

    public function manUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_cliente' => 'required|integer',
                'cod_sucursal' => 'required|integer',
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'cargo' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }

            try {
                $data = ['cod_cliente'=>$re->cod_cliente,'idSucursal'=>$re->cod_sucursal,'nombres'=>$re->nombres,'apellidos'=>$re->apellidos,'cargo'=>$re->cargo,'fch_nacimiento'=>$re->fch_nacimiento,'telefono'=>$re->telefono,'email'=>$re->email,'direccion'=>$re->direccion];
                if (!empty($re->u_xid)) {
                    $data['cod_usr_modifica'] = $idUser;
                    $data['updated_at'] = Carbon::now();
                    $s_u = Consulta::actualiza('sgkma_cliente_usuarios',$data,[['id','=',$re->u_xid]]);
                    if ($s_u > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    } else {
                        return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                    }
                }
                $data['cod_usr_crea'] = $idUser;
                $u = Consulta::ingreso('sgkma_cliente_usuarios',$data);
                if ($u > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $usu = Consulta::selecciona('sgkma_cliente_usuarios',['id','cod_cliente','idSucursal','nombres','apellidos','cargo','fch_nacimiento','telefono','email','direccion'],[['id','=',$re->id]]);
            $data['usu'] = $usu;
            $data['suc'] = Consulta::selecciona('sgkma_sucursal',['id','dsc_sucursal'],[['cod_cliente','=',$usu[0]->cod_cliente]]);
            return $data;
        }
    }

    public function desactivarUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                if ($re->fec_fin > date('Y-m-d')) {
                    return ['confirm'=>0,'msg'=>'La fecha ingresada no puede ser mayor a la fecha actual'];
                }
                $eq = Consulta::selecciona('sgkma_asignaciones',['cod_equipo'],[['cod_cliente_usuario','=',$re->id]]);
                if (count($eq) > 0) {
                    foreach ($eq as $q) {
                        SGEquipo::where('id',$q->cod_equipo)->update(['cod_estado'=>9]);
                    }
                }
                Consulta::actualiza('sgkma_asignaciones',['fch_final'=>$re->fec_fin],[['cod_cliente_usuario','=',$re->id]]);
                $up = Consulta::actualiza('sgkma_cliente_usuarios',['flg_activo' => 0,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()],[['id','=',$re->id]]);
                if ($up > 0) {
                    return ['confirm'=>1,'msg'=>'Se desactivo y liberó los equipos asignados a este usuario.'];
                }
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function activarUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return Consulta::actualiza('sgkma_cliente_usuarios',['flg_activo' => 1,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()],[['id','=',$re->id]]);
            } catch (\Throwable $e) {
               return $e->getMessage();
            }
        }
    }

    public function filtroUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $cli = ''; $suc = '';
            if (!empty($re->u_cod_cliente)) {
                $cli = 'cu.cod_cliente = '.$re->u_cod_cliente;
            }
            if (!empty($re->u_sucursal)) {
                $suc = ' and cu.idSucursal = '.$re->u_sucursal;
            }
            $t = ['sgkma_cliente as c'=>['c.id','=','cu.cod_cliente'],'sgkma_sucursal as s'=>['s.id','=','cu.idSucursal']];
            $s = ['cu.id','cu.nombres','cu.apellidos','cu.cargo','c.dsc_cliente','s.dsc_sucursal','cu.flg_activo','cu.user_kunaq','cu.telefono','cu.email'];
            $order = ['asc'=>'cu.nombres'];
            $w = $cli.$suc;
            $usu = Consulta::union('sgkma_cliente_usuarios as cu',$t,$s,$w,$order);
            return $usu;
        }
    }
    // METODOS EQUIPO
    public function equipos() {
        $data = ['cod_cliente'=>0,'cod_periferico'=>0,'cod_marca'=>0,'cod_estado'=>0];
        $cli = SECliente::select(['id','dsc_cliente'])->where('flg_activo',1)->whereNotIn('id',[1])->orderby('dsc_cliente')->get();
        $per = SEPeriferico::select(['id','dsc_periferico'])->where('flg_activo',1)->orderby('dsc_periferico')->get();
        $mar = SEMarca::select(['id','dsc_marca'])->where('flg_activo',1)->orderby('dsc_marca')->get();
        $est = SEEstado::select(['id','dsc_estado'])->where([['flg_activo','=',1],['cod_tabla','=','EQ']])->orderby('orden')->get();
        $eq = Consulta::filtroEquipo($data);//SGEquipo::clientes();
        $tp = Consulta::selecciona('sgkma_tipo_propiedad',['id','dsc_tipo_propiedad'],[['flg_activo','=',1]],['asc'=>'dsc_tipo_propiedad']);
        $prov = Consulta::selecciona('sgkma_proveedor',['id','dsc_proveedor'],[['flg_activo','=',1]],['asc'=>'dsc_proveedor']);
        $pro = Consulta::selecciona('sgkma_procesador',['id','dsc_procesador'],[['flg_activo','=',1]],['asc'=>'dsc_procesador']);
        $mon = $this->moneda;
        $tipo_man = Consulta::selecciona('sgkma_tipo',['cod_tipo','dsc_tipo'],[['cod_tabla','=','MNT'],['flg_activo','=',1]]);
        $est_man = SEEstado::select(['id','dsc_estado'])->where([['flg_activo','=',1],['cod_tabla','=','MNT']])->orderby('orden')->get();
        $cat = Consulta::selecciona('sgkma_categoria_software',['id','dsc_categoria'],[['flg_activo','=',1]],['asc'=>'dsc_categoria']);
        return view('configuracion/equipos',compact('cli','per','mar','est','eq','tp','prov','pro','mon','tipo_man','est_man','cat'));
    }

    public function sucursalEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            return SGSucursal::select('id','dsc_sucursal')->where('cod_cliente',$re->id)->where('flg_activo',1)->get();
        }
    }

    public function ubicacionEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_ubicaciones',['id','dsc_ubicaciones'],[['cod_cliente','=',$re->cli],['cod_sucursal','=',$re->suc],['flag','=',1]],'dsc_ubicaciones');
        }
    }

    public function obtenerModelo(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_modelo',['id','dsc_modelo'],[['cod_periferico','=',$re->per],['cod_marca','=',$re->mar],['flg_activo','=',1]],'dsc_modelo');
        }
    }

    public function manEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_sucursal' => 'required|integer',
                'cod_ubicacion' => 'required|integer',
                'cod_marca' => 'required|integer',
                'cod_periferico' => 'required|integer',
                'cod_modelo' => 'required|integer',
                'cod_estado' => 'required|integer',
                'cod_cliente' => 'required|integer',
                'dsc_equipo' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                if (!empty($re->id)) {
                    unset($re['_token']);
                    $re['cod_usr_modifica'] = $idUser;
                    $re['updated_at'] = Carbon::now();
                    $save_cli = SGEquipo::where('id',$re->id)->update($re->all());
                    if ($save_cli > 0) {
                        $this->eliminarSucursalUbicacion($re->id,$re->cod_sucursal,$re->cod_ubicacion);
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    } else {
                        return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                    }
                }
                
                $e = SGEquipo::create($re->all());
                $e->cod_usr_crea = $idUser;
                $e->save();
                if ($e->id) {
                    $this->eliminarSucursalUbicacion($e->id,$re->cod_sucursal,$re->cod_ubicacion);
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'No se guardo los datos satisfactoriamente'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminarSucursalUbicacion($id,$suc,$ubi) {
        Consulta::elimina('sucursal_ubicacion',['idEquipo'=>$id]);
        Consulta::ingreso2('sucursal_ubicacion',['idEquipo'=>$id,'idSucursal'=>$suc,'idUbicacion'=>$ubi]);
    }

    public function getEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            $eq = SGEquipo::where('id',$re->id)->get();
            $data['eq'] = $eq;
            $data['suc'] = SGSucursal::select('id','dsc_sucursal')->where('cod_cliente',$eq[0]->cod_cliente)->where('flg_activo',1)->orderby('dsc_sucursal')->get();
            $data['ubi'] = Consulta::selecciona('sgkma_ubicaciones',['id','dsc_ubicaciones'],[['cod_cliente','=',$eq[0]->cod_cliente],['cod_sucursal','=',$eq[0]->cod_sucursal]],['asc'=>'dsc_ubicaciones']);
            $data['mod'] = Consulta::selecciona('sgkma_modelo',['id','dsc_modelo'],[['cod_marca','=',$eq[0]->cod_marca],['cod_periferico','=',$eq[0]->cod_periferico]],['asc'=>'dsc_modelo']);
            return $data;
        }
    }

    public function desactivarEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SGEquipo::where('id',$re->id)->update(['flg_activo' => 0,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function filtroEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                return Consulta::filtroEquipo($re->all());
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function clienteUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $t = ['sgkca_equipo as e'=>['a.cod_equipo','=','e.id'],
                    'sgkma_cliente_usuarios as cu'=>['a.cod_cliente_usuario','=','cu.id'],
                    'sgkma_cliente as c'=>['cu.cod_cliente','=','c.id']];
                $s = ['a.id','cu.cod_cliente','e.dsc_equipo','cu.id as cli_usu','cu.nombres','cu.apellidos','c.dsc_cliente','a.fch_inicio','a.fch_final','a.obs'];
                $w = [['a.cod_equipo','=',$re->id]];
                $order = ['desc'=>'a.created_at'];
                
                $usu['cli_usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$re->cli],['flg_activo','=',1]],'nombres, apellidos');
                $usu['asig_usu'] = Consulta::union('sgkma_asignaciones as a',$t,$s,$w,$order);
                if (count($usu['asig_usu']) > 0) {
                    foreach ($usu['asig_usu'] as $k => $v) {
                        ($k===0) ? $usu_act = 1 : $usu_act = 0;
                        $usu['asig_usu'][$k] = $v;
                        $usu['asig_usu'][$k]->active = $usu_act;
                    }
                }
                return $usu;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function guardAsignacion(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'fch_inicio' => 'required|date',
                'cod_cliente_usuario' => 'required|integer'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $f_f = null;
                $cons = Consulta::selecciona('sgkma_asignaciones',['fch_inicio','fch_final'],[['cod_equipo','=',$re->c_e]]);
                if (count($cons) > 0) {
                    if (empty($cons[0]->fch_final)) {
                        return ['confirm'=>0,'msg'=>'Equipo se encuentra asignado sin fecha final'];
                    }
                    if (!empty($cons[0]->fch_inicio) && !empty($cons[0]->fch_final)) {
                        if ($re->fch_inicio >= $cons[0]->fch_inicio && $re->fch_inicio <= $cons[0]->fch_final) {
                            return ['confirm'=>0,'msg'=>'Equipo se encuentra asignado en las fechas ingresadas'];
                        }
                    }
                }
                if (!empty($re->fch_final)) {
                    $f_f = $re->fch_final;
                    if ($re->fch_inicio >= $re->fch_final) {
                        return ['confirm'=>0,'msg'=>'La fecha inicial no puede ser mayor o igual a la final'];
                    }
                }
                $data = ['cod_equipo'=>$re->c_e,'cod_cliente_usuario'=>$re->cod_cliente_usuario,'fch_inicio'=>$re->fch_inicio,'fch_final'=>$f_f,'obs'=>$re->obs,'cod_usr_crea'=>$idUser];
                $asg = Consulta::ingreso('sgkma_asignaciones',$data);
                if ($asg > 0) {
                    SGEquipo::where('id',$re->c_e)->update(['cod_estado'=>8]);
                    return ['confirm'=>1,'msg'=>'Se guardo satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Error no se guardo el registro!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    
    public function getHistoria(Request $re) {
        if ($re->isMethod('POST')) {
            // $res['usuario'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['id','<>',$re->cli_usu],['cod_cliente','=',$re->cli],['flg_activo','=',1]]);

            $res['fecha'] = Consulta::selecciona('sgkma_asignaciones',['id','fch_inicio','fch_final'],[['id','=',$re->id]]);
            
            return $res;
        }
    }

    public function actualizaHistorial(Request $re) {
        if ($re->isMethod('POST')) {
            if ($re->fch_fi == "") {
                return ['confirm'=>0,'msg'=>'No se actualizó ya que no se envió ningun dato'];
            }
            try {
                $data = [];
                if (!empty($re->fch_fi)) {
                    $data['fch_final'] = $re->fch_fi;
                }
                if (count($data) > 0) {
                    $act = Consulta::actualiza('sgkma_asignaciones',$data,[['id','=',$re->id]]);
                    if ($act > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó satisfactoriamente'];
                    }
                    return ['confirm'=>0,'msg'=>'No se actualizó los datos'];
                }
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function componenteClienteEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            $t = ['sgkca_equipo as e'=>['c.cod_equipo_comp','=','e.id']];
            $s = ['c.cod_equipo','c.cod_equipo_comp','e.dsc_equipo'];
            $w = [['c.cod_equipo','=',$re->id],['e.cod_cliente','=',$re->cli]];
            $order = ['desc'=>'c.created_at'];
            // $equipo = Consulta::selecciona('sgkma_componentes',['cod_equipo_comp'],[['cod_equipo','=',$re->id]]);
            // if (count($equipo) > 0) {
            //     foreach ($equipo as $e) {
            //         #
            //     }
            // }
            $eq['components'] = Consulta::union('sgkma_componentes as c',$t,$s,$w,$order);
            $eq['equipos'] = Consulta::selecciona('sgkca_equipo',['id','dsc_equipo'],[['id','<>',$re->id],['cod_cliente','=',$re->cli]]);
            return $eq;
        }
    }

    public function guardarComponente(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'id_e' => 'required|integer',
                'id_c_e' => 'required|integer'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $cons1 = Consulta::selecciona('sgkma_componentes',['cod_equipo_comp'],[['cod_equipo_comp','=',$re->id_c_e]]);
                $cons2 = Consulta::selecciona('sgkma_componentes',['cod_equipo'],[['cod_equipo','=',$re->id_c_e]]);
                if (count($cons1) > 0) {
                    return ['confirm'=>0,'msg'=>'El equipo ya se encuentra asignado'];
                }
                if (count($cons2) > 0) {
                    return ['confirm'=>0,'msg'=>'El equipo no puede ser asignado debido que contiene componentes asignados a el'];
                }
                $eq = Consulta::ingreso2('sgkma_componentes',['cod_equipo'=>$re->id_e,'cod_equipo_comp'=>$re->id_c_e,'cod_usr_crea'=>$idUser]);
                if ($eq > 0) {
                    return ['confirm'=>1,'msg'=>'Se registro satisfactoriamente'];
                }
                return ['confirm'=>0,'msg'=>'No se registro'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function deleteComponente(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $id = explode("-",$re->id);
                $eli = Consulta::elimina('sgkma_componentes',[['cod_equipo','=',$id[0]],['cod_equipo_comp','=',$id[1]]]);
                if ($eli > 0) {
                    return ['confirm'=>1,'msg'=>'Se eliminó satisfactoriamente'];
                }
                return ['confirm'=>0,'msg'=>'No se eliminó'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // METODOS EQUIPO - MANTENIMIENTO
    public function saveMantenimiento(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_equipo' => 'required|integer',
                'cod_tipo' => 'required|integer',
                'cod_estado' => 'required|integer',
                'observaciones' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                unset($re['_token']);
                $re['cod_tecnico'] = $idUser;
                $re['cod_usr_crea'] = $idUser;
                $equ_man = Consulta::ingreso2('sgkde_eqp_mantenimiento',$re->all());
                if ($equ_man > 0) {
                    $data = $this->listaMantenimiento($re->cod_equipo,1);
                    return ['confirm'=>1,'msg'=>'Se registro satisfactoriamente','data'=>$data];
                }
                return ['confirm'=>0,'msg'=>'No se guardaron los datos'];
            } catch (\Throwable $e) {
                return 'Consulte con su Administrador';//$e->getMessage();
            }
        }
    }
    public function obtenerMantenimiento(Request $re) {
        if ($re->isMethod('POST')) {
            $w = ' and date(em.created_at) between "'.date('Y-m-01').'" and "'.date('Y-m-t').'"';
            $data['mantenimiento'] = $this->listaMantenimiento($re->id,'',$w);
            return $data;
        }
    }
    public function listaMantenimiento($id,$limit,$w = '') {
        $s = ['em.*', 't.dsc_tipo', 'e.dsc_estado', 'm.dsc_abrev'];
        $tables = [
            'sgkma_tipo as t' => ['t.cod_tipo','=','em.cod_tipo'],
            'sgkma_estado as e' => ['e.id','=','em.cod_estado'],
            'sgkma_moneda as m' => ['m.id','=','em.moneda']
        ];
        $where = 'em.cod_equipo = '.$id;
        if ($w) {
            $where .= $w;
        }
        $or = ['desc'=>'em.created_at'];
        return Consulta::union('sgkde_eqp_mantenimiento as em',$tables,$s,$where,$or,[],$limit);
    }
    // METODOS EQUIPO - SOFTWARE
    public function obtenerSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_software',['id','dsc_software'],[['cod_categoria','=',$re->id],['flg_activo','=',1]]);
        }
    }
    public function saveSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_equipo' => 'required|integer',
                'cod_software' => 'required|integer',
                'fch_instalacion' => 'required|date'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                unset($re['_token']);
                $re['cod_usr_crea'] = $idUser;
                $equ_sof = Consulta::ingreso2('sgkde_eqp_software',$re->all());
                if ($equ_sof > 0) {
                    $data = $this->listaSoftware($re->cod_equipo,1);
                    return ['confirm'=>1,'msg'=>'Se registro satisfactoriamente','data'=>$data];
                }
                return ['confirm'=>0,'msg'=>'No se guardaron los datos'];
            } catch (\Throwable $e) {
                return 'Consulte con su Administrador';//$e->getMessage();
            }
        }
    }
    public function obtenerListaSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            $w = ' and date(es.created_at) between "'.date('Y-m-01').'" and "'.date('Y-m-t').'"';
            $data['software'] = $this->listaSoftware($re->id,'',$w);
            return $data;
        }
    }
    public function listaSoftware($id,$limit,$w = '') {
        $s = ['cs.dsc_categoria','s.dsc_software','es.fch_instalacion','es.observaciones'];
        $tables = [
            'sgkma_software as s' => ['s.id','=','es.cod_software'],
            'sgkma_categoria_software as cs' => ['cs.id','=','s.cod_categoria']
        ];
        $where = 'es.cod_equipo = '.$id;
        if ($w) {
            $where .= $w;
        }
        $or = ['desc'=>'es.created_at'];
        return Consulta::union('sgkde_eqp_software as es',$tables,$s,$where,$or,[],$limit);
    }
    // TIPO DE ATENCION
    public function tipoAtencion() {
        $ta = Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion','flg_activo'],'',['asc'=>'dsc_tipo_atencion']);
        return view('configuracion/tipo_atencion',compact('ta'));
    }

    public function manTipoAtencion(Request $re) {
        if ($re->isMethod('POST')) {
            $v = Validator::make($re->all(),[
                'dsc_tipo_atencion' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['dsc_tipo_atencion'=>$re->dsc_tipo_atencion,'flg_activo'=>$activo];
                if (!empty($re->xid)) {
                    $data['updated_at'] = Carbon::now();
                    $save_atencion = Consulta::actualiza('sgkma_tipo_atencion',$data,[['id','=',$re->xid]]);
                    if ($save_atencion > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                
                $atencion = Consulta::ingreso2('sgkma_tipo_atencion',$data);
                if ($atencion > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getTipoAtencion(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion','flg_activo'],[['id','=',$re->id]]);
        }
    }
    // METODOS MARCA
    public function marca() {
        $mar = SEMarca::select('id','dsc_marca','flg_activo')->orderby('dsc_marca')->get();
        return View('configuracion/marca',compact('mar'));
    }

    public function manMarca(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_marca' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                if (!empty($re->xid)) {
                    $data = ['dsc_marca'=>$re->dsc_marca,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    $save_marca = SEMarca::where('id',$re->xid)->update($data);
                    if ($save_marca > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }

                $e = SEMarca::create($re->all());
                $e->cod_usr_crea = $idUser;
                $e->save();
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getMarca(Request $re) {
        if ($re->isMethod('POST')) {
            return SEMarca::select(['dsc_marca'])->where('id',$re->id)->get();
        }
    }

    public function eliminarMarca(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $eq_mar = SGEquipo::where('cod_marca',$re->id)->get();
                if (count($eq_mar) > 0) {
                    return ['confirm'=>0,'msg'=>'No se puede eliminar esta marca ya que tiene un equipo asignado'];
                }
                $del = SEMarca::where('id',$re->id)->delete();
                if ($del > 0) {
                    return ['confirm'=>1,'msg'=>'Se eliminó satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'No se eliminó'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';//$e->getMessage();
            }
        }
    }
    // METODOS PERIFERICO
    public function periferico() {
        $per = SEPeriferico::select('id','dsc_periferico','flg_activo')->orderby('dsc_periferico')->get();
        return View('configuracion/periferico',compact('per'));
    }

    public function manPeriferico(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_periferico' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                if (!empty($re->xid)) {
                    $data = ['dsc_periferico'=>$re->dsc_periferico,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    $save_marca = SEPeriferico::where('id',$re->xid)->update($data);
                    if ($save_marca > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }

                $e = SEPeriferico::create($re->all());
                $e->cod_usr_crea = $idUser;
                $e->save();
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getPeriferico(Request $re) {
        if ($re->isMethod('POST')) {
            return SEPeriferico::select(['dsc_periferico'])->where('id',$re->id)->get();
        }
    }

    public function desactivarPeriferico(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                return SEPeriferico::where('id',$re->id)->update(['flg_activo' => 0,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // METODOS MODELO
    public function modelo() {
        $mar = SEMarca::where('flg_activo',1)->orderby('dsc_marca')->get();
        $per = SEPeriferico::where('flg_activo',1)->orderby('dsc_periferico')->get();
        // $mod = SEModelo::all();
        $s = ['m.id','ma.dsc_marca','p.dsc_periferico','m.dsc_modelo','m.flg_activo'];
        $t = [
            'sgkma_marca as ma' => ['ma.id','=','m.cod_marca'],
            'sgkma_periferico as p' => ['p.id','=','m.cod_periferico']
        ];
        $or = 'p.dsc_periferico,ma.dsc_marca,m.dsc_modelo';
        $mod = Consulta::union('sgkma_modelo as m',$t,$s,'',$or);
        return View('configuracion/modelo',compact('mar','per','mod'));
    }

    public function manModelo(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_marca' => 'required|integer',
                'cod_periferico' => 'required|integer',
                'dsc_modelo' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados '];
            }
            try {
                if (!empty($re->xid)) {
                    $data = ['cod_marca'=>$re->cod_marca,'cod_periferico'=>$re->cod_periferico,'dsc_modelo'=>$re->dsc_modelo,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    $save_marca = SEModelo::where('id',$re->xid)->update($data);
                    if ($save_marca > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }

                $e = SEModelo::create($re->all());
                $e->cod_usr_crea = $idUser;
                $e->save();
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminarModelo(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $eq_mod = SGEquipo::where('cod_modelo',$re->id)->get();
                if (count($eq_mod) > 0) {
                    return ['confirm'=>0,'msg'=>'No se puede eliminar este modelo ya que tiene un equipo asignado'];
                }
                $del = SEModelo::where('id',$re->id)->delete();
                if ($del > 0) {
                    return ['confirm'=>1,'msg'=>'Se eliminó satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'No se eliminó'];
            } catch (\Throwable $e) {
                return 'Comuniquese con su adminsitrador';//$e->getMessage();
            }
        }
    }

    public function getModelo(Request $re) {
        if ($re->isMethod('POST')) {
            return SEModelo::select(['cod_marca','cod_periferico','dsc_modelo'])->where('id',$re->id)->get();
        }
    }
    // METODOS PROCESADOR
    public function procesador() {
        $pro = Consulta::selecciona('sgkma_procesador',['id','dsc_procesador','flg_activo'],'',['asc'=>'dsc_procesador']);
        return View('configuracion/procesador',compact('pro'));
    }

    public function manProcesador(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_procesador' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['dsc_procesador'=>$re->dsc_procesador,'flg_activo'=>$activo];
                if (!empty($re->id)) {
                    $data['cod_usr_modifica'] = $idUser;
                    $data['updated_at'] = Carbon::now();
                    $update_procesador = Consulta::actualiza('sgkma_procesador',$data,[['id','=',$re->id]]);
                    if ($update_procesador > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                $data['cod_usr_crea'] = $idUser;
                $procesador = Consulta::ingreso2('sgkma_procesador',$data);
                if ($procesador > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';//$e->getMessage();
            }
        }
    }

    public function getProcesador(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_procesador',['id','dsc_procesador','flg_activo'],[['id','=',$re->id]]);
        }
    }
    // METODOS ESTADO
    public function estado() {
        $sol = Consulta::selecciona('sgkma_solicitud',['cod_tabla','dsc_solicitud'],[['flg_activo',1]]);
        $tables = [
            'sgkma_estado as e' => ['e.cod_tabla','=','s.cod_tabla']
        ];
        $s = ['e.id','s.dsc_solicitud','e.dsc_estado','e.flg_activo'];
        $or = 's.dsc_solicitud, e.orden';
        $est = Consulta::union('sgkma_solicitud as s',$tables,$s,'',$or);
        return View('configuracion/estado',compact('sol','est'));
    }

    public function manEstado(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'solicitud' => 'required|string',
                'dsc_estado' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                if (!empty($re->xid)) {
                    $flg = ($re->flg_activo) ? 1 : 0;
                    $data = ['dsc_estado'=>$re->dsc_estado,'cod_tabla'=>$re->solicitud,'flg_activo'=>$flg,'cod_usr_modifica'=>$idUser,'updated_at'=>Carbon::now()];
                    $save_marca = SEEstado::where('id',$re->xid)->update($data);
                    if ($save_marca > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }

                $e = SEEstado::create($re->all());
                $e->cod_tabla = $re->solicitud;
                $e->cod_usr_crea = $idUser;
                $e->save();
                return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getEstado(Request $re) {
        if ($re->isMethod('POST')) {
            if (!empty($re->cod)) {
                $id = $re->cod;
                $campo = 'cod_tabla';
            } else {
                $id = $re->id;
                $campo = 'id';
            }
            return SEEstado::select(['id','dsc_estado','cod_tabla','orden','flg_activo'])->where($campo,$id)->get();
        }
    }

    public function filtroEstado(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $tables = [
                    'sgkma_estado as e' => ['e.cod_tabla','=','s.cod_tabla']
                ];
                $s = ['e.id','s.dsc_solicitud','e.dsc_estado','e.flg_activo'];
                if ($re->solicitud) {
                    $w = [['e.cod_tabla','=',$re->solicitud]];
                } else {
                    $w = '';
                }
                $or = 's.dsc_solicitud, e.orden';
                return Consulta::union('sgkma_solicitud as s',$tables,$s,$w,$or);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function ordenEstado(Request $re) {
        try {
            foreach ($re->orden as $k => $v) {
                Consulta::actualiza('sgkma_estado',['orden'=>$v],[['id','=',$k]]);
            }
            return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
    // SERVICIOS
    public function servicios() {
        $se = Consulta::selecciona('sgkma_servicio',['id','dsc_servicio','flg_activo'],'');
        return view('configuracion/servicio',compact('se'));
    }

    public function manServicios(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_servicio' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['dsc_servicio'=>$re->dsc_servicio,'flg_activo'=>$activo,'cod_usr_registro'=>$idUser];
                if (!empty($re->xid)) {
                    $update_servicio = Consulta::actualiza('sgkma_servicio',$data,[['id','=',$re->xid]]);
                    if ($update_servicio > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                
                $servicio = Consulta::ingreso2('sgkma_servicio',$data);
                if ($servicio > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getServicios(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_servicio',['id','dsc_servicio','flg_activo'],[['id','=',$re->id]]);
        }
    }
    // MODALIDAD DE ATENCION
    public function modalidad_atencion() {
        $ma = Consulta::selecciona('sgkma_tipo_soporte',['id','dsc_tipo_soporte','flg_activo'],'');
        return view('configuracion/modalidad_atencion',compact('ma'));
    }

    public function manModalidad(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_tipo_soporte' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['dsc_tipo_soporte'=>$re->dsc_tipo_soporte,'flg_activo'=>$activo];
                if (!empty($re->xid)) {
                    $update_modalidad = Consulta::actualiza('sgkma_tipo_soporte',$data,[['id','=',$re->xid]]);
                    if ($update_modalidad > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                
                $modalidad = Consulta::ingreso2('sgkma_tipo_soporte',$data);
                if ($modalidad > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getModalidad(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_tipo_soporte',['id','dsc_tipo_soporte','flg_activo'],[['id','=',$re->id]]);
        }
    }
    // METODOS SERVICIOS CONTRATADOS
    public function serviciosContratados() {
        $cli = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->get();
        return view('configuracion/servicios',compact('cli'));
    }

    public function clienteServicios(Request $re) {
        if ($re->isMethod('POST')) {
            $ser = Consulta::selecciona('sgkma_servicio',['id','dsc_servicio'],[['flg_activo','=',1]]);
            if (count($ser) > 0) {
                foreach ($ser as $se => $s) {
                    $cli = Consulta::selecciona('sgkma_cliente_servicio',['flg_activo','fch_inicio','fch_fin'],[['idCliente','=',$re->id],['idServicio','=',$s->id]]);
                    if (count($cli) > 0) {
                        $ser[$se]->idCliente = $re->id;
                        $ser[$se]->idServicio = $s->id;
                        $ser[$se]->dsc_servicio = $s->dsc_servicio;
                        $ser[$se]->flg_activo = $cli[0]->flg_activo;
                        $ser[$se]->fch_inicio = $cli[0]->fch_inicio;
                        $ser[$se]->fch_fin = $cli[0]->fch_fin;
                    } else {
                        $ser[$se]->idCliente = $re->id;
                        $ser[$se]->idServicio = $s->id;
                        $ser[$se]->dsc_servicio = $s->dsc_servicio;
                        $ser[$se]->flg_activo = 0;
                        $ser[$se]->fch_inicio = '';
                        $ser[$se]->fch_fin = '';
                    }
                }
            }
            return $ser;
            // $tables = ['sgkma_servicio as s' => ['cs.idServicio','=','s.id']];
            // $s = ['cs.*','s.dsc_servicio'];
            // $w = [['cs.idCliente','=',$re->id]];
            // return Consulta::union('sgkma_cliente_servicio as cs',$tables,$s,$w);
        }
    }

    public function clienteEstado(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            try {
                $con = Consulta::selecciona('sgkma_cliente_servicio',['idCliente'],[['idCliente','=',$re->cli],['idServicio','=',$re->ser]]);
                if ($re->est == 1) {
                    $est_msg = 'Se desactivo el servicio satisfactoriamente!';
                    $flag = 0;
                } elseif ($re->est == 0) {
                    $est_msg = 'Se activo el servicio satisfactoriamente!';
                    $flag = 1;
                }
                $fec_ini = (!empty($re->fec_ini)) ? $re->fec_ini : null;
                $fec_fin = (!empty($re->fec_fin)) ? $re->fec_fin : null;
                if (count($con) > 0) {
                    $c = Consulta::actualiza('sgkma_cliente_servicio',['flg_activo'=>$flag,'fch_inicio'=>$fec_ini,'fch_fin'=>$fec_fin],[['idCliente','=',$re->cli],['idServicio','=',$re->ser]]);
                } else {
                    $c = Consulta::ingreso2('sgkma_cliente_servicio',['idCliente'=>$re->cli,'idServicio'=>$re->ser,'flg_activo'=>$flag,'cod_usr_registro'=>$idUser,'fch_inicio'=>$fec_ini,'fch_fin'=>$fec_fin]);
                }
                if ($c > 0) {
                    return ['confirm'=>1,'msg'=>$est_msg];
                }
                return ['confirm'=>0,'msg'=>'Error en la acción'];
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // PROVEEDOR
    public function proveedor(Request $re) {
        if ($re->isMethod('POST')) {
            $v = Validator::make($re->all(),[
                'dsc_proveedor' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Nombre obligatorio'];
            }
            try {
                $prov = Consulta::ingreso('sgkma_proveedor',['dsc_proveedor'=>$re->dsc_proveedor]);
                if ($prov) {
                    return ['confirm'=>1,'msg'=>'Se registro satisfactoriamente','id'=>$prov,'nombre'=>$re->dsc_proveedor];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';
            }
            
        }
    }
    // CATEGORIA SOFTWARE
    public function categoriaSoftware() {
        $cs = Consulta::selecciona('sgkma_categoria_software',['id','dsc_categoria','flg_activo'],'',['asc'=>'dsc_categoria']);
        return view('configuracion/categoria_software',compact('cs'));
    }

    public function manCategoria(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'dsc_categoria' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['dsc_categoria'=>$re->dsc_categoria,'flg_activo'=>$activo];
                if (!empty($re->id)) {
                    $data['cod_usr_modifica'] = $idUser;
                    $data['updated_at'] = Carbon::now();
                    $update_categoria = Consulta::actualiza('sgkma_categoria_software',$data,[['id','=',$re->id]]);
                    if ($update_categoria > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                $data['cod_usr_crea'] = $idUser;
                $categoria = Consulta::ingreso2('sgkma_categoria_software',$data);
                if ($categoria > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';//$e->getMessage();
            }
        }
    }

    public function getCategoria(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_categoria_software',['id','dsc_categoria','flg_activo'],[['id','=',$re->id]]);
        }
    }
    // SOFTWARE
    public function allSoftware() {
        $cat = Consulta::selecciona('sgkma_categoria_software',['id','dsc_categoria'],[['flg_activo','=',1]],['asc'=>'dsc_categoria']);
        $mon = Consulta::selecciona('sgkma_moneda',['id','dsc_moneda'],[['flg_activo','=',1]]);
        $tables = [
            'sgkma_categoria_software as c' => ['c.id','=','s.cod_categoria']
        ];
        $s = ['s.id','c.dsc_categoria','s.dsc_software','s.flg_activo'];
        $or = 'c.dsc_categoria,s.dsc_software';
        $sof = Consulta::union('sgkma_software as s',$tables,$s,'',$or);
        return view('configuracion/software',compact('sof','cat','mon'));
    }

    public function manSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cod_categoria' => 'required|integer',
                'dsc_software' => 'required|string',
                'dsc_version' => 'required|string'
                // 'moneda' => 'required|integer',
                // 'costo' => 'required|numeric'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            $licencia = false;
            if ($re->flg_licencia) {
                $licencia = true;
                if (empty($re->moneda) || empty($re->costo)) {
                    return ['confirm'=>0,'msg'=>'Seleccione moneda e ingrese el costo'];
                }
            }
            try {
                $activo = (!empty($re->flg_activo)) ? true : false;
                $data = ['cod_categoria'=>$re->cod_categoria,'dsc_software'=>$re->dsc_software,'dsc_version'=>$re->dsc_version,'flg_licencia'=>$licencia,'moneda'=>$re->moneda,'costo'=>$re->costo,'observaciones'=>$re->observaciones,'flg_activo'=>$activo];
                if (!empty($re->id)) {
                    $data['cod_usr_modifica'] = $idUser;
                    $data['updated_at'] = Carbon::now();
                    $update_software = Consulta::actualiza('sgkma_software',$data,[['id','=',$re->id]]);
                    if ($update_software > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó los datos satisfactoriamente!'];
                    }
                    return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
                }
                $data['cod_usr_crea'] = $idUser;
                $software = Consulta::ingreso2('sgkma_software',$data);
                if ($software > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardaron los datos satisfactoriamente!'];
                }
                return ['confirm'=>0,'msg'=>'Comuniquese con el administrador'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';//$e->getMessage();
            }
        }
    }

    public function getSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_software',['*'],[['id','=',$re->id]]);
        }
    }
    // CONTROL DE ACCESO
    public function controlAcceso() {
        $cli = SECliente::where('flg_activo',1)->orderBy('dsc_cliente')->get();
        $rol = Consulta::selecciona('sgkma_roles',['id','dsc_rol'],[['flg_activo','=',1]]);
        $usu = Consulta::control_usuarios(['cli'=>0]);

        return view('configuracion/control',compact('cli','rol','usu'));
    }

    public function usuariosCliente(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['cod_cliente','=',$re->id],['flg_activo','=',1]],'nombres, apellidos asc');
        }
    }

    public function usuariosAcount(Request $re) {
        if ($re->isMethod('POST')) {
            $usu = Consulta::selecciona('sgkma_cliente_usuarios',['nombres','apellidos'],[['id','=',$re->id],['cod_cliente','=',$re->cli]]);
            $nom = substr($usu[0]->nombres, 0, 1);
            $ape = explode(" ",$usu[0]->apellidos);
            $login = $nom.$ape[0];
            for ($i=0; $i < 100; $i++) { 
                $lo = Consulta::selecciona('sgkma_usuario',['login'],[['login','=',$login],['idCliente','=',$re->cli]]);
                if (count($lo) == 0) {
                    break;
                } else {
                    $login = $login.$i;
                }
            }

            return strtoupper($login);
        }
    }

    public function guardarAccesso(Request $re) {
        if ($re->isMethod('POST')) {
            $idUser = session('idUser');
            $v = Validator::make($re->all(),[
                'cliente' => 'required|integer',
                'rol' => 'required|integer',
                'usu' => 'required|integer',
                'usuario' => 'required|string'
            ]);
            if ($v->fails()) {
                return ['confirm'=>0,'msg'=>'Datos Obligatorios o errados'];
            }
            try {
                $usu = Consulta::selecciona('sgkma_usuario',['id'],[['login','=',$re->usuario],['idCLiente','=',$re->cliente]]);
                if ($re->id) {
                    ($re->flg_activo) ? $flg = true : $flg = false;
                    $dato = ['login'=>$re->usuario,'clave'=>sha1($re->password),'rol'=>$re->rol,'flg_activo'=>$flg,'cod_usr_modifica'=>$idUser,'fch_modifica'=>Carbon::now()];
                    if (empty($re->password)) {
                        unset($dato['clave']);
                    }
                    $up = Consulta::actualiza('sgkma_usuario',$dato,[['id','=',$re->id]]);
                    if ($up > 0) {
                        return ['confirm'=>1,'msg'=>'Se actualizó correctamente'];
                    }
                    return ['confirm'=>0,'msg'=>'No se actualizó'];
                }
                if (count($usu) > 0) {
                    return ['confirm'=>0,'msg'=>'Ya existe un usuario con este nombre para este cliente'];
                }
                if (empty($re->password)) {
                    return ['confirm'=>0,'msg'=>'Ingrese una contraseña'];
                }
                $dato = ['idCliente'=>$re->cliente,'idUsuario'=>$re->usu,'login'=>$re->usuario,'clave'=>sha1($re->password),'rol'=>$re->rol,'cod_usr_crea'=>$idUser];
                $save = Consulta::ingreso2('sgkma_usuario',$dato);
                if ($save > 0) {
                    return ['confirm'=>1,'msg'=>'Se guardo correctamente'];
                }
                return ['confirm'=>0,'msg'=>'No se guardó'];
            } catch (\Throwable $e) {
                return 'Comuniquese con el administrador';
            }
        }
    }

    public function usuarioControl(Request $re) {
        if ($re->isMethod('POST')) {
            $usu = Consulta::selecciona('sgkma_usuario',['*'],[['id','=',$re->id]]);
            $data['usuario'] = $usu;
            $data['usu'] = Consulta::selecciona('sgkma_cliente_usuarios',['id','nombres','apellidos'],[['id','=',$usu[0]->idUsuario]]);
            return $data;
        }
    }

    public function filtroControlUsuarios(Request $re) {
        if ($re->isMethod('POST')) {
            return Consulta::control_usuarios(['cli'=>$re->f_cliente]);
        }
    }
}
