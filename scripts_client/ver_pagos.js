

var estado =""
var anio ="";
$(function () {
  mostrar_datos_cliente();
  all_pagos(estado, anio)
  filtro_pagos_year ();

});

function all_pagos(estado, anio){
  $.post( "ajax_client/ver_pagos.php?op=ver_pagos_cliente", {estado:estado, anio:anio},  function (e) {
    e = JSON.parse(e); console.log(e);			
    if (e.status == true) {
     	
      $('.list_data_pagos').html(e.data);
      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e);  }); 
}

function mostrar_datos_cliente() {
 
  $.getJSON( "ajax_client/ver_pagos.php?op=mostrar_datos_cliente", function (e, textStatus, jqXHR) {
    
    if (e.status == true) {     	
      $('.cliente_nombre').html(e.data.cliente_nombre_completo);      
      $('.cliente_dni').html(e.data.numero_documento);      
      $('.cliente_direccion').html(e.data.direccion);      
      $('.cliente_plan').html(`${e.data.nombre_plan} - S/. ${e.data.costo}`);      
      $('.cliente_f_afiliacion').html( format_d_m_a(e.data.fecha_afiliacion,'/'));      
      $('.cliente_f_pago').html(e.data.dia_cancelacion_v2);      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e);  }); 
}

function filtro_pagos_year (){
  $.post( "ajax_client/ver_pagos.php?op=filtro_pagos_year", {},  function (e) {
    e = JSON.parse(e); console.log(e);	

    if (e.status == true) {    			
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

    if (e.status == true) {      			
      $('.list_month').html(e.data);      
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { 
    ver_errores(e);
  }); 

}

function ver_comprobante(idventa, tipo_comprobante, num_comprobante) { 

  $("#modal_ver_comprobante").modal("show");
  $(".btn_formato_ticket").attr("onclick",`ver_formato_ticket(${idventa}, ${tipo_comprobante})`);
  $(".btn_formato_a4").attr("onclick",`ver_formato_a4_completo(${idventa}, ${tipo_comprobante})`);

  $(".btn_formato_ticket").click();
  //$(".btn_formato_a4").click();

  $(".serie_comp").text(num_comprobante);
  
 }

// ::::::::::::::::::::::::::::::::::::::::::::: FORMATOS DE IMPRESION :::::::::::::::::::::::::::::::::::::::::::::

function ver_formato_ticket(idventa, tipo_comprobante) {
  $("#modal_ver_comprobante .modal-dialog").removeClass("modal-sm modal-lg modal-xl modal-xxl").addClass("modal-md");
  
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal_cliente.php?id=" + idventa;
    $(".formato_ticket").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);

  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal_cliente.php?id=" + idventa;
    $(".formato_ticket").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);

  } else if (tipo_comprobante == '07') {
    var rutacarpeta = "../reportes/TicketNotaCredito.php?id=" + idventa;
  $(".formato_ticket").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);

  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal_cliente.php?id=" + idventa;
     $(".formato_ticket").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
}

function ver_formato_a4_completo(idventa, tipo_comprobante) {  
  $("#modal_ver_comprobante .modal-dialog").removeClass("modal-sm modal-md modal-lg modal-xxl").addClass("modal-xl");
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/A4FormatHtml_cliente.php?id=" + idventa;
     $(".formato_a4").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
   
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/A4FormatHtml_cliente.php?id=" + idventa;
     $(".formato_a4").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
   
  } else if (tipo_comprobante == '07') {
    var rutacarpeta = "../reportes/A4FormatHtml_cliente.php?id=" + idventa;
     $(".formato_a4").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
   
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/A4FormatHtml_cliente.php?id=" + idventa;
    $(".formato_a4").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);

  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
  
}


//::::::::::::::::::::::::::::::filtros ::::::::::::::::::::::::::::.
function year_a(d_anio) {  anio = d_anio;  all_pagos(estado, d_anio);};
function stado(d_estado) {  
  estado = d_estado; all_pagos(d_estado, anio);


};

function limpiar_filtros() { all_pagos("", ""); 
  // Remover las clases de pintado de ambos botones
  $('.class_btn_pagado, .class_btn_por_pagado').removeClass('bg-secondary').addClass('bg-secondary-transparent'); };

$('.class_btn_pagado, .class_btn_por_pagado').click(function() {
  // Remover las clases de pintado de ambos botones
  $('.class_btn_pagado, .class_btn_por_pagado').removeClass('bg-secondary').addClass('bg-secondary-transparent');

  // Añadir la clase de pintado solo al botón que fue clickeado
  $(this).removeClass('bg-secondary-transparent').addClass('bg-secondary');
});