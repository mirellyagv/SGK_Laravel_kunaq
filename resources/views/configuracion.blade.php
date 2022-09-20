@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript: void(0);"><b>Configuración</b></a> <span class="uri-seg"> > </span>Tablas Maestras</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row">
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/control') }}"><img class="man elemento" src="{{asset('image/configuracion/control_acceso.png')}}" alt="acceso" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/periferico') }}"><img class="man elemento" src="{{asset('image/configuracion/periferico.png')}}" alt="periferico" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/marca') }}"><img class="man elemento" src="{{asset('image/configuracion/marca.png')}}" alt="marca" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/modelo') }}"><img class="man elemento" src="{{asset('image/configuracion/modelo.png')}}" alt="modelo" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/procesador') }}"><img class="man elemento" src="{{asset('image/configuracion/tipo_procesador.png')}}" alt="procesadores" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/estado') }}"><img class="man elemento" src="{{asset('image/configuracion/estado.png')}}" alt="estado" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/servicios') }}"><img class="man elemento" src="{{asset('image/configuracion/servicios.png')}}" alt="servicios" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/tipo-atencion') }}"><img class="man elemento" src="{{asset('image/configuracion/tipo-atencion.png')}}" alt="tipo-atencion" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/modalidad') }}"><img class="man elemento" src="{{asset('image/configuracion/modalidad_atencion.png')}}" alt="modadlidad-atencion" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/categoria-software') }}"><img class="man elemento" src="{{asset('image/configuracion/categoria-software.png')}}" alt="categoria-software" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/software') }}"><img class="man elemento" src="{{asset('image/configuracion/software.png')}}" alt="software" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/clientes') }}"><img class="man elemento" src="{{asset('image/configuracion/cliente.png')}}" alt="clientes" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="{{ url('config/equipos') }}"><img class="man elemento" src="{{asset('image/configuracion/equipo.png')}}" alt="equipos-cliente" width="100%"></a>
                    </div>
                    <div class="col-lg-3 text-center mb-5">
                        <a href="javascript:void(0)"><img class="man elemento" src="{{asset('image/configuracion/servicios_cliente.png')}}" alt="servicios-cliente" width="100%"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .man {
            opacity: 0.8;
        }
        .man:hover {
            opacity: 1;
        }
        .elemento {
            box-shadow: 8px 8px 11px #999;
            /* webkit-box-shadow: 2px 2px 5px #999;
            -moz-box-shadow: 2px 2px 5px #999; */
        }
        .col-lg-3 img {
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease; /* Opera */
            width:100%;
        }
        .col-lg-3:hover img {
            -webkit-transform:scale(1.25);
            -moz-transform:scale(1.25);
            -ms-transform:scale(1.25);
            -o-transform:scale(1.25);
            transform:scale(1.25);
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            // var a = sha1('hola');
            // console.log(a);
            // alert(a);
        });
    </script>
@endpush