<?php
global $router;


// Rutas de la pagina del cliente
$router->get('/', 'index.php');
$router->get('/reservas', 'reservas.php');
$router->post('/reservas', 'auth/reservas/crear.post.php');
$router->get('/reservas/clientes/search', 'auth/marketing/clientes/clientes.get.php');
$router->post('/reservas/clientes/crear', 'auth/marketing/clientes/crear.post.php');
$router->get('/servicios', 'servicios.php');
$router->get('/promociones', 'promociones.php');
$router->get('/contacto', 'contacto.php');
$router->post('/contacto', 'contacto.post.php');
$router->get('/acceso_denegado', 'denegado.php');

// Rutas de autenticacion
$router->get('/auth', 'auth/index.php')->middleware('auth');
$router->get('/auth/login', 'auth/login/index.php')->middleware('anon');
$router->post('/auth/login', 'auth/login/index.post.php')->middleware('anon');
$router->post('/auth/logout', 'auth/logout.post.php')->middleware('auth');

// Rutas de administracion
$router->get('/auth/reservas', 'auth/reservas/index.php')->middleware('administracion');
$router->get('/auth/reservas/crear', 'auth/reservas/crear.php')->middleware('administracion');
$router->post('/auth/reservas/crear', 'auth/reservas/crear.post.php')->middleware('administracion');
$router->post('/auth/reservas/check-in', 'auth/reservas/actualizar.php')->middleware('administracion');
$router->get('/auth/reservas/eliminar', 'auth/reservas/eliminar.delete.php')->middleware('administracion');
$router->post('/auth/reservas/check-in/registrar', 'auth/reservas/check-in.post.php')->middleware('administracion');
$router->post('/auth/reservas/check-out', 'auth/reservas/check-out.post.php')->middleware('administracion');
$router->post('/auth/reservas/check-out/registrar', 'auth/reservas/check-out.put.php')->middleware('administracion');

$router->get('/auth/tipohabsal', 'auth/TipoHabitacionSalon/index.php')->middleware('administracion');
$router->get('/auth/tipohabitacion/search', 'auth/TipoHabitacionSalon/tipoHabitacion.search.php')->middleware('administracion');
$router->get('/auth/tiposalon/search', 'auth/TipoHabitacionSalon/tipoSalon.search.php')->middleware('administracion');
$router->put('/auth/tipohabsal/actualizar', 'auth/TipoHabitacionSalon/update.put.php')->middleware('administracion');

$router->get('/auth/servicios/search', 'auth/servicio.search.php')->middleware('administracion');

$router->get('/auth/inventario', 'auth/inventario/index.php')->middleware('administracion');
$router->get('/auth/inventario/crear', 'auth/inventario/crear.php')->middleware('administracion');
$router->post('/auth/inventario/crear', 'auth/inventario/crear.post.php')->middleware('administracion');
$router->post('/auth/inventario/eliminar', 'auth/inventario/eliminar.php')->middleware('administracion');
$router->post('/auth/inventario/actualizar', 'auth/inventario/actualizar.php')->middleware('administracion');
$router->get('/auth/inventario/habitacion', 'auth/inventario/habitacion.inve.php')->middleware('administracion');
$router->get('/auth/inventario/habitacioncrear', 'auth/inventario/habitacion.crear.php')->middleware('administracion');
$router->post('/auth/inventario/habitacioncrear', 'auth/inventario/habitacion.crear.post.php')->middleware('administracion');
$router->post('/auth/inventario/actualizarhabitacion', 'auth/inventario/actualizarhabitacion.php')->middleware('administracion');
$router->post('/auth/inventario/habitacioneliminar', 'auth/inventario/eliminarhabitacion.php')->middleware('administracion');
$router->post('/auth/inventario/actualizarinstalacion', 'auth/inventario/actualizarinstalacion.php')->middleware('administracion');
$router->post('/auth/inventario/instalacioneliminar', 'auth/inventario/eliminarinstalacion.php')->middleware('administracion');
$router->post('/auth/inventario/actualizarsalon', 'auth/inventario/actualizarsalon.php')->middleware('administracion');
$router->post('/auth/inventario/saloneliminar', 'auth/inventario/eliminarsalon.php')->middleware('administracion');

$router->get('/auth/inventario/instalacion', 'auth/inventario/instalacion.inve.php')->middleware('administracion');
$router->get('/auth/inventario/instalacioncrear', 'auth/inventario/instalacion.crear.php')->middleware('administracion');
$router->post('/auth/inventario/instalacioncrear', 'auth/inventario/instalacion.crear.post.php')->middleware('administracion');

$router->get('/auth/inventario/salon', 'auth/inventario/salon.inve.php')->middleware('administracion');
$router->get('/auth/inventario/saloncrear', 'auth/inventario/salon.crear.php')->middleware('administracion');
$router->post('/auth/inventario/saloncrear', 'auth/inventario/salon.crear.post.php')->middleware('administracion');

$router->get('/auth/inventario/excel', 'auth/inventario/reporteinvge.php')->middleware('administracion');
$router->get('/auth/inventario/excelhab', 'auth/inventario/reporteinvhab.php')->middleware('administracion');
$router->get('/auth/inventario/excelinst', 'auth/inventario/reporteinvinst.php')->middleware('administracion');
$router->get('/auth/inventario/excelsalon', 'auth/inventario/reporteinvsalon.php')->middleware('administracion');

$router->get('/auth/limpieza', 'auth/limpieza/index.php')->middleware('administracion');
$router->get('/auth/limpieza/crear', 'auth/limpieza/crear.php')->middleware('administracion');
$router->post('/auth/limpieza/crear', 'auth/limpieza/crear.post.php')->middleware('administracion');
$router->get('/auth/limpieza/vista', 'auth/limpieza/vista.php')->middleware('administracion');
$router->post('/auth/limpieza/eliminar', 'auth/limpieza/eliminar.php')->middleware('administracion');
$router->post('/auth/limpieza/actualizar', 'auth/limpieza/actualizar.php')->middleware('administracion');

$router->get('/auth/limpieza/excel', 'auth/limpieza/reportelim.php')->middleware('administracion');

$router->get('/auth/instalacion', 'auth/instalacion/index.php')->middleware('administracion');
$router->get('/auth/instalacion/crear', 'auth/instalacion/crear.php')->middleware('administracion');
$router->get('/auth/instalacion/crearnueva', 'auth/instalacion/crear.nueva.php')->middleware('administracion');
$router->post('/auth/instalacion/crearnueva', 'auth/instalacion/crear.nueva.post.php')->middleware('administracion');
$router->post('/auth/instalacion/crear', 'auth/instalacion/crear.post.php')->middleware('administracion');
$router->get('/auth/instalacion/vista', 'auth/instalacion/vista.php')->middleware('administracion');
$router->post('/auth/instalacion/eliminar', 'auth/instalacion/eliminar.php')->middleware('administracion');
$router->post('/auth/instalacion/actualizar', 'auth/instalacion/actualizar.php')->middleware('administracion');
$router->post('/auth/instalacion/actualizarperso', 'auth/instalacion/actualizar.pers.php')->middleware('administracion');

$router->get('/auth/instalacion/seleccionarpersonal', 'auth/instalacion/seleccionar.php')->middleware('administracion');
$router->get('/auth/instalacion/seleccionar', 'auth/instalacion/crear.personal.php')->middleware('administracion');
$router->post('/auth/instalacion/seleccionar', 'auth/instalacion/crear.personal.post.php')->middleware('administracion');
$router->post('/auth/instalacion/personaleliminar', 'auth/instalacion/eliminarpersonal.php')->middleware('administracion');

$router->get('/auth/instalacion/excel', 'auth/instalacion/reporteins.php')->middleware('administracion');
$router->get('/auth/instalacion/excelpers', 'auth/instalacion/reporteinspers.php')->middleware('administracion');

// Rutas de personal
$router->get('/auth/personal', 'auth/personal/personal.php')->middleware('personal');
$router->post('/auth/personal/eliminar', 'auth/personal/personal.delete.php')->middleware('personal');
$router->get('/auth/personal/personal', 'auth/personal.get.php')->middleware('personal');
$router->get('/auth/personal/crear', 'auth/add_personal.php')->middleware('personal');
$router->post('/auth/personal/crear', 'auth/add_personal.post.php')->middleware('personal');
$router->post('/auth/personal/crear', 'auth/validacionCedula.php')->middleware('personal');
$router->get('/auth/personal/crear/search', 'auth/personal/cedulaRepetida.get.php')->middleware('personal');
$router->post('/auth/personal/actualizar', 'auth/personal/personal.update.php')->middleware('personal');
$router->post('/auth/personal/actualizar/enviar', 'auth/personal/personal.update.post.php')->middleware('personal');

$router->get('/auth/evaluacion', 'auth/evaluacion/index.php')->middleware('personal');
$router->post('/auth/evaluacion/actualizar', 'auth/evaluacion/index.update.php')->middleware('personal');
$router->post('/auth/evaluacion/eliminar', 'auth/evaluacion/evaluacionDesempeno.delete.php')->middleware('personal');
$router->get('/auth/evaluacion/evaluar', 'auth/evaluacion/evaluacionDesempeno.php')->middleware('personal');
$router->post('/auth/evaluacion/evaluar', 'auth/evaluacion/evaluacionDesempeno.post.php')->middleware('personal');
$router->get('/auth/evaluacion/evaluar/search', 'auth/evaluacion/evaluacionDesempeno.get.php')->middleware('personal');

$router->get('/auth/personal/asistencia', 'auth/asistencia.php')->middleware('personal');
$router->get('/auth/asistencia/crear', 'auth/add_asistencia.php')->middleware('personal');
$router->get('/auth/personal/asistencia/crear', 'auth/add_asistencia.php')->middleware('personal');
$router->post('/auth/personal/asistencia/crear', 'auth/asistencia.post.php')->middleware('personal');
$router->post('/auth/asistencia/crear', 'auth/asistencia.post.php')->middleware('personal');
$router->get('/auth/personal/horario', 'auth/asis_horario.php')->middleware('personal');
$router->post('/auth/personal/horario', 'auth/horario_post.php')->middleware('personal');
$router->post('/auth/personal/iniciar_registro', 'auth/iniciar_registro.php')->middleware('personal');

$router->get('/auth/Pagos', 'auth/personal/pagos.php')->middleware('personal');
$router->post('/auth/Pagos/crear', 'auth/personal/pers_pagos.post.php')->middleware('personal');

$router->get('/auth/roles', 'auth/personal/roles.php')->middleware('personal');
$router->get('/auth/roles/crear', 'auth/personal/rolPago.php')->middleware('personal');
$router->get('/auth/pdf/crear', 'auth/personal/pdf.php')->middleware('personal');

//pdf generador
$router->get('/auth/pdf', 'auth/fpdf.php')->middleware('personal');

// Rutas de marketing
$router->get('/auth/clientes/search', 'auth/marketing/clientes/clientes.get.php')->middleware('marketing');
$router->post('/auth/clientes/crear', 'auth/marketing/clientes/crear.post.php')->middleware('marketing');
$router->get('/auth/marketing/clientes', 'auth/marketing/clientes/index.php')->middleware('marketing');
$router->get('/auth/marketing', 'auth/marketing/index.php')->middleware('marketing');
$router->get('/auth/marketing/crear', 'auth/marketing/crear.php')->middleware('marketing');
$router->post('/auth/marketing/crear', 'auth/marketing/crear.post.php')->middleware('marketing');
$router->post('/auth/marketing/eliminar', 'auth/marketing/eliminar.php')->middleware('marketing');
$router->post('/auth/marketing/actualizar', 'auth/marketing/actualizar.php')->middleware('marketing');
$router->get('/auth/marketing/promociones/crear', 'auth/marketing/promociones/crear.php')->middleware('marketing');
$router->post('/auth/marketing/promociones/crear', 'auth/marketing/promociones/crear.post.php')->middleware('marketing');
$router->get('/auth/marketing/promociones', 'auth/marketing/promociones/index.php')->middleware('marketing');
$router->post('/auth/marketing/promociones/eliminar', 'auth/marketing/promociones/eliminar.php')->middleware('marketing');
$router->post('/auth/marketing/promociones/actualizar', 'auth/marketing/promociones/actualizar.php')->middleware('marketing');
// Rutas de Seguridad
$router->get('/auth/seguridad', 'auth/seguridad.php')->middleware('seguridad');
$router->post('/auth/seguridad', 'auth/seguridad.post.php')->middleware('seguridad');
$router->get('/auth/auditoria', 'auth/auditoria.php')->middleware('seguridad');
$router->get('/auth/register', 'auth/register/index.php');
$router->post('/auth/register', 'auth/register/index.post.php');

//Rutas de Ingresos
$router->get('/auth/ingresos/registrar', 'auth/ingresos/registrar.php')->middleware('ingresos');
$router->get('/auth/ingresos/registrar/search', 'auth/ingresos/registrar.get.php')->middleware('ingresos');
$router->get('/auth/ingresos/ingresos_realizados', 'auth/ingresos/ingresos_realizados.php')->middleware('ingresos');
$router->post('/auth/ingresos/procesar', 'auth/ingresos/procesar.php')->middleware('ingresos');
$router->get('/auth/ingresos/reporte','auth/ingresos/reportes_ingresos.php')->middleware('ingresos');
$router->get('/auth/ingresos/descargar','auth/ingresos/reportes_ingresos_descargar.php')->middleware('ingresos');


// Rutas de egresos
$router->get('/auth/egresos', 'auth/egresos/index.php')->middleware('egresos');
$router->get('/auth/egresos/crear', 'auth/egresos/crear.php')->middleware('egresos');
$router->post('/auth/egresos/crear', 'auth/egresos/crear.php')->middleware('egresos');
$router->post('/auth/egresos/actualizar', 'auth/egresos/actualizar.php')->middleware('egresos');
$router->post('/auth/egresos/actualizaregre', 'auth/egresos/actualizar.egre.php')->middleware('egresos');
$router->post('/auth/egresos/eliminar', 'auth/egresos/eliminar.php')->middleware('egresos');
$router->get('/auth/egresos/pago_sueldos', 'auth/egresos/pago_sueldos.php')->middleware('egresos');
$router->post('/auth/egresos/pago_sueldos', 'auth/egresos/pago_sueldos.php')->middleware('egresos');
$router->get('/auth/egresos/pago_aporte_personal', 'auth/egresos/pago_aporte_personal.php')->middleware('egresos');
$router->post('/auth/egresos/pago_aporte_personal', 'auth/egresos/pago_aporte_personal.php')->middleware('egresos');
$router->get('/auth/egresos/pago_aporte_patronal', 'auth/egresos/pago_aporte_patronal.php')->middleware('egresos');
$router->post('/auth/egresos/pago_aporte_patronal', 'auth/egresos/pago_aporte_patronal.php')->middleware('egresos');
$router->get('/auth/egresos/pago_sueldos_reportes', 'auth/egresos/reportes_sueldos.php')->middleware('egresos');
$router->get('/auth/egresos/pago_sueldos/descargar', 'auth/egresos/reportes_sueldos_descargar.php')->middleware('egresos');
$router->post('/auth/egresos/pago_sueldos/descargar', 'auth/egresos/reportes_sueldos_descargar.php')->middleware('egresos');
$router->get('/auth/egresos/pago_personal_reportes', 'auth/egresos/reportes_personal.php')->middleware('egresos');
$router->get('/auth/egresos/pago_aporte_personal/descargar', 'auth/egresos/reportes_personal_descargar.php')->middleware('egresos');
$router->post('/auth/egresos/pago_aporte_personal/descargar', 'auth/egresos/reportes_personal_descargar.php')->middleware('egresos');
$router->get('/auth/egresos/pago_patronal_reportes', 'auth/egresos/reportes_patronal.php')->middleware('egresos');
$router->get('/auth/egresos/pago_aporte_patronal/descargar', 'auth/egresos/reportes_patronal_descargar.php')->middleware('egresos');
$router->post('/auth/egresos/pago_aporte_patronal/descargar', 'auth/egresos/reportes_patronal_descargar.php')->middleware('egresos');
$router->get('/auth/egresos/egresos_totales', 'auth/egresos/egresos_totales.php')->middleware('egresos');
$router->get('/auth/egresos/egresos_totales/reportes', 'auth/egresos/egresos_totales_reportes.php')->middleware('egresos');
$router->post('/auth/egresos/egresos_totales/reportes', 'auth/egresos/egresos_totales_reportes.php')->middleware('egresos');
$router->get('/auth/egresos/egresos_totales_descargar', 'auth/egresos/egresos_totales_descargar.php')->middleware('egresos');
$router->post('/auth/egresos/egresos_totales_descargar', 'auth/egresos/egresos_totales_descargar.php')->middleware('egresos');
$router->get('/auth/egresos/inactivos', 'auth/egresos/egresos_inactivos.php')->middleware('egresos');
$router->post('/auth/egresos/inactivos', 'auth/egresos/egresos_inactivos.php')->middleware('egresos');
$router->post('/auth/egresos/inactivar', 'auth/egresos/inactivar.php')->middleware('egresos');
?>

