<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;
    protected $table = 'sgkma_incidentes';
    public $primarykey = 'id';
    protected $fillable = ['idCliente','idSucursal','idUsuario','idTipoIncidencia','cod_actividad','fch_crea','tiempo_hora','titulo','obs','equipo','estado','cod_usr_crea','usu_soporte','prioridad','created_at','updated_at'];
}
