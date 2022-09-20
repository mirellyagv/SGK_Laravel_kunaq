<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEMarca extends Model
{
    use HasFactory;
    protected $table = 'sgkma_marca';
    public $primarykey = 'id';
    protected $fillable = ['cod_marca','dsc_marca','flg_software','flg_hardware','observaciones','flg_activo','created_at','cod_usr_crea','updated_at','cod_usr_modifica'];
}
