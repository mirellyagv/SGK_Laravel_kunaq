<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public function index() {
        return view('login');
    }

    public function autentication(Request $re) {
        if ($re->isMethod('POST')) {
            $v = Validator::make($re->all(),[
                'ruc' => 'required|numeric|digits:11',
                'username' => 'required|string',
                'pass' => 'required|string'
            ]);
            if ($v->fails()) {
                return back();
            }
            try {
                $login = Consulta::logeo($re);
                if (count($login) > 0) {
                    $re->session()->regenerate();
                    Session::put('idUser', $login[0]->idUser);
                    Session::put('usuario', $login[0]->dsc_usuario);
                    Session::put('ruc', $login[0]->ruc);
                    Session::put('idCliente', $login[0]->idCliente);
                    Session::put('rol', $login[0]->rol);
                    return redirect('general');
                } else {
                    return back();
                }
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function logout(Request $re){
        Session::flush();
        $re->session()->invalidate();
        return redirect('/');
    }
}
