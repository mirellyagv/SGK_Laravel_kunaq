<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE SERVICIO</title>
    <link rel="shortcut icon" href="{{asset('image/favicon.png')}}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <style>
        .table-bordered-danger {
            border-color: #AA0000;
        }
        .table-bordered-danger thead th {
            background-color: #AA0000;
        }
    </style>
    <!-- HIGGHCHARTS -->
    <script src="{{ asset('highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('highcharts/highcharts-3d.js') }}"></script>
    <script src="{{ asset('highcharts/exporting.js') }}"></script>
    <script src="{{ asset('highcharts/export-data.js') }}"></script>
    <script src="{{ asset('highcharts/accessibility.js') }}"></script>
</head>
<body>
    <div id="capture" class="container card-box">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="logo-box float-left position-absolute">
                    <a href="#" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('image/Logo_KQ_web.png') }}" height="70">
                        </span>
                    </a>
                </div>
                <p><b>REPORTE DE SERVICIOS DE CONSULTORIA DE TECNOLOGIA DE INFORMACION</b></p>
                <p><b>CLIENTE: {{ strtoupper($cli->dsc_cliente) }}</b></p>
                <p><b>{{ $mes }}</b></p>
            </div>
        </div>
        <div class="row">
            @if(count($reporte) > 0)
                @foreach($reporte as $rr => $r)
                    <div class="col-lg-12">
                        <div id="{{$rr}}"></div>
                    </div>
                    <script type="text/javascript">
                        Highcharts.chart('{{$rr}}',<?php echo $r; ?>);
                    </script>
                @endforeach
            @else
                <div class="alert alert-danger">No hay registros a mostrar</div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table m-0 table-colored-bordered table-bordered-danger">
                        <thead>
                            <tr>
                                <th>GRUPO ACTIVIDAD</th>
                                @foreach($m as $i)
                                    <th>{{ substr($i, 0, 3) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actividades as $ac)
                                <tr>
                                    <td>{{ $ac->dsc_actividad }}</td>
                                    @for($i = 1; $i <= 12; $i++)
                                        @if(isset($act[$ac->id][$i]))
                                            <td><b>{{ $act[$ac->id][$i] }} %</b></td>
                                        @else
                                            <td>{{ 0 }} %</td>
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>