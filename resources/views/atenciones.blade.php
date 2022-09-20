@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript:void(0)"><b>Atenciones</b></a></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#lista-incidencia" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista de Atenciones</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-incidencia">
                        <div class="row create">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo"></label></div>
                                    <div class="card-body">
                                        <form id="FrmAtencion" method="post">
                                            @csrf
                                            <h5 class="card-title">Datos Generales</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1">
                                                            <input type="checkbox" id="inc" name="inc" value="1">
                                                            <label for="inc">Crear Incidencia</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Cliente:</label>
                                                        <select class="form-control vali" name="cod_cliente" id="cod_cliente">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cli as $c)
                                                            <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                            @endforeach
                                                        </select>
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
                                                        <label>Incidente:</label>
                                                        <select class="form-control vali" name="idIncidencia" id="idIncidencia">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Servicios:</label>
                                                        <select class="form-control vali" name="cod_actividad" id="cod_actividad">
                                                            <option value="">Seleccione</option>
                                                            @foreach($act as $a)
                                                            <option value="{{ $a->id }}">{{ $a->dsc_actividad }}</option>
                                                            @endforeach
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
                                            </div>
                                            <h5 class="card-title">Tipo de Atención</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tipo:</label>
                                                        <select class="form-control vali" name="cod_atencion" id="cod_atencion">
                                                            <option value="">Seleccione</option>
                                                            @foreach($t_ate as $ta)
                                                            <option value="{{ $ta->id }}">{{ $ta->dsc_tipo_atencion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha y hora :</label>
                                                        <input type="text" class="form-control daterange vali" name="daterange" id="daterange" value="{{date('Y-m-d H:i:s').' - '.$fch_hra_fin}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tiempo de Atención:</label>
                                                        <div class="form-control" id="tiempo_atencion">{{$interval->format('%H:%i:%s')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mt-3">Detalles de Atención</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Evento Presentado:</label>
                                                    <textarea class="form-control vali" name="evento" id="evento" cols="30" rows="5"></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Observaciones:</label>
                                                    <textarea class="form-control" name="obs" id="obs" cols="30" rows="5"></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Pendientes:</label>
                                                    <textarea class="form-control" name="pendiente" id="pendiente" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="xid" id="xid">
                                        </form>
                                        <div class="col-lg-12 mt-3">
                                            <button type="button" class="btn btn-secondary radio cancel">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                        <label>Cliente</label>
                                                        <select class="form-control" name="f_cod_cliente" id="f_cod_cliente">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cli as $c)
                                                            <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicio</label>
                                                        <input type="date" class="form-control vali" name="f_fch_inicio" id="f_fch_inicio" value="{{date('Y-m-01')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Fin</label>
                                                        <input type="date" class="form-control vali" name="f_fch_fin" id="f_fch_fin" value="{{date('Y-m-t')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-kunaq mt-3 search"><i class="fe-search"></i></button>
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
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new">Nuevo</button></div>
                                    <div class="card-body  table-responsive atenciones">
                                        <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ACCION</th>
                                                    <th class="text-center">INCIDENTE</th>
                                                    <th class="text-center">ACTIVIDAD</th>
                                                    <th class="text-center">TIPO SOPORTE</th>
                                                    <th class="text-center">CLIENTE</th>
                                                    <th class="text-center">FECHA</th>
                                                    <th class="text-center">ATENDIDO POR</th>
                                                    <th class="text-center">TIEMPO ATENDIDO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($ate as $a)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $a->id }}" title="EDITAR" nom="{{ $a->titulo }}"><i class="fas fa-edit"></i></a></td>
                                                    <td class="text-center">{{ $a->titulo }}</td>
                                                    <td class="text-center">{{ $a->dsc_actividad }}</td>
                                                    <td class="text-center">{{ $a->dsc_tipo_soporte }}</td>
                                                    <td class="text-center">{{ $a->dsc_cliente }}</td>
                                                    <td class="text-center">{{ $a->fch_atencion }}</td>
                                                    <td class="text-center">{{ $a->dsc_usuario }}</td>
                                                    <td class="text-center">{{ $a->tiempo_hora }}</td>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();
            $(".create").hide();
            $("#cod_sucursal").prop('disabled',true);
            $("#usuario").prop('disabled',true);

            $(".new").on('click',function() {
                $(".titulo").html('Creación de una nueva atención');
                $("#FrmAtencion")[0].reset();
                $(".lista").hide();
                $("#xid").val('');
                $("#inc").prop('disabled',false);
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });
            
            $("#cod_cliente").on('change',function() {
                id = $(this).val();
                option("cod_sucursal");
                option("usuario");
                option("idIncidencia");
                if( $("#inc").is(':checked') ) {
                    // SUCURSAL
                    $.post("{{ url('soporte/get-sucursal') }}",{id:id,_token:tk},function(r) {
                        $.each(r,function(i,k) {
                            $('#cod_sucursal').append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                        });
                    });
                } else {
                    // INCIDENTE
                    $.post("{{ url('soporte/get-incidencia') }}",{id:id,_token:tk},function(r) {
                        $.each(r,function(i,k) {
                            $('#idIncidencia').append('<option value="'+k.id+'">'+k.id+' - '+k.titulo+'</option>');
                        });
                    });
                }
            });

            $("#cod_sucursal").on('change',function() {
                idCli = $("#cod_cliente").val();
                id = $(this).val();
                option('usuario');
                $.post("{{ url('soporte/get-usuario') }}",{cli:idCli,suc:id,_token:tk},function(r) {
                    // USUARIO
                    $.each(r,function(i,k) {
                        $('#usuario').append('<option value="'+k.id+'">'+k.nombres+' '+k.apellidos+'</option>');
                    });
                });
            });

            $("#idIncidencia").on('change',function() {
                idCli = $("#cod_cliente").val();
                inc = $(this).val();
                $('#cod_sucursal').empty();
                $('#usuario').empty();
                $.post("{{ url('soporte/get-suc-usu') }}",{cli:idCli,inc:inc,_token:tk},function(r) {
                    // SUCURSAL
                    $('#cod_sucursal').append('<option value="'+r.suc[0].id+'">'+r.suc[0].dsc_sucursal+'</option>');
                    // USUARIOS
                    $('#usuario').append('<option value="'+r.usu[0].id+'">'+r.usu[0].nombres+' '+r.usu[0].apellidos+'</option>');
                    //EVENTO PRESENTADO
                    $("#evento").val(r.inc);
                });
            });

            $("#inc").on('click',function() {
                $("#cod_cliente").val("");
                option("cod_sucursal");
                option("usuario");
                option("idIncidencia");
                if( $(this).is(':checked') ) {
                    $("#idIncidencia").removeClass('vali');
                    $("#idIncidencia").removeClass('border border-danger');
                    $('#idIncidencia').prop('disabled',true);
                    $("#cod_sucursal").prop('disabled',false);
                    $("#usuario").prop('disabled',false);
                } else {
                    $("#idIncidencia").addClass('vali');
                    $('#idIncidencia').prop('disabled',false);
                    $("#cod_sucursal").prop('disabled',true);
                    $("#usuario").prop('disabled',true);
                }
            });

            $(".atenciones").on('click','.editar',function() {
               id = $(this).attr('id');
               $(".titulo").html('Modificación de una atención');
               $("#inc").prop('disabled',true);
               option('cod_sucursal');
               option('usuario');
               option('idIncidencia');
               $.post("{{ url('soporte/get-atencion') }}",{id:id,_token:tk},function(r) {
                    //Servicios
                    $("#cod_actividad").val(r.ate.cod_actividad);
                    //Tipo de Atencion
                    $("#cod_soporte").val(r.ate.cod_soporte);
                    //Cliente
                    $("#cod_cliente").val(r.ate.cod_cliente);
                    //Sucursal
                    $.each(r.suc,function(i,s) {
                        $("#cod_sucursal").append('<option value="'+s.id+'">'+s.dsc_sucursal+'</option>');
                    });
                    $("#cod_sucursal").val(r.ate.cod_sucursal);
                    //Usuario
                    $.each(r.usu,function(i,u) {
                        $("#usuario").append('<option value="'+u.id+'">'+u.nombres+' '+u.apellidos+'</option>');
                    });
                    $("#usuario").val(r.ate.usuario);
                    //Incidente
                    $.each(r.inc,function(i,ii) {
                        $("#idIncidencia").append('<option value="'+ii.id+'">'+ii.titulo+'</option>');
                    });
                    $("#idIncidencia").val(r.ate.idIncidencia);
                    //Tipo
                    $("#cod_atencion").val(r.ate.cod_atencion);
                    //Fecha Atencion
                    // $("#fch_atencion").val(r.ate.fch_atencion);
                    // //Hora Inicio
                    // $("#hra_inicio").val(r.ate.hra_inicio)
                    // //Hora Fin
                    // $("#hra_fin").val(r.ate.hra_fin);
                    $("#daterange").val(r.ate.fch_atencion+' '+r.ate.hra_inicio+' - '+r.ate.fch_atencion_fin+' '+r.ate.hra_fin);
                    // Tiempo de Atencion
                    $("#tiempo_atencion").html(r.ate.tiempo_hora);
                    //Evento
                    $("#evento").val(r.ate.evento);
                    //Observaciones
                    $("#obs").val(r.ate.obs);
                    //Pendiente
                    $("#pendiente").val(r.ate.pendiente);
                });
                $(".lista").hide();
                $("#xid").val(id);
                $(".create").show();
            });

            $(".enviar").on('click',function() {
                $("#cod_sucursal").prop('disabled',false);
                $("#usuario").prop('disabled',false);
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

            $(".search").on('click',function() {
                Frm = $("#FrmSearch").serializeArray();
                var table = $('#table-list').DataTable();
                table.destroy();
                $("#table-list tbody").empty();
                $("#deta-list").html('<div class="alert alert-danger">Seleccione una Incidencia</div>');
                $.post("{{ url('soporte/filtro-atencion') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        tr = '<tr>';
                        tr += '<td class="text-center">'+j+'</td>';
                        tr += '<td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="'+k.id+'" title="EDITAR" nom="'+k.titulo+'"><i class="fas fa-edit"></i></a></td>';
                        tr += '<td class="text-center">'+k.titulo+'</td>';
                        tr += '<td class="text-center">'+k.dsc_actividad+'</td>';
                        tr += '<td class="text-center">'+k.dsc_tipo_soporte+'</td>';
                        tr += '<td class="text-center">'+k.dsc_cliente+'</td>';
                        tr += '<td class="text-center">'+k.fch_atencion+'</td>';
                        tr += '<td class="text-center">'+k.dsc_usuario+'</td>';
                        tr += '<td class="text-center">'+k.tiempo_hora+'</td>';
                        tr += '</tr>';
                        j++;
                        $("#table-list tbody").append(tr);
                    });
                    FunDataTable("table-list");
                });
            });
            
            $("#daterange").on('change', function() {
                fec_hra = $(this).val();
                $.post("{{ url('soporte/diff-hora') }}",{fec_hra:fec_hra,_token:tk},function(r) {
                    $("#tiempo_atencion").html(r);
                });
            });

            $(".daterange").daterangepicker({
                timePicker: !0,
                timePicker24Hour: true,
                // use24hours: true,
                timePickerIncrement: 1,
                locale: {
                    format: "YYYY-MM-DD HH:mm"
                },
                buttonClasses: ["btn", "btn-sm"],
                applyClass: "btn-success",
                cancelClass: "btn-light"
            });
        });
        function option(id) {
            $("#"+id).empty();
            $("#"+id).append('<option value="">Seleccione</option>');
        }
    </script>
@endpush