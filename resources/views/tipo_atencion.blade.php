@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Resumen de Soporte Técnico</b></a> <span class="uri-seg"> > </span>Tipo de Atención</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 card-box">
            <ul class="nav nav-tabs tabs-bordered">
                <li class="nav-item">
                    <a href="#pie" data-toggle="tab" aria-expanded="true" class="nav-link active">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Resumen Mensual</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#lineal" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Detalle por Atención</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#barra" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Total Atenciones</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="pie">
                    <div class="row card-box">
                        <div class="col-md-12">
                            <form id="FrmPie">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Año</label>
                                            <select name="anio" class="form-control">
                                                <option value="{{date('Y')}}">{{ date('Y') }}</option>
                                                @for($i = 1; $i <= 4; $i++)
                                                    <option value="{{date('Y') - $i}}">{{ date('Y') - $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mes</label>
                                            <select name="mes" class="form-control">
                                                <option value="{{date('n')}}">{{ $mess[date('n')] }}</option>
                                                @for($i = 1; $i <= date('n') - 1; $i++)
                                                <option value="{{date('m') - $i}}">{{ $mess[date('n') - $i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    @if(count($clientes) > 0)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select name="cod_cliente" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($clientes as  $c)
                                                <option value="{{$c->id}}">{{ $c->dsc_cliente }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-kunaq mt-3 filtro"><i class="fe-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class=" mt-3 col-md-12 pie">
                            <?= $res['pie'] ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="lineal">
                    <div class="row card-box">
                        <div class="col-md-12">
                            <form id="FrmLineal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Año</label>
                                            <select name="anio" class="form-control">
                                                <option value="{{date('Y')}}">{{ date('Y') }}</option>
                                                @for($i = 1; $i <= 4; $i++)
                                                    <option value="{{date('Y') - $i}}">{{ date('Y') - $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Atención</label>
                                            <select name="tipo_atencion" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($ta as $a)
                                                <option value="{{$a->id}}">{{ $a->dsc_tipo_atencion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if(count($clientes) > 0)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select name="cod_cliente" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($clientes as  $c)
                                                <option value="{{$c->id}}">{{ $c->dsc_cliente }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-kunaq mt-3 filtro-l"><i class="fe-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-3 col-md-12 lineal">
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="barra">
                    <div class="row card-box">
                        <div class="col-md-12">
                            <form id="FrmBarra">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Año</label>
                                            <select name="anio" class="form-control">
                                                <option value="{{date('Y')}}">{{ date('Y') }}</option>
                                                @for($i = 1; $i <= 4; $i++)
                                                    <option value="{{date('Y') - $i}}">{{ date('Y') - $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    @if(count($clientes) > 0)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select name="cod_cliente" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($clientes as  $c)
                                                <option value="{{$c->id}}">{{ $c->dsc_cliente }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-kunaq mt-3 filtro-b"><i class="fe-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-3 col-md-12 barra">
                            <?= $res['barra'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();

            $(".filtro").on('click',function() {
                Frm = $("#FrmPie").serializeArray();
                $(".pie").empty();
                $.post("{{ url('soporte/atencion') }}",Frm,function(r) {
                    $(".pie").html(r);
                });
            });

            $(".filtro-l").on('click',function() {
                Frm = $("#FrmLineal").serializeArray();
                $(".lineal").empty();
                $.post("{{ url('soporte/atencion-lineal') }}",Frm,function(r) {
                    $(".lineal").html(r);
                });
            });

            $(".filtro-b").on('click',function() {
                Frm = $("#FrmBarra").serializeArray();
                $(".barra").empty();
                $.post("{{ url('soporte/atencion-barra') }}",Frm,function(r) {
                    $(".barra").html(r);
                });
            });
        });
    </script>
@endpush