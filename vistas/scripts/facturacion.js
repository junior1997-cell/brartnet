var tabla_principal_facturacion;
var tabla_productos;
var form_validate_facturacion;
var array_data_venta = [];
var file_pond_mp_comprobante;

// ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T C H O I C E ══════════════════════════════════════

// const choice_distrito       = new Choices('#distrito',  {  removeItemButton: true,noResultsText: 'No hay resultados.', } );
// const choice_tipo_documento = new Choices('#tipo_documento',  {  removeItemButton: true,noResultsText: 'No hay resultados.', } );
// const choice_idbanco        = new Choices('#idbanco',  {  removeItemButton: true,noResultsText: 'No hay resultados.', } );

function init(){

  listar_tabla_facturacion(); // Listamos la tabla principal
  $(".btn-boleta").click();   // Selecionamos la BOLETA
  mini_reporte();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $(".btn-guardar").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-venta").submit(); }  });
  $("#guardar_registro_proveedor").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-proveedor").submit(); } });
  $("#guardar_registro_producto").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-producto").submit(); } });

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/facturacion.php?op=select2_cliente", '#idpersona_cliente', null);
  lista_select2("../ajax/facturacion.php?op=listar_crl_comprobante&tipos='00','01','03','12'", '#tipo_comprobante', null);

  lista_select2("../ajax/facturacion.php?op=select_categoria", '#categoria', null);
  lista_select2("../ajax/facturacion.php?op=select_u_medida", '#u_medida', null);
  lista_select2("../ajax/facturacion.php?op=select_marca", '#marca', null);

  // lista_selectChoice("../ajax/ajax_general.php?op=selectChoice_distrito", choice_distrito, null);
  // lista_selectChoice("../ajax/ajax_general.php?op=selectChoice_tipo_documento", choice_tipo_documento, null);  
  // lista_selectChoice("../ajax/ajax_general.php?op=selectChoice_banco", choice_idbanco, null);

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#idpersona_cliente").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#tipo_comprobante").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#metodo_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  
}


function show_hide_form(flag) {
	if (flag == 1) {        // TABLA PRINCIPAL
		$("#div-tabla").show();
    $("#div-mini-reporte").show();
		$("#div-formulario").hide();

		$(".btn-agregar").show();
		$(".btn-guardar").hide();
		$(".btn-cancelar").hide();
		
	} else if (flag == 2) { // FORMULARIO FACTURACION
		$("#div-tabla").hide();
    $("#div-mini-reporte").hide();
		$("#div-formulario").show();

		$(".btn-agregar").hide();		
		$(".btn-cancelar").show();
	}
}

function mini_reporte() {

  $(".vw_total_factura").html(`<div class="spinner-border spinner-border-sm" role="status"></div>`);
  $(".vw_total_boleta").html(`<div class="spinner-border spinner-border-sm" role="status"></div>`);
  $(".vw_total_ticket").html(`<div class="spinner-border spinner-border-sm" role="status"></div>`);

  $.getJSON(`../ajax/facturacion.php?op=mini_reporte`, function (e, textStatus, jqXHR) {
    $(".vw_total_factura").html( `${formato_miles(e.data.factura)}` ).addClass('count-up');
    $(".vw_total_factura_p").html( `${e.data.factura_p >= 0? '<i class="ri-arrow-up-s-line me-1 align-middle"></i>' : '<i class="ri-arrow-down-s-line me-1 align-middle"></i>'} ${(e.data.factura_p)}%` );
    e.data.factura_p >= 0? $(".vw_total_factura_p").addClass('text-success').removeClass('text-danger') : $(".vw_total_factura_p").addClass('text-danger').removeClass('text-success') ;

    $(".vw_total_boleta").html( `${formato_miles(e.data.boleta)}` ).addClass('count-up');
    $(".vw_total_boleta_p").html( `${e.data.boleta_p >= 0? '<i class="ri-arrow-up-s-line me-1 align-middle"></i>' : '<i class="ri-arrow-down-s-line me-1 align-middle"></i>'} ${(e.data.boleta_p)}%` );
    e.data.boleta_p >= 0? $(".vw_total_boleta_p").addClass('text-success').removeClass('text-danger') : $(".vw_total_boleta_p").addClass('text-danger').removeClass('text-success') ;

    $(".vw_total_ticket").html( `${formato_miles(e.data.ticket)}` ).addClass('count-up');
    $(".vw_total_ticket_p").html( `${e.data.ticket_p >= 0? '<i class="ri-arrow-up-s-line me-1 align-middle"></i>' : '<i class="ri-arrow-down-s-line me-1 align-middle"></i>'} ${(e.data.ticket_p)}%` );
    e.data.ticket_p >= 0? $(".vw_total_ticket_p").addClass('text-success').removeClass('text-danger') : $(".vw_total_ticket_p").addClass('text-danger').removeClass('text-success') ;

  });
}

// ::::::::::::::::::::::::::::::::::::::::::::: S E C C I O N   F A C T U R A C I O N :::::::::::::::::::::::::::::::::::::::::::::

// abrimos el navegador de archivos
$("#doc1_i").click(function () { $('#doc1').trigger('click'); });
$("#doc1").change(function (e) { addImageApplication(e, $("#doc1").attr("id"), null, '100%', '300px', true) });

function doc1_eliminar() {
  $("#doc1").val("");
  $("#doc1_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
  $("#doc1_nombre").html("");
}

function limpiar_form_venta(){

  array_data_venta = [];
  $("#idventa").val('');

  $("#idpersona_cliente").val('').trigger('change'); 
  $("#metodo_pago").val('').trigger('change'); 
  $("#observacion_documento").val(''); 
  $("#periodo_pago").val('');
  $("#codigob").val('');
  
  $("#total_recibido").val(0);
  $("#mp_monto").val(0);
  $("#total_vuelto").val(0);
  $("#ua_monto_usado").val('');
  $("#mp_serie_comprobante").val('');
  file_pond_mp_comprobante.removeFiles();
  $("#mp_comprobante_old").val('');


  $("#venta_total").val("");     
  $(".venta_total").html("0");

  $(".venta_subtotal").html("<span>S/</span> 0.00");
  $("#venta_subtotal").val("");

  $(".venta_descuento").html("<span>S/</span> 0.00");
  $("#venta_descuento").val("");

  $(".venta_igv").html("<span>S/</span> 0.00");
  $("#venta_igv").val("");

  $(".venta_total").html("<span>S/</span> 0.00");
  $("#venta_total").val("");

  $(".filas").remove();

  cont = 0;

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();

}

function listar_tabla_facturacion(){
  tabla_principal_facturacion = $("#tabla-ventas").dataTable({
    responsive: true, 
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>", //Definimos los elementos del control de tabla
    buttons: [  
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_principal_facturacion) { tabla_principal_facturacion.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,2,3,4,5,6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,2,3,4,5,6], }, title: 'Lista de ventas', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [0,2,3,4,5,6], }, title: 'Lista de ventas', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax: {
      url: `../ajax/facturacion.php?op=listar_tabla_facturacion`,
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
      },
		},
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); }
      // columna: #
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap text-center"); }
      // columna: #
      if (data[5] != '') { $("td", row).eq(5).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    footerCallback: function( tfoot, data, start, end, display ) {
      var api1 = this.api(); var total1 = api1.column( 5 ).data().reduce( function ( a, b ) { return  (parseFloat(a) + parseFloat( b)) ; }, 0 )
      $( api1.column( 5 ).footer() ).html( `<span class="float-start">S/</span> <span class="float-end">${formato_miles(total1)}</span> ` );       
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]],
    columnDefs: [      
      { targets: [2], render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'), },
      { targets: [5], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = ''; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-start">S/</span> <span class="float-end ${color} "> ${number} </span>`; } return number; }, },      

      // { targets: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19], visible: false, searchable: false, },
    ],
  }).DataTable();
}

function guardar_editar_facturacion(e) {
  var formData = new FormData($("#form-facturacion")[0]);  

  Swal.fire({
    title: "¿Está seguro que deseas guardar esta Venta?",
    html: "Verifica que todos lo <b>campos</b>  esten <b>conformes</b>!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Guardar!",
    preConfirm: (input) => {
      return fetch("../ajax/facturacion.php?op=guardar_editar_facturacion", {
        method: 'POST', // or 'PUT'
        body: formData, // data can be `string` or {object}!        
      }).then(response => {
        //console.log(response);
        if (!response.ok) { throw new Error(response.statusText) }
        return response.json();
      }).catch(error => { Swal.showValidationMessage(`<b>Solicitud fallida:</b> ${error}`); });
    },
    showLoaderOnConfirm: true,
  }).then((result) => {
    if (result.isConfirmed) {
      if (result.value.status == true){        
        Swal.fire("Correcto!", "Venta guardada correctamente", "success");

        tabla_principal_facturacion.ajax.reload(null, false);

        limpiar_form_venta(); show_hide_form(1);
             
      } else {
        ver_errores(result.value);
      }      
    }
  });  
}

function mostrar_detalle_venta(idventa){
  $("#modal-detalle-venta").modal("show");

  $.post("../ajax/facturacion.php?op=mostrar_detalle_venta", { idventa: idventa }, function (e, status) {          
      
    $('#custom-tabContent').html(e);      
    $('#custom-datos1_html-tab').click(); // click para ver el primer - Tab Panel
    $(".jq_image_zoom").zoom({ on: "grab" });      
    $("#excel_venta").attr("href",`../reportes/export_xlsx_venta_tours.php?id=${idventa}`);      
    $("#print_pdf_venta").attr("href",`../reportes/comprobante_venta_tours.php?id=${idventa}`);    
    
  }).fail( function(e) { ver_errores(e); } );

}

function eliminar_papelera_venta(idventa, nombre){
  $('.tooltip').remove();
	crud_eliminar_papelera(
    "../ajax/facturacion.php?op=papelera",
    "../ajax/facturacion.php?op=eliminar", 
    idventa, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>venta: ${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){ tabla_principal_facturacion.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}

function ver_img_comprobante(idventa) {
  $('#modal-ver-comprobante1').modal('show');
  $("#comprobante-container1").html(`<div class="row" > <div class="col-lg-12 text-center"> <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div> </div>`);

  $.post("../ajax/facturacion.php?op=mostrar_venta", { idventa: idventa },  function (e, status) {
    e = JSON.parse(e);
    if (e.status == true) {
      if (e.data.comprobante == "" || e.data.comprobante == null) { } else {
        var nombre_comprobante = `${e.data.tipo_comprobante} ${e.data.serie_comprobante}`;
        $('.title-modal-comprobante1').html(nombre_comprobante);
        $("#comprobante-container1").html(doc_view_download_expand(e.data.comprobante, 'assets/modulo/comprobante_venta',nombre_comprobante , '100%', '400px'));
        $('.jq_image_zoom').zoom({ on: 'grab' });
      }
    } else { ver_errores(e); }
  }).fail( function(e) { ver_errores(e); } );
}

// ::::::::::::::::::::::::::::::::::::::::::::: MOSTRAR SERIES :::::::::::::::::::::::::::::::::::::::::::::

function ver_series_comprobante(input) {
  $("#serie_comprobante").html('');
  $(".charge_serie_comprobante").html(`<div class="spinner-border spinner-border-sm" role="status"></div>`);

  var tipo_comprobante = $(input).val() == ''  || $(input).val() == null ? '' : $(input).val();
  $('#tipo_comprobante_hidden').val(tipo_comprobante);

  $.getJSON("../ajax/facturacion.php?op=select2_series_comprobante", { tipo_comprobante: tipo_comprobante },  function (e, status) {    
    if (e.status == true) {      
      $("#serie_comprobante").html(e.data);
      $(".charge_serie_comprobante").html('');
      $("#form-facturacion").valid();
    } else { ver_errores(e); }
  }).fail( function(e) { ver_errores(e); } );
}

// ::::::::::::::::::::::::::::::::::::::::::::: MOSTRAR COBROS :::::::::::::::::::::::::::::::::::::::::::::
function es_cobro_valid() { console.log($(".es_cobro").hasClass("on"));
  if ($(".es_cobro").hasClass("on") == true) {
    $("#es_cobro_inp").val("SI");
    $(".datos-de-cobro-mensual").show("slow");    
    if (form_validate_facturacion) { $("#periodo_pago").rules('add', { required: true, messages: {  required: "Campo requerido" } }); }
  } else {
    $("#es_cobro_inp").val("NO");
    $(".datos-de-cobro-mensual").hide("slow");
    if (form_validate_facturacion) { $("#periodo_pago").rules('remove', 'required'); }
  }
  $("#form-facturacion").valid();
}

// ::::::::::::::::::::::::::::::::::::::::::::: MOSTRAR ANTICIPOS :::::::::::::::::::::::::::::::::::::::::::::
function usar_anticipo_valid() { 
  $("#ua_monto_usado").val('');

  var id_cliente = $('#idpersona_cliente').val() == ''  || $('#idpersona_cliente').val() == null ? '' : $('#idpersona_cliente').val(); 

  if ($(".usar_anticipo").hasClass("on") == true) {

    $("#usar_anticipo").val("SI");
    $(".datos-de-saldo").show("slow");
    if (id_cliente != '') {
      $.getJSON(`../ajax/facturacion.php?op=mostrar_anticipos`, {id_cliente:id_cliente}, function (e, textStatus, jqXHR) {
        $("#ua_monto_disponible").val(e.data.total_anticipo);
        if (form_validate_facturacion) { $("#ua_monto_usado").rules('add', { required: true, max: parseFloat(e.data.total_anticipo) , messages: {  required: "Campo requerido", max: "Saldo disponible: {0}" } }); }
        $("#form-facturacion").valid();
      });
    }
  } else {
    $("#usar_anticipo").val("NO");
    $(".datos-de-saldo").hide("slow");
    if (form_validate_facturacion) { $("#ua_monto_usado").rules('remove', 'required'); }
    $("#form-facturacion").valid();
  }
}

// ::::::::::::::::::::::::::::::::::::::::::::: CLIENTE VALIDO :::::::::::::::::::::::::::::::::::::::::::::
function es_valido_cliente() {
  var id_cliente = $('#idpersona_cliente').val() == ''  || $('#idpersona_cliente').val() == null ? '' : $('#idpersona_cliente').val();

  if (id_cliente != null && id_cliente != '') {

    var tipo_comprobante = $('#tipo_comprobante_hidden').val() == ''  || $('#tipo_comprobante_hidden').val() == null ? '' : $('#tipo_comprobante_hidden').val();
    var tipo_documento    = $('#idpersona_cliente').select2('data')[0].element.attributes.tipo_documento.value;
    var numero_documento  = $('#idpersona_cliente').select2('data')[0].element.attributes.numero_documento.value;
    var direccion         = $('#idpersona_cliente').select2('data')[0].element.attributes.direccion.value;  
    var campos_requeridos = ""; 
    var es_valido = true; 
    

    if (tipo_comprobante == '01') {
      
      if ( tipo_documento == '6'  ) { }else{ campos_requeridos = campos_requeridos.concat(`<li>Tipo de Documento: RUC</li>`);  }
      if ( numero_documento != '' ) { }else{ campos_requeridos = campos_requeridos.concat(`<li>Numero de Documento</li>`);  }
      if ( direccion != '' ) {    }else{  campos_requeridos = campos_requeridos.concat(`<li>Direccion</li>`);  }
      if (tipo_documento == '6' && numero_documento != '' && direccion != '' ) {  es_valido = true;  } else {   es_valido = false; }

    } else if (tipo_comprobante == '03' || id_cliente == '1') {
      
      if ( tipo_documento == '1' ) {  }else{  campos_requeridos = campos_requeridos.concat(`<li>Tipo de Documento: DNI</li>`);  }
      if ( numero_documento != '' ) {  }else{  campos_requeridos = campos_requeridos.concat(`<li>Numero de Documento</li>`);  }
      if ( direccion == '' || direccion == null ) {  campos_requeridos = campos_requeridos.concat(`<li>Direccion</li>`);  }else{    }
      if ( (tipo_documento == '1' || tipo_documento == '0' ) && numero_documento != ''  ) { es_valido = true; } else {  es_valido = false; }

    } else if (tipo_comprobante == '12' ) {
      es_valido = true;
    }

    if (es_valido == true) {
     
    } else {
      sw_cancelar('Cliente no permitido', `El cliente no cumple con los siguientes requsitos:  <ul class="pt-3 text-left font-size-13px"> ${campos_requeridos} </ul>`, 10000);
      $("#idpersona_cliente").val('').trigger('change'); 
    }   
    
    console.log(tipo_comprobante, tipo_documento, numero_documento, direccion, es_valido);
  }    
}

// ::::::::::::::::::::::::::::::::::::::::::::: FORMATOS DE IMPRESION :::::::::::::::::::::::::::::::::::::::::::::

function ver_formato_ticket(idventa, tipo_comprobante) {
  
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/TicketFactura.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/TicketBoleta.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/TicketNotaVenta.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
}

// ::::::::::::::::::::::::::::::::::::::::::::: S E C C I O N   P R O D U C T O S :::::::::::::::::::::::::::::::::::::::::::::
function limpiar_form_producto(){

	$('#idproducto').val('');
  
	$('#codigo').val('');
	$('#categoria').val('');
	$('#u_medida').val('58');
	$('#marca').val('');
	$('#nombre').val('');
	$('#descripcion').val('');
	$('#stock').val('');
	$('#stock_min').val('');
	$('#precio_v').val('');
	$('#precio_c').val('');
	$('#precio_x_mayor').val('');
	$('#precio_dist').val('');
	$('#precio_esp').val('');

  $("#imagen").val("");
  $("#imagenactual").val("");
  $("#imagenmuestra").attr("src", "../assets/modulo/productos/no-producto.png");
  $("#imagenmuestra").attr("src", "../assets/modulo/productos/no-producto.png").show();
  var imagenMuestra = document.getElementById('imagenmuestra');
  if (!imagenMuestra.src || imagenMuestra.src == "") {
    imagenMuestra.src = '../assets/modulo/productos/no-producto.png';
  }


  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

function listar_tabla_producto(tipo = 'PR'){
  $("#modal-producto").modal('show');
  $("#title-modal-producto-label").html( (tipo == 'PR' ? 'Seleccionar Producto' : 'Seleccionar Servicio') );
  tabla_productos = $("#tabla-productos").dataTable({
    responsive: true, 
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>", //Definimos los elementos del control de tabla
    buttons: [  
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_productos) { tabla_productos.ajax.reload(null, false); } } },
    ],
    ajax: {
      url: `../ajax/facturacion.php?op=listar_tabla_producto&tipo_producto=${tipo}`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
      complete: function () {
        $(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');
        $('[data-bs-toggle="tooltip"]').tooltip();
      },
		},
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-nowrap text-center"); }
      // columna: #
      // if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap text-center") }
      // columna: #
      // if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
      
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]],
    columnDefs: [      
      // { targets: [2], render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'), },
      // { targets: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19], visible: false, searchable: false, },
    ],
  }).DataTable();
}

function guardar_editar_producto(e){
  var formData = new FormData($("#form-agregar-producto")[0]);

	$.ajax({
		url: "../ajax/producto.php?op=guardar_editar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (e) {
			try {
				e = JSON.parse(e);
        if (e.status == true) {	
					sw_success('Exito', 'producto guardado correctamente.');
					tabla_productos.ajax.reload(null, false);
          limpiar_form_producto();
          $("#modal-agregar-producto").modal('hide');
				} else {
					ver_errores(e);
				}				
			} catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      
      $(".btn-guardar").html('<i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar').removeClass('disabled send-data');
		},
		xhr: function () {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function (evt) {
				if (evt.lengthComputable) {
					var percentComplete = (evt.loaded / evt.total) * 100;
					$("#barra_progress_producto").css({ "width": percentComplete + '%' });
					$("#barra_progress_producto div").text(percentComplete.toFixed(2) + " %");
				}
			}, false);
			return xhr;
		},
		beforeSend: function () {
			$(".btn-guardar").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled send-data');
			$("#barra_progress_producto").css({ width: "0%", });
			$("#barra_progress_producto div").text("0%");
      $("#barra_progress_producto_div").show();
		},
		complete: function () {
			$("#barra_progress_producto").css({ width: "0%", });
			$("#barra_progress_producto div").text("0%");
      $("#barra_progress_producto_div").hide();
		},
		error: function (jqXhr, ajaxOptions, thrownError) {
			ver_errores(jqXhr);
		}
	});
}

function cambiarImagenProducto() {
	var imagenInput = document.getElementById('imagenProducto');
	imagenInput.click();
}

function removerImagenProducto() {
	$("#imagenmuestraProducto").attr("src", "../assets/modulo/productos/no-producto.png");
	$("#imagenProducto").val("");
  $("#imagenactualProducto").val("");
}

document.addEventListener('DOMContentLoaded', function () {
	var imagenMuestra = document.getElementById('imagenmuestraProducto');
	var imagenInput = document.getElementById('imagenProducto');

	imagenInput.addEventListener('change', function () {
		if (imagenInput.files && imagenInput.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) { imagenMuestra.src = e.target.result;	}
			reader.readAsDataURL(imagenInput.files[0]);
		}
	});
});


$(document).ready(function () {
  init(); 
});

function mayus(e) { 
  e.value = e.value.toUpperCase(); 
}


// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function(){

  form_validate_facturacion = $("#form-facturacion").validate({
    ignore: '',
    rules: {
      idpersona_cliente:      { required: true },
      tipo_comprobante:       { required: true },
      serie_comprobante:      { required: true, },
      observacion_documento:  { minlength: 4 },
      periodo_pago:           { required: true},
      metodo_pago:            { required: true},
      total_recibido:         { required: true, min: 0, step: 0.01},      
      mp_monto:               { required: true, min: 0, step: 0.01},
      total_vuelto:           { required: true, step: 0.01},
      ua_monto_usado:         { required: true, min: 1, step: 0.01},
      mp_serie_comprobante:   { minlength: 4},
      // mp_comprobante:         { extension: "png|jpg|jpeg|webp|svg|pdf",  }, 
    },
    messages: {
      idpersona_cliente:      { required: "Campo requerido", },
      tipo_comprobante:       { required: "Campo requerido", },
      periodo_pago:           { required: "Campo requerido", },
      serie_comprobante:      { required: "Campo requerido", },
      observacion_documento:  { minlength: "Minimo {0} caracteres", },
      // mp_comprobante:         { extension: "Ingrese imagenes validas ( {0} )", },
      total_recibido:         { step: "Solo 2 decimales."},      
      mp_monto:               { step: "Solo 2 decimales."},
      total_vuelto:           { step: "Solo 2 decimales."},
      ua_monto_usado:         { step: "Solo 2 decimales."},
    },

    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },

    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },

    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },

    submitHandler: function (form) {
      guardar_editar_facturacion(form);
    },
  }); 

  $('#distrito').on('change', function() { $(this).trigger('blur'); });
  $("#form-agregar-proveedor").validate({
    ignore: "",
    rules: {           
      tipo_documento:           { required: true, minlength: 1, maxlength: 2, },       
      numero_documento:    			{ required: true, minlength: 8, maxlength: 20, },       
      nombre_razonsocial:    		{ required: true, minlength: 4, maxlength: 200, },       
      apellidos_nombrecomercial:{ required: true, minlength: 4, maxlength: 200, },       
      correo:    			          { minlength: 4, maxlength: 100, },       
      celular:    			        { minlength: 8, maxlength: 9, },       

      direccion:    			      { minlength: 4, maxlength: 200, },       
      distrito:    			        { required: true, },       
      departamento:    			    { required: true, },       
      provincia:    			      { required: true, },  
      ubigeo:    			          { required: true, },

      idbanco:    			        { required: true, },
      cuenta_bancaria:    			{ minlength: 4, maxlength: 45, },
      cci:    			            { minlength: 4, maxlength: 45, },
			
    },
    messages: {     
      tipo_documento:    			  { required: "Campo requerido", },
      numero_documento:    			{ required: "Campo requerido", }, 
      nombre_razonsocial:    		{ required: "Campo requerido", }, 
      apellidos_nombrecomercial:{ required: "Campo requerido", }, 
      correo:    			          { minlength: "Mínimo {0} caracteres.", }, 
      celular:    			        { minlength: "Mínimo {0} caracteres.", }, 

      direccion:    			      { minlength: "Mínimo {0} caracteres.", },
      distrito:    			        { required: "Campo requerido", }, 
      departamento:    			    { required: "Campo requerido", }, 
      provincia:    			      { required: "Campo requerido", }, 
      ubigeo:    			          { required: "Campo requerido", },

      idbanco:    			        { required: "Campo requerido", }, 
      cuenta_bancaria:    			{ minlength: "Mínimo {0} caracteres.", }, 
      cci:    			            { minlength: "Mínimo {0} caracteres.", }, 
      titular_cuenta:    			  { minlength: "Mínimo {0} caracteres.", },  

    },
        
    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },

    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },

    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");   
    },
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      guardar_proveedor(e);      
    },
  });
  $('#distrito').rules('add', { required: true, messages: {  required: "Campo requerido" } });

  $("#form-agregar-producto").validate({
    ignore: "",
    rules: {           
      codigo:         { required: true, minlength: 2, maxlength: 20, },       
      categaria:    	{ required: true },       
      u_medida:    		{ required: true },       
      marca:    			{ required: true },       
      nombre:    			{ required: true, minlength: 2, maxlength: 20,  },       
      descripcion:    { required: true, minlength: 2, maxlength: 500, },       
      stock:          { required: true, min: 0,  },       
      stock_min:      { required: true, min: 0,  }, 
      precio_v:       { required: true, min: 0,  },       
      precio_c:       { required: true, min: 0,  },	
    },
    messages: {     
      cogido:    			{ required: "Campo requerido", },
      categaria:    	{ required: "Seleccione una opción", },
      u_medida:    		{ required: "Seleccione una opción", },
      marca:    			{ required: "Seleccione una opción", },
      nombre:    			{ required: "Campo requerido", }, 
      descripcion:    { required: "Campo requerido", },       
      stock:          { required: "Campo requerido", },       
      stock_min:      { required: "Campo requerido", }, 
      precio_v:       { required: "Campo requerido", },       
      precio_c:       { required: "Campo requerido", },	
    },
        
    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },

    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },

    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");   
    },
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600);
      guardar_editar_producto(e);      
    },
  });

});




// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function reload_idpersona_cliente(){ lista_select2("../ajax/facturacion.php?op=select2_cliente", '#idpersona_cliente', null, '.charge_idpersona_cliente'); }


function printIframe(id) {
  var iframe = document.getElementById(id);
  iframe.focus(); // Para asegurarse de que el iframe está en foco
  iframe.contentWindow.print(); // Llama a la función de imprimir del documento dentro del iframe
}

(function () {
  "use strict"

  // for invoice stats
  var options = {
    series: [
      { name: 'Factura', data: [76, 85, 101, 98, 87, 105] }, 
      { name: 'Boleta', data: [35, 41, 36, 26, 45, 48] }, 
      { name: 'Ticket', data: [44, 55, 57, 56, 61, 58] }
    ],
    chart: { type: 'bar', height: 210, stacked: true },
    plotOptions: { bar: { horizontal: false, columnWidth: '25%', endingShape: 'rounded', }, },
    grid: { borderColor: '#f2f5f7', },
    dataLabels: { enabled: false },
    colors: ["#4b9bfa", "#28d193", "#ffbe14", "#f3f6f8"],
    stroke: { show: true, colors: ['transparent'] },
    xaxis: {
      categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
      labels: {
        show: true,
        style: { colors: "#8c9097", fontSize: '11px', fontWeight: 600, cssClass: 'apexcharts-xaxis-label', },
      }
    },
    yaxis: {
      title: { style: { color: "#8c9097", } },
      labels: {
        show: true,
        style: { colors: "#8c9097", fontSize: '11px', fontWeight: 600, cssClass: 'apexcharts-xaxis-label', },
      }
    },
    fill: { opacity: 1 },
    tooltip: { y: {  formatter: function (val) { return "S/ " + val ; } } }
  };
  var chart = new ApexCharts(document.querySelector("#invoice-list-stats"), options);
  chart.render();

  // UPLOADS ===================================

  /* filepond */
  FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginFileEncode,
    FilePondPluginImageEdit,
    FilePondPluginFileValidateType,
    FilePondPluginImageCrop,
    FilePondPluginImageResize,
    FilePondPluginImageTransform,
      
  );

  /* multiple upload */
  const MultipleElement = document.querySelector('.multiple-filepond');
  file_pond_mp_comprobante = FilePond.create(MultipleElement, FilePond_Facturacion_LabelsES );

})();
