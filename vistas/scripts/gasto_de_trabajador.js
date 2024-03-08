var tabla;

function init() {

  listar_tabla();
  
  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $(".btn-guardar").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-gasto").submit(); } });

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/gasto_de_trabajador.php?op=listar_trabajador", '#idtrabajador', null);
  lista_select2("../ajax/gasto_de_trabajador.php?op=listar_proveedor", '#idproveedor', null);

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#idtrabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#tipo_comprobante").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idproveedor").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

}

// abrimos el navegador de archivos
$("#doc1_i").click(function () { $('#doc1').trigger('click'); });
$("#doc1").change(function (e) { addImageApplication(e, $("#doc1").attr("id"), null, null, null, true) });

function doc1_eliminar() {
  $("#doc1").val("");
  $("#doc1_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
  $("#doc1_nombre").html("");
}

function limpiar_form() {
  $("#idgasto_de_trabajador").val("");
  $("#idtrabajador").val(null).trigger("change"); 
  $("#idproveedor").val(null).trigger("change"); 

  $("#descr_gastos").val("");
  $("#tipo_comprobante").val("NINGUNO").trigger("change");  
  $("#serie_comprobante").val("");
  $("#fecha").val("");
  $("#precio_sin_igv").val("");
  $("#igv").val("");
  $("#precio_con_igv").val("");
  $("#descr_comprobante").val("");
  
  //limpiamos imagen
  doc1_eliminar();
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".form-select").removeClass('is-valid');
  $(".form-select").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();

}

function show_hide_form(flag) {
  if (flag == 1) {
    $("#div-tabla").show();
    $("#div-formulario").hide();

    $(".btn-agregar").show();
    $(".btn-guardar").hide();
    $(".btn-cancelar").hide();

  } else if (flag == 2) {
    $("#div-tabla").hide();
    $("#div-formulario").show();

    $(".btn-agregar").hide();
    $(".btn-guardar").show();
    $(".btn-cancelar").show();
  }
}

function guardar_editar(e) {
  var formData = new FormData($("#formulario-gasto")[0]);
  $.ajax({
    url: "../ajax/gasto_de_trabajador.php?op=guardar_editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (e) {
      try {
        e = JSON.parse(e); console.log(e);
        if (e.status == true) {
          Swal.fire("Correcto!", "El registro se guardo exitosamente.", "success");
          tabla.ajax.reload(null, false);
          show_hide_form(1); limpiar_form();
        } else { ver_errores(e); }
      } catch (err) { console.log('Error: ', err.message); toastr.error('<h5 class="font-size-16px">Error temporal!!</h5> puede intentalo mas tarde, o comuniquese con <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>'); }
      $("#guardar_registro_gasto").html('Guardar Cambios').removeClass('disabled send-data');
    },
    beforeSend: function () {
      $("#guardar_registro_gasto").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled send-data');
      $("#barra_progress_gasto").css({ width: "0%", });
      $("#barra_progress_gasto div").text("0%");
      $("#barra_progress_gasto_div").show();
    },
    complete: function () {
      $("#barra_progress_gasto").css({ width: "0%", });
      $("#barra_progress_gasto div").text("0%");
      $("#barra_progress_gasto_div").hide();
    },
    error: function (jqXhr, ajaxOptions, thrownError) {
      ver_errores(jqXhr);
    }
  });
}

function listar_tabla() {
  tabla = $('#tabla-gastos').dataTable({
    lengthMenu: [[-1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200,]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: "<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function (e, dt, node, config) { if (tabla) { tabla.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true, },
      { extend: 'excel', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true, },
      { extend: 'pdf', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL', },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    "ajax": {
      url: '../ajax/gasto_de_trabajador.php?op=listar_tabla',
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
      complete: function () {
        $(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');
        $(".buttons-copy").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Copiar');
        $(".buttons-excel").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Excel');
        $(".buttons-pdf").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'PDF');
        $(".buttons-colvis").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Columnas');
        $('[data-bs-toggle="tooltip"]').tooltip();
      },
      dataSrc: function (e) {
				if (e.status != true) {  ver_errores(e); }  return e.aaData;
			},
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    footerCallback: function( tfoot, data, start, end, display ) {
      var api1 = this.api(); var total1 = api1.column( 5 ).data().reduce( function ( a, b ) { return  (parseFloat(a) + parseFloat( b)) ; }, 0 )
      $( api1.column( 5 ).footer() ).html( `S/ ${formato_miles(total1)}` );       
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[2, "desc"]],//Ordenar (columna,orden)
    columnDefs: [
      // { targets: [7,8, 9, 10, 11, 12, 13, 14], visible: false, searchable: false, }, 
      { targets: [2], render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'), },
      { targets: [5], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = ''; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-left">S/</span> <span class="float-right ${color} "> ${number} </span>`; } return number; }, },      

    ],
  }).DataTable();
}

function eliminar_gasto(idgasto_de_trabajador, nombre_razonsocial) {

  crud_eliminar_papelera(
    "../ajax/gasto_de_trabajador.php?op=desactivar",
    "../ajax/gasto_de_trabajador.php?op=eliminar",
    idgasto_de_trabajador,
    "!Elija una opción¡",
    `<b class="text-danger"><del> ${nombre_razonsocial} </del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`,
    function () { sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado.") },
    function () { sw_success('Eliminado!', 'Tu registro ha sido Eliminado.') },
    function () { tabla.ajax.reload(null, false); },
    false,
    false,
    false,
    false
  );
}

function mostrar_comprobante(idgasto_de_trabajador) {
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_editar_gdt", { idgasto_de_trabajador: idgasto_de_trabajador },  function (e, status) {

    e = JSON.parse(e);
    if (e.status == true) {
      if (e.data.comprobante == "" || e.data.comprobante == null) { } else {
        $("#comprobante-container").html(doc_view_extencion(e.data.comprobante, 'assets/modulo/gasto_de_trabajador', '100%', '500'));
        $('.jq_image_zoom').zoom({ on: 'grab' });
      }
      $('#modal-ver-comprobante').modal('show');

    } else { ver_errores(e); }
  }).fail( function(e) { ver_errores(e); } );

}

//liStamos datos para EDITAR
function mostrar_editar_gdt(idgasto_de_trabajador) {
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_editar_gdt", { idgasto_de_trabajador: idgasto_de_trabajador }, function (e, status) {
    e = JSON.parse(e);
    if (e.status == true) {
      $("#idgasto_de_trabajador").val(e.data.idgasto_de_trabajador);
      $("#idtrabajador").val(e.data.idpersona_trabajador).trigger("change");
      $("#idproveedor").val(e.data.idproveedor).trigger("change");

      $("#descr_gastos").val(e.data.descripcion_gasto);
      $("#tipo_comprobante").val(e.data.tipo_comprobante);
      $("#serie_comprobante").val(e.data.serie_comprobante);
      $("#fecha").val(e.data.fecha_ingreso);
      
      $("#precio_sin_igv").val(e.data.precio_sin_igv);
      $("#igv").val(e.data.precio_igv);
      $("#val_igv").val(e.data.val_igv);
      $("#precio_con_igv").val(e.data.precio_con_igv);
      $("#descr_comprobante").val(e.data.descripcion_comprobante);      

      // ------------ IMAGEN -----------
      if (e.data.comprobante == "" || e.data.comprobante == null) { } else {
        $("#doc_old_1").val(e.data.comprobante);
        $("#doc1_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.comprobante)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc1_ver").html(doc_view_extencion(e.data.comprobante, 'assets/modulo/gasto_de_trabajador', '50%', '110'));   //ruta imagen          
      }

      show_hide_form(2);
    }else{
      ver_errores(e);
    }
  }).fail( function(e) { ver_errores(e); } );
}

//listamos los datos para MOSTRAR TODO
function mostrar_detalles_gasto(idgasto_de_trabajador) {
  $("#modal-ver-detalle").modal('show');
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_detalle_gasto", { idgasto_de_trabajador: idgasto_de_trabajador }, function (e, status) {
    e = JSON.parse(e);
    if (e.status == true) {

      // existen algunos registros que tiene el apellido = NULL  --> para ocultar el null hacemos esta condicion <(°-°)>
      var apellido = e.data.trabajador.data.apellidos_nombrecomercial;
      var nombre = e.data.trabajador.data.nombre_razonsocial;
      if (apellido !== null && apellido.trim() !== '') {
        $("#trabajador").val(nombre + ' ' + apellido);
      } else { $("#trabajador").val(nombre); }

      $("#tipo_comb").val(e.data.trabajador.data.tipo_comprobante);
      $("#d_serie").val(e.data.trabajador.data.serie_comprobante);
      $("#fecha_emision").val(e.data.trabajador.data.fecha_ingreso);
      $("#s_proveedor").val(e.data.proveedor.data.nombre_razonsocial);
      $("#p_sin_igv").val(e.data.trabajador.data.precio_sin_igv);
      $("#p_igv").val(e.data.trabajador.data.precio_igv);
      $("#v_igv").val(e.data.trabajador.data.val_igv);
      $("#p_con_igv").val(e.data.trabajador.data.precio_con_igv);
      $("#d_gasto").val(e.data.trabajador.data.descripcion_gasto);
      $("#d_compb").val(e.data.trabajador.data.descripcion_comprobante);

      $(".imagen_comb").html(doc_view_extencion(e.data.trabajador.data.comprobante, 'assets/modulo/gasto_de_trabajador/', '500px', 'auto'));


      //mostrar el div del proveedor siempre y cuando tp_comprbante sea F - NV
      if (e.data.trabajador.data.tipo_comprobante == 'FACTURA' || e.data.trabajador.data.tipo_comprobante == 'NOTA_DE_VENTA') {
        $(".proveedor_s").show();
      } else { $(".proveedor_s").hide(); }
    }else{
      ver_errores(e);
    }
  }).fail( function(e) { ver_errores(e); } );
}

// MOSTRAR LISTA
$('#tipo_comprobante').change(function () {
  $('.proveedor').toggle($('#tipo_comprobante').val() === 'FACTURA' || $('#tipo_comprobante').val() === 'NOTA_DE_VENTA');
  $('#formulario-gasto').valid();  
  comprob_factura();
  validando_igv();
});

//segun tipo de comprobante
function comprob_factura() {

  var precio_con_igv = $("#precio_con_igv").val(); 
  
  if ($("#tipo_comprobante").select2('val') == "" || $("#tipo_comprobante").select2('val') == null) {

    $(".nro_comprobante").html("Núm. Comprobante");

    $("#val_igv").val(""); $("#tipo_gravada").val(""); 

    if (precio_con_igv == null || precio_con_igv == "") {
      $("#precio_sin_igv").val(0);
      $("#igv").val(0);    
    } else {
      $("#precio_sin_igv").val(parseFloat(precio_con_igv).toFixed(2));
      $("#igv").val(0);    
    }   

  } else if ($("#tipo_comprobante").select2('val') == "NINGUNO") {     

    $(".nro_comprobante").html("Núm. de Operación");
    $("#val_igv").prop("readonly",true);

    if (precio_con_igv == null || precio_con_igv == "") {
      $("#precio_sin_igv").val(0);
      $("#igv").val(0);
      
      $("#val_igv").val("0"); 
      $("#tipo_gravada").val("NO GRAVADA");  

    } else {
      $("#precio_sin_igv").val(parseFloat(precio_con_igv).toFixed(2));
      $("#igv").val(0); 

      $("#val_igv").val("0"); 
      $("#tipo_gravada").val("NO GRAVADA"); 

    }   

  } else if ($("#tipo_comprobante").select2("val") == "FACTURA") {          

    $(".nro_comprobante").html("Núm. Comprobante");
    $(".div_ruc").show(); $(".div_razon_social").show();      
    calculandototales_fact();     
  
  } else if ($("#tipo_comprobante").select2("val") == "BOLETA") {       

    
    $("#val_igv").prop("readonly",true);
    $(".nro_comprobante").html("Núm. Comprobante");

    $(".div_ruc").show(); $(".div_razon_social").show();
    
    if (precio_con_igv == null || precio_con_igv == "") {
      $("#precio_sin_igv").val(0);
      $("#igv").val(0); 
      $("#val_igv").val("0");   
    } else {
              
      $("#precio_sin_igv").val("");
      $("#igv").val("");

      $("#precio_sin_igv").val(parseFloat(precio_con_igv).toFixed(2));
      $("#igv").val(0); 
      
      $("#val_igv").val("0"); 
      $("#tipo_gravada").val("NO GRAVADA"); 
    } 
      
  } else {
    $("#val_igv").prop("readonly",true);    
    $(".nro_comprobante").html("Núm. Comprobante");
    $(".div_ruc").hide(); $(".div_razon_social").hide();
    $("#ruc").val(""); $("#razon_social").val("");

    if (precio_con_igv == null || precio_con_igv == "") {
      
      $("#precio_sin_igv").val(0);
      $("#igv").val(0);

      $("#val_igv").val("0"); 
      $("#tipo_gravada").val("NO GRAVADA");  

    } else {

      $("#precio_sin_igv").val(parseFloat(precio_con_igv).toFixed(2));
      $("#igv").val(0); 

      $("#val_igv").val("0"); 
      $("#tipo_gravada").val("NO GRAVADA");  

    } 
    
  }   
}

function validando_igv() {
  if ($("#tipo_comprobante").select2("val") == "FACTURA") {
    $("#val_igv").prop("readonly",false);
    $("#val_igv").val(18); 
  }else {
    $("#val_igv").val(0); 
  }  
}

function calculandototales_fact() {
  //----------------
  $("#tipo_gravada").val("GRAVADA");         
  $(".nro_comprobante").html("Núm. Comprobante");
  var precio_con_igv = $("#precio_con_igv").val();
  var val_igv = $('#val_igv').val();

  if (precio_con_igv == null || precio_con_igv == "") {

    $("#precio_sin_igv").val(0);
    $("#igv").val(0); 

  } else {
 
    var precio_sin_igv = 0;
    var igv = 0;

    if (val_igv == null || val_igv == "") {

      $("#precio_sin_igv").val(parseFloat(precio_con_igv));
      $("#igv").val(0);

    }else{

      $("precio_sin_igv").val("");
      $("#igv").val("");

      precio_sin_igv = quitar_igv_del_precio(precio_con_igv, val_igv, 'entero');
      igv = precio_con_igv - precio_sin_igv;

      $("#precio_sin_igv").val(parseFloat(precio_sin_igv).toFixed(2));
      $("#igv").val(parseFloat(igv).toFixed(2));

    }
  }  
}

function quitar_igv_del_precio(precio , igv, tipo ) {
  console.log(precio , igv, tipo);
  var precio_sin_igv = 0;

  switch (tipo) {
    case 'decimal':

      if (parseFloat(precio) != NaN && igv > 0 && igv <= 1 ) {
        precio_sin_igv = ( parseFloat(precio) * 100 ) / ( ( parseFloat(igv) * 100 ) + 100 )
      }else{
        precio_sin_igv = precio;
      }
    break;

    case 'entero':

      if (parseFloat(precio) != NaN && igv > 0 && igv <= 100 ) {
        precio_sin_igv = ( parseFloat(precio) * 100 ) / ( parseFloat(igv)  + 100 )
      }else{
        precio_sin_igv = precio;
      }
    break;
  
    default:
      $(".val_igv").html('IGV (0%)');
      toastr.success('No has difinido un tipo de calculo de IGV.')
    break;
  } 
  
  return precio_sin_igv; 
}



// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..
$(function () {
  $("#formulario-gasto").validate({
    rules: {
      idtrabajador:     { required: true },
      descr_gastos:     { required: true, minlength: 2, maxlength: 500 },
      fecha:            { required: true },
      precio_con_igv:      { required: true, min: 1, },
      val_igv:          { required: true, minlength: 1, maxlength: 100 },
      serie_comprobante:{
        required: function (element) {
          return $("#tipo_comprobante").val() !== "NINGUNO";
        }
      }
    },

    messages: {
      idtrabajador:     { required: "Campo requerido" },
      descr_gastos:     { required: "Campo requerido" },
      serie_comprobante:{ required: "Campo requerido" },
      fecha:            { required: "Campo requerido" },
      precio_con_igv:      { required: "Campo requerido" },
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
      window.scroll({ top: document.body.scrollHeight, left: document.body.scrollHeight, behavior: "smooth", });
      guardar_editar(e);
    },
  });
});

$(document).ready(function () {
  init();
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function mayus(e) {
  e.value = e.value.toUpperCase();
}

function ver_img(img, nombre) {
	$(".title-modal-img").html(`-${nombre}`);
  $('#modal-ver-img').modal("show");
  $('.html_ver_img').html(doc_view_extencion(img, 'assets/modulo/persona/perfil', '100%', '550'));
  $(`.jq_image_zoom`).zoom({ on:'grab' });
}


function reload_idtrabajador(){ lista_select2("../ajax/gasto_de_trabajador.php?op=listar_trabajador", '#idtrabajador', null, '.charge_idtrabajador'); }
function reload_idproveedor(){ lista_select2("../ajax/gasto_de_trabajador.php?op=listar_proveedor", '#idproveedor', null, '.charge_idproveedor'); }
