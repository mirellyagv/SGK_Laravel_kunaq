@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Estado</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 card-box">
            <ul class="nav nav-tabs tabs-bordered">
                <li class="nav-item">
                    <a href="#estados" data-toggle="tab" aria-expanded="false" class="nav-link active">
                        <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                        <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#orden" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                        <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Orden</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="estados">
                    <div class="row create">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo"></label></div>
                                <div class="card-body">
                                    <form id="FrmEstado" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo solicitud:</label>
                                                    <select class="form-control vali" name="solicitud" id="solicitud">
                                                        <option value="">Selecciona</option>
                                                        @foreach($sol as $s)
                                                            <option value="{{$s->cod_tabla}}">{{$s->dsc_solicitud}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nombre:</label>
                                                <input type="text" class="form-control vali" id="dsc_estado" name="dsc_estado" autocomplete="off">
                                                <input type="hidden" id="xid" name="xid">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Estado:</label><br>
                                                    <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                        <input type="checkbox" name="flg_activo" id="flg_activo" value="1" checked="">
                                                        <label for="flg_activo"> Activo </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-secondary radio cancel">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                        </div>
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
                                    <form id="FrmSearchEstado">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo solicitud:</label>
                                                    <select class="form-control vali" name="solicitud">
                                                        <option value="">Selecciona</option>
                                                        @foreach($sol as $s)
                                                            <option value="{{$s->cod_tabla}}">{{$s->dsc_solicitud}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-kunaq mt-3 search-estado"><i class="fe-search"></i> Buscar</button>
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
                                <div class="card-body table-responsive table_modelo">
                                    <table id="table-Estado" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">TIPO SOLICITUD</th>
                                                <th class="text-center">NOMBRE ESTADO</th>
                                                <th class="text-center">ESTADO</th>
                                                <th class="text-center">ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($est as $ee)
                                            <?php
                                                if($ee->flg_activo) {
                                                    $e = 'ACTIVO'; $cl = 'badge-success';
                                                } else {
                                                    $e = 'INACTIVO'; $cl = 'badge-danger';
                                                }
                                            ?>
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $ee->dsc_solicitud }}</td>
                                                <td class="text-center">{{ $ee->dsc_estado }}</td>
                                                <td class="text-center"><span class="badge label-table {{ $cl }}">{{ $e }}</span></td>
                                                <td class="text-center">{{ $ee->id }}</td>
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
                <div class="tab-pane show" id="orden">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo solicitud:</label>
                                <select class="form-control" id="o-solicitud">
                                    <option value="">Selecciona</option>
                                    @foreach($sol as $s)
                                        <option value="{{$s->cod_tabla}}">{{$s->dsc_solicitud}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 orden"></div>
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
            table('table-Estado');

            $(".new").on('click',function() {
                $(".titulo").html('NUEVO ESTADO');
                $(".lista").hide();
                $("#FrmEstado")[0].reset();
                $("#xid").val('');
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
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

            $(".search-estado").on('click',function() {
                Frm = $("#FrmSearchEstado").serializeArray();
                var tabla = $('#table-Estado').DataTable();
                tabla.destroy();
                $("#table-Estado tbody").empty();
                $.post("{{ url('config/search-estado') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        if(k.flg_activo == 1) {
                            e = 'ACTIVO'; cl = 'badge-success';
                        } else {
                            e = 'INACTIVO'; cl = 'badge-danger';
                        }
                        tr = '<tr>';
                        tr +='<td class="text-center">'+j+'</td>';
                        tr +='<td class="text-center">'+k.dsc_solicitud+'</td>';
                        tr +='<td class="text-center">'+k.dsc_estado+'</td>';
                        tr +='<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                        tr +='<td class="text-center">'+k.id+'</td>';
                        tr +='</tr>';
                        j++;
                        $("#table-Estado tbody").append(tr);
                    });
                    table('table-Estado');
                });
            });

            $("#o-solicitud").on('change',function() {
                id = $(this).val();
                $(".orden").empty();
                $.post(" {{ url('config/get-estado') }} ",{cod:id,_token:tk},function(r) {
                    row = '<div class="row mt-3">';
                    row += '<div class="col-md-6">';
                    row += '<form id="FrmOrden">';
                    row += '<input type="hidden" name="_token" value="{{csrf_token()}}">';
                    row += '<table class="table mb-0 table-sm"><thead><tr><th class="text-center">#</th><th class="text-center">ESTADO</th><th class="text-center">ORDEN</th></tr></thead>';
                    row += '<tbody>';
                    j = 1;
                    $.each(r,function(i,k) {
                        row += '<tr>';
                        row += '<td>'+j+'</td>';
                        row += '<td>'+k.dsc_estado+'</td>';
                        row += '<td><input type="number" class="form-control text-center" name="orden['+k.id+']" value="'+k.orden+'"></td>';
                        row += '</tr>';
                        j++;
                    });
                    row += '</tbody>';
                    row += '</form>';
                    row += '</table>';
                    row += '</div>';
                    row += '</div>';
                    row += '<div class="row mt-2">';
                    row += '<div class="col-md-12">';
                    row += '<button type="button" class="btn btn-kunaq env-orden">Grabar</button>';
                    row += '</div>';
                    row += '</div>';
                    $(".orden").html(row);
                });
            });

            $(".orden").on('click','.env-orden',function() {
                Frm = $("#FrmOrden").serializeArray();
                $.post(" {{ url('config/orden') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success");
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });
        });
        function select() {
            var tk = $("#tk").val();
            $('.table_modelo tbody').on('dblclick', 'tr', function() {
                var table = $('#table-Estado').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    //Limpiamos
                    $("#FrmEstado")[0].reset();
                    $("#xid").val('');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][4];
                    nom_sol = table.rows('.selected').data()[0][1];
                    nom_est = table.rows('.selected').data()[0][2];
                    
                    $("#xid").val(id);
                    $(".titulo").html(nom_sol+' '+nom_est);
                    $.post(" {{ url('config/get-estado') }} ",{id:id,_token:tk},function(r) {
                        $.each(r,function(i,k) {
                            $("#solicitud").val(k.cod_tabla);
                            $("#dsc_estado").val(k.dsc_estado);
                            if (k.flg_activo) {
                                $("#flg_activo").prop('checked',true);
                            } else {
                                $("#flg_activo").prop('checked',false);
                            }
                        });
                    });
                    $(".lista").hide();
                    $(".create").show();
                }
            });
        }
        function table(table) {
            $('#'+table).DataTable({
                responsive: true,
                "columnDefs": [{
                        "targets": [4],
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