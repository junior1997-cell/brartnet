var tabla;

function init(){
  
  listar_tabla();
  listar_trabajador();
  listar_proveedor();

	$(".btn-guardar").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-gasto").submit(); } });

}

// abrimos el navegador de archivos
$("#doc1_i").click(function() {  $('#doc1').trigger('click'); });
$("#doc1").change(function(e) {  addImageApplication(e,$("#doc1").attr("id"), null, null, null, true) });

function doc1_eliminar() {
	$("#doc1").val("");
	$("#doc1_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
	$("#doc1_nombre").html("");
}

function limpiar_form(){
$("#idgasto_de_trabajador").val("");
$("#descr_gastos").val("");
$("#tp_comprobante").val("NINGUNO");
$(".proveedor").hide();
$("#serie_comprobante").val("");
$("#fecha").val("");
$("#sub_total").val("");
$("#igv").val("");
$("#total_gasto").val("");
$("#descr_comprobante").val("");
//reseteamos los select
listar_trabajador();
listar_proveedor();
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

function guardar_editar(e){
  var formData = new FormData($("#formulario-gasto")[0]);
  $.ajax({
    url: "../ajax/gasto_de_trabajador.php?op=guardar_editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false, 

    success: function (e) {
      try {
        e = JSON.parse(e);  console.log(e);
        if (e.status == true) {
          Swal.fire("Correcto!", "El registro se guardo exitosamente.", "success");
          tabla.ajax.reload(null, false);
          show_hide_form(1); limpiar_form();
        }else{ ver_errores(e); }
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

function listar_tabla(){
  tabla = $('#tabla-gastos').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla) { tabla.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [1,2,3,4,5,6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
		"ajax":	{
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
		},
		language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[2, "desc"]]//Ordenar (columna,orden)
  }).DataTable();
}

function eliminar_gasto(idgasto_de_trabajador, nombre_razonsocial) {

  crud_eliminar_papelera(
    "../ajax/gasto_de_trabajador.php?op=desactivar",
    "../ajax/gasto_de_trabajador.php?op=eliminar", 
    idgasto_de_trabajador, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del> ${nombre_razonsocial} </del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){ tabla.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}

function listar_trabajador() {
  $.post("../ajax/gasto_de_trabajador.php?op=listar_trabajador", {}, function (e, status) {
    e = JSON.parse(e);
    if(e.status == true) {
      $("#idtrabajador").html(e.data);
    }
  });
}

function listar_proveedor() {
  $.post("../ajax/gasto_de_trabajador.php?op=listar_proveedor", {}, function (e, status) {
    e = JSON.parse(e);
    if(e.status == true) {
      $("#idproveedor").html(e.data);
    }
  });

  // MOSTRAR LISTA
  $('#tp_comprobante').change(function() {
    $('.proveedor').toggle($('#tp_comprobante').val() === 'FACTURA' || $('#tp_comprobante').val() === 'NOTA_DE_VENTA');
  });
}

function mostrar_comprobante(idgasto_de_trabajador) {
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_gasto_trabajador", 
  {idgasto_de_trabajador: idgasto_de_trabajador},
  function(e, status){ 

    e = JSON.parse(e);
    if(e.status == true){
      if (e.data.comprobante == "" || e.data.comprobante == null  ) {   } else {
        $("#comprobante-container").html(doc_view_extencion(e.data.comprobante,'assets/modulo/gasto_de_trabajador', '100%', '500' ));
        $('.jq_image_zoom').zoom({ on:'grab' });
      }
      $('#modal-ver-comprobante').modal('show');

    }else {ver_errores(e);}
  });

}

//liStamos datos para EDITAR
function mostrar_gasto_de_trabajador(idgasto_de_trabajador) {
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_gasto_trabajador",{idgasto_de_trabajador: idgasto_de_trabajador}, function(e, status){
    e = JSON.parse(e);
    if(e.status == true){
      $("#idgasto_de_trabajador").val(e.data.idgasto_de_trabajador);
      $("#idtrabajador").val(e.data.idtrabajador);
      $("#descr_gastos").val(e.data.descripcion_gasto);
      $("#tp_comprobante").val(e.data.tipo_comprobante);
      $("#serie_comprobante").val(e.data.serie_comprobante);
      $("#fecha").val(e.data.fecha_ingreso);
      $("#idproveedor").val(e.data.idproveedor);
      $("#sub_total").val(e.data.precio_sin_igv);
      $("#igv").val(e.data.precio_igv);
      $("#val_igv").val(e.data.val_igv);
      $("#total_gasto").val(e.data.precio_con_igv);
      $("#descr_comprobante").val(e.data.descripcion_comprobante);
      if(e.data.tipo_comprobante == 'FACTURA' || e.data.tipo_comprobante == 'NOTA_DE_VENTA'){ $(".proveedor").show(); }

      // ------------ IMAGEN -----------
      if (e.data.comprobante == "" || e.data.comprobante == null  ) {   } else {
        $("#doc_old_1").val(e.data.comprobante); 
        $("#doc1_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.comprobante)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc1_ver").html(doc_view_extencion(e.data.comprobante,'assets/modulo/gasto_de_trabajador', '50%', '110' ));   //ruta imagen          
      }

      show_hide_form(2);
    }
  });
}

//listamos los datos para MOSTRAR TODO
function mostrar_detalles_gasto(idgasto_de_trabajador) {
  $("#modal-ver-detalle").modal('show');
  $.post("../ajax/gasto_de_trabajador.php?op=mostrar_detalle_gasto",{idgasto_de_trabajador: idgasto_de_trabajador}, function(e, status){
    e = JSON.parse(e);
    if(e.status == true){

      // existen algunos registros que tiene el apellido = NULL  --> para ocultar el null hacemos esta condicion <(°-°)>
      var apellido = e.data.trabajador.data.apellidos_nombrecomercial;
      var nombre = e.data.trabajador.data.nombre_razonsocial;
      if (apellido !== null && apellido.trim() !== ''){
        $("#trabajador").val(nombre + ' ' + apellido);
      }else {$("#trabajador").val(nombre);}

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

      $(".imagen_comb").html(doc_view_extencion(e.data.trabajador.data.comprobante,'assets/modulo/gasto_de_trabajador/', '500px', 'auto' ));
      

      //mostrar el div del proveedor siempre y cuando tp_comprbante sea F - NV
      if(e.data.trabajador.data.tipo_comprobante == 'FACTURA' || e.data.trabajador.data.tipo_comprobante == 'NOTA_DE_VENTA'){ 
        $(".proveedor_s").show(); 
      } else{$(".proveedor_s").hide();}
    }
  });
}

function calcularigv(){ //cortesia de chatGPT :)
  var tipo_comprobante = $("#tp_comprobante").val();
  var precio_sin_igv = parseFloat($("#sub_total").val());
  var precio_igv = parseFloat($("#igv").val());
  var valor_igv = parseFloat($("#val_igv").val());
  var precio_con_igv = parseFloat($("#total_gasto").val());

  // Verificar el tipo de comprobante
  if (tipo_comprobante === "FACTURA" || tipo_comprobante === "NOTA_DE_VENTA") {
    // Calcular el precio del IGV y el precio sin IGV
    valor_igv2 = 1.18;
    valor_igv = 0.18;
    precio_igv = (precio_con_igv * valor_igv2) / 100;
    precio_sin_igv = precio_con_igv - precio_igv;
  } else if (tipo_comprobante === "BOLETA" || tipo_comprobante === "NINGUNO") {
    // Configurar valores para comprobante BOLETA o NINGUNO
    valor_igv = 0;
    precio_igv = 0;
    precio_sin_igv = precio_con_igv;
  }

  // Actualizar los valores en los elementos HTML
  $("#igv").val(precio_igv.toFixed(2));
  $("#val_igv").val(valor_igv.toFixed(2));
  $("#sub_total").val(precio_sin_igv.toFixed(2));
}

function mayus(e) {
	e.value = e.value.toUpperCase();
}


// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..
$(function () {
  $("#formulario-gasto").validate({
    rules: {
      idtrabajador: { required: true },
      descr_gastos: { required: true, minlength: 2, maxlength: 500},
      fecha: { required: true },
      total_gasto:  { required: true, minlength: 1, maxlength: 100 },
      serie_comprobante: { 
        required: function(element) {
          return $("#tp_comprobante").val() !== "NINGUNO";
        }
      }
    },

    messages: {
      idtrabajador: { required: "Por favor selecciones un trabajador" },
      descr_gastos: { required: "Por favor rellena el campo" },
      serie_comprobante: { required: "Por favor rellene el campo" },
      fecha: { required: "Por favor ingrese una fecha valida" },
      total_gasto:  { required: "Por favor rellena el campo" },
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

init();

