@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript:void(0)"><b>Incidencias</b></a></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box id-tabs">
                @if(count($tarjetas) > 0)
                    <div class="row mb-3">
                        @foreach($tarjetas as $k=>$v)
                            <div class="col-md-3 tarjeta" style="background: <?= $v['color'] ?>">
                                <h3>{{ $k }}</h3>
                                <p>{{ $v['cantidad'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#lista-incidencia" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista de Incidencia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#incidencia" id="l-incidencia" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Detalle de la Incidencia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#detalle" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Atenciones</span>
                        </a>
                    </li>
                    @if(empty($cc))
                    <li class="nav-item">
                        <a href="#nueva-atencion" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Nueva Atencion</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-incidencia">
                        <div class="row lista">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                    <div class="card-body">
                                        <form id="FrmSearch">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Cliente:</label>
                                                        @if(!empty($cc))
                                                            <div class="form-control">{{$cli[0]->dsc_cliente}}</div>
                                                            <input type="hidden" name="f_cod_cliente" value="{{$cli[0]->id}}">
                                                        @else
                                                            <select class="form-control vali" name="f_cod_cliente" id="f_cod_cliente">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cli as $c)
                                                            <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                            @endforeach
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicio:</label>
                                                        <input type="date" class="form-control" name="f_fch_inicio" id="f_fch_inicio" value="{{ date('Y-m-01') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Fin:</label>
                                                        <input type="date" class="form-control" name="f_fch_fin" id="f_fch_fin" value="{{ date('Y-m-t') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Estado:</label>
                                                        <select name="f_estado" class="form-control">
                                                            <option value="0">Seleccione</option>
                                                            @foreach($estados as $est)
                                                                <option value="{{$est->id}}">{{$est->dsc_estado}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-kunaq mt-3 search"><i class="fe-search"></i> Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row lista">
                            <div class="col-md-12 mt-3">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new_inc">Nuevo</button></div>
                                    <div class="card-body table-responsive">
                                        <table id="table-incidencia" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ACCION</th>
                                                    <th class="text-center">CÓDIGO</th>
                                                    <th class="text-center">TIPO INCIDENTE</th>
                                                    <th class="text-center">CLIENTE</th>
                                                    <th class="text-center">TÍTULO</th>
                                                    <th class="text-center">FECHA</th>
                                                    <th class="text-center">ASIGNADO A</th>
                                                    <th class="text-center">ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody class="l-inc">
                                                <?php $i = 1; ?>
                                                @foreach($inc as $in)
                                                <?php
                                                    $icon = '<a href="javascript:void(0)" class="uri-seg cerrar" title="CERRAR" id="'.$in->id.'" nom="'.$in->titulo.'"><i class="icon-lock-open"></i></a>';
                                                    if($in->estado == 3) {
                                                        $icon = '<a href="javascript:void(0)" class="uri-seg" title="CERRADO"><i class="icon-lock"></i></a>';
                                                    }
                                                    if($in->estado == 17) {//PENDIENTE
                                                        $cl = 'badge-danger';
                                                    } elseif ($in->estado == 18) {//PROCESO
                                                        $cl = 'badge-warning';
                                                    } elseif ($in->estado == 19) {//CERRADO
                                                        $cl = 'badge-success';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $in->id }}</td>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-center"><?= $icon ?></td>
                                                    <td class="text-center">{{ str_pad($in->id,100) }}</td>
                                                    <td class="text-center">{{ $in->dsc_tipo_atencion }}</td>
                                                    <td class="text-center">{{ $in->dsc_cliente }}</td>
                                                    <td>{{ $in->titulo }}</td>
                                                    <td class="text-center">{{ $in->fch_crea }}</td>
                                                    <td class="text-center">{{ $in->dsc_usuario }}</td>
                                                    <td class="text-center"><span class="badge label-table {{$cl}}">{{ $in->dsc_estado }}</span></td>
                                                </tr>
                                                <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="incidencia">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo">Creación de una nueva incidencia</label></div>
                                    <div class="card-body">
                                        <form id="FrmIncidencia" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Código:</label>
                                                        <div class="form-control" id="codigo"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>F.Registro:</label>
                                                        <input type="date" class="form-control vali" name="fch_crea" id="fch_crea" value="{{date('Y-m-d')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Hora:</label>
                                                        <input type="time" class="form-control vali" name="tiempo_hora" id="tiempo_hora" value="{{date('H:i')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Cliente:</label>
                                                        @if(!empty($cc))
                                                            <div class="form-control">{{$cli[0]->dsc_cliente}}</div>
                                                            <input type="hidden" name="idCliente" id="idCliente" value="{{$cli[0]->id}}">
                                                        @else
                                                            <select class="form-control vali" name="idCliente" id="idCliente">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cli as $c)
                                                            <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                            @endforeach
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sucursal:</label>
                                                        @if(count($suc) > 0)
                                                            <select class="form-control vali" name="idSucursal" id="idSucursal">
                                                                <option value="">Seleccione</option>
                                                                @foreach($suc as $su)
                                                                    <option value="{{ $su->id }}">{{ $su->dsc_sucursal }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <select class="form-control vali" name="idSucursal" id="idSucursal">
                                                                <option value="">Seleccione</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Usuario:</label>
                                                        <select class="form-control vali" name="idUsuario" id="idUsuario">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tipo:</label>
                                                        <select class="form-control vali" name="idTipoIncidencia" id="idTipoIncidencia">
                                                            <option value="">Seleccione</option>
                                                            <option value="1">Mantenimiento</option>
                                                            <option value="2">Soporte Técnico</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tipo:</label>
                                                        <select class="form-control vali" name="idTipoIncidencia" id="idTipoIncidencia">
                                                            <option value="">Seleccione</option>
                                                            @foreach($t_ate as $ta)
                                                            <option value="{{ $ta->id }}">{{ $ta->dsc_tipo_atencion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Servicios:</label>
                                                        <select class="form-control vali" name="cod_actividad" id="cod_actividad">
                                                            @foreach($act as $a)
                                                            <option value="{{ $a->id }}">{{ $a->dsc_actividad }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Prioridad:</label>
                                                        <select class="form-control" name="prioridad" id="prioridad">
                                                            <option value="1">Alta</option>
                                                            <option value="2">Media</option>
                                                            <option value="3">Baja</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Equipo:</label>
                                                        <select class="form-control" name="equipo" id="equipo">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @if(count($soporte) > 0)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Usuario Soporte:</label>
                                                        <select class="form-control" name="usu_soporte" id="usu_soporte">
                                                            <option value="">Seleccione</option>
                                                            @foreach($soporte as $s)
                                                                <option value="{{ $s->id }}">{{ $s->dsc_usuario }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Título:</label>
                                                        <input type="text" class="form-control vali" name="titulo" id="titulo" placeholder="Ingrese Título" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Detalle:</label>
                                                        <textarea class="form-control" name="obs" id="obs" cols="30" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="xid" id="xid">
                                        </form>
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-secondary radio limpiar">Nuevo</button>
                                            <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="detalle">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="deta-incidencia" class="table-responsive">
                                    <div class="alert alert-danger">Seleccione una Incidencia</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(empty($cc))
                    <div class="tab-pane show" id="nueva-atencion">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo-atencion"></label></div>
                                    <div class="card-body">
                                        <form id="FrmAtencion" method="post">
                                            @csrf
                                            <!-- <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1">
                                                            <input type="checkbox" id="ate" name="ate" value="1">
                                                            <label for="inc">Crear Atención</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Cliente:</label>
                                                        <select class="form-control vali" name="cod_cliente" id="cod_cliente">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                        <input type="hidden" name="idIncidencia" id="idIncidencia">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sucursal:</label>
                                                        <select class="form-control vali" name="cod_sucursal" id="cod_sucursal">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Usuario:</label>
                                                        <select class="form-control vali" name="usuario" id="usuario">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Modalidad de atención:</label>
                                                        <select class="form-control vali" name="cod_soporte" id="cod_soporte">
                                                            <option value="">Seleccione</option>
                                                            @foreach($t_sop as $tp)
                                                            <option value="{{ $tp->id }}">{{ $tp->dsc_tipo_soporte }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha y hora :</label>
                                                        <input type="text" class="form-control rango_fecha vali" name="daterange" id="fecha_rango"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tiempo de Atención:</label>
                                                        <div class="form-control" id="tiempo_atencion"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado:</label>
                                                        <select name="estado" class="form-control">
                                                            @foreach($estados as $est)
                                                                @if($est->id <> 17)
                                                                    <option value="{{$est->id}}">{{$est->dsc_estado}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <h5 class="card-title mt-3">Detalles de Atención</h5> -->
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Evento Presentado:</label>
                                                        <textarea class="form-control vali" name="evento" id="evento" cols="30" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Detalle Atención:</label>
                                                        <textarea class="form-control" name="obs" id="obs" cols="30" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Pendientes:</label>
                                                        <textarea class="form-control" name="pendiente" id="pendiente" cols="30" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="xid" id="xid">
                                        </form>
                                        <div class="col-lg-12 mt-3">
                                            <button type="button" class="btn btn-secondary radio cancel">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar-atencion">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .tarjeta{
            position: relative;
            margin-right: 15px;
            height: 100px;
        }
        .tarjeta > h3 {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -15px 0 0 -70px;
            color: #fff;
            font-weight: 600;
        }
        .tarjeta > p {
            color: #fff;
            font-weight: 600;
            font-size: 25px;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();
            // $(".create").hide();
            // $("#cod_sucursal").prop('disabled',true);
            // $("#usuario").prop('disabled',true);
            tableIncidencia('table-incidencia');

            $(".limpiar").on('click',function() {
                $(".titulo").html('Creación de una nueva incidencia');
                // $(".lista").hide();
                $("#FrmIncidencia")[0].reset();
                $("#codigo").html('');
                $("#xid").val('');
                <?php if(count($suc) == 0) { ?>
                option('idSucursal');
                <?php } ?>
                option('idUsuario');
                option("equipo");
                // $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });

            $('#table-incidencia tbody').on('dblclick', 'tr', function() {
                var table = $('#table-incidencia').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    limpiar();
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][0];
                    name = table.rows('.selected').data()[0][6];
                    // EDITAR INCIDENCIA
                    $(".titulo").html('Modificación de una incidencia');
                    option('idSucursal');
                    option('idUsuario');
                    option('equipo');
                    $.post("{{ url('soporte/edita-incidencia') }}", {id: id,_token: tk}, function(r) {
                        $("#codigo").html(('0000000000' + r.inc.id).slice(-10));
                        $("#idCliente").val(r.inc.idCliente);
                        //Sucursal
                        $.each(r.suc,function(i,s) {
                            $("#idSucursal").append('<option value="'+s.id+'">'+s.dsc_sucursal+'</option>');
                        });
                        $("#idSucursal").val(r.inc.idSucursal);
                        //Usuario
                        $.each(r.usu,function(i,u) {
                            $("#idUsuario").append('<option value="'+u.id+'">'+u.nombres+' '+u.apellidos+'</option>');
                        });
                        $("#idUsuario").val(r.inc.idUsuario);
                        //Equipo
                        $.each(r.eq,function(i,e) {
                            $("#equipo").append('<option value="'+e.id+'">'+e.dsc_equipo+'</option>');
                        });
                        $("#equipo").val(r.inc.equipo);
                        //Tipo
                        $("#idTipoIncidencia").val(r.inc.idTipoIncidencia);
                        //Fecha Registro
                        $("#fch_crea").val(r.inc.fch_crea);
                        //Hora
                        $("#tiempo_hora").val(r.inc.tiempo_hora);
                        // Usuario Soporte
                        $("#usu_soporte").val(r.inc.usu_soporte);
                        //Titulo
                        $("#titulo").val(r.inc.titulo);
                        //OBS
                        $("#obs").val(r.inc.obs);
                    });
                    $("#xid").val(id);
                    // MOSTRAR ATENCIONES
                    $("#deta-incidencia").empty();
                    $.post("{{ url('soporte/deta-incidencia') }}",{id:id,_token:tk},function(r) {
                        $("#deta-incidencia").html(r);
                    });
                    // OBTENER DATOS PARA LLENAR UNA ATENCION
                    $(".titulo-atencion").html("Incidente - "+name);
                    $("#cod_cliente").empty();
                    $("#cod_sucursal").empty();
                    $("#usuario").empty();
                    $.post(" {{ url('soporte/obtener-incidencia') }} ",{id:id,_token:tk},function(r) {
                        // CLIENTE
                        $("#cod_cliente").append("<option value='"+r.cliente.id+"'>"+r.cliente.dsc_cliente+"</option>");
                        // SUCURSAL
                        $('#cod_sucursal').append('<option value="'+r.suc[0].id+'">'+r.suc[0].dsc_sucursal+'</option>');
                        // USUARIOS
                        $('#usuario').append('<option value="'+r.usu[0].id+'">'+r.usu[0].nombres+' '+r.usu[0].apellidos+'</option>');
                        $("#idIncidencia").val(id);
                        $("#evento").val(r.inc.titulo);
                    });
                    tabs();
                    $('html, body').animate({scrollTop:0}, 'slow');
                }
            });
            
            $("#idCliente").on('change',function() {
                id = $(this).val();
                option("idSucursal");
                option("idUsuario");
                option("equipo");
                $.post("{{ url('soporte/get-sucursal') }}",{id:id,inc:1,_token:tk},function(r) {
                    // SUCURSAL
                    $.each(r.suc,function(i,k) {
                        $('#idSucursal').append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                    });
                    //EQUIPO
                    $.each(r.eq,function(i,k) {
                        $('#equipo').append('<option value="'+k.id+'">'+k.dsc_equipo+'</option>');
                    });
                });
            });

            $("#idSucursal").on('change',function() {
                idCli = $("#idCliente").val();
                id = $(this).val();
                option("idUsuario");
                $.post("{{ url('soporte/get-usuario-inc') }}",{cli:idCli,suc:id,_token:tk},function(r) {
                    // USUARIO
                    $.each(r,function(i,k) {
                        $('#idUsuario').append('<option value="'+k.id+'">'+k.nombres+' '+k.apellidos+'</option>');
                    });
                });
            });

            $(".search").on('click',function() {
                Frm = $("#FrmSearch").serializeArray();
                var table = $('#table-incidencia').DataTable();
                table.destroy();
                $("#table-incidencia tbody").empty();
                $("#deta-incidencia").html('<div class="alert alert-danger">Seleccione una Incidencia</div>');
                $.post("{{ url('soporte/filtro') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        tr = '<tr>';
                        icon = '<a href="javascript:void(0)" class="uri-seg cerrar" title="CERRAR" id="'+k.id+'" nom="'+k.titulo+'"><i class="icon-lock-open"></i></a>';
                        if(k.estado == 19) {
                            icon = '<a href="javascript:void(0)" class="uri-seg" title="CERRADO"><i class="icon-lock"></i></a>';
                        }
                        if(k.estado == 17) {//PENDIENTE
                            cl = 'badge-danger';
                        } else if (k.estado == 18) {//PROCESO
                            cl = 'badge-warning';
                        } else if (k.estado == 19) {//CERRADO
                            cl = 'badge-success';
                        }
                        tr += '<td class="text-center">'+k.id+'</td>';
                        tr += '<td class="text-center">'+j+'</td>';
                        tr += '<td class="text-center">'+icon+'</td>';
                        tr += '<td class="text-center">'+('0000000000' + k.id).slice(-10)+'</td>';
                        tr += '<td class="text-center">'+k.dsc_tipo_atencion+'</td>';
                        tr += '<td class="text-center">'+k.dsc_cliente+'</td>';
                        tr += '<td>'+k.titulo+'</td>';
                        tr += '<td class="text-center">'+k.fch_crea+'</td>';
                        if (k.dsc_usuario) { usuario = k.dsc_usuario } else { usuario = '' }
                        tr += '<td class="text-center">'+usuario+'</td>';
                        tr += '<td class="text-center"><span class="badge label-table '+cl+'">'+ k.dsc_estado +'</span></td>';
                        tr += '</tr>';
                        j++;
                        $("#table-incidencia tbody").append(tr);
                    });
                    tableIncidencia("table-incidencia");
                });
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmIncidencia").serializeArray();
                v = 0;
                $("#FrmIncidencia").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmIncidencia").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('soporte/save-incidencias') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success").then(function() {
                            location.reload();
                        });
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });

            $(".enviar-atencion").on('click',function() {
                // $("#cod_sucursal").prop('disabled',false);
                // $("#usuario").prop('disabled',false);
                Frm = $("#FrmAtencion").serializeArray();
                v = 0;
                $("#FrmAtencion").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmAtencion").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('soporte/save-atenciones') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success").then(function(){
                            location.reload();
                        });
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });

            $(".new_inc").on('click',function() {
                limpiar();
                tabs();
            });

            // $(".l-inc").on('click', '.editar', function() {
            //     id = $(this).attr('id');
            //     $(".titulo").html('Modificación de una incidencia');
            //     option('idSucursal');
            //     option('idUsuario');
            //     option('equipo');
            //     $.post("{{ url('soporte/edita-incidencia') }}", {id: id,_token: tk}, function(r) {
            //         $("#idCliente").val(r.inc.idCliente);
            //         //Sucursal
            //         $.each(r.suc,function(i,s) {
            //             $("#idSucursal").append('<option value="'+s.id+'">'+s.dsc_sucursal+'</option>');
            //         });
            //         $("#idSucursal").val(r.inc.idSucursal);
            //         //Usuario
            //         $.each(r.usu,function(i,u) {
            //             $("#idUsuario").append('<option value="'+u.id+'">'+u.nombres+' '+u.apellidos+'</option>');
            //         });
            //         $("#idUsuario").val(r.inc.idUsuario);
            //         //Equipo
            //         $.each(r.eq,function(i,e) {
            //             $("#equipo").append('<option value="'+e.id+'">'+e.dsc_equipo+'</option>');
            //         });
            //         $("#equipo").val(r.inc.equipo);
            //         //Tipo
            //         $("#idTipoIncidencia").val(r.inc.idTipoIncidencia);
            //         //Fecha Registro
            //         $("#fch_crea").val(r.inc.fch_crea);
            //         //Hora
            //         $("#tiempo_hora").val(r.inc.tiempo_hora);
            //         // Usuario Soporte
            //         $("#usu_soporte").val(r.inc.usu_soporte);
            //         //Titulo
            //         $("#titulo").val(r.inc.titulo);
            //         //OBS
            //         $("#obs").val(r.inc.obs);
            //     });
            //     $(".lista").hide();
            //     $("#xid").val(id);
            //     $(".create").show();
            // });

            $(".l-inc").on('click', '.cerrar', function() {
                id = $(this).attr('id');
                nom = $(this).attr('nom');
                swal({
                        title: "Estas Seguro?",
                        text: "Deseas cerrar la incidencia " + nom,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.post("{{ url('soporte/close-incidencia') }}", {id: id,_token: tk}, function(r) {
                                if (r.confirm == 1) {
                                    swal("Correcto!", r.msg, "success").then(function() {
                                        location.reload();
                                    });
                                } else if(r.confirm == 0){
                                    swal("Incorrecto!", r.msg, "error");
                                } else {
                                    swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                                }
                            });
                        }
                    });
            });

            $("#fecha_rango").on('change', function() {
                fec_hra = $(this).val();
                $.post("{{ url('soporte/diff-hora') }}",{fec_hra:fec_hra,_token:tk},function(r) {
                    $("#tiempo_atencion").html(r);
                });
            });            

            $(".rango_fecha").daterangepicker({
                timePicker: !0,
                timePicker24Hour: true,
                // use24hours: true,
                timePickerIncrement: 1,
                startDate: moment().startOf('hour: minute'),
                endDate: moment().startOf('hour: minute').add(5, 'minute'),
                locale: {
                    format: "YYYY-MM-DD HH:mm"
                },
                buttonClasses: ["btn", "btn-sm"],
                applyClass: "btn-success",
                cancelClass: "btn-light"
            });
            
        });
        function limpiar(){
            // LIMPIAR INCIDENCIA
            $(".titulo").html('Creación de una nueva incidencia');
            $("#FrmIncidencia")[0].reset();
            $("#codigo").html('');
            $("#xid").val('');
            <?php if(count($suc) == 0) { ?>
            option('idSucursal');
            <?php } ?>
            option('idUsuario');
            option("equipo");
            // LIMPIAR LISTA ATENCIOENS
            $("#deta-incidencia").empty();
            // LIMPIAR ATENCION
            $(".titulo-atencion").html("");
            $("#FrmAtencion")[0].reset();
            option('cod_cliente');
            option('cod_sucursal');
            option('usuario');
        }
        function option(id) {
            $("#"+id).empty();
            $("#"+id).append('<option value="">Seleccione</option>');
        }
        function tableIncidencia(table) {
            $('#'+table).DataTable({
                responsive: true,
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ],
                language: {
                    search: "Busqueda&nbsp;:",
                    lengthMenu: "Mostrar _MENU_ elementos",
                    info: "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
                    paginate: {
                        first: "Primero",
                        previous: "Aterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    }
                }
            });
        }
        function tabs() {
            $(".id-tabs").find(".nav-link, .tab-pane").each(function() {
                $(this).removeClass("active");
            });
            $("#l-incidencia").addClass("active");
            $("#incidencia").addClass("active");
        }
    </script>
@endpush