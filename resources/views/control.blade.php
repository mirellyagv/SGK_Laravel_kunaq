@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript: void(0);"><b>General</b></a> <span class="uri-seg">></span> Control Acceso</p>
            </div>
        </div>
    </div>

    <div class="row card-box">
        @if(session('rol') == 'AD')
        <div class="col-md-12 mb-5">
            <button class="btn btn-kunaq new">Nuevo</button>
        </div>
        @endif
        <div class="col-md-12">
            <h4 class="header-title">usuarios</h4>
            <div class="table-responsive">
                <table class="table mb-0">
                    @if(count($usu) > 0)
                    <thead>
                        <tr class="uri-seg">
                            <th>N°</th>
                            @if(session('rol') == 'AD')
                            <th class="text-center">ACCIÓN</th>
                            @endif
                            <th class="text-center">NOMBRES</th>
                            <th class="text-center">USUARIO</th>
                            <th class="text-center">ROL</th>
                            <th class="text-center">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($usu as $u)
                        <?php
                            if($u->flg_activo) {
                                $e = 'ACTIVO'; $cl = 'badge-success';
                            } else {
                                $e = 'INACTIVO'; $cl = 'badge-danger';
                            }
                        ?>
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            @if(session('rol') == 'AD')
                            <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $u->id }}" title="EDITAR" nom="{{ $u->nombres.' '.$u->apellidos }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="uri-seg clave" id="{{ $u->id }}" title="CLAVE" nom="{{ $u->nombres.' '.$u->apellidos }}"><i class="mdi mdi-onepassword"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="uri-seg eliminar" id="{{ $u->id }}" title="DESACTIVAR" nom="{{ $u->nombres.' '.$u->apellidos }}"><i class="fas fa-trash-alt"></i></a></td>
                            @endif
                            <td>{{ $u->nombres.' '.$u->apellidos }}</td>
                            <td class="text-center">{{ $u->login }}</td>
                            <td class="text-center">{{ $u->dsc_rol }}</td>
                            <td class="text-center"><span class="badge label-table {{ $cl }}">{{ $e }}</span></td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    @else
                        <div class="alert alert-danger mt-3">No hay registros a mostrar</div>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div id="NewUsuario" class="modal fade" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title titulo"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="user" method="post">
                            @csrf
                            <div class="form-group us">
                                <label>Nombres:</label>
                                <input type="text" class="form-control vali" id="nombre" name="nombre" autocomplete="off">
                            </div>
                            <div class="form-group us">
                                <label>Usuario:</label>
                                <input type="text" class="form-control vali" id="usuario" name="usuario" autocomplete="off">
                                <input type="hidden" id="xid" name="xid">
                                <input type="hidden" id="clv" name="clv">
                            </div>
                            <div class="form-group pas">
                                <label>Contraseña:</label>
                                <input type="password" class="form-control vali" name="clave" id="clave">
                            </div>
                            <div class="form-group pas">
                                <div class="checkbox checkbox-primary form-check-inline ml-1">
                                    <input type="checkbox" id="ver" value="ver">
                                    <label for="ver"> Mostrar Contraseña </label>
                                </div>
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
                $("#user")[0].reset();
                $(".us").show();
                $(".pas").show();
                $(".titulo").html('NUEVO USUARIO');
                $("#xid").val('');
                $("#NewUsuario").modal('show');
            });

            $('#ver').click(function () {
                if ($('#ver').is(':checked')) {
                    $('#clave').attr('type', 'text');
                } else {
                    $('#clave').attr('type', 'password');
                }
            });

            $(".enviar").on('click',function() {
                Frm = $("#user").serializeArray();
                v = 0;
                $("#user").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#user").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('man-user') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#NewUsuario").modal('hide');
                        swal("Correcto!", r.msg, "success");
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });

            $(".editar").on('click',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $(".titulo").html('ACTUALIZA DATOS');
                $(".us").show();
                $(".pas").hide();
                $("#clv").val('0');

                $.post("{{ url('get-user') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#nombre").val(k.dsc_usuario);
                        $("#usuario").val(k.login);
                        $("#xid").val(k.id);
                    });
                });
                $("#NewUsuario").modal('show');
            });

            $(".clave").on('click',function() {
                id = $(this).attr('id');
                $("#xid").val(id);
                $(".titulo").html('RESETEAR CONTRASEÑA');
                $(".pas").show();
                $(".us").hide();
                $("#clave").val('');
                $("#clv").val('1');
                $("#NewUsuario").modal('show');
            });

            $(".eliminar").on('click',function() {
                id = $(this).attr('id');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas desactivar del sistema!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('delete-user') }}",{id:id,_token:tk},function(res){
                            if (res > 0) {
                                swal("Se desactivo satisfactoriamente!", {icon: "success"});
                                setTimeout(function(){
                                    location.reload();
                                },2000);
                            } else {
                                swal("Error no se desactivo!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush