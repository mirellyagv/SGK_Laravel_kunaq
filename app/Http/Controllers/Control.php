<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Control extends Controller
{
    private $idUser;
    private $idCliente;
    public function __construct() {
       $this->middleware('autenticado');
    }

    public function control() {
        $this->idCliente = session('idCliente');
        $usu = Consulta::usuarios($this->idCliente);
        return view('control',compact('usu'));
    }

    public function usuario(Request $re) {
        if ($re->isMethod('POST')) {
            $this->idCliente = session('idCliente');
            $this->idUser = session('idUser');
            try {
                if (!empty($re->xid)) {
                    $where = [['id','=',$re->xid],['idCliente','=',$this->idCliente]];
                    if (!empty($re->clv)) {
                        $v = Validator::make($re->all(),[
                            'clave' => 'required|string'
                        ]);
                        if ($v->fails()) {
                            return ['confirm'=>0,'msg'=>"Campos Obligatorios"];
                        }
                        $data = [
                            'clave' => sha1($re->clave),
                            'fch_modifica' => date('Y-m-d H:i:s'),
                            'cod_usr_modifica' => $this->idUser
                        ];
                    } else {
                        $v = Validator::make($re->all(),[
                            'nombre' => 'required|string',
                            'usuario' => 'required|string'
                        ]);
                        if ($v->fails()) {
                            return ['confirm'=>0,'msg'=>"Campos Obligatorios"];
                        }
                        $data = [
                            'dsc_usuario' => mb_strtoupper($re->nombre),
                            'login' => mb_strtoupper($re->usuario),
                            'fch_modifica' => date('Y-m-d H:i:s'),
                            'cod_usr_modifica' => $this->idUser
                        ];
                    }
                    $ac = Consulta::actualiza('sgkma_usuario',$data,$where);
                    if ($ac > 0) {
                        return ['confirm'=>1,'msg'=>"La operación se realizó con éxito!"];
                    }
                } else {
                    $v = Validator::make($re->all(),[
                        'nombre' => 'required|string',
                        'usuario' => 'required|string',
                        'clave' => 'required|string'
                    ]);
                    if ($v->fails()) {
                        return ['confirm'=>0,'msg'=>"Campos Obligatorios"];
                    }
                    $data = [
                        'idCliente' => $this->idCliente,
                        'dsc_usuario' => mb_strtoupper($re->nombre),
                        'login' => mb_strtoupper($re->usuario),
                        'clave' => sha1($re->clave),
                        'rol' => 3,
                        'cod_usr_crea' => $this->idUser
                    ];
                    $in = Consulta::ingreso('sgkma_usuario',$data);
                    if ($in > 0) {
                        return ['confirm'=>1,'msg'=>"La operación se realizó con éxito!"];
                    }
                }
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function getUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $this->idCliente = session('idCliente');
            $se = ['id','dsc_usuario','login'];
            $w = [['id','=',$re->id],['idCliente','=',$this->idCliente]];
            try {
                return Consulta::selecciona('sgkma_usuario',$se,$w);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function delUsuario(Request $re) {
        if ($re->isMethod('POST')) {
            $this->idCliente = session('idCliente');
            $data = ['flg_activo' => 0];
            $w = [['id','=',$re->id],['idCliente','=',$this->idCliente]];
            return Consulta::actualiza('sgkma_usuario',$data,$w);
        }
    }
}
