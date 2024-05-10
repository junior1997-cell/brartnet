var tabla_plan;
var tabl_preguntas_frecuentes;

//Función que se ejecuta al inicio
function init_landingPage() {
  
  $("#bloc_Recurso").addClass("menu-open");

  $("#mRecurso").addClass("active");

  tabla_principal_plan();
  tabla_preguntasFrecuentes();

  $("#guardar_plan").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-plan").submit(); }  });
  $("#guardar_registro_preguntas").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-preguntas").submit(); }  });

}

/*==========================================================================================
-------------------------------------------P L A N E S-------------------------------------
==========================================================================================*/

function show_hide_form_plan(flag) {
	if (flag == 1) {
		$("#div-tabla-plan").show();
		$("#div-form-plan").hide();
		$("#footer-plan").hide();
		$("#guardar_plan").hide();
		$("#cancelar_plan").hide();
    $("#footer-plan").addClass("d-none");


		
	} else if (flag == 2) {
		$("#div-tabla-plan").hide();
		$("#div-form-plan").show();
		$("#footer-plan").show();
		$("#guardar_plan").show();
		$("#cancelar_plan").show();
    $("#footer-plan").removeClass("d-none");
	}
}

//Función limpiar_form
function limpiar_form_plan() {
  //Mostramos los Materiales
  $("#idplan").val("");
  $("#nombre_plan").val("");
  $("#costo_plan").val("");
  $(".ql-editor").val("");

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

//Función Listar
function tabla_principal_plan() {

  tabla_plan = $('#tabla-plan').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-4'B><'col-md-2 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload px-2 btn btn-sm btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_plan) { tabla_plan.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,2,3], }, text: `<i class="fas fa-copy" ></i>`, className: "px-2 btn btn-sm btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,2,3], }, title: 'Lista de planes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "px-2 btn btn-sm btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [0,2,3], }, title: 'Lista de planes', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "px-2 btn btn-sm btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "px-2 btn btn-sm btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax:{
      url: '../ajax/landing_page.php?op=tabla_principal_plan',
      type : "get",
      dataType : "json",						
      error: function(e){
        console.log(e.responseText);	ver_errores(e);
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
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[6] != '') { $("td", row).eq(6).addClass("text-center"); }
    },
		language: {
      lengthMenu: "_MENU_ ",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 5,//Paginación
    "order": [[0, "asc"]]//Ordenar (columna,orden)
  }).DataTable();
}

//Función para guardar o editar
function guardar_y_editar_plan(e) {
  transferirContenido();

  var formData = new FormData($("#form-agregar-plan")[0]);
 
  $.ajax({
    url: "../ajax/landing_page.php?op=editar_plan",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      e = JSON.parse(e);  console.log(e);  
      if (e.status == true) {
        Swal.fire("Correcto!", "Plan registrado correctamente.", "success");
	      tabla_plan.ajax.reload(null, false);         
				limpiar_form_plan();
        show_hide_form_plan(1);        
			}else{
				ver_errores(e);
			}
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_plan").css({"width": percentComplete+'%'});
          $("#barra_progress_plan").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#barra_progress_plan").css({ width: "0%",  });
      $("#barra_progress_plan").text("0%");
    },
    complete: function () {
      $("#barra_progress_plan").css({ width: "0%", });
      $("#barra_progress_plan").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

function mostrar_plan(idplan) {
  $(".tooltip").remove();
  $("#guardar_plan").hide();
  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();
  
  limpiar_form_plan();

  show_hide_form_plan(2)

  $.post("../ajax/plan.php?op=mostrar_plan", { idplan: idplan }, function (e, status) {

    e = JSON.parse(e);  console.log(e);  

    if (e.status == true) {
      $("#idplan").val(e.data.idplan);
      $("#nombre_plan").val(e.data.nombre);        
      $("#costo_plan").val(e.data.costo)    
      $(".ql-editor").html(e.data.landing_caracteristica)    

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e); } );
}

function editar_estado_landing(idplan, landing_estado) {
  let mensaje = "";
  
    if (landing_estado == 0) {
      mensaje = "Este Plan es visible en la página principal";
    } else if (landing_estado == 1) {
      mensaje = "Este Plan está oculto";
    }

    $.post("../ajax/landing_page.php?op=editar_estadoLanding", { idplan: idplan, landing_estado: landing_estado }, function (e) {
      try {
        e = JSON.parse(e);
        if (e.status == true) {
          Swal.fire({
            title: "Actualizado",
            text: mensaje,
            icon: "success"
          });
          tabla_plan.ajax.reload(null, false);
        } else {
          ver_errores(e);
        }
      } catch (e) {
        ver_errores(e);
      }
    }).fail(function (e) {
      ver_errores(e);
    });

  
}


function transferirContenido() {
  var contenido = document.querySelector('.ql-editor').innerHTML;  // Obtiene el contenido HTML del div
  document.getElementById('caracteristicas').value = contenido;  // Coloca el contenido en el textarea
}

// function transferirContenido() {
 // var contenido = document.querySelector('.ql-editor').innerText;  Obtener el contenido del div como texto sin formato
  // var contenidoSeguro = encodeURIComponent(contenido); Escapar caracteres especiales

  // document.getElementById('caracteristicas').value = contenidoSeguro; Copiar el contenido seguro en el textarea
// }





/*==========================================================================================
-----------------------P R E G U N T A S   F R E C U E N T E S-----------------------------
==========================================================================================*/

function limpiar_form_preguntas(){
  $("#idpreguntas_frecuentes").val("");

  $("#pregunta_pf").val("");

  $("#respuesta_pf").val("");

}
function tabla_preguntasFrecuentes(){
  tabl_preguntas_frecuentes = $('#tabla-preguntas-frecuentes').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-4'B><'col-md-2 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload px-2 btn btn-sm btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabl_preguntas_frecuentes) { tabl_preguntas_frecuentes.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,2,3], }, text: `<i class="fas fa-copy" ></i>`, className: "px-2 btn btn-sm btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,2,3], }, title: 'Lista de preguntas frecuentes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "px-2 btn btn-sm btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [0,2,3], }, title: 'Lista de preguntas frecuentes', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "px-2 btn btn-sm btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "px-2 btn btn-sm btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax:{
      url: '../ajax/landing_page.php?op=tabla_principal_PregFerct',
      type : "get",
      dataType : "json",						
      error: function(e){
        console.log(e.responseText);	ver_errores(e);
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
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); }
      if (data[1] != '') { $("td", row).eq(0).addClass("text-center"); }
      if (data[4] != '') { $("td", row).eq(0).addClass("text-center"); }
    },
		language: {
      lengthMenu: "_MENU_ ",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 5,//Paginación
    "order": [[0, "asc"]]//Ordenar (columna,orden)
  }).DataTable();

}

function guardar_y_editar_pregFrec(e) {
  var formData = new FormData($("#form-agregar-preguntas")[0]);
 
  $.ajax({
    url: "../ajax/landing_page.php?op=guardar_y_editar_pregFrec",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      e = JSON.parse(e);  console.log(e);  
      if (e.status == true) {
        Swal.fire("Correcto!", "Pregunta Frecuente registrado correctamente.", "success");
	      tabl_preguntas_frecuentes.ajax.reload(null, false);         
				limpiar_form_preguntas();
        $("#modal-agregar-preguntas").modal("hide");        
			}else{
				ver_errores(e);
			}
      $("#guardar_registro_preguntas").html('<i class="bx bx-save bx-tada"></i> Guardar').removeClass('disabled send-data');
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_pregunta").css({"width": percentComplete+'%'});
          $("#barra_progress_pregunta").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro_pregunta").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_pregunta").css({ width: "0%",  });
      $("#barra_progress_pregunta").text("0%");
    },
    complete: function () {
      $("#barra_progress_pregunta").css({ width: "0%", });
      $("#barra_progress_pregunta").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

function mostrar_pregFrec(idpreguntas_frecuentes) {
  $(".tooltip").remove();
  $("#cargando-9-fomulario").hide();
  $("#cargando-10-fomulario").show();
  
  limpiar_form_preguntas();

  $("#modal-agregar-preguntas").modal("show")

  $.post("../ajax/landing_page.php?op=mostrar_pregFrec", { idpreguntas_frecuentes: idpreguntas_frecuentes }, function (e, status) {

    e = JSON.parse(e);  console.log(e);  

    if (e.status == true) {
      $("#idpreguntas_frecuentes").val(e.data.idpreguntas_frecuentes);
      $("#pregunta_pf").val(e.data.pregunta);        
      $("#respuesta_pf").val(e.data.respuesta)    

      $("#cargando-9-fomulario").show();
      $("#cargando-10-fomulario").hide();
    } else {
      ver_errores(e);
    }
    
  }).fail( function(e) { ver_errores(e); } );
}

function eliminar_pregFrec(idpreguntas_frecuentes) {

  crud_eliminar_papelera(
    "../ajax/landing_page.php?op=desactivar",
    "../ajax/landing_page.php?op=eliminar", 
    idpreguntas_frecuentes, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>Pregunta / Respuesta</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){ tabl_preguntas_frecuentes.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );

}


/*==========================================================================================
------------------------------------------- Z O N A S -------------------------------------
==========================================================================================*/

$(document).ready(function () {
  init_landingPage();
});

$(function () {

  $("#form-agregar-plan").validate({
    rules: {
      nombre_plan: { required: true,  maxlength: 60,  },
      costo_plan: { required: true }
    },
    messages: {
      nombre_plan: {  required: "Campo requerido.", },
      costo_plan: {  required: "Campo requerido.", },
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
      guardar_y_editar_plan(e);      
    },

  });


  $("#form-agregar-preguntas").validate({
    rules: {
      pregunta_pf: { required: true,  maxlength: 100,  } ,     // terms: { required: true },
      respuesta_pf: { required: true }      // terms: { required: true },
    },
    messages: {
      pregunta_pf: {  required: "Campo requerido.", },
      respuesta_pf: {  required: "Campo requerido.", },
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
      guardar_y_editar_pregFrec(e);      
    },

  });
});

