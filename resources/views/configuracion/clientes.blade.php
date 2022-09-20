@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Configuración</b></a> <span class="uri-seg"> > </span>Clientes</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 card-box">
            <ul class="nav nav-tabs tabs-bordered">
                <li class="nav-item">
                    <a href="#clientes" data-toggle="tab" aria-expanded="false" class="nav-link active">
                        <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-table"></i></span>
                        <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-table"></i> Clientes </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#sucursal" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                        <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Sucursal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#usuarios" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uri-seg mdi mdi-checkbox-intermediate"></i></span>
                        <span class="d-none d-sm-block"><i class="uri-seg mdi mdi-checkbox-intermediate"></i> Usuarios</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="clientes">
                    <div class="row create-cliente">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="titulo-cliente"></label></div>
                                <div class="card-body">
                                    <form id="FrmCliente" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Razón Social:</label>
                                                    <input type="text" class="form-control vali" id="dsc_cliente" name="dsc_cliente" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ruc:</label>
                                                    <input type="number" class="form-control vali" id="dsc_ruc" name="dsc_ruc" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "11" autocomplete="off">
                                                    <input type="hidden" id="xid" name="xid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teléfono:</label>
                                                    <input type="number" class="form-control" id="telefono" name="telefono" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Información:</label>
                                                    <textarea class="form-control" name="observaciones" id="observaciones_c" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Dirección:</label>
                                                    <textarea class="form-control" name="direccion" id="direccion" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Fecha Inicio:</label>
                                                    <input type="date" class="form-control vali" name="fch_inicio" id="fch_inicio" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Fecha Fin:</label>
                                                    <input type="date" class="form-control vali" name="fch_vencimiento" id="fch_vencimiento" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row contacto">
                                            <hr>
                                            <div class="col-md-12">
                                                <h5>Usuario de Contacto</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombres:</label>
                                                    <div id="nom_cont" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cargo:</label>
                                                    <div id="cargo" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Teléfono:</label>
                                                    <div id="c-telefono" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Correo:</label>
                                                    <div id="c-correo" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Elija contacto principal con el cliente:</label>
                                                    <select name="contacto" id="contacto" class="form-control"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-secondary radio cancel-cliente">Cancelar</button>
                                                <button type="button" class="btn btn-kunaq enviar">Grabar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-cliente">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                <div class="card-body">
                                    <form id="FrmSearchCliente">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estado:</label>
                                                    <select class="form-control" name="c_estado" id="c_estado">
                                                    <option value="1">ACTIVO</option>
                                                    <option value="0">INACTIVO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-kunaq mt-3 search-cliente"><i class="fe-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-cliente">
                        <div class="col-md-12 mt-3">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new">Nuevo</button></div>
                                <div class="card-body table-responsive table_cli">
                                <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ACCIÓN</th>
                                            <th class="text-center">CLIENTE</th>
                                            <th class="text-center">RUC</th>
                                            <th class="text-center">FECHA INICIO</th>
                                            <th class="text-center">FECHA FIN</th>
                                            <th class="text-center">ESTADO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($cli as $c)
                                        <?php
                                            if($c->flg_activo) {
                                                $e = 'ACTIVO'; $cl = 'badge-success';
                                            } else {
                                                $e = 'INACTIVO'; $cl = 'badge-danger';
                                            }
                                        ?>
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="{{ $c->id }}" title="EDITAR" nom="{{ $c->dsc_cliente }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="uri-seg eliminar" id="{{ $c->id }}" title="DESACTIVAR" nom="{{ $c->dsc_cliente }}"><i class="fas fa-trash-alt"></i></a></td>
                                            <td>{{ $c->dsc_cliente }}</td>
                                            <td class="text-center">{{ $c->dsc_ruc }}</td>
                                            <td class="text-center">{{ $c->fch_inicio }}</td>
                                            <td class="text-center">{{ $c->fch_vencimiento }}</td>
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
                <div class="tab-pane" id="sucursal">
                    <div class="row create-sucursal">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="s-titulo"></label></div>
                                <div class="card-body">
                                    <h4>Datos de la Sucursal</h4>
                                    <hr>
                                    <form id="FrmSucursal" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Cliente:</label>
                                                            <select class="form-control vali" name="cod_cliente" id="cod_cliente">
                                                                <option value="">Seleccione</option>
                                                                @foreach($cli as $cl)
                                                                <option value="{{ $cl->id }}">{{ $cl->dsc_cliente }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nombre:</label>
                                                            <input type="text" class="form-control vali" id="dsc_sucursal" name="dsc_sucursal" autocomplete="off">
                                                            <input type="hidden" id="s_xid" name="s_xid">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Direccion:</label>
                                                            <input type="text" class="form-control vali" name="dsc_direccion" id="dsc_direccion" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Observaciones</label>
                                                            <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                            <h4>Ubicaciones dentro de la Sucursal</h4>
                                                <div class="row mt-3">
                                                    <div class="col-md-6 secc-ubi"></div>
                                                    <div class="col-md-6 text-ubi">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label><b>NUEVA UBICACION</b></label>
                                                                    <input type="text" class="form-control" name="ubi[]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-kunaq mt-3 add-ubi"><i class="fas fa-plus-square"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mt-5">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-secondary radio cancel-sucursal">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar-sucursal">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-sucursal">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                <div class="card-body">
                                    <form id="FrmSearchSucursal">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cliente:</label>
                                                    <select class="form-control vali" name="s_cod_cliente" id="s_cod_cliente">
                                                    <option value="">Seleccione</option>
                                                    @foreach($cli as $c)
                                                    <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-kunaq mt-3 search-sucursal"><i class="fe-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-sucursal">
                        <div class="col-md-12 mt-3">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new-sucursal">Nuevo</button></div>
                                <div class="card-body table-responsive table_sucursal">
                                    <table id="table-list-sucursal" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ACCIÓN</th>
                                                <th class="text-center">CLIENTE</th>
                                                <th class="text-center">SUCURSAL</th>
                                                <th class="text-center">UBICACIONES</th>
                                                <th class="text-center">DIRECCIÓN</th>
                                                <th class="text-center">ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $j = 1; ?>
                                            @foreach($suc as $s)
                                            <?php
                                                if($s->flg_activo) {
                                                    $s_e = 'ACTIVO'; $s_cl = 'badge-success';
                                                    $icon = '<a href="javascript:void(0)" class="uri-seg s-eliminar" id="'.$s->id.'" title="DESACTIVAR" nom="'.$s->dsc_sucursal.'"><i class="fas fa-trash-alt"></i></a>';
                                                } else {
                                                    $s_e = 'INACTIVO'; $s_cl = 'badge-danger';
                                                    $icon = '<a href="javascript:void(0)" class="uri-seg s-activar" id="'.$s->id.'" title="ACTIVAR" nom="'.$s->dsc_sucursal.'"><i class="fe-check-circle"></i></a>';
                                                }
                                            ?>
                                            <tr>
                                                <td class="text-center">{{ $j }}</td>
                                                <td class="text-center"><a href="javascript:void(0)" class="uri-seg s-editar" id="{{ $s->id }}" title="EDITAR" nom="{{ $s->dsc_sucursal }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<?= $icon ?></td>
                                                <td>{{ $s->dsc_cliente }}</td>
                                                <td class="text-center">{{ $s->dsc_sucursal }}</td>
                                                <td>{{ $s->ubicaciones }}</td>
                                                <td>{{ $s->dsc_direccion }}</td>
                                                <td class="text-center"><span class="badge label-table {{ $s_cl }}">{{ $s_e }}</span></td>
                                            </tr>
                                            <?php $j++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="usuarios">
                    <div class="row create-usuario">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> <label class="u-titulo"></label></div>
                                <div class="card-body">
                                    <form id="FrmUsuario" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cliente:</label>
                                                    <select class="form-control vali" name="cod_cliente" id="u_cod_cliente">
                                                        <option value="">Seleccione</option>
                                                        @foreach($cli as $cl)
                                                        <option value="{{ $cl->id }}">{{ $cl->dsc_cliente }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sucursal:</label>
                                                    <select class="form-control vali" name="cod_sucursal" id="u_cod_sucursal">
                                                        <option value="">Seleccione</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cargo:</label>
                                                    <input type="text" class="form-control vali" name="cargo" id="u_cargo" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nombres:</label>
                                                    <input type="text" class="form-control vali" id="u_nombres" name="nombres" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Apellidos:</label>
                                                    <input type="text" class="form-control vali" id="u_apellidos" name="apellidos" autocomplete="off">
                                                    <input type="hidden" id="u_xid" name="u_xid">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Fecha Nacimiento:</label>
                                                    <input type="date" class="form-control" id="u_fch_nacimiento" name="fch_nacimiento">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Telefono:</label>
                                                    <input type="text" class="form-control" id="u_telefono" name="telefono" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" class="form-control" id="u_email" name="email" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Dirección:</label>
                                                    <input type="text" class="form-control" id="u_direccion" name="direccion" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-secondary radio cancel-usuario">Cancelar</button>
                                            <button type="button" class="btn btn-kunaq enviar-usuario">Grabar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-usuario">
                        <div class="col-lg-12">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-format-page-break"></i> Filtros</div>
                                <div class="card-body">
                                    <form id="FrmSearchUsuario">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cliente:</label>
                                                    <select class="form-control vali" name="u_cod_cliente" id="f_u_cod_cliente">
                                                    <option value="">Seleccione</option>
                                                    @foreach($cli as $c)
                                                    <option value="{{ $c->id }}">{{ $c->dsc_cliente }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Sucursal:</label>
                                                    <select class="form-control vali" name="u_sucursal" id="u_sucursal">
                                                        <option value="">Seleccione</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-kunaq mt-3 search-usuario"><i class="fe-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row lista-usuario">
                        <div class="col-md-12 mt-3">
                            <div class="card border">
                                <div class="card-header"><i class="uri-seg mdi mdi-table"></i> Listado<button class="btn btn-kunaq float-right new-usuario">Nuevo</button></div>
                                <div class="card-body table-responsive table_usuario">
                                    <table id="table-list-usuario" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ACCIÓN</th>
                                                <th class="text-center">CLIENTE</th>
                                                <th class="text-center">SUCURSAL</th>
                                                <th class="text-center">NOMBRES</th>
                                                <th class="text-center">CARGO</th>
                                                <th class="text-center">TELÉFONO</th>
                                                <th class="text-center">EMAIL</th>
                                                <th class="text-center">CONTACTO</th>
                                                <th class="text-center">ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $r = 1; ?>
                                            @foreach($usu as $u)
                                            <?php
                                                $u_e = 'INACTIVO'; $u_cl = 'badge-danger';
                                                $icon = '<a href="javascript:void(0)" class="uri-seg u-activar" id="'.$u->id.'" title="ACTIVAR" nom="'.$u->nombres.'"><i class="fe-check-circle"></i></a>';
                                                if($u->flg_activo) {
                                                    $u_e = 'ACTIVO'; $u_cl = 'badge-success';
                                                    $icon = '<a href="javascript:void(0)" class="uri-seg u-eliminar" id="'.$u->id.'" title="DESACTIVAR" nom="'.$u->nombres.'"><i class="fas fa-trash-alt"></i></a>';
                                                }
                                                $img = 'cancel.svg';
                                                $title = 'KUNAQ';
                                                if (!empty($u->user_kunaq)) {
                                                    $img = 'ok.svg';
                                                    $title = 'KUNAQ';
                                                }
                                            ?>
                                            <tr>
                                                <td class="text-center">{{ $r }}</td>
                                                <td class="text-center"><a href="javascript:void(0)" class="uri-seg u-editar" id="{{ $u->id }}" title="EDITAR" nom="{{ $u->nombres }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<?= $icon ?></td>
                                                <td>{{ $u->dsc_cliente }}</td>
                                                <td class="text-center">{{ $u->dsc_sucursal }}</td>
                                                <td>{{ $u->nombres.' '.$u->apellidos }}</td>
                                                <td>{{ $u->cargo }}</td>
                                                <td class="text-center">{{ $u->telefono }}</td>
                                                <td class="text-center">{{ $u->email }}</td>
                                                <td class="text-center"><img class="icon-colored cu {{$title}}" src="{{asset('assets/images/icons/'.$img)}}" title="{{$title}}"></td>
                                                <td class="text-center"><span class="badge label-table {{ $u_cl }}">{{ $u_e }}</span></td>
                                            </tr>
                                            <?php $r++; ?>
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
        .i-ubi {
            color: #AA0000;
            cursor: pointer;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            var tk = $("#tk").val();
            $(".create-cliente").hide();
            $(".create-sucursal").hide();
            $(".create-usuario").hide();
            // CLIENTES
            $(".cancel-cliente").on('click',function() {
                $(".create-cliente").hide();
                $(".lista-cliente").show();
            });

            $(".new").on('click',function() {
                $("#FrmCliente")[0].reset();
                $("#xid").val('');
                $(".titulo-cliente").html('Creación de un nuevo cliente');
                $(".contacto").hide();
                $(".create-cliente").show();
                $(".lista-cliente").hide();
            });

            $(".enviar").on('click',function() {
                Frm = $("#FrmCliente").serializeArray();
                ruc = $("#dsc_ruc").val();
                v = 0;
                $("#FrmCliente").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmCliente").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }
                if (ruc.length != 11) {
                    swal("Alerta!", "El campo ruc debe contener 11 dígitos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-cliente') }} ",Frm,function(r) {
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

            $(".table_cli").on('click','.editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $("#xid").val(id);
                $(".titulo-cliente").html('Modificación '+tit);
                $(".contacto").show();
                $("#nom_cont").empty();
                $("#cargo").empty();
                option("contacto");
                $.post("{{ url('config/get-cliente') }}",{id:id,_token:tk},function(r) {
                    $.each(r.cli,function(i,k) {
                        $("#dsc_cliente").val(k.dsc_cliente);
                        $("#dsc_ruc").val(k.dsc_ruc);
                        $("#telefono").val(k.telefono);
                        $("#email").val(k.email);
                        $("#observaciones_c").val(k.observaciones);
                        $("#direccion").val(k.direccion);
                        $("#fch_inicio").val(k.fch_inicio);
                        $("#fch_vencimiento").val(k.fch_vencimiento);
                    });
                    if (r.con.length > 0) {
                        $.each(r.con,function(i,c) {
                            $("#nom_cont").html(c.apellidos+' '+c.nombres);
                            $("#cargo").html(c.cargo);
                            $("#c-telefono").html(c.telefono);
                            $("#c-correo").html(c.email);
                        });
                    }
                    if (r.usu.length > 0) {
                        $.each(r.usu,function(i,u) {
                            $("#contacto").append('<option value="'+u.id+'">'+u.apellidos+' '+u.nombres+'</option>');
                        });
                    }
                });
                $(".create-cliente").show();
                $(".lista-cliente").hide();
            });

            $(".table_cli").on('click','.eliminar',function() {
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
                        $.post("{{ url('config/delete-cliente') }}",{id:id,_token:tk},function(res){
                            if (res > 0) {
                                swal("Se desactivo satisfactoriamente!", {icon: "success"}).then(function(){
                                    location.reload();
                                });
                            } else {
                                swal("Error no se desactivo!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });

            $(".table_cli").on('click','.activar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas activar al sistema a !"+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/active-cliente') }}",{id:id,_token:tk},function(res){
                            if (res > 0) {
                                swal("Se activo satisfactoriamente!", {icon: "success"}).then(function(){
                                    location.reload();
                                });
                            } else {
                                swal("Error no se desactivo!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });

            $(".search-cliente").on('click',function() {
                Frm = $("#FrmSearchCliente").serializeArray();
                var tabla = $('#table-list').DataTable();
                tabla.destroy();
                $("#table-list tbody").empty();
                $.post("{{ url('config/search-cliente') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        if(k.flg_activo == 1) {
                            e = 'ACTIVO'; cl = 'badge-success';
                            icon = '<a href="javascript:void(0)" class="uri-seg eliminar" id="'+k.id+'" title="DESACTIVAR" nom="'+k.dsc_cliente+'"><i class="fas fa-trash-alt"></i></a>';
                        } else {
                            e = 'INACTIVO'; cl = 'badge-danger';
                            icon = '<a href="javascript:void(0)" class="uri-seg activar" id="'+k.id+'" title="ACTIVAR" nom="'+k.dsc_cliente+'"><i class="fe-check-circle"></i></a>';
                        }
                        tr = '<tr>';
                        tr +='<td class="text-center">'+j+'</td>';
                        tr +='<td class="text-center"><a href="javascript:void(0)" class="uri-seg editar" id="'+k.id+'" title="EDITAR" nom="'+k.dsc_cliente+'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;'+icon+'</td>';
                        tr +='<td>'+k.dsc_cliente+'</td>';
                        tr +='<td class="text-center">'+k.dsc_ruc+'</td>';
                        tr +='<td class="text-center">'+k.fch_inicio+'</td>';
                        tr +='<td class="text-center">'+k.fch_vencimiento+'</td>';
                        tr +='<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                        tr +='</tr>';
                        j++;
                        $("#table-list tbody").append(tr);
                    });
                    table("table-list");
                });
            });
            // SUCURSAL
            $(".cancel-sucursal").on('click',function() {
                $(".create-sucursal").hide();
                $(".lista-sucursal").show();
            });
            table("table-list-sucursal");

            $(".new-sucursal").on('click',function() {
                $("#FrmSucursal")[0].reset();
                $("#s_xid").val('');
                $(".s-titulo").html('Creando nueva sucursal');
                $(".create-sucursal").show();
                $(".lista-sucursal").hide();
                $(".secc-ubi").empty();
            });

            $(".add-ubi").on('click',function() {
                div = '<div class="row">';
                div += '<div class="col-md-10">';
                div += '<div class="form-group">';
                div += '<label></label>';
                div += '<input type="text" class="form-control" name="ubi[]">';
                div += '</div>';
                div += '</div>';
                div += '<div class="col-md-2">';
                div += '<button type="button" class="btn btn-kunaq mt-3 min-ubi"><i class="far fa-trash-alt"></i></button>';
                div += '</div>';
                div += '</div>';
                $(".text-ubi").append(div);
            });

            $(".text-ubi").on('click','.min-ubi',function() {
                $(this).parent().parent().remove();
            });

            $(".enviar-sucursal").on('click',function() {
                Frm = $("#FrmSucursal").serializeArray();
                v = 0;
                $("#FrmSucursal").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmSucursal").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-sucursal') }} ",Frm,function(r) {
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

            $(".table_sucursal").on('click','.s-editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $("#s_xid").val(id);
                $(".s-titulo").html('Modificando '+tit);

                $.post("{{ url('config/get-sucursal') }}",{id:id,_token:tk},function(r) {
                    $.each(r.suc,function(i,k) {
                        $("#cod_cliente").val(k.cod_cliente);
                        $("#dsc_sucursal").val(k.dsc_sucursal);
                        $("#dsc_direccion").val(k.dsc_direccion);
                        $("#observaciones").val(k.observaciones);
                    });
                    $(".secc-ubi").empty();
                    if (r.ubi.length > 0) {
                        $.each(r.ubi,function(uu,u) {
                            div = '<div class="row">';
                            div += '<div class="col-md-10">';
                            div += '<input type="text" id="text-'+u.id+'" class="form-control" style="display:none" value="'+u.dsc_ubicaciones+'" >';
                            div += '<div class="form-control" id="cont-'+u.id+'">'+u.dsc_ubicaciones+'</div>';
                            div += '</div>';
                            div += '<div class="col-md-2">';
                            div += '<i id="sav-'+u.id+'" class="fas fa-save i-ubi u-save" u-id="'+u.id+'" title="GUARDAR" style="display:none"></i>&nbsp;&nbsp;&nbsp;';
                            div += '<i class="fas fa-edit mt-1 i-ubi u-edit" u-id="'+u.id+'"></i>&nbsp;&nbsp;&nbsp;<i class="fas fa-trash-alt mt-1 i-ubi u-del" u-id="'+u.id+'"></i>';
                            div += '</div>';
                            div += '</div>';
                            $(".secc-ubi").append(div);
                        });
                    }
                });
                $(".create-sucursal").show();
                $(".lista-sucursal").hide();
            });
            // Editar Ubicacion
            $(".secc-ubi").on('click','.u-edit',function() {
                uid = $(this).attr('u-id');
                $("#cont-"+uid).hide();
                $("#text-"+uid).show();
                $("#sav-"+uid).show();
            });
            //Actualizar Ubicacion
            $(".secc-ubi").on('click','.u-save',function() {
                id = $(this).attr('u-id');
                text = $("#text-"+id).val();
                $.post("{{ url('config/act-ubicacion') }}",{id:id,text:text,_token:tk},function(r) {
                    if (r.confirm == 1) {
                        swal("Correcto!", r.msg, "success").then(function(){
                            $("#cont-"+id).html(text);
                            $("#sav-"+id).hide();
                            $("#text-"+id).hide();
                            $("#cont-"+id).show();
                        });
                    } else if(r.confirm == 0){
                        swal("Incorrecto!", r.msg, "error");
                    } else {
                        swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                    }
                });
            });
            //Eliminar Ubicacion
            $(".secc-ubi").on('click','.u-del',function() {
                id = $(this).attr('u-id');
                ubi = $("#text-"+id).val();
                swal({
                    title: "Estas Seguro?",
                    text: "Vas a eliminar la ubicación "+ubi,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        let index = $(this);
                        $.post("{{ url('config/del-ubicacion') }}",{id:id,_token:tk},function(r) {
                            if (r.confirm == 1) {
                                swal("Correcto!", r.msg, "success").then(function(){
                                    index.parent().parent().remove();
                                });
                            } else if(r.confirm == 0) {
                                swal("Incorrecto!", r.msg, "info");
                            } else {
                                swal("Incorrecto!", "Error comuniquese con su administrador", "error");
                            }
                        });
                    }
                });
            });

            $(".table_sucursal").on('click','.s-eliminar',function() {
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
                        $.post("{{ url('config/delete-sucursal') }}",{id:id,_token:tk},function(res){
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

            $(".table_sucursal").on('click','.s-activar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas activar al sistema a !"+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/active-sucursal') }}",{id:id,_token:tk},function(res){
                            if (res > 0) {
                                swal("Se activo satisfactoriamente!", {icon: "success"}).then(function(){
                                    location.reload();
                                });
                            } else {
                                swal("Error no se desactivo!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });

            $(".search-sucursal").on('click',function() {
                Frm = $("#FrmSearchSucursal").serializeArray();
                var tabla = $('#table-list-sucursal').DataTable();
                tabla.destroy();
                $("#table-list-sucursal tbody").empty();
                $.post("{{ url('config/search-sucursal') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        if(k.flg_activo == 1) {
                            e = 'ACTIVO'; cl = 'badge-success';
                            icon = '<a href="javascript:void(0)" class="uri-seg s-eliminar" id="'+k.id+'" title="DESACTIVAR" nom="'+k.dsc_sucursal+'"><i class="fas fa-trash-alt"></i></a>';
                        } else {
                            e = 'INACTIVO'; cl = 'badge-danger';
                            icon = '<a href="javascript:void(0)" class="uri-seg s-activar" id="'+k.id+'" title="ACTIVAR" nom="'+k.dsc_sucursal+'"><i class="fe-check-circle"></i></a>';
                        }
                        tr = '<tr>';
                        tr +='<td class="text-center">'+j+'</td>';
                        tr +='<td class="text-center"><a href="javascript:void(0)" class="uri-seg s-editar" id="'+k.id+'" title="EDITAR" nom="'+k.dsc_sucursal+'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;'+icon+'</td>';
                        tr +='<td>'+k.dsc_cliente+'</td>';
                        tr +='<td class="text-center">'+k.dsc_sucursal+'</td>';
                        let ubi = (k.ubicaciones) ? k.ubicaciones : '';
                        tr +='<td>'+ubi+'</td>';
                        tr +='<td>'+k.dsc_direccion+'</td>';
                        tr +='<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                        tr +='</tr>';
                        j++;
                        $("#table-list-sucursal tbody").append(tr);
                    });
                    table("table-list-sucursal");
                });
            });
            // USUARIO
            $(".cancel-usuario").on('click',function() {
                $(".create-usuario").hide();
                $(".lista-usuario").show();
            });
            table("table-list-usuario");

            $(".new-usuario").on('click',function() {
                $("#FrmUsuario")[0].reset();
                option("u_cod_sucursal");
                $("#u_xid").val('');
                $(".u-titulo").html('Creando nuevo usuario');
                $(".create-usuario").show();
                $(".lista-usuario").hide();
            });

            $("#u_cod_cliente").on('change',function() {
                id = $(this).val();
                option("u_cod_sucursal");
                $.post("{{ url('config/cli-sucursal') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#u_cod_sucursal").append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                    });
                });
            });

            $("#f_u_cod_cliente").on('change',function() {
                id = $(this).val();
                option("u_sucursal");
                $.post("{{ url('config/cli-sucursal') }}",{id:id,_token:tk},function(r) {
                    $.each(r,function(i,k) {
                        $("#u_sucursal").append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                    });
                });
            });

            $(".enviar-usuario").on('click',function() {
                Frm = $("#FrmUsuario").serializeArray();
                v = 0;
                $("#FrmUsuario").find(".vali").each(function(){
                    if ($(this).val() == "") {
                        v = 1;
                    }
                });
                if (v) {
                    $("#FrmUsuario").find(".vali").each(function(){
                        if ($(this).val() == "") {
                            $(this).addClass('border border-danger');
                        } else {
                            $(this).removeClass('border border-danger');
                        }
                    });
                    swal("Alerta!", "Ingrese campos", "info");
                    return false;
                }

                $.post(" {{ url('config/man-usuario') }} ",Frm,function(r) {
                    if (r.confirm == 1) {
                        $("#NewUsuario").modal('hide');
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

            $(".table_usuario").on('click','.u-editar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                $("#u_xid").val(id);
                $(".u-titulo").html('Modificando '+tit);

                $.post("{{ url('config/get-usuario') }}",{id:id,_token:tk},function(r) {
                    option("u_cod_sucursal");
                    $.each(r.suc,function(i,k) {
                        $("#u_cod_sucursal").append('<option value="'+k.id+'">'+k.dsc_sucursal+'</option>');
                    });
                    $.each(r.usu,function(i,k) {
                        $("#u_cod_cliente").val(k.cod_cliente);
                        $("#u_cod_sucursal").val(k.idSucursal);
                        $("#u_nombres").val(k.nombres);
                        $("#u_apellidos").val(k.apellidos);
                        $("#u_cargo").val(k.cargo);
                        $("#u_fch_nacimiento").val(k.fch_nacimiento);
                        $("#u_telefono").val(k.telefono);
                        $("#u_email").val(k.email);
                        $("#u_direccion").val(k.direccion);
                    });
                    
                });
                $(".create-usuario").show();
                $(".lista-usuario").hide();
            });

            $(".table_usuario").on('click','.u-eliminar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                var fec = document.createElement("input");
                fec.type = "date"; fec.id = "fch_fin_usr"; fec.value = "<?= date('Y-m-d') ?>";
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas desactivar al usuario "+tit+". Con esta acción se procederá colocarle fin a los equipos que tiene el usuario. Esta operación es irreversible",
                    content: fec,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        fch = $("#fch_fin_usr").val();
                        $.post("{{ url('config/delete-usuario') }}",{id:id,fec_fin:fch,_token:tk},function(r){
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
                    }
                });
            });

            $(".table_usuario").on('click','.u-activar',function() {
                id = $(this).attr('id');
                tit = $(this).attr('nom');
                swal({
                    title: "Estas Seguro?",
                    text: "Deseas activar al sistema a !"+tit,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ url('config/active-usuario') }}",{id:id,_token:tk},function(res){
                            if (res > 0) {
                                swal("Se activo satisfactoriamente!", {icon: "success"}).then(function(){
                                    location.reload();
                                });
                            } else {
                                swal("Error no se desactivo!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });

            $(".search-usuario").on('click',function() {
                Frm = $("#FrmSearchUsuario").serializeArray();
                var tabla = $('#table-list-usuario').DataTable();
                tabla.destroy();
                $("#table-list-usuario tbody").empty();
                $.post("{{ url('config/search-usuario') }}",Frm,function(r) {
                    j = 1;
                    $.each(r,function (i,k) {
                        if(k.flg_activo == 1) {
                            e = 'ACTIVO'; cl = 'badge-success';
                            icon = '<a href="javascript:void(0)" class="uri-seg u-eliminar" id="'+k.id+'" title="DESACTIVAR" nom="'+k.nombres+'"><i class="fas fa-trash-alt"></i></a>';
                        } else {
                            e = 'INACTIVO'; cl = 'badge-danger';
                            icon = '<a href="javascript:void(0)" class="uri-seg u-activar" id="'+k.id+'" title="ACTIVAR" nom="'+k.nombres+'"><i class="fe-check-circle"></i></a>';
                        }
                        img = 'cancel.svg';
                        title = 'KUNAQ';
                        if (k.user_kunaq) {
                            img = 'ok.svg';
                            title = 'KUNAQ';
                        }
                        tr = '<tr>';
                        tr +='<td class="text-center">'+j+'</td>';
                        tr +='<td class="text-center"><a href="javascript:void(0)" class="uri-seg u-editar" id="'+k.id+'" title="EDITAR" nom="'+k.nombres+'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;'+icon+'</td>';
                        tr +='<td>'+k.dsc_cliente+'</td>';
                        tr +='<td class="text-center">'+k.dsc_sucursal+'</td>';
                        tr +='<td>'+k.nombres+' '+k.apellidos+'</td>';
                        tr +='<td>'+k.cargo+'</td>';
                        let tel = (k.telefono) ? k.telefono : '';
                        tr +='<td class="text-center">'+tel+'</td>';
                        let email = (k.email) ? k.email : '';
                        tr +='<td class="text-center">'+email+'</td>';
                        tr +='<td class="text-center"><img class="icon-colored cu '+title+'" src="<?=asset('assets/images/icons')?>/'+img+'" title="'+title+'"></td>';
                        tr +='<td class="text-center"><span class="badge label-table '+cl+'">'+e+'</span></td>';
                        tr +='</tr>';
                        j++;
                        $("#table-list-usuario tbody").append(tr);
                    });
                    table("table-list-usuario");
                });
            });
        });
        function option(id) {
            $("#"+id).empty();
            $("#"+id).append('<option value="">Seleccione</option>');
        }
        function table(table) {
            $("#"+table).DataTable({
                responsive: true,
                    language: {
                        search:         "Busqueda&nbsp;:",
                        lengthMenu:     "Mostrar _MENU_ elementos",
                        info:           "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
                        paginate: {
                            first:      "Primero",
                            previous:   "Aterior",
                            next:       "Siguiente",
                            last:       "Ultimo"
                        }
                    }
            });
        }
    </script>
@endpush