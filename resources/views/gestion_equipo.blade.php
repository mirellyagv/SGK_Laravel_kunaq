@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript: void(0);"><b>Soporte Técnico</b></a> <span class="uri-seg">></span> Gestión de Equipos</p>
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
                        <a href="#lista-equipos" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista Equipos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#detalle-equipo" id="l-detalle-equipo" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Detalle Equipo</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asignacion" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Asignaciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#historial-mantenimiento" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Historial Mantenimiento</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#software" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Software Instalado</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="lista-equipos">
                         <div class="row lista">
                            <div class="col-md-12 mt-3">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado </div>
                                    <div class="card-body table-responsive table_equipo">
                                    <form id="FrmFiltro" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Periférico :</label>
                                                    <select class="form-control" name="periferico">
                                                        <option value="">Seleccione</option>
                                                        @foreach($per as $p)
                                                        <option value="{{ $p->id }}">{{ $p->dsc_periferico }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Marca :</label>
                                                    <select class="form-control" name="marca">
                                                        <option value="">Seleccione</option>
                                                        @foreach($mar as $m)
                                                        <option value="{{ $m->id }}">{{ $m->dsc_marca }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Estado :</label>
                                                    <select class="form-control" name="estado">
                                                        <option value="">Seleccione</option>
                                                        @foreach($est as $es)
                                                        <option value="{{ $es->id }}">{{ $es->dsc_estado }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label></label>
                                                    <button type="button" class="btn btn-kunaq filtro mt-3">Filtrar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </br>
                                    <table id="table-Equipo" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <!-- <th class="text-center">CÓDIGO</th> -->
                                                <th class="text-center">EQUIPO</th>
                                                <th class="text-center">PERIFÉRICO</th>
                                                <th class="text-center">MARCA</th>
                                                <th class="text-center">MODELO</th>
                                                <th class="text-center">ESTADO</th>
                                                <th class="text-center">USUARIO</th>
                                                <th class="text-center">COD ACTIVO</th>
                                                <th class="text-center">SERIE</th>
                                                <th class="text-center">FEC COMPRA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eq as $e)
                                            <tr>
                                                <td class="text-center">{{ $e->id }}</td>
                                                <!-- <td class="text-center">{{ str_pad($e->id,  10, "0",STR_PAD_LEFT) }}</td> -->
                                                <td class="text-center">{{ $e->dsc_equipo }}</td>
                                                <td class="text-center">{{ $e->dsc_periferico }}</td>
                                                <td class="text-center">{{ $e->dsc_marca }}</td>
                                                <td class="text-center">{{ $e->dsc_modelo }}</td>
                                                <td class="text-center">{{ $e->dsc_estado }}</td>
                                                <td>{{ $e->nombres.' '.$e->apellidos }}</td>
                                                <td class="text-center">{{ $e->cod_activo }}</td>
                                                <td class="text-center">{{ $e->serie }}</td>
                                                <td class="text-center">{{ Carbon\Carbon::parse($e->fch_compra)->format('d-m-Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="detalle-equipo">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><h4 class="deta-titulo"></h4></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Sucursal:</label>
                                                    <div class="form-control lmp-equipo" id="sucursal"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Ubicación:</label>
                                                    <div class="form-control lmp-equipo" id="ubicacion"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Estado:</label>
                                                    <div class="form-control lmp-equipo" id="estado"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Periférico:</label>
                                                    <div class="form-control lmp-equipo" id="periferico"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Marca:</label>
                                                    <div class="form-control lmp-equipo" id="marca"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Modelo:</label>
                                                    <div class="form-control lmp-equipo" id="modelo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Código Inventario:</label>
                                                    <div class="form-control lmp-equipo" id="inventario"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Código Activo:</label>
                                                    <div class="form-control lmp-equipo" id="activo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Serie:</label>
                                                    <div class="form-control lmp-equipo" id="serie"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Procesador:</label>
                                                    <div class="form-control lmp-equipo" id="procesador"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Velocidad:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">GHz</span>
                                                        </div>
                                                        <div class="form-control lmp-equipo" id="velocidad"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Memoria:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">GB</span>
                                                        </div>
                                                        <div class="form-control lmp-equipo" id="memoria"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Disco Duro:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">Gb</span>
                                                        </div>
                                                        <div class="form-control lmp-equipo" id="disco_duro"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tamaño:</label>
                                                    <div class="form-control lmp-equipo" id="tamanio"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Fecha Compra:</label>
                                                    <div class="form-control lmp-equipo" id="fecha_compra"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Fecha Instalación:</label>
                                                    <div class="form-control lmp-equipo" id="fecha_instalacion"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Propiedad:</label>
                                                    <div class="form-control lmp-equipo" id="tipo_propiedad"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Proveedor:</label>
                                                    <div class="form-control lmp-equipo" id="proveedor"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Contrato:</label>
                                                    <div class="form-control lmp-equipo" id="contrato"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Vcmto. Contrato:</label>
                                                    <div class="form-control lmp-equipo" id="vcmto_contrato"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Cuota</label>
                                                    <div class="form-control lmp-equipo" id="cuota"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Costo Equipo</label>
                                                    <div class="form-control lmp-equipo" id="costo_equipo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Código Equipo</label>
                                                    <div class="form-control" id="cod_equipo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Detalle:</label>
                                                    <div class="form-control lmp-equipo" id="observaciones"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="asignacion">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="deta-incidencia" class="table-responsive">
                                    <h4 class="modal-title titulo-asignar"></h4>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="table-responsive" style="height: 300px;overflow-y: scroll;">
                                                <table class="table mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center">USUARIO</th>
                                                        <th class="text-center">FECHA INICIO</th>
                                                        <th class="text-center">FECHA FIN</th>
                                                        <th class="text-center">OBSERVACIÓN</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="history"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="historial-mantenimiento">
                        <h4 class="titulo-mantenimiento mb-3"></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" style="height: 400px;overflow-y: scroll;">
                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">MANTENIMIENTO</th>
                                            <th class="text-center">F.PROGRAMADA</th>
                                            <th class="text-center">F.EJECUCIÓN</th>
                                            <th class="text-center">ESTADO</th>
                                            <th class="text-center">COSTO</th>
                                            <th class="text-center">OBSERVACIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list-mantenimiento"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="software">
                        <h4 class="titulo-software mb-3"></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" style="height: 400px;overflow-y: scroll;">
                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">CATEGORÍA</th>
                                            <th class="text-center">SOFTWARE</th>
                                            <th class="text-center">FECHA INSTALACIÓN</th>
                                            <th class="text-center">OBSERVACIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list-software"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .tarjeta{
            position: relative;
            margin-right: 15px;
            margin-bottom: -3rem;
            height: 6rem;
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
            select();
            tableEquipo("table-Equipo");

            $(".filtro").on('click',function() {
                Frm = $("#FrmFiltro").serializeArray();
                var tabla = $('#table-Equipo').DataTable();
                tabla.destroy();
                $("#table-Equipo tbody").empty();
                // Limpiamos Historial Asignacion
                $(".history").empty();
                $.post("{{ url('soporte/lista-equipos') }}",Frm,function(r) {
                    $.each(r,function (i,k) {
                        tr = '<tr>';
                        tr +='<td class="text-center">'+k.id+'</td>';
                        // tr +='<td class="text-center">'+('0000000000' + k.id).slice(-10)+'</td>';
                        tr +='<td class="text-center">'+k.dsc_equipo+'</td>';
                        tr +='<td class="text-center">'+k.dsc_periferico+'</td>';
                        tr +='<td class="text-center">'+k.dsc_marca+'</td>';
                        tr +='<td class="text-center">'+k.dsc_modelo+'</td>';
                        tr +='<td class="text-center">'+k.dsc_estado+'</td>';
                        nom = (k.nombres) ? k.nombres : ''; ape = (k.apellidos) ? k.apellidos : '';
                        tr +='<td>'+nom+' '+ape+'</td>';
                        activo = (k.cod_activo) ? k.cod_activo : '';
                        tr +='<td class="text-center">'+activo+'</td>';
                        serie = (k.serie) ? k.serie : '';
                        tr +='<td class="text-center">'+serie+'</td>';
                        tr +='<td class="text-center">'+k.fch_compra+'</td>';
                        tr +='</tr>';
                        $("#table-Equipo tbody").append(tr);
                    });
                    tableEquipo("table-Equipo");
                });
            });
        });
        function select() {
            var tk = $("#tk").val();
            $('.table_equipo tbody').on('dblclick', 'tr', function() {
                var table = $('#table-Equipo').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    // Limpia el titulo detalle equipo
                    $(".deta-titulo").html('');
                    $(".lmp-equipo").html('');
                    $("#kunaq").prop('checked',false);
                    $("#alquilado").prop('checked',false);
                    // Limpiamos el titulo de equipo
                    $(".titulo-asignar").html('');
                    // Limpiamos Historial Asignacion
                    $(".history").empty();
                    // Limpiamos mantenimiento
                    $(".titulo-mantenimiento").html('');
                    $(".list-mantenimiento").empty();
                    // Limpiamos software
                    $(".titulo-software").html('');
                    $(".list-software").empty();
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][0];
                    nom = table.rows('.selected').data()[0][1];
                    // DETALLE EQUIPO
                    $(".deta-titulo").html(nom);
                    $(".lmp-equipo").html('');
                    $.post(" {{ url('soporte/deta-equipo') }} ",{id:id,_token:tk},function(r) {
                        $.each(r,function(i,k) {
                            $("#sucursal").html(r[0].dsc_sucursal);
                            $("#ubicacion").html(r[0].dsc_ubicaciones);
                            $("#estado").html(r[0].dsc_estado);
                            $("#periferico").html(r[0].dsc_periferico);
                            $("#marca").html(r[0].dsc_marca);
                            $("#modelo").html(r[0].dsc_modelo);
                            $("#inventario").html(r[0].nro_inventario);
                            $("#activo").html(r[0].cod_activo);
                            $("#serie").html(r[0].serie);
                            $("#procesador").html(r[0].dsc_procesador);
                            $("#velocidad").html(r[0].velocidad_procesador);
                            $("#memoria").html(r[0].memoria);
                            $("#disco_duro").html(r[0].disco_duro);
                            $("#fecha_compra").html(r[0].fch_compra);
                            $("#fecha_instalacion").html(r[0].fch_instalacion);
                            $("#tamanio").html(r[0].tamanio);
                            $("#tipo_propiedad").html(r[0].dsc_tipo_propiedad);
                            $("#contrato").html(r[0].contrato);
                            $("#vcmto_contrato").html(r[0].fch_vcmto_mes);
                            $("#cuota").html(r[0].dsc_abrev+' '+r[0].cuota_mes);
                            $("#costo_equipo").html(r[0].costo_equipo);
                            $("#cod_equipo").html(('0000000000' + id).slice(-10));
                            $("#observaciones").html(r[0].observaciones);
                        });
                    });
                    // ASIGNACIONES
                    $(".titulo-asignar").html(nom);
                    $.post(" {{ url('soporte/usu-equipos') }} ",{id:id,_token:tk},function(r) {
                        $(".history").empty();
                        if (r.asig_usu.length > 0) {
                            j = 1;
                            $.each(r.asig_usu,function(i,k) {
                                if (i == 0) {
                                    icon = '<i class="fas fa-check-circle uri-seg"></i>';
                                } else {
                                    icon = '';
                                }
                                tr = '<tr>';
                                tr += '<td class="text-center">'+j+'</td>';
                                tr += '<td class="text-center">'+icon+'</td>';
                                tr += '<td>'+k.apellidos+' '+k.nombres+'</td>';
                                tr += '<td class="text-center">'+k.fch_inicio+'</td>';
                                (k.fch_final==null) ? f_f = '' : f_f = k.fch_final;
                                tr += '<td class="text-center">'+f_f+'</td>';
                                (k.obs==null) ? obs = '' : obs = k.obs;
                                tr += '<td>'+obs+'</td>';
                                tr += '</tr>';
                                $(".history").append(tr);
                                j++;
                            });
                        }
                    });
                    // MANTENIMIENTO
                    $(".titulo-mantenimiento").html(nom);
                    $(".list-mantenimiento").empty();
                    $.post(" {{ url('soporte/lista-mantenimiento') }} ",{id:id,_token:tk},function(r) {
                        if (r.mantenimiento.length > 0) {
                            $.each(r.mantenimiento,function(i,k) {
                                tr = '<tr>';
                                tr += '<td class="text-center">'+k.dsc_tipo+'</td>';
                                tr += '<td class="text-center">'+k.fch_programado+'</td>';
                                tr += '<td class="text-center">'+k.fch_ejecucion+'</td>';
                                tr += '<td class="text-center">'+k.dsc_estado+'</td>';
                                tr += '<td class="text-center">'+k.dsc_abrev+' '+k.costo+'</td>';
                                tr += '<td>'+k.observaciones+'</td>';
                                tr += '</tr>';
                                $(".list-mantenimiento").append(tr);
                            });
                        }
                    });
                    // SOFTWARE
                    $(".titulo-software").html(nom);
                    $(".list-software").empty();
                    $.post(" {{ url('soporte/lista-software') }} ",{id:id,_token:tk},function(r) {
                        if (r.software.length > 0) {
                            $.each(r.software,function(i,k) {
                                tr = '<tr>';
                                tr += '<td>'+k.dsc_categoria+'</td>';
                                tr += '<td>'+k.dsc_software+'</td>';
                                tr += '<td class="text-center">'+k.fch_instalacion+'</td>';
                                tr += '<td>'+k.observaciones+'</td>';
                                tr += '</tr>';
                                $(".list-software").append(tr);
                            });
                        }
                    });
                    tabs();
                    $('html, body').animate({scrollTop:0}, 'slow');
                }
            });
        }
        function tableEquipo(table) {
            $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-kunaq';
            $('#'+table).DataTable({
                dom: "Bfrtip",
                // dom: '<"top"i>rt<"bottom"flp><"clear">',
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
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    }
                },
                buttons: ["excel", "pdf"]
            });
        }
        function tabs() {
            $(".id-tabs").find(".nav-link, .tab-pane").each(function() {
                $(this).removeClass("active");
            });
            $("#l-detalle-equipo").addClass("active");
            $("#detalle-equipo").addClass("active");
        }
    </script>
@endpush