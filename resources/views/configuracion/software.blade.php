@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Software</p>
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
                                        <form id="FrmSoftware">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Categoría:</label>
                                                        <select class="form-control vali" name="cod_categoria" id="cod_categoria">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cat as $c)
                                                                <option value="{{$c->id}}">{{$c->dsc_categoria}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Software:</label>
                                                        <input type="text" class="form-control vali" name="dsc_software"  id="dsc_software" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Versión:</label>
                                                        <input type="text" class="form-control vali" name="dsc_version"  id="dsc_version" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Licencia:</label>
                                                        <select class="form-control vali" name="flg_licencia" id="flg_licencia">
                                                            <option value="">Seleccione</option>
                                                            <option value="1">SI</option>
                                                            <option value="0">NO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Moneda:</label>
                                                        <select class="form-control" name="moneda" id="moneda">
                                                            <option value="">Seleccione</option>
                                                            @foreach($mon as $m)
                                                                <option value="{{$m->id}}">{{$m->dsc_moneda}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Costo:</label>
                                                        <input type="number" class="form-control" name="costo"  id="costo" min="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado:</label><br>
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                            <input type="checkbox" name="flg_activo" id="flg_activo" value="1" checked>
                                                            <label for="flg_activo"> Activo </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Detalle:</label>
                                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="xid" name="id">
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
                                    <div class="card-body table-responsive table_software">
                                        <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ACCIÓN</th>
                                                    <th class="text-center">CATEGORÍA</th>
                                                    <th class="text-center">SOFTWARE</th>
                                                    <th class="text-center">ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($sof as $s)
                                                <?php
                                                    if($s->flg_activo) {
                                                        $e = 'ACTIVO'; $cl = 'badge-success';
                                                    } else {
                                                        $e = 'INACTIVO'; $cl = 'badge-danger';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $s->id }}" title="EDITAR" nom="{{ $s->dsc_software }}"><i class="fas fa-edit"></i></a></td>
                                                    <td>{{ $s->dsc_categoria }}</td>
                                                    <td>{{ $s->dsc_software }}</td>
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
            $("#moneda").prop('disabled',true);
            $("#costo").prop('disabled',true);

            $(".nuevo").on('click',function() {
                $(".titulo").html('Creación de software');
                $(".lista").hide();
                $("#FrmSoftware")[0].reset();
                $("#xid").val('');
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });

            $("#flg_licencia").on('change',function() {
                let id = $(this).val();
                if (id == 1) {
                    $("#moneda").prop('disabled',false);
                    $("#costo").prop('disabled',false);
                } else {
                    $("#moneda").prop('disabled',true);
                    $("#costo").prop('disabled',true);
                }
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmSoftware").serializeArray();
                v = 0;
                $("#FrmSoftware").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmSoftware").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-software') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success").then(function(){
                            location.reload();
                        });
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "info");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });

            $(".table_software").on('click','.editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $(".titulo").html('Modificación de '+tit);
                $.post("{{ url('config/get-software') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#cod_categoria").val(k.cod_categoria);
                        $("#dsc_software").val(k.dsc_software);
                        $("#dsc_version").val(k.dsc_version);
                        $("#flg_licencia").val(k.flg_licencia);
                        $("#moneda").val(k.moneda);
                        $("#costo").val(k.costo);
                        $("#observaciones").val(k.observaciones);
                        if (k.flg_licencia) {
                            $("#moneda").prop('disabled',false);
                            $("#costo").prop('disabled',false);
                        } else {
                            $("#moneda").prop('disabled',true);
                            $("#costo").prop('disabled',true);
                        }
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