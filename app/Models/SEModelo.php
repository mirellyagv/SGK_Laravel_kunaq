<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEModelo extends Model
{
    use HasFactory;
    protected $table = 'sgkma_modelo';
    public $primaryKey = 'id';
    protected $fillable = ['cod_modelo','cod_marca','cod_periferico','dsc_modelo','imagen','observaciones','flg_activo','created_at','cod_usr_crea','updated_at','cod_usr_modifica'];
}
