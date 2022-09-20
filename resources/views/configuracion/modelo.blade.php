@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Modelo</p>
            </div>
        </div>
    </div>

    <div class="row card-box">
        <div class="col-md-12 mb-5">
            <button class="btn btn-kunaq new">Nuevo</button>
        </div>
        <div class="col-md-12 table-responsive table_modelo">
            @if(count($mod) > 0)
                <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">ACCIÓN</th>
                            <th class="text-center">PERIFÉRICO</th>
                            <th class="text-center">MARCA</th>
                            <th class="text-center">MODELO</th>
                            <th class="text-center">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($mod as $m)
                        <?php
                            if($m->flg_activo) {
                                $e = 'ACTIVO'; $cl = 'badge-success';
                            } else {
                                $e = 'INACTIVO'; $cl = 'badge-danger';
                            }
                        ?>
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $m->id }}" title="EDITAR" nom="{{ $m->dsc_modelo }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="uri-seg eliminar" id="{{ $m->id }}" title="DESACTIVAR" nom="{{ $m->dsc_modelo }}"><i class="fas fa-trash-alt"></i></a></td>
                            <td>{{ $m->dsc_periferico }}</td>
                            <td>{{ $m->dsc_marca }}</td>
                            <td>{{ $m->dsc_modelo }}</td>
                            <td class="text-center"><span class="badge label-table {{ $cl }}">{{ $e }}</span></td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger mt-3">No hay registros a mostrar</div>
            @endif
        </div>
        <div id="NewModelo" class="modal fade" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title titulo"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="FrmModelo" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Marca:</label>
                                <select class="form-control vali" name="cod_marca" id="cod_marca">
                                    <option value="">Seleccione</option>
                                    @foreach($mar as $m)
                                    <option value="{{ $m->id }}">{{ $m->dsc_marca }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Periferico:</label>
                                <select class="form-control vali" name="cod_periferico" id="cod_periferico">
                                    <option value="">Seleccione</option>
                                    @foreach($per as $p)
                                    <option value="{{ $p->id }}">{{ $p->dsc_periferico }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" class="form-control vali" id="dsc_modelo" name="dsc_modelo" autocomplete="off">
                                <input type="hidden" id="xid" name="xid">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary radio" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-kunaq enviar">Enviar</button>
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

            $(".new").on('click',function() {
                $("#FrmModelo")[0].reset();
                $("#xid").val('');
                $(".titulo").html('NUEVO MODELO');
                $("#NewModelo").modal('show');
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmModelo").serializeArray();
                v = 0;
                $("#FrmModelo").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmModelo").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-modelo') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#NewModelo").modal('hide');
                        swal("Correcto!", r.msg, "success");
                        setTimeout(function(){
                            location.reload();
                        },2000);
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });

            $(".table_modelo").on('click','.editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $("#xid").val(id);
                $(".titulo").html('EDITANDO '+tit);

                $.post("{{ url('config/get-modelo') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#cod_marca").val(k.cod_marca);
                        $("#cod_periferico").val(k.cod_periferico);
                        $("#dsc_modelo").val(k.dsc_modelo);
                    });
                });
                $("#NewModelo").modal('show');
            });

            $(".table_modelo").on('click','.eliminar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas eliminar el modelo "+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/delete-modelo') }}",{id:id,_token:tk},function(r) {
                            if (r.confirm == 1) {
                                swal("Correcto!", r.msg, "success").then(function() {
                                    location.reload();
                                });
                            } else if(r.confirm == 0){
                                swal("Incorrecto!", r.msg, "info");
                            } else {
                                swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush