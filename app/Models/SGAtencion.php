<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SGAtencion extends Model
{
    use HasFactory;

    protected $table = 'sgkma_atenciones';
    public $primarykey = 'id';
    protected $fillable = ['idIncidencia','cod_actividad','cod_soporte','cod_cliente','cod_sucursal','cod_atencion','usuario','fch_atencion','fch_atencion_fin','hra_inicio','hra_fin','tiempo_hora','evento','obs','pendiente','flg_estado','cod_usr_crea','cod_usr_modifica','created_at','updated_at'];
}
