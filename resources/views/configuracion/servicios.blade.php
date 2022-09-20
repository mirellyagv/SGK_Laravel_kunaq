@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Servicios Contratados</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#lista-clientes" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista Clientes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#servicios" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Servicios Contratados</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-clientes">
                        <div class="row lista">
                            <div class="col-md-12 mt-3">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new_equipo">Nuevo</button></div>
                                    <div class="card-body table-responsive table_cliente_servicios">
                                        <table id="table-Clientes" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">CLIENTE</th>
                                                    <th class="text-center">RUC</th>
                                                    <th class="text-center">FECHA INICIO</th>
                                                    <th class="text-center">FECHA FIN</th>
                                                    <th class="text-center">TELÉFONO</th>
                                                    <th class="text-center">EMAIL</th>
                                                    <th class="text-center">ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($cli as $c)
                                                <?php
                                                    if ($c->flg_activo) {
                                                        $e = 'ACTIVO'; $cl = 'badge-success';
                                                    } else {
                                                        $e = 'INACTIVO'; $cl = 'badge-danger';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $c->id }}</td>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td>{{ $c->dsc_cliente }}</td>
                                                    <td class="text-center">{{ $c->dsc_ruc }}</td>
                                                    <td class="text-center">{{ $c->fch_inicio }}</td>
                                                    <td class="text-center">{{ $c->fch_vencimiento }}</td>
                                                    <td class="text-center">{{ $c->telefono }}</td>
                                                    <td class="text-center">{{ $c->email }}</td>
                                                    <td class="text-center"><span class="badge label-table {{$cl}}">{{ $e }}</span></td>
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
                    <div class="tab-pane show" id="servicios">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="deta-incidencia" class="table-responsive">
                                    <h4 class="modal-title titulo-servicios"></h4><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive table-servicios" style="height: 300px;overflow-y: scroll;">
                                                <table class="table mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">ACCIÓN</th>
                                                        <th class="text-center">SERVICIO CONTRATO</th>
                                                        <th class="text-center">FECHA INICIO</th>
                                                        <th class="text-center">FECHA FIN</th>
                                                        <th class="text-center">ESTADO</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="servicios"></tbody>
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
        </div>
    </div>
    <style>
        .cu {
            cursor: pointer;
        }
        .marg {
            margin-top: 1rem;
        }
        .icon-colored {
            height: 38px;
            width: 38px;
            margin: 0.1rem;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();
            select();
            tableEquipo("table-Clientes");

            $(".new").on('click',function() {
                $("#FrmEstado")[0].reset();
                $("#xid").val('');
                $(".titulo").html('NUEVO ESTADO');
                $("#NewEstado").modal('show');
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmEstado").serializeArray();
                v = 0;
                $("#FrmEstado").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmEstado").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-estado') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#NewEstado").modal('hide');
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

                $.post("{{ url('config/get-estado') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#dsc_estado").val(k.dsc_estado);
                    });
                });
                $("#NewEstado").modal('show');
            });

            $(".table_modelo").on('click','.eliminar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas desactivar del sistema a "+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/delete-estado') }}",{id:id,_token:tk},function(res){
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

            $(".table-servicios").on('click','.ACTIVAR, .DESACTIVAR', function() {
                id_cli = $(this).attr('id_cli');
                id_ser = $(this).attr('id_ser');
                nom = $(this).attr('nom');
                est = $(this).attr('est');
                var control = $(this);
                var tr = control.closest('tr');
                var obj = {cli:id_cli,ser:id_ser,est:est,_token:tk};
                tr.find('input').each(function(i,v){
                    obj[$(v).attr('name')] = $(v).val();
                });
                if (est == 1) {
                    text = '¿ Deseas desactivar el servicio ?';
                } else {
                    text = '¿ Deseas activar el servicio ?';
                }
                swal({
                    title: nom,
                    text: text,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/estado') }}",obj,function(res){
                            if (res.confirm == 1) {
                                swal(res.msg, { icon: "success" }).then(function() {
                                    location.reload();
                                });
                            } else if (res.confirm == 0) {
                                swal(res.msg, { icon: "warning" });
                            } else {
                                swal("Comuniquese con el administrador", { icon: "error" });
                            }
                        });
                    }
                });
            });
        });
        function select() {
            var tk = $("#tk").val();
            $('.table_cliente_servicios tbody').on('click', 'tr', function() {
                var table = $('#table-Clientes').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    //Limpiamos titulo Servicios
                    $(".titulo-servicios").html('');
                    // Limpiamos Historial Asignacion
                    $(".history").empty();
                    //Limpiar Componentes
                    $("#idEquipo").val('');
                    option("c_equipo");
                    $(".list-comp").empty();
                    $(".title-comp").html('');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][0];
                    cli = table.rows('.selected').data()[0][2];
                    // SERVICIOS CONTRATADOS
                    $(".titulo-servicios").html(cli);
                    $(".servicios").empty();
                    $.post("{{ url('config/cli-servicio') }}",{id:id,_token:tk},function(r) {
                        j = 1;
                        $.each(r,function(i,k) {
                            if(k.flg_activo) {
                                e = 'ACTIVO'; cl = 'badge-success';
                                src = '<?php echo asset("assets/images/icons") ?>';
                                img = '/cancel.svg';
                                title = 'DESACTIVAR';
                            } else {
                                e = 'INACTIVO'; cl = 'badge-danger';
                                src = '<?php echo asset("assets/images/icons") ?>';
                                img = '/ok.svg';
                                title = 'ACTIVAR';
                            }
                            fec_ini = '';fec_fin = '';
                            if (k.fch_inicio) {
                                fec_ini = k.fch_inicio;
                            }
                            if (k.fch_fin) {
                                fec_fin = k.fch_fin;
                            }
                            tr = '<tr>';
                            tr += '<td class="text-center">'+j+'</td>';
                            tr += '<td><img class="icon-colored cu '+title+'" id_cli="'+k.idCliente+'" id_ser="'+k.idServicio+'" nom="'+k.dsc_servicio+'" est="'+k.flg_activo+'" src="'+src+img+'" title="'+title+'"></td>';
                            tr += '<td>'+k.dsc_servicio+'</td>';
                            tr += '<td class="text-center"><input type="date" class="form-control" name="fec_ini" value="'+fec_ini+'"></td>';
                            tr += '<td class="text-center"><input type="date" class="form-control" name="fec_fin" value="'+fec_fin+'"></td>';
                            tr += '<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                            tr += '</tr>';
                            $(".servicios").append(tr);
                            j++;
                        });
                    });
                }
            });
        }
        function tableEquipo(table) {
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