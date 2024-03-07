var tabla_cliente;

//Función que se ejecuta al inicio
function init() {

  $("#bloc_Recurso").addClass("menu-open");

  $("#mRecurso").addClass("active");

  tabla_principal_cliente();

  $(".btn-guardar").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-cliente").submit(); } else { toastr_warning("Espera", "Procesando Datos", 3000); } });


  lista_select2("../ajax/ajax_general.php?op=select2_tipo_documento", '#tipo_documento', null);
  lista_select2("../ajax/ajax_general.php?op=select2_distrito", '#distrito', null);

  lista_select2("../ajax/persona_cliente.php?op=select2_plan", '#idplan', null);
  lista_select2("../ajax/persona_cliente.php?op=select2_zona_antena", '#idzona_antena', null);
  lista_select2("../ajax/persona_cliente.php?op=select2_trabajador", '#idpersona_trabajador', null);
  lista_select2("../ajax/persona_cliente.php?op=selec_centroProbl", '#idselec_centroProbl', null);

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#tipo_documento").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#distrito").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

  $("#idplan").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idzona_antena").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idpersona_trabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

  $("#tipo_persona_sunat").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idselec_centroProbl").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });


}

//Función limpiar
function limpiar_cliente() {

  $("#guardar_registro_cliente").html('Guardar Cambios').removeClass('disabled');

  $("#tipo_persona_sunat").val('').trigger("change");
  $("#tipo_documento").val('').trigger("change");
  $("#numero_documento").val("");
  $("#nombre_razonsocial").val("");
  $("#apellidos_nombrecomercial").val("");
  $("#fecha_nacimiento").val("");
  $("#celular").val("");
  $("#direccion").val("");
  $("#distrito").val('').trigger("change");;

  $("#correo").val("");

  $("#idpersona_trabajador").val('').trigger("change");
  $("#idzona_antena").val('').trigger("change");
  $("#idselec_centroProbl").val('').trigger("change");
  $("#idplan").val('').trigger("change");
  $("#ip_personal").val("");
  $("#fecha_afiliacion").val("");
  $("#fecha_cancelacion").val("");
  // $("#estado_descuento").val("");
  // $("#descuento").val("");

  $("#imagen").val("");
  $("#imagenactual").val("");
  $("#imagenmuestra").attr("src", "../assets/modulo/persona/perfil/no-perfil.jpg");
  $("#imagenmuestra").attr("src", "../assets/modulo/persona/perfil/no-perfil.jpg").show();
  var imagenMuestra = document.getElementById('imagenmuestra');
  if (!imagenMuestra.src || imagenMuestra.src == "") {
    imagenMuestra.src = '../assets/modulo/usuario/perfil/no-perfil.jpg';
  }


  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();

}

function wiev_tabla_formulario(flag) {

  if (flag == 1) {

    $("#seccion_cliente").show();
    $("#seccion_form").hide();

    $(".btn-agregar").show();
    $(".btn-guardar").hide();
    $(".btn-cancelar").hide();
    limpiar_cliente();

  } else if (flag == 2) {

    $("#seccion_cliente").hide();
    $("#seccion_form").show();

    $(".btn-agregar").hide();
    $(".btn-guardar").show();
    $(".btn-cancelar").show();

  }

}

//nombres segun el tipo de doc
$('#tipo_documento').change(function () {
  var tipo = $(this).val();

  if (tipo !== null && tipo !== '' && tipo == '6') {
    $('.nombre_razon').html('Razón Social <sup class="text-danger">*</sup>');
    $('.apellidos_nombrecomer').html('Nombre comercial <sup class="text-danger">*</sup>');
  } else {
    $('.nombre_razon').html('Nombres <sup class="text-danger">*</sup>');
    $('.apellidos_nombrecomer').html('Apellidos <sup class="text-danger">*</sup>');
  }

});

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
    var iddistrito = $(input).select2('data')[0].element.attributes.iddistrito.value;
    $.post(`../ajax/ajax_general.php?op=select2_distrito_id&id=${iddistrito}`, function (e) {
      e = JSON.parse(e); console.log(e);
      $("#departamento").val(e.data.departamento);
      $("#provincia").val(e.data.provincia);
      $("#ubigeo").val(e.data.ubigeo_inei);

      $(".chargue-pro").html(''); $(".chargue-dep").html(''); $(".chargue-ubi").html('');
      $("#form-agregar-cliente").valid();
    });
  }
}

function funtion_switch() {
  $("#toggleswitchSuccess").val(0);
  var isChecked = $('#toggleswitchSuccess').prop('checked');
  if (isChecked) {
    toastr_success("Estado", "Descuento Activado", 700);


    $("#estado_descuento").val(1);
    $('#descuento').removeAttr('readonly');

  } else {
    toastr_warning("Estado", "Descuento Desactivado", 700);
    $("#estado_descuento").val(0);
    $("#descuento").val('0');
    $("#monto_descuento").val('0.00');
    $('#descuento').attr('readonly', 'readonly');

  }
}


//Función Listar
function tabla_principal_cliente() {

  tabla_cliente = $('#tabla-cliente').dataTable({
    lengthMenu: [[-1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200,]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: "<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function (e, dt, node, config) { if (tabla) { tabla.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true, },
      { extend: 'excel', exportOptions: { columns: [0, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, title: 'Lista de Clientes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true, },
      { extend: 'pdf', exportOptions: { columns: [0, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, title: 'Lista de Clientes', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL', },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax: {
      url: '../ajax/persona_cliente.php?op=tabla_principal_cliente',
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
        // $('[data-bs-toggle="tooltip"]').tooltip();
      },
    },
    createdRow: function (row, data, ixdex) {
      // columna: #
      // if (data[6] != '') { $("td", row).eq(6).addClass("text-center"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[2, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      { targets: [9, 10, 11, 12, 13, 14, 15, 16, 17], visible: false, searchable: false, },
    ],
  }).DataTable();
}

//Función para guardar o editar
function guardar_y_editar_cliente(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-agregar-cliente")[0]);

  $.ajax({
    url: "../ajax/persona_cliente.php?op=guardar_y_editar_cliente",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      e = JSON.parse(e); console.log(e);
      if (e.status == true) {
        Swal.fire("Correcto!", "Color registrado correctamente.", "success");

        tabla_cliente.ajax.reload(null, false);

        limpiar_cliente();

        wiev_tabla_formulario(1);
        $("#guardar_registro_cliente").html('Guardar Cambios').removeClass('disabled');
      } else {
        ver_errores(e);
      }
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total) * 100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_cliente").css({ "width": percentComplete + '%' });
          $("#barra_progress_cliente").text(percentComplete.toFixed(2) + " %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro_cliente").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_cliente").css({ width: "0%", });
      $("#barra_progress_cliente").text("0%");
    },
    complete: function () {
      $("#barra_progress_cliente").css({ width: "0%", });
      $("#barra_progress_cliente").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

function mostrar_cliente(idpersona_cliente) {

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  limpiar_cliente();

  wiev_tabla_formulario(2);

  $.post("../ajax/persona_cliente.php?op=mostrar_cliente", { idpersona_cliente: idpersona_cliente }, function (e, status) {

    e = JSON.parse(e); console.log(e);

    if (e.status) {

      $("#idpersona").val(e.data.idpersona);
      $("#idtipo_persona").val(e.data.idtipo_persona);
      $("#idbancos").val(e.data.idbancos);
      $("#idcargo_trabajador").val(e.data.idcargo_trabajador);

      $("#idpersona_cliente").val(e.data.idpersona_cliente);

      $("#tipo_persona_sunat").val(e.data.tipo_persona_sunat).trigger("change");
      $("#tipo_documento").val(e.data.tipo_documento).trigger("change");
      $("#numero_documento").val(e.data.numero_documento);
      $("#nombre_razonsocial").val(e.data.nombre_razonsocial);
      $("#apellidos_nombrecomercial").val(e.data.apellidos_nombrecomercial);
      $("#fecha_nacimiento").val(e.data.fecha_nacimiento);
      $("#celular").val(e.data.celular);
      $("#direccion").val(e.data.direccion);
      $("#distrito").val(e.data.distrito).trigger("change");
      $("#departamento").val(e.data.departamento);
      $("#provincia").val(e.data.provincia);
      $("#ubigeo").val(e.data.cod_ubigeo);
      $("#correo").val(e.data.correo);
      $("#idpersona_trabajador").val(e.data.idpersona_trabajador).trigger("change");
      $("#idzona_antena").val(e.data.idzona_antena).trigger("change");
      $("#idselec_centroProbl").val(e.data.idcentro_poblado).trigger("change");
      $("#idplan").val(e.data.idplan).trigger("change");
      $("#ip_personal").val(e.data.ip_personal);
      $("#fecha_afiliacion").val(e.data.fecha_afiliacion);
      $("#fecha_cancelacion").val(e.data.fecha_cancelacion);
      $("#estado_descuento").val(e.data.estado_descuento);
      $("#descuento").val(e.data.descuento);

      if (e.data.estado_descuento !== null && e.data.estado_descuento !== '' && e.data.estado_descuento == '1') {

        $('#toggleswitchSuccess').prop('checked', true);
        $("#estado_descuento").val(1);
        $('#descuento').removeAttr('readonly');

      } else {
        $('#toggleswitchSuccess').prop('checked', false);

        $("#estado_descuento").val(0);
        $("#descuento").val('0');
        $("#monto_descuento").val('0.00');
        $('#descuento').attr('readonly', 'readonly');

      }

      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src", "../assets/modulo/persona/perfil/" + e.data.foto_perfil);
      $("#imagenactual").val(e.data.foto_perfil);


      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

    } else {
      ver_errores(e);
    }

  }).fail(function (e) { ver_errores(e); });
}

//Función para desactivar registros
function eliminar_cliente(idpersona_cliente, nombre) {

  crud_eliminar_papelera(
    "../ajax/persona_cliente.php?op=desactivar",
    "../ajax/persona_cliente.php?op=eliminar",
    idpersona_cliente,
    "!Elija una opción¡",
    `<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`,
    function () { sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado.") },
    function () { sw_success('Eliminado!', 'Tu registro ha sido Eliminado.') },
    function () { tabla_cliente.ajax.reload(null, false); },
    false,
    false,
    false,
    false
  );

}


init();

$(function () {
  $('#tipo_persona_sunat').on('change', function () { $(this).trigger('blur'); });
  $('#tipo_documento').on('change', function () { $(this).trigger('blur'); });
  $('#distrito').on('change', function () { $(this).trigger('blur'); });

  $('#idpersona_trabajador').on('change', function () { $(this).trigger('blur'); });
  $('#idzona_antena').on('change', function () { $(this).trigger('blur'); });
  $('#idselec_centroProbl').on('change', function () { $(this).trigger('blur'); });
  $('#idplan').on('change', function () { $(this).trigger('blur'); });

  $("#form-agregar-cliente").validate({
    rules: {

      tipo_persona_sunat: { required: true },
      tipo_documento: { required: true },
      numero_documento: { required: true },
      nombre_razonsocial: { required: true },
      apellidos_nombrecomercial: { required: true },
      distrito: { required: true },
      departamento: { required: true },
      provincia: { required: true },
      ubigeo: { required: true },
      idpersona_trabajador: { required: true },
      idzona_antena: { required: true },
      idselec_centroProbl: { required: true },
      idplan: { required: true },
      ip_personal: { required: true },
      fecha_afiliacion: { required: true },


    },
    messages: {

      tipo_persona_sunat: { required: "Campo requerido.", },
      tipo_documento: { required: "Campo requerido.", },
      numero_documento: { required: "Campo requerido.", },
      nombre_razonsocial: { required: "Campo requerido.", },
      apellidos_nombrecomercial: { required: "Campo requerido.", },
      distrito: { required: "Campo requerido.", },
      departamento: { required: "Campo requerido.", },
      provincia: { required: "Campo requerido.", },
      ubigeo: { required: "Campo requerido.", },
      idpersona_trabajador: { required: "Campo requerido.", },
      idzona_antena: { required: "Campo requerido.", },
      idselec_centroProbl: { required: "Campo requerido.", },
      idplan: { required: "Campo requerido.", },
      ip_personal: { required: "Campo requerido.", },
      fecha_afiliacion: { required: "Campo requerido.", },

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
      guardar_y_editar_cliente(e);
    },

  });

  $('#tipo_persona_sunat').rules('add', { required: true, messages: { required: "Campo requerido" } });
  $('#tipo_documento').rules('add', { required: true, messages: { required: "Campo requerido" } });
  $('#distrito').rules('add', { required: true, messages: { required: "Campo requerido" } });

  $('#idpersona_trabajador').rules('add', { required: true, messages: { required: "Campo requerido" } });
  $('#idzona_antena').rules('add', { required: true, messages: { required: "Campo requerido" } });
  $('#idselec_centroProbl').rules('add', { required: true, messages: { required: "Campo requerido" } });
  $('#ip_personal').rules('add', { required: true, messages: { required: "Campo requerido" } });
});
// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
function cambiarImagen() {
  var imagenInput = document.getElementById('imagen');
  imagenInput.click();
}
function removerImagen() {
  // var imagenMuestra = document.getElementById('imagenmuestra');
  // var imagenActualInput = document.getElementById('imagenactual');
  // var imagenInput = document.getElementById('imagen');
  // imagenMuestra.src = '../assets/images/faces/9.jpg';
  $("#imagenmuestra").attr("src", "../assets/modulo/persona/perfil/no-perfil.jpg");
  // imagenActualInput.value = '';
  // imagenInput.value = '';
  $("#imagen").val("");
  $("#imagenactual").val("");
}

// Esto se encarga de mostrar la imagen cuando se selecciona una nueva
document.addEventListener('DOMContentLoaded', function () {
  var imagenMuestra = document.getElementById('imagenmuestra');
  var imagenInput = document.getElementById('imagen');

  imagenInput.addEventListener('change', function () {
    if (imagenInput.files && imagenInput.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) { imagenMuestra.src = e.target.result; }
      reader.readAsDataURL(imagenInput.files[0]);
    }
  });
});



function ver_img(img, nombre) {
  $(".title-modal-img").html(`-${nombre}`);
  $('#modal-ver-img').modal("show");
  $('.html_ver_img').html(doc_view_extencion(img, 'assets/modulo/persona/perfil', '100%', '550'));
  $(`.jq_image_zoom`).zoom({ on: 'grab' });
}






