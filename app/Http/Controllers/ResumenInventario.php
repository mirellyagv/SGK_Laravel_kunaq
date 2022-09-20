<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\SECliente;
use Illuminate\Http\Request;

class ResumenInventario extends Controller
{
    private $mes;
    public function __construct() {
        $this->middleware('autenticado');
        $this->mes = ["","ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
    }

    public function index() {
        if (session('rol') == "AD" || session('rol') == "US") {
            $cli = session('idCliente');
            $clientes = [];
        } else {
            $clientes = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->get();
            $cli = 0;
        }
        if (count($clientes) == 0) {
            // EQUIPOS X ESTADO
            $dato = ['op'=>1,'cli'=>$cli];
            $eq_x_est = Consulta::sp_resumen_inventario($dato);
            if (count($eq_x_est) > 0) {
                foreach ($eq_x_est as $e) {
                    $est[] = [$e->dsc_estado, $e->cantidad];
                }
                $eq_est = '<div id="equipo_x_estado"></div>';
                $eq_est .= '<script type="text/javascript">';
                $eq_est .= 'Highcharts.chart(equipo_x_estado,';
                $eq_est .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'EQUIPOS POR ESTADO: '.$this->mes[date('n')].' AÑO: '.date('Y')],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$est]]],JSON_NUMERIC_CHECK);
                $eq_est .= ');';
                $eq_est .= '</script>';
            }
            // EQUIPOS X UBICACION
            // EQUIPOS X PERIFERICO
            $dato = ['op'=>3,'cli'=>$cli];
            $eq_x_per = Consulta::sp_resumen_inventario($dato);
            if (count($eq_x_per) > 0) {
                foreach ($eq_x_per as $p) {
                    $per[] = [$p->dsc_periferico, $p->cantidad];
                }
                $eq_per = '<div id="equipo_x_periferico"></div>';
                $eq_per .= '<script type="text/javascript">';
                $eq_per .= 'Highcharts.chart(equipo_x_periferico,';
                $eq_per .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'EQUIPOS POR PERIFERICO: '.$this->mes[date('n')].' AÑO: '.date('Y')],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$per]]],JSON_NUMERIC_CHECK);
                $eq_per .= ');';
                $eq_per .= '</script>';
            }
            // EQUIPOS X MARCA
            $dato = ['op'=>4,'cli'=>$cli];
            $eq_x_mar = Consulta::sp_resumen_inventario($dato);
            if (count($eq_x_mar) > 0) {
                foreach ($eq_x_mar as $m) {
                    $mar[] = [$m->dsc_marca, $m->cantidad];
                }
                $eq_mar = '<div id="equipo_x_marca"></div>';
                $eq_mar .= '<script type="text/javascript">';
                $eq_mar .= 'Highcharts.chart(equipo_x_marca,';
                $eq_mar .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'EQUIPOS POR MARCA: '.$this->mes[date('n')].' AÑO: '.date('Y')],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$mar]]],JSON_NUMERIC_CHECK);
                $eq_mar .= ');';
                $eq_mar .= '</script>';
            }
        } else {
            $eq_est = '';
            $eq_per = '';
            $eq_mar = '';
        }
        $res['eq_x_est'] = $eq_est;
        $res['eq_x_per'] = $eq_per;
        $res['eq_x_mar'] = $eq_mar;
        return view('resumen_inventario',compact('res'));
    }
}
