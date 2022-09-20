<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SGSucursal extends Model
{
    use HasFactory;
    protected $table = 'sgkma_sucursal';
    public $primarykey = 'id';
    protected $fillable = ['cod_cliente','dsc_sucursal','dsc_direccion','observaciones','flg_activo','created_at','cod_usr_crea','updated_at','cod_usr_modifica'];

    public static function clienteSucursal($cli = false) {
        $re = DB::table('sgkma_sucursal as s')
                ->select('s.id','c.dsc_cliente','s.dsc_sucursal','s.dsc_direccion','s.observaciones','s.flg_activo',DB::raw('(select group_concat(" ",dsc_ubicaciones) from sgkma_ubicaciones where cod_cliente = c.id and cod_sucursal = s.id) as ubicaciones'))
                ->join('sgkma_cliente as c','c.id','=','s.cod_cliente');
        if ($cli) {
            $re->where('c.id',$cli);
        }
        $re->orderBy('c.dsc_cliente','asc');
        $re->orderBy('s.dsc_sucursal','asc');
        $r = $re->get();
        return $r;
    }
}
