<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEPeriferico extends Model
{
    use HasFactory;
    protected $table = 'sgkma_periferico';
    public $primaryKey = 'id';
    protected $fillable = ['cod_periferico','dsc_periferico','flg_software','observaciones','flg_activo','created_At','cod_usr_crea','updated_at','cod_usr_modifica'];
}
