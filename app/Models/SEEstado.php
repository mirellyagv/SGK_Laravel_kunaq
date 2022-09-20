<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEEstado extends Model
{
    use HasFactory;
    protected $table = 'sgkma_estado';
    public $primaryKey = 'id';
    protected $fillable = ['dsc_estado','color','flg_fecha','flg_1','flg_2','flg_estado','cod_tabla','observaciones','flg_activo','created_at','cod_usr_crea','updated_at','cod_usr_modifica'];
}
