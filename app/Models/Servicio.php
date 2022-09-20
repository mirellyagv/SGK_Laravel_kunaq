<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'sgkma_servicio';
    public $primaryKey = 'id';
    protected $fillable = ['dsc_servicio','icono','flg_activo'];

    public static function cliente_servicio($idCliente) {
        return DB::table('sgkma_servicio as s')
                    ->select('s.id','s.dsc_servicio', 's.icono', 'cs.flg_activo')
                    ->join('sgkma_cliente_servicio as cs','s.id','=','cs.idServicio')
                    ->where('cs.idCliente',$idCliente)
                    ->get();
    }
}
