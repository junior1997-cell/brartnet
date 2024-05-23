var tabla_cliente;

//Función que se ejecuta al inicio
function init() {

  $("#bloc_Recurso").addClass("menu-open");

  $("#mRecurso").addClass("active");  

  $(".btn-guardar").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-cliente").submit(); } else { toastr_warning("Espera", "Procesando Datos", 3000); } });

  // ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════ 
  lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_trabajador", '#filtro_trabajador', null, '.charge_filtro_trabajador');
  lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_anio_pago", '#filtro_p_all_anio_pago', null, '.charge_filtro_p_all_anio_pago');
  lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_mes_pago", '#filtro_p_all_mes_pago', null, '.charge_filtro_p_all_mes_pago');
  lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_tipo_comprob", '#filtro_tipo_comprob', null, '.charge_filtro_tipo_comprob');

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#filtro_trabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_anio_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_mes_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_tipo_comprob").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

}

//Función Listar
function tabla_principal_cliente(filtro_trabajador, filtro_anio_pago, filtro_p_all_mes_pago, filtro_tipo_comprob) {

  tabla_cliente = $('#tabla-cliente').dataTable({
    lengthMenu: [[-1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200,]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-4'B><'col-md-2 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload px-2 btn btn-sm btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_plan) { tabla_plan.ajax.reload(null, false); } } },
      //{ extend: 'copy', exportOptions: { columns: [0,2,3], }, text: `<i class="fas fa-copy" ></i>`, className: "px-2 btn btn-sm btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,2,3], }, title: 'Lista de planes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "px-2 btn btn-sm btn-outline-success btn-wave ", footer: true,  }, 
      //{ extend: 'pdf', exportOptions: { columns: [0,2,3], }, title: 'Lista de planes', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "px-2 btn btn-sm btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "px-2 btn btn-sm btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax: {
      url: `../ajax/reporte_x_trabajador.php?op=tabla_principal_cliente&filtro_trabajador=${filtro_trabajador}&filtro_anio_pago=${filtro_anio_pago}&filtro_p_all_mes_pago=${filtro_p_all_mes_pago}&filtro_tipo_comprob=${filtro_tipo_comprob}`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
      complete: function () {
        $(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');
        $(".buttons-copy").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Copiar');
        $(".buttons-excel").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Excel');
        $(".buttons-pdf").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'PDF');
        $(".buttons-colvis").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Columnas');
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('#id_buscando_tabla').remove();
      },
      dataSrc: function (e) {
				if (e.status != true) {  ver_errores(e); }  return e.aaData;
			},
    },
    createdRow: function (row, data, ixdex) {
      // columna: Acciones
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
      // columna: Cliente
      if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "_MENU_ ",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    footerCallback: function( tfoot, data, start, end, display ) {
      var api1 = this.api(); var total1 = api1.column( 4 ).data().reduce( function ( a, b ) { return  (parseFloat(a) + parseFloat( b)) ; }, 0 )
      $( api1.column( 4 ).footer() ).html( `<span class="float-start">S/</span> <span class="float-end">${formato_miles(total1)}</span> ` );       
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      // { targets: [5], render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'), },
      { targets: [], visible: false, searchable: false, },
    ],
  }).DataTable();
}


$(document).ready(function () {
  init();
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
function cargando_search() {
  if ($('#id_buscando_tabla').length) { } else {
    $('.buscando_tabla').prepend(`<tr id="id_buscando_tabla"> 
      <th colspan="20" class="bg-danger " style="text-align: center !important;"><i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando... </th>
    </tr>`);
  }  
}

function filtros() {  

  var filtro_trabajador      = $("#filtro_trabajador").select2('val');
  var filtro_anio_pago     = $("#filtro_p_all_anio_pago").select2('val'); 
  var filtro_p_all_mes_pago  = $("#filtro_p_all_mes_pago").select2('val');
  var filtro_tipo_comprob     = $("#filtro_tipo_comprob").select2('val');
  
  
  if (filtro_trabajador == '' || filtro_trabajador == 0 || filtro_trabajador == null) { filtro_trabajador = ""; nombre_trabajador = ""; }       // filtro de trabajador  
  if (filtro_anio_pago == '' || filtro_anio_pago == 0 || filtro_anio_pago == null) { filtro_anio_pago = ""; nombre_anio_pago = ""; }                 // filtro de dia pago  
  if (filtro_p_all_mes_pago == '' || filtro_p_all_mes_pago == 0 || filtro_p_all_mes_pago == null) { filtro_p_all_mes_pago = ""; nombre_mes_pago = ""; }                                     // filtro de plan
  if (filtro_tipo_comprob == '' || filtro_tipo_comprob == 0 || filtro_tipo_comprob == null) { filtro_tipo_comprob = ""; nombre_tipo_comprob = ""; }  // filtro de zona antena

  $('#id_buscando_tabla').html(`<i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando ${nombre_trabajador} ${nombre_anio_pago} ${nombre_mes_pago}...`);
  //console.log(filtro_categoria, fecha_2, filtro_p_all_mes_pago, comprobante);

  tabla_principal_cliente(filtro_trabajador, filtro_anio_pago, filtro_p_all_mes_pago, filtro_tipo_comprob);
}

function reload_select(r_text) {

  switch (r_text) {
    case 'filtro_trabajador':
      lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_trabajador", '#filtro_trabajador',     null, '.charge_filtro_trabajador');
    break; 
    case 'filtro_anio_pago':
      lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_anio_pago",  '#filtro_p_all_anio_pago',  moment().format('YYYY'), '.charge_filtro_p_all_anio_pago');
    break;    
    case 'filtro_p_all_mes_pago':
      lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_p_all_mes_pago", '#filtro_p_all_mes_pago', null, '.charge_filtro_p_all_mes_pago');
    break;
    case 'filtro_tipo_comprob':
      lista_select2("../ajax/reporte_x_trabajador.php?op=select2_filtro_tipo_comprob",'#filtro_tipo_comprob', null, '.charge_filtro_tipo_comprob');
    break;   
  

    default:
      console.log('Caso no encontrado.');
  }
 
}
