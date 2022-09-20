@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Control de Acceso</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#lista-usuarios" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista Usuarios</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-usuarios">
                        <div class="row create">
                            <div class="col-md-8 offset-md-2 p-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo">Nuevo Acceso</label></div>
                                    <div class="card-body">
                                        <form id="FrmAccesso">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Cliente:</label>
                                                        <select class="form-control vali" name="cliente" id="cliente">
                                                            <option value="">Seleccione</option>
                                                            @foreach($cli as $c)
                                                                <option value="{{$c->id}}">{{$c->dsc_cliente}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Rol:</label>
                                                        <select class="form-control vali" name="rol" id="rol">
                                                            <option value="">Seleccione</option>
                                                            @foreach($rol as $r)
                                                                <option value="{{$r->id}}">{{$r->dsc_rol}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Apellidos y Nombres:</label>
                                                        <select class="form-control vali" name="usu" id="usu">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Usuario:</label>
                                                        <input type="text" class="form-control vali" name="usuario" id="usuario" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Clave:</label>
                                                        <input type="password" class="form-control ver" name="password" id="clave" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1">
                                                            <input type="checkbox" id="ver" value="ver">
                                                            <label for="ver"> Mostrar Contraseña </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Estado:</label><br>
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                            <input type="checkbox" name="flg_activo" id="flg_activo" value="1" checked>
                                                            <label for="flg_activo"> Activo </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="xid" name="id">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-secondary radio cancel">Cancelar</button>
                                                    <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row lista">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                    <div class="card-body">
                                        <form id="FrmUsuario">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Cliente</label>
                                                        <select name="f_cliente" id="f_cliente" class="form-control">
                                                            <option value="0">Seleccione</option>
                                                            @foreach($cli as $c)
                                                                <option value="{{$c->id}}">{{$c->dsc_cliente}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-kunaq mt-3 filtro"><i class="fe-search"></i> Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row lista">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right nuevo">Nuevo</button></div>
                                    <div class="card-body table-responsive table_servicios">
                                        <table id="tableUsuario" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>CLIENTE</th>
                                                    <th class="text-center">RUC</th>
                                                    <th class="text-center">ROL</th>
                                                    <th class="text-center">SUCURSAL</th>
                                                    <th class="text-center">USUARIO</th>
                                                    <th class="text-center">NOMBRES</th>
                                                    <th class="text-center">ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($usu as $u)
                                                <?php
                                                    ($u->dsc_sucursal) ? $suc = $u->dsc_sucursal : $suc = '';
                                                    if($u->flg_activo) {
                                                        $e = 'ACTIVO'; $cl = 'badge-success';
                                                    } else {
                                                        $e = 'INACTIVO'; $cl = 'badge-danger';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $u->usu }}</td>
                                                    <td>{{ $u->dsc_cliente }}</td>
                                                    <td class="text-center">{{ $u->dsc_ruc }}</td>
                                                    <td class="text-center">{{ $u->dsc_rol }}</td>
                                                    <td class="text-center">{{ $suc }}</td>
                                                    <td class="text-center">{{ $u->login }}</td>
                                                    <td>{{ $u->nombres.' '.$u->apellidos }}</td>
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
            select();
            table('tableUsuario');

            $(".nuevo").on('click',function() {
                $("#cliente").removeAttr('readonly');
                $(".titulo").html('Creación de un nuevo usuario');
                $(".lista").hide();
                $("#FrmAccesso")[0].reset();
                $("#xid").val('');
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });

            $('#ver').click(function () {
                if ($('#ver').is(':checked')) {
                    $('#clave').attr('type', 'text');
                } else {
                    $('#clave').attr('type', 'password');
                }
            });

            $("#cliente").on('change',function() {
                id = $(this).val();
                option('usu');
                $("#usuario").val('');
                $.post(" {{ url('config/user-client') }} ",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#usu").append('<option value="'+k.id+'">'+k.nombres+' '+k.apellidos+'</option>');
                    });
                });
            });

            $("#usu").on('change',function() {
                id = $(this).val();
                cli = $("#cliente").val();
                $("#usuario").val('');
                $.post(" {{ url('config/user-acount') }} ",{id:id,cli:cli,_token:tk},function(r) {
                    $("#usuario").val(r);
                });
            });

            $(".filtro").on('click',function() {
                let Frm = $("#FrmUsuario").serializeArray();
                let tabla = $('#tableUsuario').DataTable();
                tabla.destroy();
                $("#tableUsuario tbody").empty();
                $.post("{{ url('config/filtro-accesso') }}",Frm,function(r) {
                    if (r.length > 0) {
                        $.each(r,function (i,k) {
                            (k.dsc_sucursal) ? suc = k.dsc_sucursal : suc = '';
                            if(k.flg_activo) {
                                e = 'ACTIVO'; cl = 'badge-success';
                            } else {
                                e = 'INACTIVO'; cl = 'badge-danger';
                            }
                            tr = '<tr>';
                            tr += '<td class="text-center">'+k.usu+'</td>';
                            tr += '<td>'+k.dsc_cliente+'</td>';
                            tr += '<td class="text-center">'+k.dsc_ruc+'</td>';
                            tr += '<td class="text-center">'+k.dsc_rol+'</td>';
                            tr += '<td class="text-center">'+suc+'</td>';
                            tr += '<td class="text-center">'+k.login+'</td>';
                            tr += '<td>'+k.nombres+' '+k.apellidos+'</td>';
                            tr += '<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                            tr += '</tr>';
                            $("#tableUsuario tbody").append(tr);
                        });
                        table("tableUsuario");
                    }
                });
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmAccesso").serializeArray();
                v = 0;
                $("#FrmAccesso").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmAccesso").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post("{{ url('config/save-accesso') }}",Frm,function(r) {
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
            });
        });
        function option(id) {
            $("#"+id).empty();
            $("#"+id).append('<option value="">Seleccione</option>');
        }
        function select() {
            var tk = $("#tk").val();
            $('#tableUsuario tbody').on('dblclick', 'tr', function() {
                var table = $('#tableUsuario').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][0];
                    nom = table.rows('.selected').data()[0][6];
                    // EDITAR EQUIPO
                    $(".titulo").html('Modificación de '+nom);
                    $.post("{{ url('config/get-usu-control') }}",{id:id,_token:tk},function(r) {
                        if (r.usu.length > 0) {
                            $.each(r.usu,function(i,u) {
                                $("#usu").empty().append('<option value="'+u.id+'">'+u.nombres+' '+u.apellidos+'</option>');
                            });
                        }
                        $.each(r.usuario,function(i,k) {
                            $("#cliente").val(k.idCliente);
                            $("#rol").val(k.rol);
                            $("#usuario").val(k.login);
                            if (k.flg_activo) {
                                $("#flg_activo").prop('checked',true);
                            } else {
                                $("#flg_activo").prop('checked',false);
                            }
                        });
                        $("#cliente").prop('readonly');
                    });
                    $(".lista").hide();
                    $("#xid").val(id);
                    $(".create").show();
                    $('html, body').animate({scrollTop:0}, 'slow');
                }
            });
        }
        function table(table) {
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
    </script>
@endpush