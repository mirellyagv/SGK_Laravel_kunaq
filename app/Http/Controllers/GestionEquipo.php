<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\SEEstado;
use App\Models\SEMarca;
use App\Models\SEPeriferico;
use App\Models\SGEquipo;
use Illuminate\Http\Request;

class GestionEquipo extends Controller
{

    public function __construct() {
        $this->middleware('autenticado');
    }

    public function index() {
        $idCli = session('idCliente');
        $tarjetas = [];
        $data = ['cod_cliente'=>$idCli,'cod_periferico'=>0,'cod_marca'=>0,'cod_estado'=>0];
        $per = SEPeriferico::where('flg_activo',1)->get();
        $mar = SEMarca::where('flg_activo',1)->get();
        $est = SEEstado::where([['flg_activo','=',1],['cod_tabla','=','EQ']])->orderby('orden')->get();
        foreach ($est as $e) {
            $tarjetas[$e->dsc_estado]['color'] = $e->color;
            $tarjetas[$e->dsc_estado]['cantidad'] = SGEquipo::where('cod_cliente',$idCli)->where('cod_estado', $e->id)->count();
        }
        $eq = Consulta::filtroEquipo($data);
        
        return view('gestion_equipo',compact('eq','per','mar','est','tarjetas'));
    }

    public function listaEquipos(Request $re) {
        if ($re->isMethod('POST')) {
            $idCli = session('idCliente');
            $per = ($re->periferico) ? $re->periferico : 0;
            $mar = ($re->marca) ? $re->marca : 0;
            $est = ($re->estado) ? $re->estado : 0;
            $data = ['cod_cliente'=>$idCli,'cod_periferico'=>$per,'cod_marca'=>$mar,'cod_estado'=>$est];
            return Consulta::filtroEquipo($data);
        }
    }

    public function detalleEquipo(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $idCli = session('idCliente');
                $s = ['s.dsc_sucursal', 'u.dsc_ubicaciones', 'es.dsc_estado', 'p.dsc_periferico', 'm.dsc_marca', 'mo.dsc_modelo', 'e.cod_activo', 'e.serie', 'e.fch_compra', 'e.nro_inventario', 'e.cod_activo', 'e.serie', 'e.procesador', 'e.velocidad_procesador', 'e.memoria', 'e.disco_duro', 'e.fch_compra', 'e.fch_instalacion',
                'e.dsc_equipo', 'e.observaciones', 'e.tamanio', 'e.contrato', 'e.costo_equipo', 'e.fch_vcmto_mes', 'e.cuota_mes', 'tp.dsc_tipo_propiedad', 'pro.dsc_proveedor', 'md.dsc_abrev','pr.dsc_procesador'];
                $tables = [
                    'sgkma_marca as m' => ['m.id','=','e.cod_marca'],
                    'sgkma_periferico as p' => ['p.id','=','e.cod_periferico'],
                    'sgkma_modelo as mo' => ['mo.id','=','e.cod_modelo'],
                    'sgkma_estado as es' => ['es.id','=','e.cod_estado'],
                    'sucursal_ubicacion as su' => ['e.id','=','su.idEquipo'],
                    'sgkma_sucursal as s' => ['su.idSucursal','=','s.id'],
                    'sgkma_ubicaciones as u' => ['su.idUbicacion','=','u.id'],
                    'sgkma_tipo_propiedad as tp' => ['tp.id','=','e.tipo_propiedad']
                ];
                $left = [
                    'sgkma_procesador as pr' => ['pr.id','=','e.procesador'],
                    'sgkma_proveedor as pro' => ['pro.id','=','e.proveedor'],
                    'sgkma_moneda as md' => ['md.id','=','e.moneda']
                ];
                $w = [['e.id','=',$re->id],['e.cod_cliente','=',$idCli]];
                return Consulta::union('sgkca_equipo as e',$tables,$s,$w,'',$left);
            } catch (\Throwable $e) {
                return $e->getMessage();//'Error de ejecucion';//
            }
        }
    }

    public function usuarioEquipos(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                $t = ['sgkca_equipo as e'=>['a.cod_equipo','=','e.id'],
                    'sgkma_cliente_usuarios as cu'=>['a.cod_cliente_usuario','=','cu.id'],
                    'sgkma_cliente as c'=>['cu.cod_cliente','=','c.id']];
                $s = ['a.id','cu.cod_cliente','e.dsc_equipo','cu.id as cli_usu','cu.nombres','cu.apellidos','c.dsc_cliente','a.fch_inicio','a.fch_final','a.obs'];
                $w = [['a.cod_equipo','=',$re->id]];
                $order = ['desc'=>'a.created_at'];
                
                $usu['asig_usu'] = Consulta::union('sgkma_asignaciones as a',$t,$s,$w,$order);
                return $usu;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function listaMantenimiento(Request $re) {
        if ($re->isMethod('POST')) {
            $s = ['em.*', 't.dsc_tipo', 'e.dsc_estado', 'm.dsc_abrev'];
            $tables = [
                'sgkma_tipo as t' => ['t.cod_tipo','=','em.cod_tipo'],
                'sgkma_estado as e' => ['e.id','=','em.cod_estado'],
                'sgkma_moneda as m' => ['m.id','=','em.moneda']
            ];
            $where = 'em.cod_equipo = '.$re->id;
            $or = ['desc'=>'em.created_at'];
            $data['mantenimiento'] = Consulta::union('sgkde_eqp_mantenimiento as em',$tables,$s,$where,$or);
            return $data;
        }
    }

    public function listaSoftware(Request $re) {
        if ($re->isMethod('POST')) {
            $s = ['cs.dsc_categoria','s.dsc_software','es.fch_instalacion','es.observaciones'];
            $tables = [
                'sgkma_software as s' => ['s.id','=','es.cod_software'],
                'sgkma_categoria_software as cs' => ['cs.id','=','s.cod_categoria']
            ];
            $where = 'es.cod_equipo = '.$re->id;
            $or = ['desc'=>'es.created_at'];
            $data['software'] = Consulta::union('sgkde_eqp_software as es',$tables,$s,$where,$or);
            return $data;
        }
    }
}
