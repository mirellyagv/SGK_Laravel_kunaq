<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SGEquipo extends Model
{
    use HasFactory;
    protected $table = 'sgkca_equipo';
    public $primaryKey = 'id';
    protected $fillable = ['cod_sucursal','cod_ubicacion','cod_equipo','cod_marca','cod_periferico','cod_modelo','cod_estado','cod_cliente','dsc_equipo','nro_inventario','cod_activo','serie','procesador','velocidad_procesador','memoria','disco_duro','flg_software','observaciones','fch_compra','fch_instalacion','tipo_propiedad','proveedor','contrato','moneda','cuota_mes','fch_vcmto_mes','tamanio','costo_equipo','created_at','cod_usr_crea','aupdated_at','cod_usr_modifica'];

    // public static function clientes($idCliente = false,$filtros = []) {
    //     $cli = DB::table('sgkca_equipo as e')
    //                 ->select('e.id','e.dsc_equipo', 'e.cod_cliente', 'cl.dsc_cliente', 'p.dsc_periferico', 'm.dsc_marca', 'mo.dsc_modelo', 'es.dsc_estado', 'e.cod_activo', 'e.serie', 'e.fch_compra','cu.nombres','cu.apellidos')
    //                 ->join('sgkma_cliente as cl','cl.id','=','e.cod_cliente')
    //                 ->leftJoin('sgkma_asignaciones as a','a.cod_equipo','=','e.id')
    //                 ->leftjoin('sgkma_cliente_usuarios as cu','cu.id','=','a.cod_cliente_usuario')
    //                 ->join('sgkma_marca as m','m.id','=','e.cod_marca')
    //                 ->join('sgkma_periferico as p','p.id','=','e.cod_periferico')
    //                 ->join('sgkma_modelo as mo','mo.id','=','e.cod_modelo')
    //                 ->join('sgkma_estado as es','es.id','=','e.cod_estado');
    //                 if ($idCliente) {
    //                     $cli->where('e.cod_cliente',$idCliente);
    //                 }
    //                 if (count($filtros) > 0) {
    //                     if ($filtros['periferico']) {
    //                         $cli->where('e.cod_periferico',$filtros['periferico']);
    //                     }
    //                     if ($filtros['marca']) {
    //                         $cli->where('e.cod_marca',$filtros['marca']);
    //                     }
    //                     if ($filtros['estado']) {
    //                         $cli->where('e.cod_estado',$filtros['estado']);
    //                     }
    //                 }
    //                 
    //                 $res = $cli->orderBy('e.id')->get();
    //                 dd($res);
    //     return $res;
    // }
}
