<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\SECliente;
use App\Models\Servicio;
use Illuminate\Http\Request;

class General extends Controller
{
    protected $idCliente;
    protected $user_rol;

    public function __construct() {
        $this->middleware('autenticado');
    }
    
    public function index() {
        $this->user_rol = session('rol');
        $this->idCliente = session('idCliente');
        if ($this->user_rol == 'AD' || $this->user_rol == 'US') {
            $cli_serv = Servicio::cliente_servicio($this->idCliente);
            $ser_k = [];
            $servicio = 'Servicios con Kunaq & Asociados';
        } else {
            $cli_serv = [];
            $ser_k = Consulta::selecciona('sgkma_servicio as s',['s.*'],'');
            $servicio = 'Servicios de Kunaq & Asociados';
        }
        $cli = SECliente::where('id',$this->idCliente)->first();
        $s = ['cu.*','s.dsc_sucursal'];
        $w = [['cu.cod_cliente','=',$this->idCliente]];
        $or = 'nombres,apellidos';
        $left = [
            'sgkma_sucursal as s' => ['s.id','=','cu.idSucursal']
        ];
        $usu = Consulta::union('sgkma_cliente_usuarios as cu',[],$s,$w,$or,$left);
        return view('perfil',compact('cli_serv','cli','ser_k','servicio','usu'));
    }
}
