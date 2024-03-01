var tabla_usuario;
var modoDemo = false;
//Función que se ejecuta al inicio
function init() {

	listar();

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $(".btn-guardar").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-usuario").submit(); }  });

	// ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/ajax_general.php?op=select2_usuario_persona", '#idusuario', null);

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════
  $("#tipo_documento").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#cargo").select2({  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

	$("#imagenmuestra").hide();

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
 

  $.post("../ajax/usuario.php?op=permisos&id=", function (r) { $("#permisos").html(r); });
  $.post("../ajax/usuario.php?op=series&id=", function (r) { $("#series").html(r); });

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
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

$("#imagenmuestra").css("display", "block");


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
					tabla_usuario.ajax.reload();
					$('#modal-agregar-usuario').modal('hide');
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
	$('#modal-agregar-usuario').modal('show');
	$('#cargando-1-fomulario').hide();	$('#cargando-2-fomulario').show();
	$('#cargando-3-fomulario').hide();	$('#cargando-4-fomulario').show();
	$.post("../ajax/usuario.php?op=mostrar", { idusuario: idusuario }, function (e, status) {
		e = JSON.parse(e);

		$("#nombre").val(e.data.nombre);
		$("#apellidos").val(e.data.apellidos);
		$("#tipo_documento").append('<option value="' + e.data.tipo_documento + '">' + e.data.tipo_documento + '</option>');
		$("#tipo_documento").val(e.data.tipo_documento);
		//$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(e.data.num_documento);
		$("#direccion").val(e.data.direccion);
		$("#telefono").val(e.data.telefono);
		$("#email").val(e.data.email);
		$("#cargo").val(e.data.cargo);
		$("#login").val(e.data.login);
		//$("#clave").val(e.data.clave);

		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../asset/modulo/usuario/perfil/" + e.data.imagen);
		$("#imagenactual").val(e.data.imagen);
		$("#idusuario").val(e.data.idusuario);

		$.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (r) {
			$("#permisos").html(r);
			$.post("../ajax/usuario.php?op=series&id=" + idusuario, function (r) {
				$("#series").html(r);
				$.post("../ajax/usuario.php?op=permisosEmpresa&id=" + idusuario, function (r) {
					$("#empresas").html(r);
					
					$('#cargando-1-fomulario').show();	$('#cargando-2-fomulario').hide();
					$('#cargando-3-fomulario').show();	$('#cargando-4-fomulario').hide();
				});
			});
		});

	});	
}

//Función para desactivar registros
function desactivar(idusuario) {
	crud_eliminar_papelera(
    "../ajax/bancos.php?op=desactivar_bancos",
    "../ajax/bancos.php?op=eliminar_bancos", 
    idbancos, 
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
function activar(idusuario) {
	crud_simple_alerta(
		"../ajax/bancos.php?op=desactivar_bancos",
    idbancos, 
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




function cambiarImagen() {
	var imagenInput = document.getElementById('imagen');
	imagenInput.click();
}

function removerImagen() {
	var imagenMuestra = document.getElementById('imagenmuestra');
	var imagenActualInput = document.getElementById('imagenactual');
	imagenMuestra.src = '../assets/images/faces/9.jpg';
	imagenActualInput.value = '';
}

// Esto se encarga de mostrar la imagen cuando se selecciona una nueva
document.addEventListener('DOMContentLoaded', function () {
	var imagenMuestra = document.getElementById('imagenmuestra');
	var imagenInput = document.getElementById('imagen');

	imagenInput.addEventListener('change', function () {
		if (imagenInput.files && imagenInput.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				imagenMuestra.src = e.target.result;
			}

			reader.readAsDataURL(imagenInput.files[0]);
		}
	});
});


$(document).ready(function () {
	$('#tipo_documento').change(function () {
		if ($(this).val() == 'DNI') {
			$('#num_documento').focus(); // Asumiendo que tu input para ingresar el número tiene el id 'num_documento'.
		}
	});
});

$('#num_documento').keypress(function (e) {
	if (e.which == 13) { // 13 es el código de tecla para Enter
		var numero = $(this).val();
		if (numero) { // verifica si el número no está vacío
			consultaDniSunat(numero);
		} else {
			toastr_warning('Vacio!!', 'El numero de documento esta vacio, porfavor ingresa un numero.');
		}
	}
});


function consultaDniSunat(numero) {
	var dni_ruc = numero == '' || numero == null ? $('#num_documento').val() : numero;
	$('#icon-search-sr').html(`<i class='bx bx-loader bx-spin fs-5' ></i>`);
	$.ajax({
		type: 'POST',
		url: "../ajax/ajax_general.php?op=reniec_otro&dni=" + dni_ruc,
		dataType: 'json',
		beforeSend: function () {
			// Aquí puedes mostrar un loader o similar
		},
		complete: function (data) {			
			// Acciones después de completar la solicitud, por ejemplo, ocultar el loader
		},
		success: function (e) {
			console.log(e);
			if (e.status == true) {
				$("#num_documento").val(e.numeroDocumento);
				$('#nombre').val(e.nombres);
				$('#apellidos').val(e.apellidoPaterno + ' ' + e.apellidoMaterno);
			} else {
				ver_errores(e);
			}
			$('#icon-search-sr').html(`<i class='bx bx-search-alt fs-5'></i>`);
		},
		error: function (e) {
      console.log(e); toastr_error('Error!!', `Tenemos este error: ${e.statusText}`);
		}
	});
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

$(document).ready(function () {
  init();
});

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {
  $('#cargo').on('change', function() { $(this).trigger('blur'); });
  $("#form-agregar-usuario").validate({
    ignore: "",
    rules: { 
      tipo_documento: { required: true, },
      num_documento:  { required: true, },
      nombre:  				{ required: true, },
      apellidos:      { required: true, },
      direccion:      { required: true, minlength:2, maxlength:100 },
      email:    			{  minlength:2, maxlength:200 },
      telefono:       { required: true, minlength:5, maxlength:12 },
      cargo:          { required: true,   },       
      clave:    			{ required: true,   },       
      imagen:         { extension: "png|jpg|jpeg|webp|svg",  }, 
			login:          { required: true, minlength: 4, maxlength: 20,
        remote: {
          url: "../ajax/usuario.php?op=validar_usuario",
          type: "get",
          data: {
            action: function () { return "checkusername";  },
            username: function() { var username = $("#login").val(); return username; },
            idusuario: function() { var idusuario = $("#idusuario").val(); return idusuario; }
          }
        }
      },
    },
    messages: {
      tipo_documento:	{ required: "Campo requerido", },
      num_documento:  { required: "Campo requerido", },
      nombre:  				{ required: "Campo requerido", },
      apellidos:      { required: "Campo requerido", },
      direccion:      { required: "Campo requerido", minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      email:    			{ minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      telefono:       { required: "Campo requerido", minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      cargo:          { required: "Campo requerido",  },
      login:    			{ required: "Campo requerido", remote:"Usuario en uso."},
      clave:    			{ required: "Campo requerido", },      
      imagen:         { extension: "Ingrese imagenes validas ( {0} )", },
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
  $('#cargo').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
