@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Modalidad de Atención</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#lista-equipos" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-equipos">
                        <div class="row create">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo"></label></div>
                                    <div class="card-body">
                                        <form id="FrmModalidad">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Descripcion:</label>
                                                        <input type="text" class="form-control vali" name="dsc_tipo_soporte" id="dsc_tipo_soporte" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado Servicio:</label><br>
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                            <input type="checkbox" name="flg_activo" id="flg_activo" value="1" checked>
                                                            <label for="flg_activo"> Activo </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="xid" name="xid">
                                        </form>
                                        <div class="col-lg-12 mt-5">
                                            <button type="button" class="btn btn-secondary radio cancel">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row lista">
                            <div class="col-md-12 mt-3">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right nuevo">Nuevo</button></div>
                                    <div class="card-body table-responsive table_servicios">
                                        <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ACCIÓN</th>
                                                    <th class="text-center">DESCRIPCIÓN</th>
                                                    <th class="text-center">ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($ma as $m)
                                                <?php
                                                    if($m->flg_activo) {
                                                        $e = 'ACTIVO'; $cl = 'badge-success';
                                                    } else {
                                                        $e = 'INACTIVO'; $cl = 'badge-danger';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $m->id }}" title="EDITAR" nom="{{ $m->dsc_tipo_soporte }}"><i class="fas fa-edit"></i></a></td>
                                                    <td>{{ $m->dsc_tipo_soporte }}</td>
                                                    <td class="text-center"><span class="badge label-table {{ $cl }}">{{ $e }}</span></td>
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

            $(".nuevo").on('click',function() {
                $(".titulo").html('Creación de una nueva modalidad');
                $(".lista").hide();
                $("#FrmModalidad")[0].reset();
                $("#xid").val('');
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmModalidad").serializeArray();
                v = 0;
                $("#FrmModalidad").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmModalidad").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-modalidad') }} ",Frm,function(r) {
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

            $(".table_servicios").on('click','.editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $(".titulo").html('Modificación de '+tit);
                $.post("{{ url('config/get-modalidad') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#dsc_tipo_soporte").val(k.dsc_tipo_soporte);
                        if (k.flg_activo) {
                            $("#flg_activo").prop('checked',true);
                        } else {
                            $("#flg_activo").prop('checked',false);
                        }
                        $("#xid").val(id);
                    });
                });
                $(".lista").hide();
                $("#xid").val(id);
                $(".create").show();
            });
        });
    </script>
@endpush