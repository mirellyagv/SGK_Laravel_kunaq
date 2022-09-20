<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SECliente extends Model
{
    use HasFactory;
    protected $table = 'sgkma_cliente';
    public $primarykey = 'id';
    protected $fillable = ['dsc_dominio','cod_cliente_erp','dsc_cliente','dsc_ruc','fch_inicio','fch_vencimiento','observaciones','telefono','email','direccion','logo','flg_activo','flg_administrador','created_At','cod_usr_crea','updated_at','cod_usr_modifica'];
}
