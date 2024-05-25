var tabla_cliente;

//Función que se ejecuta al inicio
function init() {

  $("#bloc_Recurso").addClass("menu-open");

  $("#mRecurso").addClass("active");  

  $(".btn-guardar").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-cliente").submit(); } else { toastr_warning("Espera", "Procesando Datos", 3000); } });

  // ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════ 
  lista_select2("../ajax/persona_cliente.php?op=select2_filtro_trabajador", '#filtro_trabajador', null, '.charge_filtro_trabajador');
  lista_select2("../ajax/persona_cliente.php?op=select2_filtro_dia_pago",   '#filtro_dia_pago',       null, '.charge_filtro_dia_pago');
  lista_select2("../ajax/persona_cliente.php?op=select2_filtro_plan", '#filtro_plan', null, '.charge_filtro_plan');
  lista_select2("../ajax/persona_cliente.php?op=select2_filtro_zona_antena", '#filtro_zona_antena', null, '.charge_filtro_zona_antena');

  lista_select2("../ajax/ajax_general.php?op=select2_tipo_documento", '#tipo_documento', null);
  lista_select2("../ajax/ajax_general.php?op=select2_distrito", '#distrito', null);

  lista_select2("../ajax/persona_cliente.php?op=select2_plan", '#idplan', null);
  lista_select2("../ajax/persona_cliente.php?op=select2_zona_antena", '#idzona_antena', null);
  lista_select2("../ajax/persona_cliente.php?op=select2_trabajador", '#idpersona_trabajador', null);
  lista_select2("../ajax/persona_cliente.php?op=selec_centroProbl", '#idselec_centroProbl', null);
  
  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════  
  $("#filtro_trabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_dia_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_plan").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_zona_antena").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

  $("#filtro_p_all_trabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_anio_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_dia_pago").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_plan").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#filtro_p_all_zona_antena").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  
  $("#tipo_documento").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#distrito").select2({ templateResult: templateDistrito, theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

  $("#idplan").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idzona_antena").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idpersona_trabajador").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

  $("#tipo_persona_sunat").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#idselec_centroProbl").select2({ theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
}

function templateDistrito (state) {
  //console.log(state);
  if (!state.id) { return state.text; } 
  var $state = $(`<span class="fs-11" > ${state.text}</span><span class="fs-9" > (${state.title})</span>`);
  return $state;
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
  $("#distrito").val('TOCACHE').trigger("change");;

  $("#correo").val("");

  $("#idpersona").val('');
  $("#idpersona_cliente").val('');

  $("#idpersona_trabajador").val('').trigger("change");
  $("#idzona_antena").val('').trigger("change");
  $("#idselec_centroProbl").val('').trigger("change");
  $("#idplan").val('').trigger("change");
  $("#ip_personal").val("");
  $("#fecha_afiliacion").val("");
  $("#fecha_cancelacion").val("");
  $("#usuario_microtick").val("");
  $("#nota").val("");
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
    $(".div-filtro").show();
    $("#div-tabla").show();
    $("#div-form").hide();
    $("#div-pago-x-cliente").hide();
    $("#div-pago-all-cliente").hide();

    $(".btn-agregar").show();
    $(".btn-pagos-all").show();
    $(".btn-guardar").hide();
    $(".btn-cancelar").hide();
    limpiar_cliente();

  } else if (flag == 2) { // EDITAR O REGISTRA UN CLIENTE
    $(".div-filtro").hide();
    $("#div-tabla").hide();
    $("#div-form").show();
    $("#div-pago-x-cliente").hide();
    $("#div-pago-all-cliente").hide();

    $(".btn-agregar").hide();
    $(".btn-pagos-all").hide();
    $(".btn-guardar").show();
    $(".btn-cancelar").show();
  } else if (flag == 3) { // VER PAGOS POR CLIENTE
    $(".div-filtro").hide();
    $("#div-tabla").hide();
    $("#div-form").hide();
    $("#div-pago-x-cliente").show();
    $("#div-pago-all-cliente").hide();

    $(".btn-agregar").hide();
    $(".btn-pagos-all").hide();
    $(".btn-guardar").hide();
    $(".btn-regresar").show();
  } else if (flag == 4) { // VER PAGOS TODOS CLIENTE
    $(".div-filtro").hide();
    $("#div-tabla").hide();
    $("#div-form").hide();
    $("#div-pago-x-cliente").hide();
    $("#div-pago-all-cliente").show();

    $(".btn-agregar").hide();
    $(".btn-pagos-all").hide();
    $(".btn-guardar").hide();
    $(".btn-cancelar").show();
  }  

}

//nombres segun el tipo de doc
$('#tipo_documento').change(function () {
  var tipo = $(this).val() == '' ||  $(this).val() == null ? '' : $(this).val() ;

  if (tipo == '' || tipo == '0' ) { 
    $("#numero_documento").rules('remove', 'required minlength');
    $('.nombre_razon').html('Nombres <sup class="text-danger">*</sup>');
    $('.apellidos_nombrecomer').html('Apellidos <sup class="text-danger">*</sup>');
  }else if (tipo == '1') {
    $("#numero_documento").rules('add', { required: true, minlength: 8, maxlength: 8, messages: { required: 'Campo requerido', minlength: 'Mínimo {0}', maxlength: 'Máximo {0}' } }); 
    $('.nombre_razon').html('Nombres <sup class="text-danger">*</sup>');
    $('.apellidos_nombrecomer').html('Apellidos <sup class="text-danger">*</sup>');
  }else if (tipo == '6') {
    $("#numero_documento").rules('remove', 'required');
    $('.nombre_razon').html('Razón Social <sup class="text-danger">*</sup>');
    $('.apellidos_nombrecomer').html('Nombre comercial <sup class="text-danger">*</sup>');
    $("#numero_documento").rules('add', { required: true, minlength: 11, maxlength: 11, messages: { required: 'Campo requerido', minlength: 'Mínimo {0}', maxlength: 'Máximo {0}' } }); 

  } 

  $("#form-agregar-cliente").valid();

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
      e = JSON.parse(e); 
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
function tabla_principal_cliente(filtro_trabajador, filtro_dia_pago, filtro_plan, filtro_zona_antena) {

  tabla_cliente = $('#tabla-cliente').dataTable({
    lengthMenu: [[-1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200,]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: "<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function (e, dt, node, config) { if (tabla_cliente) { tabla_cliente.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true, },
      { extend: 'excel', exportOptions: { columns: [0,9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, title: 'Lista de Clientes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true, },
      { extend: 'pdf', exportOptions: { columns: [0,9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 8], }, title: 'Lista de Clientes', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL', },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    ajax: {
      url: `../ajax/persona_cliente.php?op=tabla_principal_cliente&filtro_trabajador=${filtro_trabajador}&filtro_dia_pago=${filtro_dia_pago}&filtro_plan=${filtro_plan}&filtro_zona_antena=${filtro_zona_antena}`,
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
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,//Paginación
    "order": [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      { targets: [4], render: function (data, type) { 
        var number = $.fn.dataTable.render.number(',', '.', 0).display(data); 
        if (type === 'display') { 
          let class_dia = 'numero_positivos';           
          if(data>5){
            class_dia="bg-outline-success";
          }else if (data<=5 && data>=3){
            class_dia="bg-outline-warning";
          } else{
            class_dia="bg-outline-danger";
          }
          return `<span class="badge ${class_dia}">${number} Días.</span>`; 
        } return number; 
      }, },
      // { targets: [5], render: $.fn.dataTable.render.moment('YYYY-MM-DD', 'DD/MM/YYYY'), },
      { targets: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19], visible: false, searchable: false, },
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
      $("#usuario_microtick").val(e.data.usuario_microtick);
      $("#nota").val(e.data.nota);

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

//Función para activar registros
function activar(idusuario, nombre) {
	crud_simple_alerta(
		`../ajax/persona_cliente.php?op=activar_cliente&descripcion=`,
    idusuario, 
    "!Reactivar¡", 
    `<b class="text-success">${nombre}</b> <br> Se <b>eliminara</b> la NOTA que ha sido registrado!`, 
		`Aceptar`,
    function(){ sw_success('Recuperado', "Tu cliente ha sido restaurado." ) }, 
    function(){ tabla_cliente.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}

//Función para desactivar registros
function eliminar_cliente(idtrabajador, nombre) {
  $(".tooltip").removeClass("show").addClass("hidde");
  Swal.fire({
    title: "!Elija una opción¡",
    html: `<b class="text-danger"><del>${nombre}</del></b> <br> Al <b>dar de baja</b> Padrá encontrar el registro en la papelera! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`,
    icon: "warning",
    showCancelButton: true,
    showDenyButton: true,
    confirmButtonColor: "#17a2b8",
    denyButtonColor: "#d33",
    cancelButtonColor: "#6c757d",    
    confirmButtonText: `<i class="fas fa-times"></i> Dar de Baja`,
    denyButtonText: `<i class="fas fa-skull-crossbones"></i> Eliminar`,    
    showLoaderOnDeny: true,
    preDeny: (input) => {       
      return fetch(`../ajax/persona_cliente.php?op=eliminar_cliente&id_tabla=${idtrabajador}`).then(response => {
        console.log(response);
        if (!response.ok) { throw new Error(response.statusText) }
        return response.json();
      }).catch(error => { Swal.showValidationMessage(`<b>Solicitud fallida:</b> ${error}`); })
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    
    if (result.isConfirmed) {    
      Swal.fire({
        icon: "warning",
        title: 'Antes de dar de baja ingrese una Observación',
        input: 'textarea',        
        inputAttributes: { autocapitalize: 'off', Class: 'form-control', Placeholder: 'ejemp: Corte de servicio por falta de pago.',  },
        customClass: {
          validationMessage: 'my-validation-message',
        },
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: 'Si, dar de baja!',
        confirmButtonColor: "#28a745",
        showLoaderOnConfirm: true,
        preConfirm: (value) => {
          console.log(value);
          if (!value) {
            Swal.showValidationMessage('La <i class="fw-bold">&nbsp;NOTA&nbsp;</i> es requerido.')
          }else{            
            return fetch(`../ajax/persona_cliente.php?op=desactivar_cliente&id_tabla=${idtrabajador}&descripcion=${value}`).then(response => {
              console.log(response);
              if (!response.ok) { throw new Error(response.statusText); }
              return response.json();
            }).catch(error => { Swal.showValidationMessage(`<b>Solicitud fallida:</b> ${error}`); });
          }          
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {       
        if (result.isConfirmed) {
          if (result.value.status) {
            Swal.fire("Expulsado!", "Tu trabajador ha sido expulsado.", "success");
            tabla_cliente.ajax.reload(null, false); 
          }else{
            ver_errores(result.value);
          }     
        }
      });

    }else if (result.isDenied) {
      //op=eliminar
      if (result.value.status) {
        Swal.fire("Eliminado!", "Tu trabajador ha sido Eliminado.", "success");
        tabla_cliente.ajax.reload(null, false); 
      }else{
        ver_errores(result.value);
      }      
    }
  });
}

// .....::::::::::::::::::::::::::::::::::::: V E R   P A G O S  X  C L I E N T E   :::::::::::::::::::::::::::::::::::::::..
function ver_pagos_x_cliente(idcliente) {
  wiev_tabla_formulario(3);
  $('#div_tabla_x_cliente').html(`<div class="pt-5" ><div class="col-lg-12 text-center"><div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div></div>`);
  
  $.get(`../ajax/persona_cliente.php?op=ver_pagos_x_cliente&idcliente=${idcliente}`,  function (e, textStatus, jqXHR) {
    $('#div_tabla_x_cliente').html(e);
    
    $('[data-bs-toggle="tooltip"]').tooltip();
  });
}

// .....::::::::::::::::::::::::::::::::::::: V E R   P A G O S  ALL  C L I E N T E   :::::::::::::::::::::::::::::::::::::::..

var reload_filtro_pagos_all = false;

function cargar_fltros_pagos_all_cliente() {
  wiev_tabla_formulario(4);
  if (reload_filtro_pagos_all == false) {
    lista_select2("../ajax/persona_cliente.php?op=select2_filtro_trabajador",   '#filtro_p_all_trabajador',   null, '.charge_p_all_filtro_trabajador');
    lista_select2("../ajax/persona_cliente.php?op=select2_filtro_dia_pago",     '#filtro_p_all_dia_pago',     null, '.charge_filtro_p_all_dia_pago');
    lista_select2("../ajax/persona_cliente.php?op=select2_filtro_anio_pago",    '#filtro_p_all_anio_pago',    moment().format('YYYY'), '.charge_filtro_p_all_anio_pago');
    lista_select2("../ajax/persona_cliente.php?op=select2_filtro_plan",         '#filtro_p_all_plan',         null, '.charge_p_all_filtro_plan');
    lista_select2("../ajax/persona_cliente.php?op=select2_filtro_zona_antena",  '#filtro_p_all_zona_antena',  null, '.charge_p_all_filtro_zona_antena');
    reload_filtro_pagos_all = true;
  } else {
    filtros_pago_all();
  }
}

function ver_pagos_all_cliente(filtro_trabajador ='', filtro_dia_pago ='', filtro_anio_pago='', filtro_plan ='', filtro_zona_antena ='') {  

  $('#div_tabla_all_pagos').html(`<div class="pt-5" ><div class="col-lg-12 text-center"><div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div></div>`);
  
  $.get(`../ajax/persona_cliente.php?op=ver_pagos_all_cliente&filtro_trabajador=${filtro_trabajador}&filtro_dia_pago=${filtro_dia_pago}&filtro_anio_pago=${filtro_anio_pago}&filtro_plan=${filtro_plan}&filtro_zona_antena=${filtro_zona_antena}`,  function (e, textStatus, jqXHR) {
    $('#div_tabla_all_pagos').html(e);
    $('#id_buscando_tabla_pago_all').hide();
    $('[data-bs-toggle="tooltip"]').tooltip();
  });
}

// .....::::::::::::::::::::::::::::::::::::: V E R   P A G O S  C L I E N T E  P O R   M E S :::::::::::::::::::::::::::::::::::::::..

function pagos_cliente_x_mes(idpersona_cliente, mes, anio){

  console.log("Cliente ID: " + idpersona_cliente + ", Mes: " + mes);
  var filtroTrabajador = $('#filtro_p_all_trabajador').select2('val');
  var filtroDiaPago    = $('#filtro_p_all_dia_pago').select2('val');
  var filtroAnioPago   = anio || $('#filtro_p_all_anio_pago').select2('val');
  var filtroPlan       = $('#filtro_p_all_plan').select2('val');
  var filtroZonaAntena = $('#filtro_p_all_zona_antena').select2('val');

  if (filtroTrabajador  == '' || filtroTrabajador == 0 || filtroTrabajador  == null) { filtroTrabajador = ""; nombre_trabajador  = ""; }
  if (filtroDiaPago     == '' || filtroDiaPago    == 0 || filtroDiaPago     == null) { filtroDiaPago    = ""; nombre_dia_pago    = ""; }
  if (filtroAnioPago    == '' || filtroAnioPago   == 0 || filtroAnioPago    == null) { filtroAnioPago   = ""; nombre_anio_pago   = ""; }
  if (filtroPlan        == '' || filtroPlan       == 0 || filtroPlan        == null) { filtroPlan       = ""; nombre_plan        = ""; }
  if (filtroZonaAntena  == '' || filtroZonaAntena == 0 || filtroZonaAntena  == null) { filtroZonaAntena = ""; nombre_zona_antena = ""; }

  $("#pago-cliente-mes").modal("show");
  $('#div_tabla_pagos_Cx_mes').html(`<div class="pt-5" ><div class="col-lg-12 text-center"><div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div></div>`);

  $.get(`../ajax/persona_cliente.php?op=pagos_cliente_x_mes&id=${idpersona_cliente}&mes=${mes}&filtroA=${filtroTrabajador}&filtroB=${filtroDiaPago}&filtroC=${filtroAnioPago}&filtroD=${filtroPlan}&filtroE=${filtroZonaAntena}`,  function (e, textStatus, jqXHR) {
    $('#div_tabla_pagos_Cx_mes').html(e);
    $('#id_buscando_tabla_pago_xmes').hide();
    $('[data-bs-toggle="tooltip"]').tooltip();
  });
  
}


// .....::::::::::::::::::::::::::::::::::::: I M P R I M I R   T I C K E T :::::::::::::::::::::::::::::::::::::::..

function TickcetPagoCliente(idventa, tipo_comprobante){

  $("#pago-cliente-mes").modal('hide');
  // console.log(idventa);
  if (tipo_comprobante == '01') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-Label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - FACTURA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '03') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-Label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - BOLETA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else if (tipo_comprobante == '12') {
    var rutacarpeta = "../reportes/TicketFormatoGlobal.php?id=" + idventa;
    $("#modal-imprimir-comprobante-Label").html(`<button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('iframe_format_ticket')"><i class="ri-printer-fill"></i></button> FORMATO TICKET - NOTA DE VENTA`);
    $("#html-imprimir-comprobante").html(`<iframe name="iframe_format_ticket" id="iframe_format_ticket" src="${rutacarpeta}" border="0" frameborder="0" width="100%" style="height: 450px;" marginwidth="1" src=""> </iframe>`);
    $("#modal-imprimir-comprobante").modal("show");
  } else  {
    // toastr_warning('No Disponible', 'Tenga paciencia el formato de impresión estara listo pronto.');
    toastr_error('No Existe!!', 'Este tipo de documeno no existe en mi registro.');
  }
  
}


$(document).ready(function () {
  init();
});

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

      tipo_persona_sunat:   { required: true },
      tipo_documento:       { required: true, minlength: 1, maxlength: 2, },
      numero_documento:     { required: true, minlength: 8, maxlength: 20, number: true, },
      nombre_razonsocial:   { required: true, minlength: 2, maxlength: 200, },
      apellidos_nombrecomercial: { required: true, minlength: 4, maxlength: 200, },
      correo:    			      { minlength: 4, maxlength: 100, },       
      celular:    			    { minlength: 8, maxlength: 9, },       
      fecha_nacimiento:    	{  },  

      direccion:    			  { minlength: 4, maxlength: 200, },
      distrito:             { required: true },
      departamento:         { required: true },
      provincia:            { required: true },
      ubigeo:               { required: true },

      idpersona_trabajador: { required: true },
      idzona_antena:        { required: true },
      idselec_centroProbl:  { required: true },
      idplan:               { required: true },
      ip_personal:          { minlength: 9, maxlength: 45, },
      fecha_afiliacion:     { required: true },
      fecha_cancelacion:    { required: true },
      usuario_microtick:    { required: true, minlength: 4, maxlength: 60, },
      nota:                 { minlength: 4, maxlength: 400, },

    },
    messages: {

      tipo_persona_sunat:   { required: "Campo requerido.", },
      tipo_documento:       { required: "Campo requerido.", },
      numero_documento:     { required: "Campo requerido.", },
      nombre_razonsocial:   { required: "Campo requerido.", },
      apellidos_nombrecomercial: { required: "Campo requerido.", },
      distrito:             { required: "Campo requerido.", },
      departamento:         { required: "Campo requerido.", },
      provincia:            { required: "Campo requerido.", },
      ubigeo:               { required: "Campo requerido.", },
      idpersona_trabajador: { required: "Campo requerido.", },
      idzona_antena:        { required: "Campo requerido.", },
      idselec_centroProbl:  { required: "Campo requerido.", },
      idplan:               { required: "Campo requerido.", },
      
      fecha_afiliacion:     { required: "Campo requerido.", },

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

  var filtro_trabajador   = $("#filtro_trabajador").select2('val');
  var filtro_dia_pago     = $("#filtro_dia_pago").select2('val');  
  var filtro_plan         = $("#filtro_plan").select2('val');
  var filtro_zona_antena  = $("#filtro_zona_antena").select2('val');
  
  var nombre_trabajador   = $('#filtro_trabajador').find(':selected').text();
  var nombre_dia_pago     = ' ─ ' + $('#filtro_unidad_medida').find(':selected').text();
  var nombre_plan         = ' ─ ' + $('#filtro_plan').find(':selected').text();
  var nombre_zona_antena  = ' ─ ' + $('#filtro_zona_antena').find(':selected').text();

  
  if (filtro_trabajador == '' || filtro_trabajador == 0 || filtro_trabajador == null) { filtro_trabajador = ""; nombre_trabajador = ""; }       // filtro de trabajador  
  if (filtro_dia_pago == '' || filtro_dia_pago == 0 || filtro_dia_pago == null) { filtro_dia_pago = ""; nombre_dia_pago = ""; }                 // filtro de dia pago  
  if (filtro_plan == '' || filtro_plan == 0 || filtro_plan == null) { filtro_plan = ""; nombre_plan = ""; }                                     // filtro de plan
  if (filtro_zona_antena == '' || filtro_zona_antena == 0 || filtro_zona_antena == null) { filtro_zona_antena = ""; nombre_zona_antena = ""; }  // filtro de zona antena

  $('#id_buscando_tabla').html(`<i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando ${nombre_trabajador} ${nombre_dia_pago} ${nombre_plan}...`);
  //console.log(filtro_categoria, fecha_2, filtro_plan, comprobante);

  tabla_principal_cliente(filtro_trabajador, filtro_dia_pago, filtro_plan, filtro_zona_antena);
}

function cargando_search_pago_all() {
  $('#id_buscando_tabla_pago_all').show();  
}

function filtros_pago_all() {  

  var filtro_trabajador   = $("#filtro_p_all_trabajador").select2('val');
  var filtro_dia_pago     = $("#filtro_p_all_dia_pago").select2('val');  
  var filtro_anio_pago     = $("#filtro_p_all_anio_pago").select2('val');  
  var filtro_plan         = $("#filtro_p_all_plan").select2('val');
  var filtro_zona_antena  = $("#filtro_p_all_zona_antena").select2('val');
  
  var nombre_trabajador   = $('#filtro_p_all_trabajador').find(':selected').text();
  var nombre_dia_pago     = ' ─ ' + $('#filtro_p_all_dia_pago').find(':selected').text();
  var nombre_anio_pago     = ' ─ ' + $('#filtro_p_all_anio_pago').find(':selected').text();
  var nombre_plan         = ' ─ ' + $('#filtro_p_all_plan').find(':selected').text();
  var nombre_zona_antena  = ' ─ ' + $('#filtro_p_all_zona_antena').find(':selected').text();

  
  if (filtro_trabajador == '' || filtro_trabajador == 0 || filtro_trabajador == null) { filtro_trabajador = ""; nombre_trabajador = ""; }       // filtro de trabajador  
  if (filtro_dia_pago == '' || filtro_dia_pago == 0 || filtro_dia_pago == null) { filtro_dia_pago = ""; nombre_dia_pago = ""; }                 // filtro de dia pago  
  if (filtro_anio_pago == '' || filtro_anio_pago == 0 || filtro_anio_pago == null) { filtro_anio_pago = ""; nombre_anio_pago = ""; }                 // filtro de dia pago  
  if (filtro_plan == '' || filtro_plan == 0 || filtro_plan == null) { filtro_plan = ""; nombre_plan = ""; }                                     // filtro de plan
  if (filtro_zona_antena == '' || filtro_zona_antena == 0 || filtro_zona_antena == null) { filtro_zona_antena = ""; nombre_zona_antena = ""; }  // filtro de zona antena

  // $('#id_buscando_tabla').html(`<i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando ${nombre_trabajador} ${nombre_dia_pago} ${nombre_plan}...`);
  //console.log(filtro_categoria, fecha_2, filtro_plan, comprobante);

  ver_pagos_all_cliente(filtro_trabajador,  filtro_dia_pago, filtro_anio_pago, filtro_plan, filtro_zona_antena);
}

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

function reload_select(r_text) {

  switch (r_text) {
    case 'filtro_trabajador':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_trabajador", '#filtro_trabajador',     null, '.charge_filtro_trabajador');
    break;   
    case 'filtro_dia':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_dia_pago",   '#filtro_dia_pago',       null, '.charge_filtro_dia_pago');
    break;
    case 'filtro_plan':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_plan",       '#filtro_plan',           null, '.charge_filtro_plan');
    break;
    case 'filtro_zona_antena':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_zona_antena",'#filtro_zona_antena',    null, '.charge_filtro_zona_antena');
    break;   

    case 'filtro_p_all_trabajador':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_trabajador", '#filtro_p_all_trabajador', null, '.charge_filtro_p_all_trabajador');
    break;
    case 'filtro_dia_pago':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_dia_pago",   '#filtro_p_all_dia_pago',   null, '.charge_filtro_p_all_dia_pago');
    break;
    case 'filtro_anio_pago':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_anio_pago",  '#filtro_p_all_anio_pago',  moment().format('YYYY'), '.charge_filtro_p_all_anio_pago');
    break;    
    case 'filtro_p_all_plan':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_plan",       '#filtro_p_all_plan',       null, '.charge_filtro_p_all_plan');
    break;
    case 'filtro_p_all_zona_antena':
      lista_select2("../ajax/persona_cliente.php?op=select2_filtro_zona_antena",'#filtro_p_all_zona_antena',null, '.charge_filtro_p_all_zona_antena');
    break;   

    case 'trab':
      lista_select2("../ajax/persona_cliente.php?op=select2_trabajador", '#idpersona_trabajador', null, '.charge_idtrabaj');
    break;
    case 'zona':
      lista_select2("../ajax/persona_cliente.php?op=select2_zona_antena", '#idzona_antena', null, '.charge_idzona');
    break;
    case 'centroPbl':
      lista_select2("../ajax/persona_cliente.php?op=selec_centroProbl", '#idselec_centroProbl', null, '.charge_idctroPbl');
    break;
    case 'plan':
      lista_select2("../ajax/persona_cliente.php?op=select2_plan", '#idplan', null, '.charge_idplan');
    break;
    default:
      console.log('Caso no encontrado.');
  }
 
}

function crear_dias_pagos(input) {
  $(input).append(`<option value="TODOS">TODOS</option>`);
  for (let index = 1; index <= 31; index++) {
    $(input).append(`<option value="${index}">Día ${index}</option>`); 
  }
  
}

function crear_anio_pagos(input) {
  var anio =parseFloat(moment().format('YYYY')) + (1);
  var html = "";  
  for (let i = 1; i < 6; i++) { anio--; html = html.concat(`<option value="${anio}">${anio}</option> `); }
  $(input).html(html);
}

function printIframe(id) {
  var iframe = document.getElementById(id);
  iframe.focus(); // Para asegurarse de que el iframe está en foco
  iframe.contentWindow.print(); // Llama a la función de imprimir del documento dentro del iframe
}


