var tabla_usuario;
var tabla_historial;
var modoDemo = false;
//Función que se ejecuta al inicio
function init() {

	listar();

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $(".btn-guardar").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-trabajador").submit(); }  });

	// ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/ajax_general.php?op=select2_cargo", '#idcargo_trabajador', null);
  lista_select2("../ajax/ajax_general.php?op=select2_tipo_documento", '#tipo_documento', null);
  lista_select2("../ajax/ajax_general.php?op=select2_banco", '#idbanco', null);
  lista_select2("../ajax/ajax_general.php?op=select2_distrito", '#distrito', null);

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#tipo_documento").select2({  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idcargo_trabajador").select2({  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idbanco").select2({  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#distrito").select2({  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

	$.post("../ajax/usuario.php?op=permisos&id=", function (r) {	$("#permisos").html(r);	});
	$.post("../ajax/usuario.php?op=series&id=", function (r) {	$("#series").html(r);	});
	// $.post("../ajax/usuario.php?op=permisosEmpresaTodos", function (r) {	$("#empresas").html(r);	});
}



//Función limpiar
function limpiar_form() {
	$("#nombre").val("");
	$("#apellidos").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");	
	$("#idusuario").val(""); 

  $( "#clave" ).rules( "add", { required: true,  messages: {  required: "Campo requerido", } });

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

function reload_ps() {
  $.post("../ajax/usuario.php?op=permisos&id=", function (r) { $("#permisos").html(r); });
  $.post("../ajax/usuario.php?op=series&id=", function (r) { $("#series").html(r); });
}

function show_hide_form(flag) {
	if (flag == 1) {
		$("#div-tabla").show();
		$("#div-form").hide();

		$(".btn-agregar").show();
		$(".btn-guardar").hide();
		$(".btn-cancelar").hide();
		
	} else if (flag == 2) {
		$("#div-tabla").hide();
		$("#div-form").show();

		$(".btn-agregar").hide();
		$(".btn-guardar").show();
		$(".btn-cancelar").show();
	}
}

//Función Listar
function listar() {
	tabla_usuario = $('#tabla-usuario').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_usuario) { tabla_usuario.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [1,2,3,4,5,6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
		"ajax":	{
			url: '../ajax/usuario.php?op=listar',
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
//Función para guardar o editar

function guardar_y_editar_usuario(e) {
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	
	var formData = new FormData($("#form-agregar-usuario")[0]);

	$.ajax({
		url: "../ajax/usuario.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (e) {
			try {
				e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
					tabla_usuario.ajax.reload(null, false);          
					show_hide_form(1)
					sw_success('Exito', 'Usuario guardado correctamente.');
				} else {
					ver_errores(jqXhr);
				}				
			} catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      
		},
		error: function (jqXhr, ajaxOptions, thrownError) {
			ver_errores(jqXhr);
		}
	});
}

function mostrar(idusuario) {
  limpiar_form();
	show_hide_form(2);
	$('#cargando-1-fomulario').hide();	$('#cargando-2-fomulario').show();
	$('#cargando-3-fomulario').hide();	$('#cargando-4-fomulario').show();  
	
	$.post("../ajax/usuario.php?op=mostrar", { idusuario: idusuario }, function (e, status) {
		e = JSON.parse(e);

		$.post(`../ajax/ajax_general.php?op=select2_usuario_trabajador&id=${idusuario}`, function (e2, textStatus, jqXHR) {
      e2 = JSON.parse(e2);
			$("#idpersona").html(e2.data);

			$("#idusuario").val(e.data.idusuario);
			$("#idpersona").val(e.data.idpersona).trigger("change");
			$("#cargo").val(e.data.cargo_trabajador);

			$("#email").val(e.data.email);		
			$("#login").val(e.data.login);		
      
      $("#clave").rules( "remove", "required" );

			$.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (e3) {
				$("#permisos").html(e3);
				$.post("../ajax/usuario.php?op=series&id=" + idusuario, function (e4) {
					$("#series").html(e4);
					$('#cargando-1-fomulario').show();	$('#cargando-2-fomulario').hide();
					$('#cargando-3-fomulario').show();	$('#cargando-4-fomulario').hide();
          $('#form-agregar-usuario').valid();
				});
			});
		});
	});	
}

function ver_cargo() {
	
	$('.charge_cargo').html(`<div class="spinner-border spinner-border-sm" role="status"></div>`);	
	
  var id = $('#idpersona').val() == '' || $('#idpersona').val() == null ? '0' : $('#idpersona').val();
	$.post("../ajax/usuario.php?op=cargo_persona", { idpersona: id }, function (e, status) {
    e = JSON.parse(e);	
    $('#cargo').val(e.data.cargo_trabajador);
    $('.charge_cargo').html('');
	});	
}

//Función para desactivar registros
function desactivar(idusuario, nombre) {
	$('.tooltip').remove();
	crud_eliminar_papelera(
    "../ajax/usuario.php?op=papelera",
    "../ajax/usuario.php?op=eliminar", 
    idusuario, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){ tabla_bancos.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}


//Función para activar registros
function activar(idusuario, nombre) {
	crud_simple_alerta(
		"../ajax/bancos.php?op=desactivar_bancos",
    idusuario, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
		`Aceptar`,
    function(){ sw_success('Recuperado', "Tu registro ha sido restaurado." ) }, 
    function(){ tabla_bancos.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}

function ver_password(click) {
  var x = document.getElementById("clave"); 
	//var y = document.getElementById("confirm_password");
  if (x.type === "password") {
    x.type = "text"; 
		//y.type = "text"; 
		$('#icon-view-password').html(`<i class="fa-solid fa-eye-slash text-white"></i>`); 
    $(click).attr('data-original-title', 'Ocultar contraseña');
  } else {
    x.type = "password"; 
		//y.type = "password";  
		$('#icon-view-password').html(`<i class="fa-solid fa-eye text-white"></i>`);
    $(click).attr('data-original-title', 'Ver contraseña');
  }

  $('[data-toggle="tooltip"]').tooltip();
}

function historial_sesion(id) {
  $('#modal-ver-historial-sesion').modal('show');
  tabla_historial = $('#tabla-historial-sesion').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-2'B><'col-md-3 float-left'l><'col-md-7'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_historial) { tabla_historial.ajax.reload(null, false); } } },      
    ],
		"ajax":	{
			url: `../ajax/usuario.php?op=historial_sesion&id=${id}`,
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			},
      complete: function () {
        $(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');        
        $('[data-bs-toggle="tooltip"]').tooltip();
      },
		},
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != "") { $("td", row).eq(0).addClass("text-center"); }
      // columna: sub total
      if (data[1] != "") { $("td", row).eq(1).addClass("text-nowrap"); } 
    },
		language: {
      lengthMenu: "_MENU_",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...',
      emptyTable: "No hay datos"
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[2, "desc"]]//Ordenar (columna,orden)
	}).DataTable();

}

$(document).ready(function () {
  init();
});

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {
  $('#tipo_documento').on('change', function() { $(this).trigger('blur'); });
  $('#idcargo_trabajador').on('change', function() { $(this).trigger('blur'); });
  $('#distrito').on('change', function() { $(this).trigger('blur'); });
  $('#idbanco').on('change', function() { $(this).trigger('blur'); });
  $("#form-agregar-trabajador").validate({
    ignore: "",
    rules: {           
      tipo_documento:           { required: true, minlength: 1, maxlength: 2, },       
      numero_documento:    			{ required: true, minlength: 8, maxlength: 20, },       
      idcargo_trabajador:    		{ required: true, },       
      nombre_razonsocial:    		{ required: true, minlength: 4, maxlength: 200, },       
      apellidos_nombrecomercial:{ required: true, minlength: 4, maxlength: 200, },       
      correo:    			          { minlength: 4, maxlength: 100, },       
      celular:    			        { minlength: 8, maxlength: 9, },       
      fecha_nacimiento:    			{  },  

      ruc:    			            { minlength: 4, maxlength: 11, },       
      usuario_sol:    			    { minlength: 4, maxlength: 20, },       
      clave_sol:    			      { minlength: 4, maxlength: 20, },       
      direccion:    			      { minlength: 4, maxlength: 20, },       
      distrito:    			        { required: true, },       
      departamento:    			    { required: true, },       
      provincia:    			      { required: true, },  
      ubigeo:    			          { required: true, },

      sueldo_mensual:    			  { minlength: 4, maxlength: 20, },
      sueldo_diario:    			  { minlength: 4, maxlength: 20, },
      idbanco:    			        { required: true, minlength: 4, maxlength: 20, },
      cuenta_bancaria:    			{ minlength: 4, maxlength: 45, },
      cci:    			            { minlength: 4, maxlength: 45, },
      titular_cuenta:    			  { minlength: 4, maxlength: 45, },

			
    },
    messages: {     
      tipo_documento:    			  { required: "Campo requerido", },
      numero_documento:    			{ required: "Campo requerido", }, 
      idcargo_trabajador:    		{ required: "Campo requerido", }, 
      nombre_razonsocial:    		{ required: "Campo requerido", }, 
      apellidos_nombrecomercial:{ required: "Campo requerido", }, 
      correo:    			          { minlength: "Mínimo {0} caracteres.", }, 
      celular:    			        { minlength: "Mínimo {0} caracteres.", }, 
      fecha_nacimiento:    			{  }, 

      ruc:    			            { minlength: "Mínimo {0} caracteres.", }, 
      usuario_sol:    			    { minlength: "Mínimo {0} caracteres.", }, 
      clave_sol:    			      { minlength: "Mínimo {0} caracteres.", }, 
      direccion:    			      { minlength: "Mínimo {0} caracteres.", },
      distrito:    			        { required: "Campo requerido", }, 
      departamento:    			    { required: "Campo requerido", }, 
      provincia:    			      { required: "Campo requerido", }, 
      ubigeo:    			          { required: "Campo requerido", },

      sueldo_mensual:    			  { minlength: "Mínimo {0} caracteres.", }, 
      sueldo_diario:    			  { minlength: "Mínimo {0} caracteres.", }, 
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
      guardar_y_editar_usuario(e);      
    },
  });
  $('#tipo_documento').rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $('#idcargo_trabajador').rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $('#distrito').rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $('#idbanco').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function ver_img(img, nombre) {
	$(".title-modal-img").html(`-${nombre}`);
  $('#modal-ver-img').modal("show");
  $('.html_ver_img').html(doc_view_extencion(img, 'assets/modulo/usuario/perfil', '100%', '550'));
}

function llenar_dep_prov_ubig(input) {

  $(".chargue-pro").html(`<div class="spinner-border spinner-border-sm" role="status" ></div>`); 
  $(".chargue-dep").html(`<div class="spinner-border spinner-border-sm" role="status" ></div>`); 
  $(".chargue-ubi").html(`<div class="spinner-border spinner-border-sm" role="status" ></div>`); 

  if ($(input).select2("val") == null || $(input).select2("val") == '') { 
    $("#departamento").val(""); 
    $("#provincia").val(""); 
    $("#ubigeo").val(""); 

    $(".chargue-pro").html(''); $(".chargue-dep").html(''); $(".chargue-ubi").html('');
  } else {
    var iddistrito =  $(input).select2('data')[0].element.attributes.iddistrito.value;
    $.post(`../ajax/ajax_general.php?op=select2_distrito_id&id=${iddistrito}`, function (e) {   
      e = JSON.parse(e); console.log(e);
      $("#departamento").val(e.data.departamento); 
      $("#provincia").val(e.data.provincia); 
      $("#ubigeo").val(e.data.ubigeo_inei); 

      $(".chargue-pro").html(''); $(".chargue-dep").html(''); $(".chargue-ubi").html('');
      $("#form-cliente").valid();
    });
  }  
}

// Modificar nombre segun  el tipo de documento
$('#tipo_documento').change(function() {
  var tipo = $(this).val();

  if (tipo !== null && tipo !== '' && tipo == '6') {
    $('.label-nom-raz').html('Razón Social <sup class="text-danger">*</sup>');
    $('.label-ape-come').html('Nombre comercial <sup class="text-danger">*</sup>');
  }else{
    $('.label-nom-raz').html('Nombres <sup class="text-danger">*</sup>');
    $('.label-ape-come').html('Apellidos <sup class="text-danger">*</sup>');
  }

});
  


function reload_usr_trab(){ $('.tipo_persona_venta').html(`(trabajador)`); lista_select2("../ajax/ajax_general.php?op=select2_usuario_trabajador&id=", '#idpersona', null, '.charge_idpersona'); }
