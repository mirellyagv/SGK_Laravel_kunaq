<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consulta extends Model
{
    use HasFactory;
    public static function logeo($data) {
        return DB::select('CALL sp_acceso (?,?,?)',[$data->ruc,$data->username,sha1($data->pass)]);
    }
    // EQUIPO
    public static function filtroEquipo($data) {
        return DB::select('CALL sp_filtroEquipo (?,?,?,?)',[$data['cod_cliente'],$data['cod_periferico'],$data['cod_marca'],$data['cod_estado']]);
    }
    // SOPORTE
    public static function filtro($data) {
        $cod_user = 0;
        if (empty($data['f_cod_cliente'])) {
            $data['f_cod_cliente'] = 0;
        }
        if (!empty($data['cod_user'])) {
            $cod_user = $data['cod_user'];
        }
        return DB::select('CALL sp_filtroProcedure (?,?,?,?,?,?)',[$data['op'],$data['f_cod_cliente'],$data['f_fch_inicio'],$data['f_fch_fin'],$cod_user,$data['f_estado']]);
    }
    // CONFIGURACION - CONTROL USUARIO
    public static function control_usuarios($data) {
        return DB::select('CALL sp_lista_control_usuario (?)',[$data['cli']]);
    }
    // RESUMEN INVENTARIO
    public static function sp_resumen_inventario($d) {
        return DB::select('CALL sp_resumen_inventario (?,?)',[$d['op'],$d['cli']]);
    }
    // S - RESUMEN TIPO ATENCION 1 / RESUMEN MODALIDAD ATENCION 2
    public static function sp_soporte_resumen($d) {
        return DB::select('CALL sp_reporte_resumen (?,?,?,?,?,?)',[$d['op'],$d['op2'],$d['cli'],$d['anio'],$d['mes'],$d['var']]);
    }
    // REPORTE
    public static function reporte($data) {
        return DB::select('CALL sp_reporte_servicio (?)',[$data['cli']]);
    }

    public static  function usuarios($idCliente) {
        return DB::table('sgkma_usuario as u')
                ->select('u.id','u.login','u.flg_activo','r.dsc_rol','cu.nombres','cu.apellidos')
                ->join('sgkma_roles as r','u.rol','=','r.id')
                ->join('sgkma_cliente_usuarios as cu','cu.id','=','u.idUsuario')
                ->where('u.idCliente', $idCliente)
                ->get();
    }

    public static function ingreso($table,$data) {
        return DB::table($table)->insertGetId($data);
    }

    public static function ingreso2($table,$data) {
        return DB::table($table)->insert($data);
    }

    public static function actualiza($table,$data,$where) {
        return DB::table($table)->where($where)->update($data);
    }

    public static function elimina($table,$w) {
        return DB::table($table)->where($w)->delete();
    }

    public static function selecciona($table,$s,$w,$or = '') {
        $select = DB::table($table)->select($s);
        if (is_array($w)) {
            $select->where($w);
        } else {
            if (!empty($w)) {
                $select->whereRaw($w);
            }
        }
        if (is_array($or)) {
            if (isset($or['asc'])) {
                $select->orderBy($or['asc']);
            } elseif (isset($or['desc'])) {
                $select->orderByDesc($or['desc']);
            }
        } else {
            if ($or) {
                $select->orderByRaw($or);
            }
        }
        $result = $select->get();
        
        return $result;
    }

    public static function union($table,$tables = [],$s,$w,$or, $left = [], $limit = "") {
        $join = DB::table($table)->select($s);
        if (count($tables) > 0) {
            foreach ($tables as $ta => $t) {
                $join->join($ta,$t[0],$t[1],$t[2]);
            }
        }
        if (count($left) > 0) {
            foreach ($left as $le => $l) {
                $join->leftJoin($le,$l[0],$l[1],$l[2]);
            }
        }
        if (is_array($w)) {
            $join->where($w);
        } else {
            if (!empty($w)) {
                $join->whereRaw($w);
            }
        }
        if (is_array($or)) {
            if (isset($or['asc'])) {
                $join->orderBy($or['asc']);
            } elseif (isset($or['desc'])) {
                $join->orderByDesc($or['desc']);
            }
        } else {
            if ($or) {
                $join->orderByRaw($or);
            }
        }
        if ($limit) {
            $join->limit($limit);
        }
        $result = $join->get();
        
        return $result;
    }

    // API REST
    public static function consultas($data) {
        return DB::connection('consulta')->select('EXEC usp_vta_prc_consulta_crm ?,?,?,?',[$data['proc'],$data['dato_1'],$data['dato_2'],$data['dato_3']]);
    }
}
