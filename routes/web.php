<?php

use App\Http\Controllers\Atenciones;
use App\Http\Controllers\Configuracion;
use App\Http\Controllers\Control;
use App\Http\Controllers\General;
use App\Http\Controllers\GestionEquipo;
use App\Http\Controllers\Incidencias;
use App\Http\Controllers\Login;
use App\Http\Controllers\ResumenInventario;
use App\Http\Controllers\Soporte;
use Illuminate\Support\Facades\Route;

Route::get('/', [Login::class,'index']);
Route::post('login', [Login::class,'autentication']);
Route::get('logout', [Login::class,'logout']);

Route::get('general',[General::class,'index']);
Route::get('perfil',[General::class,'index']);

Route::get('control-acceso',[Control::class,'control']);
Route::post('man-user',[Control::class,'usuario']);
Route::post('get-user',[Control::class,'getUsuario']);
Route::post('delete-user',[Control::class,'delUsuario']);

Route::prefix('soporte')->group(function() {
    // GESTION DE EQUIPOS
    Route::get('gestion-equipo',[GestionEquipo::class,'index']);
    Route::post('deta-equipo',[GestionEquipo::class,'detalleEquipo']);
    Route::post('usu-equipos',[GestionEquipo::class,'usuarioEquipos']);
    Route::post('lista-equipos',[GestionEquipo::class,'listaEquipos']);
    Route::post('lista-mantenimiento',[GestionEquipo::class,'listaMantenimiento']);
    Route::post('lista-software',[GestionEquipo::class,'listaSoftware']);
    // RESUMEN INVENTARIO
    Route::get('resumen-inventario',[ResumenInventario::class,'index']);
    // ATENCIONES
    Route::get('atenciones',[Atenciones::class,'index']);
    Route::post('get-sucursal',[Atenciones::class,'getSucursal']);
    Route::post('get-usuario',[Atenciones::class,'getUsuario']);
    Route::post('get-incidencia',[Atenciones::class,'incidenciaCliente']);
    Route::post('get-suc-usu',[Atenciones::class,'getSucursalUsuario']);
    Route::post('save-atenciones',[Atenciones::class,'saveAtencion']);
    Route::post('get-atencion',[Atenciones::class,'obtener']);
    Route::post('filtro-atencion',[Atenciones::class,'search']);
    Route::post('diff-hora',[Atenciones::class,'diferentHora']);
    // SOPORTE
    Route::get('resumen-soporte',[Soporte::class,'index']);
    Route::get('reporte/{id}',[Soporte::class,'reporteServicio']);
    // S - TIPO ATENCION
    Route::get('tipo-atencion',[Soporte::class,'tipoAtencion']);
    Route::post('atencion',[Soporte::class,'atencionTipo']);
    Route::post('atencion-lineal',[Soporte::class,'atencionLineal']);
    Route::post('atencion-barra',[Soporte::class,'atencionBarra']);
    // S - MODALIDAD ATENCION
    Route::get('modalidad-atencion',[Soporte::class,'modalidadAtencion']);
    Route::post('modalidad',[Soporte::class,'modalidadTipo']);
    Route::post('modalidad-lineal',[Soporte::class,'modalidadLineal']);
    Route::post('modalidad-barra',[Soporte::class,'modalidadBarra']);
    // INCIDENCIAS
    Route::get('incidencias',[Incidencias::class,'index']);
    Route::post('save-incidencias',[Incidencias::class,'saveIncidencia']);
    Route::post('edita-incidencia',[Incidencias::class,'editaIncidencia']);
    Route::post('obtener-incidencia',[Incidencias::class,'obtenerIncidencia']);
    Route::post('deta-incidencia',[Incidencias::class,'detalle']);
    Route::post('close-incidencia',[Incidencias::class,'cerrarIncidencia']);
    Route::post('filtro',[Incidencias::class,'search']);
    Route::post('get-usuario-inc',[Incidencias::class,'getUsuario']);
});

Route::get('configuracion',[Configuracion::class,'index']);

Route::prefix('config')->group(function() {
    // CLIENTES
    Route::get('clientes',[Configuracion::class,'misClientes']);
    Route::post('man-cliente',[Configuracion::class,'manCliente']);
    Route::post('get-cliente',[Configuracion::class,'getCliente']);
    Route::post('delete-cliente',[Configuracion::class,'desactivarCliente']);
    Route::post('active-cliente',[Configuracion::class,'activarCliente']);
    Route::post('search-cliente',[Configuracion::class,'filtroCliente']);
    // CLIENTES - SUCURSAL
    Route::post('man-sucursal',[Configuracion::class,'manSucursal']);
    Route::post('get-sucursal',[Configuracion::class,'getSucursal']);
    Route::post('delete-sucursal',[Configuracion::class,'desactivarSucursal']);
    Route::post('active-sucursal',[Configuracion::class,'activarSucursal']);
    Route::post('search-sucursal',[Configuracion::class,'filtroSucursal']);
    Route::post('act-ubicacion',[Configuracion::class,'updateUbicacion']);
    Route::post('del-ubicacion',[Configuracion::class,'deleteUbicacion']);
    // CLIENTES - USUARIO
    Route::post('cli-sucursal',[Configuracion::class,'clienteSucursal']);
    Route::post('man-usuario',[Configuracion::class,'manUsuario']);
    Route::post('get-usuario',[Configuracion::class,'getUsuario']);
    Route::post('delete-usuario',[Configuracion::class,'desactivarUsuario']);
    Route::post('active-usuario',[Configuracion::class,'activarUsuario']);
    Route::post('search-usuario',[Configuracion::class,'filtroUsuario']);
    // EQUIPOS
    Route::get('equipos',[Configuracion::class,'equipos']);
    Route::post('equipo-sucursal',[Configuracion::class,'sucursalEquipo']);
    Route::post('equipo-ubicacion',[Configuracion::class,'ubicacionEquipo']);
    Route::post('get-modelo-equipo',[Configuracion::class,'obtenerModelo']);
    Route::post('man-equipo',[Configuracion::class,'manEquipo']);
    Route::post('get-equipo',[Configuracion::class,'getEquipo']);
    Route::post('delete-equipo',[Configuracion::class,'desactivarEquipo']);
    Route::post('equipo-filtro',[Configuracion::class,'filtroEquipo']);
    Route::post('cli-usuario',[Configuracion::class,'clienteUsuario']);
    Route::post('save-asignacion',[Configuracion::class,'guardAsignacion']);
    Route::post('get-history',[Configuracion::class,'getHistoria']);
    Route::post('act-history',[Configuracion::class,'actualizaHistorial']);
    Route::post('comp-cli-equipo',[Configuracion::class,'componenteClienteEquipo']);
    Route::post('save-component',[Configuracion::class,'guardarComponente']);
    Route::post('del-component',[Configuracion::class,'deleteComponente']);
    // EQUIPOS - MANTENIMIENTO
    Route::post('save-mantenimiento',[Configuracion::class,'saveMantenimiento']);
    Route::post('lista-mantenimiento',[Configuracion::class,'obtenerMantenimiento']);
    // EQUIPOS - SOFTWARE
    Route::post('software',[Configuracion::class,'obtenerSoftware']);
    Route::post('save-software',[Configuracion::class,'saveSoftware']);
    Route::post('lista-software',[Configuracion::class,'obtenerListaSoftware']);
    // TIPO DE ATENCION
    Route::get('tipo-atencion',[Configuracion::class,'tipoAtencion']);
    Route::post('man-atencion',[Configuracion::class,'manTipoAtencion']);
    Route::post('get-atencion',[Configuracion::class,'getTipoAtencion']);
    // MARCA
    Route::get('marca',[Configuracion::class,'marca']);
    Route::post('man-marca',[Configuracion::class,'manMarca']);
    Route::post('get-marca',[Configuracion::class,'getMarca']);
    Route::post('delete-marca',[Configuracion::class,'eliminarMarca']);
    // PERIFERICO
    Route::get('periferico',[Configuracion::class,'periferico']);
    Route::post('man-periferico',[Configuracion::class,'manPeriferico']);
    Route::post('get-periferico',[Configuracion::class,'getPeriferico']);
    Route::post('delete-periferico',[Configuracion::class,'desactivarPeriferico']);
    // MODELO
    Route::get('modelo',[Configuracion::class,'modelo']);
    Route::post('man-modelo',[Configuracion::class,'manModelo']);
    Route::post('get-modelo',[Configuracion::class,'getModelo']);
    Route::post('delete-modelo',[Configuracion::class,'eliminarModelo']);
    // PROCESADOR
    Route::get('procesador',[Configuracion::class,'procesador']);
    Route::post('man-procesador',[Configuracion::class,'manProcesador']);
    Route::post('get-procesador',[Configuracion::class,'getProcesador']);
    // ESTADO
    Route::get('estado',[Configuracion::class,'estado']);
    Route::post('man-estado',[Configuracion::class,'manEstado']);
    Route::post('get-estado',[Configuracion::class,'getEstado']);
    Route::post('search-estado',[Configuracion::class,'filtroEstado']);
    Route::post('orden',[Configuracion::class,'ordenEstado']);
    // SERVICIOS
    Route::get('servicios',[Configuracion::class,'servicios']);
    Route::post('man-servicios',[Configuracion::class,'manServicios']);
    Route::post('get-servicios',[Configuracion::class,'getServicios']);
    // MODALIDAD DE ATENCION
    Route::get('modalidad',[Configuracion::class,'modalidad_atencion']);
    Route::post('man-modalidad',[Configuracion::class,'manModalidad']);
    Route::post('get-modalidad',[Configuracion::class,'getModalidad']);
    // SERVICIOS CONTRATADOS
    Route::get('servicios-contratados',[Configuracion::class,'serviciosContratados']);
    Route::post('cli-servicio',[Configuracion::class,'clienteServicios']);
    Route::post('estado',[Configuracion::class,'clienteEstado']);
    // PROVEEDOR
    Route::post('proveedor',[Configuracion::class,'proveedor']);
    // CATEGORIA SOFTWARE
    Route::get('categoria-software',[Configuracion::class,'categoriaSoftware']);
    Route::post('man-categoria',[Configuracion::class,'manCategoria']);
    Route::post('get-categoria',[Configuracion::class,'getCategoria']);
    // SOFTWARE
    Route::get('software',[Configuracion::class,'allSoftware']);
    Route::post('man-software',[Configuracion::class,'manSoftware']);
    Route::post('get-software',[Configuracion::class,'getSoftware']);
    // CONTROL DE ACCESO
    Route::get('control',[Configuracion::class,'controlAcceso']);
    Route::post('save-accesso',[Configuracion::class,'guardarAccesso']);
    Route::post('user-client',[Configuracion::class,'usuariosCliente']);
    Route::post('user-acount',[Configuracion::class,'usuariosAcount']);
    Route::post('get-usu-control',[Configuracion::class,'usuarioControl']);
    Route::post('filtro-accesso',[Configuracion::class,'filtroControlUsuarios']);
});