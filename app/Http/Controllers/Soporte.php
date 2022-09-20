<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\SECliente;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class Soporte extends Controller
{
    private $mes;
    private $mes_abrev;

    public function __construct() {
        $this->middleware('autenticado');
        $this->mes = ["","ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        $this->mes_abrev = ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"];
    }

    public function index() {
        if (session('rol') == "AD" || session('rol') == "US") {
            $cli = SECliente::where('id',session('idCliente'))->get();
        } else {
            $cli = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->get();
        }
        return view('soporte',compact('cli'));
    }

    public function reporteServicio($id) {
        // $pdf = PDF::loadView('reporte_servicio');
        // $pdf->setPaper("A4", "landscape");
        // return $pdf->stream('cliente.pdf');
        // dd(array_unique(['2','4','4','4','4']));
        $cli = SECliente::where('id',$id)->first();
        $actividades = Consulta::selecciona('sgkma_actividad',['id','dsc_actividad'],[['flg_activo','=',1]]);
        $rep = Consulta::reporte(['cli'=>$id]);
        $reporte = [];
        $m = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        $mes = $m[date("n") - 1].' DEL '.date('Y');
        $meses = [];
        $arr_exist = [];
        $cat = [];$serie = [];
        $arr_sum = [];$act = [];
        $cod_mes = 0;
        if (count($rep) > 0) {
            foreach ($rep as $r) {
                // Meses
                $meses[] = $r->mes;
                if (!in_array($r->cod_actividad,$arr_exist)) {
                    $serie[] = ['name'=>$r->dsc_actividad,'data'=>$r->hora];
                }
                array_push($arr_exist, $r->cod_actividad);
                $me[$r->dsc_actividad][] = substr(str_replace(":",".",$r->hora), 0,5);
                // Obtener la suma total de horas en sum_tot
                $cmes = $r->mes;
                if ($cod_mes <> $cmes) {
                    $sum_tot = 0;
                }
                $cod_mes = $cmes;
                $parts = explode(":", $r->hora);
                $sum_tot = $sum_tot + round(($parts[0]*3600 + $parts[1]*60 + $parts[2]), 2);
                $arr_sum[$r->mes] = $sum_tot;
            }
            // Obtener Meses
            if (count($meses) > 0) {
                $m_u = array_unique($meses);
                foreach ($m_u as $mu) {
                    $cat[] = $m[$mu - 1];
                }
            }
            // Obtener los tados de las actividades
            foreach ($serie as $i => $v) {
                foreach ($me as $mi => $mv) {
                    if ($v['name'] === $mi) {
                        if (count($m_u) == count($mv)) {
                            $serie[$i]['data'] = $mv;
                        } else {
                            $serie[$i]['data'] = array_reverse(array_pad($mv, count($m_u), ''));
                        }
                    }
                }
            }
            // Obtener la sumatoria total de las horas
            foreach ($rep as $re) {
                if (isset($arr_sum[$re->mes])) {
                    $act[$re->cod_actividad][$re->mes] = round((substr(str_replace(":",".",$re->hora), 0,5) / $this->horaMin($arr_sum[$re->mes])) * 100, 1);
                }
            }
        }
        // dd([$arr_sum,$act]);
        $reporte['grafico'] = json_encode(['chart'=>['type'=>'column'],'title'=>['text'=>''],'xAxis'=>['categories'=>$cat,'crosshair'=>true],'yAxis'=>['min'=>0,'title'=>['text'=>'']],'tooltip'=>['headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>','pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td>' . '<td style="padding:0"><b>{point.y:.2f} H.M</b></td></tr>','footerFormat'=>'</table>','shared'=>true,'useHTML'=>true],'plotOptions'=>['column'=>['pointPadding'=>0.2,'borderWidth'=>0]],'series'=>$serie],JSON_NUMERIC_CHECK);

        return view('reporte_servicio',compact('m','cli','mes','reporte','actividades','act'));

        // $pdf = PDF::loadView('reporte_servicio');
        // $pdf->setOption('enable-javascript', true);
        // $pdf->setOption('javascript-delay', 5000);
        // $pdf->setOption('enable-smart-shrinking', true);
        // $pdf->setOption('no-stop-slow-scripts', true);
        // return $pdf->download('cliente.pdf');
    }

    public function horaMin($seg) {
        $horas = floor($seg/ 3600);
        $minutos = floor(($seg - ($horas * 3600)) / 60);
        // $segundos = $seg - ($horas * 3600) - ($minutos * 60);
        return $horas.'.'.$minutos;
    }
    // REPORTE TIPO ATENCION
    public function tipoAtencion() {
        try {
            if (session('rol') == "AD" || session('rol') == "US") {
                $cli = session('idCliente');
                $clientes = [];
            } else {
                $clientes = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->get();
                $cli = 0;
            }
            $mess = $this->mes;
            $ta = Consulta::selecciona('sgkma_tipo_atencion',['id','dsc_tipo_atencion'],[['flg_activo','=',1]]);
            if (count($clientes) == 0) {
                // PIE
                $sp = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>1,'cli'=>$cli,'anio'=>date('Y'),'mes'=>date('m'),'var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[] = [$p->dsc_tipo_atencion, $p->cantidad];
                    }
                    $pie = '<div id="pie_mes"></div>';
                    $pie .= '<script type="text/javascript">';
                    $pie .= 'Highcharts.chart(pie_mes,';
                    $pie .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'TIPO DE ATENCIÓN MES: '.$this->mes[date('n')].' AÑO: '.date('Y')],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$data]]],JSON_NUMERIC_CHECK);
                    $pie .= ');';
                    $pie .= '</script>';
                } else {
                    $pie = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                // LINEAL
                // $sp1 = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>2,'cli'=>$cli,'anio'=>date('Y'),'mes'=>date('m'),'var'=>'']);
                // BARRA
                $sp3 = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>3,'cli'=>$cli,'anio'=>date('Y'),'mes'=>'','var'=>'']);
                if (count($sp3) > 0) {
                    foreach ($sp3 as $p) {
                        $data[$p->mes] = $p->cantidad;
                    }
                    for ($i = 1; $i <= 12; $i++) { 
                        if (isset($data[$i])) {
                            $da[] = $data[$i];
                        } else {
                            $da[] = '';
                        }
                    }
                    $dato[0]['name'] = date('Y');
                    $dato[0]['data'] = $da;
                    $barra = '<div id="barra_b"></div>';
                    $barra .= '<script type="text/javascript">';
                    $barra .= 'Highcharts.chart(barra_b,';
                    $barra .= json_encode(['chart'=>['type'=>'cylinder','options3d'=>['enabled'=>true,'alpha'=>15,'beta'=>15,'depth'=>50,'viewDistance'=>25]],'title'=>['text'=>'TOTAL ATENCIONES AÑO: '.date('Y')],'yAxis'=>['title'=>['text'=>'']],'xAxis'=>['categories'=>$this->mes_abrev],'plotOptions'=>['series'=>['depth'=>25,'colorByPoint'=>true]],'series'=>$dato],JSON_NUMERIC_CHECK);
                    $barra .= ');';
                    $barra .= '</script>';
                } else {
                    $barra = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
            } else {
                $pie = '';
                $barra = '';
            }
            $res['pie'] = $pie;
            $res['barra'] = $barra;
            return view('tipo_atencion',compact('mess','res','ta','clientes'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
    // CONSULTA PIE
    public function atencionTipo(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>1,'cli'=>$cli,'anio'=>$re->anio,'mes'=>$re->mes,'var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[] = [$p->dsc_tipo_atencion, $p->cantidad];
                    }
                    $div = '<div id="pie_mes"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(pie_mes,';
                    $div .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'TIPO DE ATENCIÓN MES: '.$this->mes[$re->mes].' AÑO: '.$re->anio],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$data]]],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                //throw $th;
            }
        }
    }
    // CONSULTA LINEAL
    public function atencionLineal(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>2,'cli'=>$cli,'anio'=>$re->anio,'mes'=>'','var'=>$re->tipo_atencion]);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $ate[$p->mes] = $p->cantidad;
                        $name = $p->dsc_tipo_atencion;
                    }
                    for ($i = 1; $i <= 12; $i++) {
                        if (isset($ate[$i])) {
                            $asd[] = $ate[$i];
                        } else {
                            $asd[] = '';
                        }
                    }
                    // dd($asd);
                    // foreach ($sp as $p) {
                        $data[] = ['name'=>$name,'data'=>$asd];
                    // }
                    $div = '<div id="lineal_l"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(lineal_l,';
                    $div .= json_encode(['chart'=>['type'=>'line'],'title'=>['text'=>mb_strtoupper($name).' AÑO: '.$re->anio],'subtitle'=>['text'=>''],'xAxis'=>['categories'=>$this->mes_abrev],'yAxis'=>['title'=>['text'=>'']],'plotOptions'=>['line'=>['dataLabels'=>['enable'=>true],'enableMouseTracking'=>true]],'series'=>$data],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // CONSULTA BARRA
    public function atencionBarra(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>3,'cli'=>$cli,'anio'=>$re->anio,'mes'=>'','var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[$p->mes] = $p->cantidad;
                    }
                    for ($i = 1; $i <= 12 ; $i++) {
                        if (isset($data[$i])) {
                            $da[] = $data[$i];
                        } else {
                            $da[] = '';
                        }
                    }
                    $dato[0]['name'] = date('Y');
                    $dato[0]['data'] = $da;
                    $div = '<div id="barra_b"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(barra_b,';
                    $div .= json_encode(['chart'=>['type'=>'cylinder','options3d'=>['enabled'=>true,'alpha'=>15,'beta'=>15,'depth'=>50,'viewDistance'=>25]],'title'=>['text'=>'TOTAL ATENCIONES AÑO: '.$re->anio],'yAxis'=>['title'=>['text'=>'']],'xAxis'=>['categories'=>$this->mes_abrev],'plotOptions'=>['series'=>['depth'=>25,'colorByPoint'=>true]],'series'=>$dato],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // REPORTE MODALIDAD ATENCION
    public function modalidadAtencion() {
        try {
            if (session('rol') == "AD" || session('rol') == "US") {
                $cli = session('idCliente');
                $clientes = [];
            } else {
                $clientes = SECliente::where('flg_activo',1)->whereNotIn('id',[1])->get();
                $cli = 0;
            }
            $mess = $this->mes;
            $ts = Consulta::selecciona('sgkma_tipo_soporte',['id','dsc_tipo_soporte'],[['flg_activo','=',1]]);
            if (count($clientes) == 0) {
                // PIE
                $sp = Consulta::sp_soporte_resumen(['op'=>2,'op2'=>1,'cli'=>$cli,'anio'=>date('Y'),'mes'=>date('m'),'var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[] = [$p->dsc_tipo_soporte, $p->cantidad];
                    }
                    $pie = '<div id="pie_mes"></div>';
                    $pie .= '<script type="text/javascript">';
                    $pie .= 'Highcharts.chart(pie_mes,';
                    $pie .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'TIPO DE ATENCIÓN MES: '.$this->mes[date('n')].' AÑO: '.date('Y')],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$data]]],JSON_NUMERIC_CHECK);
                    $pie .= ');';
                    $pie .= '</script>';
                } else {
                    $pie = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                // LINEAL
                // $sp1 = Consulta::sp_soporte_resumen(['op'=>2,'op2'=>2,'cli'=>$cli,'anio'=>date('Y'),'mes'=>date('m'),'var'=>'']);
                // BARRA
                $sp3 = Consulta::sp_soporte_resumen(['op'=>2,'op2'=>3,'cli'=>$cli,'anio'=>date('Y'),'mes'=>'','var'=>'']);
                if (count($sp3) > 0) {
                    foreach ($sp3 as $p) {
                        $data[$p->mes] = $p->cantidad;
                    }
                    for ($i = 1; $i <= 12; $i++) { 
                        if (isset($data[$i])) {
                            $da[] = $data[$i];
                        } else {
                            $da[] = '';
                        }
                    }
                    $dato[0]['name'] = date('Y');
                    $dato[0]['data'] = $da;
                    $barra = '<div id="barra_b"></div>';
                    $barra .= '<script type="text/javascript">';
                    $barra .= 'Highcharts.chart(barra_b,';
                    $barra .= json_encode(['chart'=>['type'=>'cylinder','options3d'=>['enabled'=>true,'alpha'=>15,'beta'=>15,'depth'=>50,'viewDistance'=>25]],'title'=>['text'=>'TOTAL ATENCIONES AÑO: '.date('Y')],'yAxis'=>['title'=>['text'=>'']],'xAxis'=>['categories'=>$this->mes_abrev],'plotOptions'=>['series'=>['depth'=>25,'colorByPoint'=>true]],'series'=>$dato],JSON_NUMERIC_CHECK);
                    $barra .= ');';
                    $barra .= '</script>';
                } else {
                    $barra = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
            } else {
                $pie = '';
                $barra = '';
            }
            $res['pie'] = $pie;
            $res['barra'] = $barra;
            return view('modalidad_atencion',compact('mess','res','ts','clientes'));
        } catch (\Throwable $e) {
            // return $e->getMessage();
        }
    }
    // CONSULTA PIE
    public function modalidadTipo(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>2,'op2'=>1,'cli'=>$cli,'anio'=>$re->anio,'mes'=>$re->mes,'var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[] = [$p->dsc_tipo_soporte, $p->cantidad];
                    }
                    $div = '<div id="pie_mes"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(pie_mes,';
                    $div .= json_encode(['chart'=>['type'=>'pie','options3d'=>['enabled'=>true,'alpha'=>45]],'title'=>['text'=>'TIPO DE ATENCIÓN MES: '.$this->mes[$re->mes].' AÑO: '.$re->anio],'subtitle'=>['text'=>''],'plotOptions'=>['pie'=>['innerSize'=>100,'depth'=>45]],'series'=>[['data'=>$data]]],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // CONSULTA LINEAL
    public function modalidadLineal(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>2,'op2'=>2,'cli'=>$cli,'anio'=>$re->anio,'mes'=>'','var'=>$re->tipo_atencion]);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $ate[$p->mes] = $p->cantidad;
                        $name = $p->dsc_tipo_soporte;
                    }
                    for ($i = 1; $i <= 12; $i++) {
                        if (isset($ate[$i])) {
                            $asd[] = $ate[$i];
                        } else {
                            $asd[] = '';
                        }
                    }
                    // dd($asd);
                    // foreach ($sp as $p) {
                        $data[] = ['name'=>$name,'data'=>$asd];
                    // }
                    $div = '<div id="lineal_l"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(lineal_l,';
                    $div .= json_encode(['chart'=>['type'=>'line'],'title'=>['text'=>mb_strtoupper($name).' AÑO: '.$re->anio],'subtitle'=>['text'=>''],'xAxis'=>['categories'=>$this->mes_abrev],'yAxis'=>['title'=>['text'=>'']],'plotOptions'=>['line'=>['dataLabels'=>['enable'=>true],'enableMouseTracking'=>true]],'series'=>$data],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
    // CONSULTA BARRA
    public function modalidadBarra(Request $re) {
        if ($re->isMethod('POST')) {
            try {
                if (session('rol') == "AD" || session('rol') == "US") {
                    $cli = session('idCliente');
                } else {
                    $cli = $re->cod_cliente;
                }
                $sp = Consulta::sp_soporte_resumen(['op'=>1,'op2'=>3,'cli'=>$cli,'anio'=>$re->anio,'mes'=>'','var'=>'']);
                if (count($sp) > 0) {
                    foreach ($sp as $p) {
                        $data[$p->mes] = $p->cantidad;
                    }
                    for ($i = 1; $i <= 12 ; $i++) {
                        if (isset($data[$i])) {
                            $da[] = $data[$i];
                        } else {
                            $da[] = '';
                        }
                    }
                    $dato[0]['name'] = date('Y');
                    $dato[0]['data'] = $da;
                    $div = '<div id="barra_b"></div>';
                    $div .= '<script type="text/javascript">';
                    $div .= 'Highcharts.chart(barra_b,';
                    $div .= json_encode(['chart'=>['type'=>'cylinder','options3d'=>['enabled'=>true,'alpha'=>15,'beta'=>15,'depth'=>50,'viewDistance'=>25]],'title'=>['text'=>'TOTAL ATENCIONES AÑO: '.$re->anio],'yAxis'=>['title'=>['text'=>'']],'xAxis'=>['categories'=>$this->mes_abrev],'plotOptions'=>['series'=>['depth'=>25,'colorByPoint'=>true]],'series'=>$dato],JSON_NUMERIC_CHECK);
                    $div .= ');';
                    $div .= '</script>';
                } else {
                    $div = '<div class="alert alert-danger">No hay registros a mostrar</div>';
                }
                return $div;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }
}
