
$(function () {


  $.post( "ajax_client/ver_pagos.php?op=ver_pagos_cliente", {},  function (e) {
    e = JSON.parse(e); console.log(e);			
    if (e.status) {
     	
      $('.list_data_pagos').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e);  }); 

  filtro_pagos_year ();
  filtro_pagos_month ();

});

function filtro_pagos_year (){
  $.post( "ajax_client/ver_pagos.php?op=filtro_pagos_year", {},  function (e) {
    e = JSON.parse(e); console.log(e);	
    if (e.status) {
    			
      $('.list_year').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { 
    ver_errores(e);
  }); 

}

function filtro_pagos_month (){

    $.post( "ajax_client/ver_pagos.php?op=filtro_pagos_month", {},  function (e) {
      e = JSON.parse(e); console.log(e);	
      if (e.status) {
      			
      $('.list_month').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { 
    ver_errores(e);
  }); 

}



// ::::::::::::::::::::::::::::::::::::::::::::: FORMATOS DE IMPRESION :::::::::::::::::::::::::::::::::::::::::::::

function ver_formato_ticket(idventa, tipo_comprobante) {
  $("#modal-imprimir-comprobante .modal-dialog").removeClass("modal-sm modal-lg modal-xl modal-xxl").addClass("modal-md");
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - FACTURA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - BOLETA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '07') {
    var rutacarpeta = "../reportes/TicketNotaCredito.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - NOTA CREDITO`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - NOTA DE VENTA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
}

function ver_formato_a4_comprimido(idventa, tipo_comprobante) {
  $("#modal-imprimir-comprobante .modal-dialog").removeClass("modal-sm modal-md modal-lg modal-xxl").addClass("modal-xl");
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/A4Comprimido.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - FACTURA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/A4Comprimido.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - BOLETA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '07') {
    toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/A4Comprimido.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - NOTA DE VENTA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
}

function ver_formato_a4_completo(idventa, tipo_comprobante) {  
  $("#modal-imprimir-comprobante .modal-dialog").removeClass("modal-sm modal-md modal-lg modal-xxl").addClass("modal-xl");
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/A4FormatHtml.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - FACTURA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/A4FormatHtml.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - BOLETA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '07') {
    var rutacarpeta = "../reportes/A4FormatHtml.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - NOTA DE VENTA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/A4FormatHtml.php?id=" + idventa;
    $("#modal-imprimir-comprobante-label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir A4" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO A4 - NOTA DE VENTA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }  
  
}