@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Equipos</p>
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
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Lista Equipos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#componentes" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Componentes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asignacion" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Asignaciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#mantenimiento" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Mantenimiento</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#software-instalado" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                            <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Software Instalado</span>
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
                                        <form id="FrmEquipo" method="post">
                                            @csrf
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
                                                        <label>Ubicación:</label>
                                                        <select class="form-control vali" name="cod_ubicacion" id="cod_ubicacion">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado:</label>
                                                        <select class="form-control vali" name="cod_estado" id="cod_estado">
                                                            <option value="">Seleccione</option>
                                                            @foreach($est as $e)
                                                            <option value="{{ $e->id }}">{{ $e->dsc_estado }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Periférico:</label>
                                                        <select class="form-control vali" name="cod_periferico" id="cod_periferico">
                                                            <option value="">Seleccione</option>
                                                            @foreach($per as $p)
                                                            <option value="{{ $p->id }}">{{ $p->dsc_periferico }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Marca:</label>
                                                        <select class="form-control vali" name="cod_marca" id="cod_marca">
                                                            <option value="">Seleccione</option>
                                                            @foreach($mar as $m)
                                                            <option value="{{ $m->id }}">{{ $m->dsc_marca }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Modelo:</label>
                                                        <select class="form-control vali" name="cod_modelo" id="cod_modelo">
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Código Inventario:</label>
                                                        <input type="text" class="form-control" name="nro_inventario" id="nro_inventario" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Código Activo:</label>
                                                        <input type="text" class="form-control" name="cod_activo" id="cod_activo" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Serie:</label>
                                                        <input type="text" class="form-control" name="serie" id="serie" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Procesador:</label>
                                                        <select class="form-control" name="procesador" id="procesador">
                                                            <option value="">Seleccione</option>
                                                            @foreach($pro as $p)
                                                            <option value="{{ $p->id }}">{{ $p->dsc_procesador }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Velocidad:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">GHz</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="velocidad_procesador" id="velocidad_procesador" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Memoria:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">GB</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="memoria" id="memoria" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Disco Duro:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">GB</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="disco_duro" id="disco_duro" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tamaño:</label>
                                                        <input type="text" class="form-control" name="tamanio" id="tamanio" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>F.Compra:</label>
                                                        <input type="date" class="form-control" name="fch_compra" id="fch_compra">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>F.Instalación:</label>
                                                        <input type="date" class="form-control" name="fch_instalacion" id="fch_instalacion">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tipo Propiedad:</label>
                                                        <select class="form-control vali" name="tipo_propiedad" id="tipo_propiedad">
                                                            <option value="">Seleccione</option>
                                                            @foreach($tp as $p)
                                                            <option value="{{ $p->id }}">{{ $p->dsc_tipo_propiedad }}</option>
                                                            @endforeach
                                                        </select>
                                                        <!-- <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                            <input type="checkbox" name="kunaq" id="kunaq" value="1">
                                                            <label for="kunaq"> Vendido por Kunaq </label>
                                                        </div>
                                                        <div class="checkbox checkbox-primary form-check-inline ml-1 mt-1">
                                                            <input type="checkbox" name="alquilado" id="alquilado" value="1">
                                                            <label for="alquilado"> Alquilado </label>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label>Proveeedor:</label>
                                                                <select class="form-control" name="proveedor" id="proveedor">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach($prov as $pro)
                                                                    <option value="{{ $pro->id }}">{{ $pro->dsc_proveedor }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-kunaq mt-3 new-proveedor"><i class="dripicons-document-new"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Contrato:</label>
                                                        <input type="text" class="form-control" name="contrato" id="contrato" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Vcmto. Contrato:</label>
                                                        <input type="date" class="form-control" name="fch_vcmto_mes" id="fch_vcmto_mes">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Moneda:</label>
                                                                <select class="form-control" name="moneda" id="moneda">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach($mon as $m)
                                                                    <option value="{{ $m->id }}">{{ $m->dsc_moneda }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Cuota Mes:</label>
                                                                <input type="number" class="form-control" name="cuota_mes" id="cuota_mes" autocomplete="off" min="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Costo de Equipo:</label>
                                                        <input type="number" class="form-control" name="costo_equipo" id="costo_equipo" autocomplete="off" min="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Nombre:</label>
                                                        <input type="text" class="form-control vali" name="dsc_equipo" id="dsc_equipo" autocomplete="off">
                                                        <input type="hidden" id="xid" name="id">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Detalle:</label>
                                                        <textarea class="form-control" name="observaciones" id="observaciones" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
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
                            <div class="col-lg-12">
                                <div class="card border">
                                    <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                    <div class="card-body">
                                        <form id="FrmFiltro" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Clientes :</label>
                                                    <select class="form-control" name="cod_cliente">
                                                        <option value="0">Seleccione</option>
                                                        @foreach($cli as $c)
                                                        <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Periférico :</label>
                                                    <select class="form-control" name="cod_periferico">
                                                        <option value="0">Seleccione</option>
                                                        @foreach($per as $p)
                                                        <option value="{{ $p->id }}">{{ $p->dsc_periferico }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Marca :</label>
                                                    <select class="form-control" name="cod_marca">
                                                        <option value="0">Seleccione</option>
                                                        @foreach($mar as $m)
                                                        <option value="{{ $m->id }}">{{ $m->dsc_marca }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Estado :</label>
                                                    <select class="form-control" name="cod_estado">
                                                        <option value="0">Seleccione</option>
                                                        @foreach($est as $e)
                                                        <option value="{{ $e->id }}">{{ $e->dsc_estado }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-kunaq mt-3 filtro"><i class="fe-search"></i> Buscar</button>
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
                                    <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new_equipo">Nuevo</button></div>
                                    <div class="card-body table-responsive table_equipo">
                                        <table id="table-Equipo" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">COD-CLIENTE</th>
                                                    <!-- <th class="text-center">CÓDIGO</th> -->
                                                    <th class="text-center">EQUIPO</th>
                                                    <th class="text-center">CLIENTE</th>
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
                                                <?php $i = 1; ?>
                                                @foreach($eq as $e)
                                                <tr>
                                                    <td class="text-center">{{ $e->id }}</td>
                                                    <td class="text-center">{{ $e->cod_cliente }}</td>
                                                    <!-- <td class="text-center">{{ str_pad($e->id,  10, "0",STR_PAD_LEFT) }}</td> -->
                                                    <td class="text-center">{{ $e->dsc_equipo }}</td>
                                                    <td class="text-center">{{ $e->dsc_cliente }}</td>
                                                    <td class="text-center">{{ $e->dsc_periferico }}</td>
                                                    <td class="text-center">{{ $e->dsc_marca }}</td>
                                                    <td class="text-center">{{ $e->dsc_modelo }}</td>
                                                    <td class="text-center">{{ $e->dsc_estado }}</td>
                                                    <td>{{ $e->nombres.' '.$e->apellidos }}</td>
                                                    <td class="text-center">{{ $e->cod_activo }}</td>
                                                    <td class="text-center">{{ $e->serie }}</td>
                                                    <td class="text-center">{{ $e->fch_compra }}</td>
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
                    <div class="tab-pane show" id="asignacion">
                        <h4 class="titulo-asignacion mb-3"></h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="deta-incidencia" class="table-responsive">
                                    <h4 class="modal-title titulo-asignar"></h4>
                                    <form id="FrmAsignar" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Fecha Inicio</label>
                                                <input type="date" class="form-control vali" name="fch_inicio" id="as_fch_inicio">
                                                <input type="hidden" name="c_e" id="c_e">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Fecha Fin</label>
                                                <input type="date" class="form-control" name="fch_final" id="as_fch_final">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Usuario de Entrega</label>
                                                <select class="form-control vali" name="cod_cliente_usuario" id="cod_cliente_usuario">
                                                    <option value="">Seleccione</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label>Observaciones:</label>
                                                <textarea class="form-control" name="obs" id="as_obs" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-5 mb-5">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-kunaq env-asig">Grabar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" style="height: 300px;overflow-y: scroll;">
                                                    <table class="table mb-0">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">ACCIÓN</th>
                                                            <th class="text-center">EQUIPO</th>
                                                            <th class="text-center">CLIENTE</th>
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="componentes">
                        <div class="table-responsive">
                            <h4 class="title-comp mb-3"></h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="scrollsize-scroll list-comp content" style="max-height: 200px;overflow-y: auto;overflow-x: auto;"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Equipo:</label>
                                                <select name="equipo" id="c_equipo" class="form-control"></select>
                                                <input type="hidden" name="idEquipo" id="idEquipo">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label></label>
                                                <button class="btn btn-kunaq mt-1 add">ADD</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="mantenimiento">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="deta-incidencia" class="table-responsive">
                                    <h4 class="titulo-mantenimiento"></h4>
                                    <form id="FrmMantenimiento" method="post">
                                        @csrf
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tipo Mantenimiento</label>
                                                    <select class="form-control vali" name="cod_tipo">
                                                        <option value="">Selecciona</option>
                                                        @foreach($tipo_man as $tm)
                                                        <option value="{{$tm->cod_tipo}}">{{$tm->dsc_tipo}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>F. Programada</label>
                                                    <input type="date" class="form-control" name="fch_programado" value="{{date('Y-m-d')}}">
                                                    <input type="hidden" name="cod_equipo" id="c_e_m">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>F. Ejecución</label>
                                                    <input type="date" class="form-control" name="fch_ejecucion" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estado Mantenimiento</label>
                                                    <select class="form-control vali" name="cod_estado">
                                                        <option value="">Seleccione</option>
                                                        @foreach($est_man as $em)
                                                        <option value="{{$em->id}}">{{$em->dsc_estado}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Moneda:</label>
                                                            <select class="form-control" name="moneda">
                                                                <option value="">Seleccione</option>
                                                                @foreach($mon as $m)
                                                                <option value="{{ $m->id }}">{{ $m->dsc_moneda }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Costo:</label>
                                                            <input type="number" class="form-control" name="costo" autocomplete="off" min="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Proveeedor:</label>
                                                    <select class="form-control" name="cod_proveedor">
                                                        <option value="">Seleccione</option>
                                                        @foreach($prov as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->dsc_proveedor }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label>Observaciones:</label>
                                                <textarea class="form-control vali" name="observaciones" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-5 mb-5">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-kunaq env-mantenimiento">Grabar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" style="height: 300px;overflow-y: scroll;">
                                                    <table id="tableMantenimiento" class="table mb-0">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show" id="software-instalado">
                        <h4 class="modal-title titulo-software mb-3"></h4>
                        <form id="FrmSoftware">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="fomr-group">
                                        <label>Categoria:</label>
                                        <select class="form-control" id="categoria">
                                            <option value="">Seleccione</option>
                                            @foreach($cat as $ca)
                                                <option value="{{$ca->id}}">{{$ca->dsc_categoria}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="fomr-group">
                                        <label>Software:</label>
                                        <select class="form-control vali" name="cod_software" id="cod_software">
                                            <option value="">Seleccione</option>
                                        </select>
                                        <input type="hidden" name="cod_equipo" id="s-id">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="fomr-group">
                                        <label>F. Instalación:</label>
                                        <input type="date" class="form-control" name="fch_instalacion" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="fomr-group">
                                        <label>Observación:</label>
                                        <textarea class="form-control" name="observaciones" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-kunaq env-software">Enviar</button>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="table-responsive" style="height: 300px;overflow-y: scroll;">
                                    <table id="tableSoftware" class="table mb-0">
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
    <div id="AsigEdit" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title titulo-usu"></h4>
                </div>
                <div class="modal-body">
                    <form id="FrmUpdateAsig" method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-md-12 table-responsive">
                            <div class="table-responsive">
                                <table class="table m-0 table-colored-bordered table-bordered-blue table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">FECHA INICIO</th>
                                            <th class="text-center">FECHA FIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%;"><div id="fch_inicio" class="form-control text-center"></div></td>
                                            <td style="width: 50%;"><input type="date" name="fch_final" id="fch_final" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="xhid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary radio" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-kunaq env-update-asig">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Nuevo-Proveedor" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title">Nuevo Proveedor</h4>
                </div>
                <div class="modal-body">
                    <form id="FrmProveedor" method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="dsc_proveedor" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary radio" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-kunaq env-proveedor">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .table .thead-light th {
            color: #fff;
            background-color: #AA0000;
            border-color: #AA0000;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();
            $(".create").hide();
            select();
            tableEquipo("table-Equipo");

            $(".new_equipo").on('click',function() {
                $(".titulo").html('Creación de un nuevo equipo');
                option('cod_modelo');
                $(".lista").hide();
                $("#FrmEquipo")[0].reset();
                $("#xid").val('');
                $(".create").show();
            });

            $(".cancel").on('click',function() {
                $(".create").hide();
                $(".lista").show();
            });

            $('.filtro').on('click',function() {
                Frm = $("#FrmFiltro").serializeArray();
                var table = $('#table-Equipo').DataTable();
                table.destroy();
                $("#table-Equipo tbody").empty();
                $.post(" {{ url('config/equipo-filtro') }} ",Frm,function(r) {
                    $.each(r,function (i,k) {
                        if (k.cod_activo) { activo = k.cod_activo } else { activo = ''; }
                        if (k.serie) { serie = k.serie } else { serie = ''; }
                        tr = '<tr>';
                        tr += '<td class="text-center">'+k.id+'</td>';
                        tr += '<td class="text-center">'+k.cod_cliente+'</td>';
                        // tr += '<td class="text-center">'+('0000000000' + k.id).slice(-10)+'</td>';
                        tr += '<td class="text-center">'+ k.dsc_equipo +'</td>';
                        tr += '<td class="text-center">'+ k.dsc_cliente +'</td>';
                        tr += '<td class="text-center">'+ k.dsc_periferico +'</td>';
                        tr += '<td class="text-center">'+ k.dsc_marca +'</td>';
                        tr += '<td class="text-center">'+ k.dsc_modelo +'</td>';
                        tr += '<td class="text-center">'+ k.dsc_estado +'</td>';
                        if(k.nombres){nom = k.nombres}else{nom=''}; if(k.apellidos){ape = k.apellidos}else{ape=''};
                        tr += '<td>'+ nom +' '+ape+'</td>';
                        tr += '<td class="text-center">'+ activo +'</td>';
                        tr += '<td class="text-center">'+ serie +'</td>';
                        tr += '<td class="text-center">'+ k.fch_compra +'</td>';
                        tr += '</tr>';
                        $("#table-Equipo tbody").append(tr);
                    });
                    tableEquipo("table-Equipo");
                });
            });

            $('#cod_cliente').on('change',function() {
                id = $(this).val();
                option('cod_sucursal');
                $.post(" {{ url('config/equipo-sucursal') }} ",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#cod_sucursal").append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                    });
                });
            });

            $('#cod_sucursal').on('change',function() {
                cli = $("#cod_cliente").val();
                suc = $(this).val();
                option('cod_ubicacion');
                $.post(" {{ url('config/equipo-ubicacion') }} ",{cli:cli,suc:suc,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#cod_ubicacion").append('<option value="'+k.id+'">'+k.dsc_ubicaciones+'</option>');
                    });
                });
            });

            $("#cod_periferico, #cod_marca").on('change',function() {
                let per = $("#cod_periferico").val();
                let mar = $("#cod_marca").val();
                $("#cod_modelo").empty();
                $.post(" {{ url('config/get-modelo-equipo') }} ",{per:per,mar:mar,_token:tk},function(r) {
                    option('cod_modelo');
                    $.each(r,function(i,k) {
                        $("#cod_modelo").append('<option value="'+k.id+'">'+k.dsc_modelo+'</option>');
                    });
                });
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmEquipo").serializeArray();
                v = 0;
                $("#FrmEquipo").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmEquipo").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }
                
                if ($("#kunaq").is(':checked')) {
                    if ($("#fch_compra").val() == "") {
                        swal("Alerta!", "Ingrese fecha de compra", "info");
                        return false;
                    }
                }
                
                if ($("#kunaq").is(':checked') && $("#alquilado").is(':checked')) {
                    swal("Alerta!", "Vendido por Kunaq y alquilado no pueden estar activados a la vez", "info");
                    return false;
                }

                $.post(" {{ url('config/man-equipo') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#NewEquipo").modal('hide');
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

            $(".table_equipo").on('click','.eliminar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas desactivar del sistema a !"+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/delete-equipo') }}",{id:id,_token:tk},function(res){
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

            $(".new-proveedor").on('click',function() {
                $("#Nuevo-Proveedor").modal('show');
            });

            $(".env-proveedor").on('click',function() {
               Frm = $("#FrmProveedor").serializeArray();
               $.post("{{ url('config/proveedor') }}",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#FrmProveedor")[0].reset();
                        $("#Nuevo-Proveedor").modal('hide');
                        swal("Correcto!", r.msg, "success").then(function(){
                            $("#proveedor").append('<option value="'+r.id+'">'+r.nombre+'</option>');
                            $("#proveedor").val(r.id);
                        });
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
               }); 
            });
            // METODOS ASIGNAR EQUIPO
            $(".env-asig").on('click',function() {
                Frm = $("#FrmAsignar").serializeArray();
                v = 0;
                $("#FrmAsignar").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmAsignar").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/save-asignacion') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#Asignar").modal('hide');
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

            $(".history").on('click','.h-editar',function() {
                id = $(this).attr('id');
                cli = $(this).attr('cli');
                cliusu = $(this).attr('cliusu');
                nom = $(this).attr('nom');
                usu = $(this).attr('usu');
                $("#xhid").val(id);
                $(".titulo-usu").html('Equipo: '+nom+' Usuario: '+usu);
                $.post(" {{ url('config/get-history') }} ",{id:id,cli:cli,cli_usu:cliusu,_token:tk},function(r) {
                    if (r.fecha.length > 0) {
                        $.each(r.fecha,function(i,k) {
                            $("#fch_inicio").html(k.fch_inicio);
                            (k.fch_final) ? fch_fin = k.fch_final : fch_final = '';
                            $("#fch_final").val(k.fch_final);
                        });
                    }
                });
                $("#AsigEdit").modal('show');
            });

            $(".env-update-asig").on('click',function() {
                id = $("#xhid").val();
                fch_fi = $("#fch_final").val();
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas actualizar los datos ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post(" {{ url('config/act-history') }} ",{id:id,fch_fi:fch_fi,_token:tk},function(r) {
                            if (r.confirm == 1) {
                                $("#AsigEdit").modal('hide');
                                swal("Correcto!", r.msg, "success").then(function(){
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
            // METODOS COMPONENTES
            $(".add").on('click',function() {
                idE = $("#idEquipo").val();
                idCE = $("#c_equipo").val();
                if (idCE == "") {
                    swal("Alerta!","Seleccione equipo","info");
                    return false;
                }
                $.post("{{ url('config/save-component') }}",{id_e:idE,id_c_e:idCE,_token:tk},function(r){
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success");
                    } else if(r.confirm == 0){
                        swal("Alerta!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "info");
                    }
                });
            });

            $(".list-comp").on('click','.eli-comp',function() {
                ids = $(this).attr('xcode');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas eliminar el componente?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/del-component') }}",{id:ids,_token:tk},function(r){
                            if (r.confirm == 1) {
                                swal("Correcto!", r.msg, "success");
                            } else if(r.confirm == 0){
                                swal("Alerta!", r.msg, "error");
                            } else {
                                swal("Incorrecto!", "Error comuniquese con su administrador", "info");
                            }
                        });
                    }
                });
            });
            // METODOS MANTENIMIENTO
            $(".env-mantenimiento").on('click',function() {
                Frm = $("#FrmMantenimiento").serializeArray();
                v = 0;
                $("#FrmMantenimiento").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmMantenimiento").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }
                if ($("#c_e_m").val()=="") {
                    swal("Alerta!", "Seleccione un equipo de la lista", "info");
                    return false;
                }
                $.post(" {{ url('config/save-mantenimiento') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#FrmMantenimiento")[0].reset()
                        swal("Correcto!", r.msg, "success").then(function(){
                            if (r.data.length > 0) {
                                $.each(r.data,function(i,k) {
                                    tr = '<tr>';
                                    tr += '<td class="text-center">'+k.dsc_tipo+'</td>';
                                    tr += '<td class="text-center">'+k.fch_programado+'</td>';
                                    tr += '<td class="text-center">'+k.fch_ejecucion+'</td>';
                                    tr += '<td class="text-center">'+k.dsc_estado+'</td>';
                                    tr += '<td class="text-center">'+k.dsc_abrev+' '+k.costo+'</td>';
                                    tr += '<td>'+k.observaciones+'</td>';
                                    tr += '</tr>';
                                    $("#tableMantenimiento tbody").prepend(tr);
                                });
                            }
                        });
                    } else if(r.confirm == 0) {
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });
            // METODOS SOFTWARE
            $("#categoria").on('change',function() {
                id = $(this).val();
                option("cod_software");
                $.post(" {{ url('config/software') }} ",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#cod_software").append('<option value="'+k.id+'">'+k.dsc_software+'</option>');
                    });
                });
            });

            $(".env-software").on('click',function() {
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
                if ($("#s-id").val()=="") {
                    swal("Alerta!", "Seleccione un equipo de la lista", "info");
                    return false;
                }
                $.post(" {{ url('config/save-software') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#FrmSoftware")[0].reset()
                        swal("Correcto!", r.msg, "success").then(function(){
                            if (r.data.length > 0) {
                                $.each(r.data,function(i,k) {
                                    tr = '<tr>';
                                    tr += '<td>'+k.dsc_categoria+'</td>';
                                    tr += '<td>'+k.dsc_software+'</td>';
                                    tr += '<td class="text-center">'+k.fch_instalacion+'</td>';
                                    tr += '<td>'+k.observaciones+'</td>';
                                    tr += '</tr>';
                                    $("#tableSoftware tbody").prepend(tr);
                                });
                            }
                        });
                    } else if(r.confirm == 0) {
                        swal("Incorrecto!", r.msg, "error");
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
            $('.table_equipo tbody').on('dblclick', 'tr', function() {
                var table = $('#table-Equipo').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    //Limpiamos formulario equipo
                    nuevo();
                    //Limpiamos select Asignacion
                    option("cod_cliente_usuario");
                    $("#c_e").val('');
                    // Limpiamos Historial Asignacion
                    $(".titulo-asignacion").html('');
                    $(".history").empty();
                    //Limpiar Componentes
                    $("#idEquipo").val('');
                    option("c_equipo");
                    $(".list-comp").empty();
                    $(".title-comp").html('');
                    // Limpiar Mantenimiento
                    $(".titulo-mantenimiento").html('');
                    $(".list-mantenimiento").empty();
                    $("#c_e_m").val('');
                    // Limpiar Software
                    $(".titulo-software").html('');
                    $(".list-software").empty();
                    $("#s-id").val('');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    id = table.rows('.selected').data()[0][0];
                    cli = table.rows('.selected').data()[0][1];
                    nom = table.rows('.selected').data()[0][2];
                    // EDITAR EQUIPO
                    $(".titulo").html('Modificación de '+nom);
                    $.post("{{ url('config/get-equipo') }}",{id:id,_token:tk},function(r) {
                        option('cod_sucursal');
                        option('cod_ubicacion');
                        option('cod_modelo');
                        $.each(r.suc,function(i,s) {
                            $("#cod_sucursal").append('<option value="'+s.id+'">'+s.dsc_sucursal+'</option>');
                        });
                        $.each(r.ubi,function(i,u) {
                            $("#cod_ubicacion").append('<option value="'+u.id+'">'+u.dsc_ubicaciones+'</option>');
                        });
                        $.each(r.mod,function(i,m) {
                            $("#cod_modelo").append('<option value="'+m.id+'">'+m.dsc_modelo+'</option>');
                        });
                        $.each(r.eq,function(i,k) {
                            $("#cod_equipo").val(k.cod_equipo);
                            $("#cod_cliente").val(k.cod_cliente);
                            $("#cod_sucursal").val(k.cod_sucursal);
                            $("#cod_ubicacion").val(k.cod_ubicacion);
                            $("#cod_estado").val(k.cod_estado);
                            $("#cod_periferico").val(k.cod_periferico);
                            $("#cod_marca").val(k.cod_marca);
                            $("#cod_modelo").val(k.cod_modelo);
                            $("#nro_inventario").val(k.nro_inventario);
                            $("#cod_activo").val(k.cod_activo);
                            $("#serie").val(k.serie);
                            $("#procesador").val(k.procesador);
                            $("#velocidad_procesador").val(k.velocidad_procesador);
                            $("#memoria").val(k.memoria);
                            $("#disco_duro").val(k.disco_duro);
                            $("#fch_compra").val(k.fch_compra);
                            $("#fch_instalacion").val(k.fch_instalacion);
                            $("#tipo_propiedad").val(k.tipo_propiedad);
                            $("#proveedor").val(k.proveedor);
                            $("#contrato").val(k.contrato);
                            $("#moneda").val(k.moneda);
                            $("#cuota_mes").val(k.cuota_mes);
                            $("#fch_vcmto_mes").val(k.fch_vcmto_mes);
                            $("#tamanio").val(k.tamanio);
                            $("#costo_equipo").val(k.costo_equipo);
                            // if (k.kunaq) {
                            //     $("#kunaq").prop('checked',true);
                            // } else {
                            //     $("#kunaq").prop('checked',false);
                            // }
                            // if (k.alquilado) {
                            //     $("#alquilado").prop('checked',true);
                            // } else {
                            //     $("#alquilado").prop('checked',false);
                            // }
                            $("#dsc_equipo").val(k.dsc_equipo);
                            $("#observaciones").val(k.observaciones);
                            $("#xid").val(id);
                        });
                    });
                    $(".lista").hide();
                    $("#xid").val(id);
                    $(".create").show();
                    $('html, body').animate({scrollTop:0}, 'slow');
                    // ASIGNACIONES
                    $(".titulo-asignacion").html(nom);
                    $("#FrmAsignar")[0].reset();
                    $("#c_e").val(id);
                    $("#cod_cliente_usuario").empty();
                    $(".history").empty();
                    $.post(" {{ url('config/cli-usuario') }} ",{id:id,cli:cli,_token:tk},function(r) {
                        o = '<option value="">Seleccione</option>';
                        $.each(r.cli_usu,function(i,k) {
                            o += '<option value="'+k.id+'">'+k.nombres+' '+k.apellidos+'</option>';
                        });
                        $("#cod_cliente_usuario").append(o);
                        if (r.asig_usu.length > 0) {
                            j = 1;
                            $.each(r.asig_usu,function(i,k) {
                                (k.active) ? icon = '&nbsp&nbsp&nbsp<i class="fas fa-check-circle uri-seg"></i>' : icon = '';
                                tr = '<tr>';
                                tr += '<td class="text-center">'+j+'</td>';
                                tr += '<td class="text-center"><a href="javascript:void(0)" class="uri-seg h-editar" id="'+k.id+'" cli="'+k.cod_cliente+'" title="EDITAR" nom="'+k.dsc_equipo+'" usu="'+k.apellidos+' '+k.nombres+'" cliusu="'+k.cli_usu+'"><i class="fas fa-edit"></i></a>'+icon+'</td>';
                                tr += '<td>'+k.dsc_equipo+'</td>';
                                tr += '<td>'+k.dsc_cliente+'</td>';
                                tr += '<td>'+k.nombres+' '+k.apellidos+'</td>';
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
                    // COMPONENTES
                    $("#idEquipo").val(id);
                    $("#c_equipo").empty();
                    $(".list-comp").empty();
                    $(".title-comp").html(nom);
                    $.post(" {{ url('config/comp-cli-equipo') }} ",{id:id,cli:cli,_token:tk},function(r) {
                        if (r.components.length > 0) {
                            ul = '<ul>';
                            $.each(r.components,function(i,k) {
                                ul += '<li>'+k.dsc_equipo+' <a href="javascript:void(0)" class="text-reset eli-comp" xcode="'+k.cod_equipo+'-'+k.cod_equipo_comp+'"><i style="color:red" class="fe-x-circle"></i></a></li>';
                            });
                            ul += '</ul>';
                            $(".list-comp").append(ul);
                        }
                        o = '<option value="">Selecciona</option>';
                        $.each(r.equipos,function(i,k) {
                            o += '<option value="'+k.id+'">'+k.dsc_equipo+'</option>';
                        });
                        $("#c_equipo").append(o);
                    });
                    // MANTENIMIENTO
                    $("#c_e_m").val(id);
                    $(".titulo-mantenimiento").html(nom);
                    $(".list-mantenimiento").empty();
                    $.post(" {{ url('config/lista-mantenimiento') }} ",{id:id,_token:tk},function(r) {
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
                    $("#s-id").val(id);
                    $(".titulo-software").html(nom);
                    $(".list-software").empty();
                    $.post(" {{ url('config/lista-software') }} ",{id:id,_token:tk},function(r) {
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
                    },{
                        "targets": [1],
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
        function nuevo() {
            $(".titulo").html('Creación de un nuevo equipo');
            option('cod_modelo');
            $("#FrmEquipo")[0].reset();
            $("#xid").val('');
        }
    </script>
@endpush