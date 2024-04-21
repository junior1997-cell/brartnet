var tbla_cliente;
var tbla_anticipo;

const choice_list_clientes = new Choices('#cliente',  {  removeItemButton: true,noResultsText: 'No hay resultados.', } );

function init() {

  tbla_pral_cliente();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_anticipo").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-anticipo").submit(); }  });
  
  lista_selectChoice("../ajax/anticipo_cliente.php?op=selectChoice_cliente", choice_list_clientes, null); 

}

function limpiar_form_anticipo(){
  
  $("#idanticipo_cliente").val("");
  $("#cliente").text(null);
  // $("#fecha").val("");
  document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
  $("#descrip").val("");
  $("#monto").val("");
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();

}

function tbla_pral_cliente(){

  tbla_cliente = $('#tabla-clientes').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-2 float-left'l><'col-md-7'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload px-2 btn btn-sm btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_plan) { tabla_plan.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,1,2], }, text: `<i class="fas fa-copy" ></i>`, className: "px-2 btn btn-sm btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,1,2], }, title: 'Lista de Clientes - Anticipo', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "px-2 btn btn-sm btn-outline-success btn-wave ", footer: true,  }, 
    ],
    "ajax":	{
			url: '../ajax/anticipo_cliente.php?op=tbla_pral_clientes',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			},
      createdRow: function (row, data, ixdex) {
        // columna: #
        if (data[3] != '') { $("td", row).eq(3).addClass("text-center"); }
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
      lengthMenu: "_MENU_",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]],
  }).DataTable();
}

function mostrar_tbla_anticipos(idpersona_cliente, nombres, apellidos){

  $("#tbl-anticipo").show();
  $("#select-user").hide();
  $nombreCompleto = nombres + ' ' + apellidos;
  $("#nomb_cliente").html($nombreCompleto);

  tbla_anticipo = $('#tabla-anticipos').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-4'B><'col-md-2 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload px-2 btn btn-sm btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tbla_anticipo) { tbla_anticipo.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,8,2,3,4,5,6,7], }, text: `<i class="fas fa-copy" ></i>`, className: "px-2 btn btn-sm btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,8,2,3,4,5,6,7], }, title: 'Lista de Anticipo Clientes', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "px-2 btn btn-sm btn-outline-success btn-wave ", footer: true,  }, 
    ],
    "ajax":	{
			url: '../ajax/anticipo_cliente.php?op=mostrar_tbla_anticipos&idpersona_cliente=' + idpersona_cliente,
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
    "drawCallback": function (settings) {
      var api = this.api();
      var suma = api.column(7, {page: 'current'}).data().reduce(function (a, b) {
          // Eliminar etiquetas HTML y luego convertir a número
          var cleanNumber = parseFloat(b.replace(/<[^>]*>/g, '').replace(/[^0-9.-]/g, ''));
          return a + (isNaN(cleanNumber) ? 0 : cleanNumber);
      }, 0);
      $('#total').html("S/ " + suma.toFixed(1));
  },
    language: {
      lengthMenu: "Mostrar: _MENU_ ",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]],
    columnDefs: [
      { targets: [8], visible: false, searchable: false, },   
    ]
  }).DataTable();
}

function guardar_editar_anticipo(e) {
  var formData = new FormData($("#form-agregar-anticipo")[0]);  

  Swal.fire({
    title: "¿Está seguro que deseas guardar este anticipo?",
    html: "Verifica que todos lo <b>campos</b>  esten <b>conformes</b>!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Guardar!",
    preConfirm: (input) => {
      return fetch("../ajax/anticipo_cliente.php?op=guardar_editar_anticipo", {
        method: 'POST',
        body: formData,      
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
        Swal.fire("Correcto!", "Anticipo guardado correctamente", "success");
        tbla_cliente.ajax.reload(null, false);
        tbla_anticipo.ajax.reload(null, false);
        limpiar_form_anticipo(); 
        $('#modal_agregar_anticipo').modal('hide');
             
      } else {
        ver_errores(result.value);
      }      
    }
  });  
}

// Imprimir Ticket
function exAnticipo_cienteTickcet(idanticipo_cliente){
  var rutacarpeta = "../reportes/ticketAnticipo_clitente.php?id=" + idanticipo_cliente;
  $("#modalAntcticket").attr("src", rutacarpeta);
  $("#modalPreviewticket").modal("show");
}

// Actualizar Serie Anticipo Cliente
function selectSerie(){
  $.post("../ajax/anticipo_cliente.php?op=selectSerie", function (r) {
    if (r == '' || r == null) {
      $(".charge-serie").html(``);
    } else {  
      $("#serie_ac").html(r);        
      var serieL = document.getElementById("serie_ac");
      var opt = serieL.value;
      $.post( "../ajax/anticipo_cliente.php?op=actualizar_numeracion&ser=" + opt, function (r) {
        var n2 = pad(r, 0);
        $("#numero_ac").val(n2);
        var SerieReal = $("#serie_ac option:selected").text();
        $("#SerieReal").val(SerieReal);
        $(".charge-numero").html(``);
      });
    }      
    $(".charge-serie").html(``);
  });
}

// Actualizar Numeración Anticipo Cliente
function actualizar_numeracion() {
  var serie = $("#serie_ac option:selected").val();
  $.post("../ajax/anticipo_cliente.php?op=actualizar_numeracion&ser=" + serie, function (r) {
    var n2 = pad(r, 0);
    $("#numero_ac").val(n2);

    var SerieReal = $("#serie_ac option:selected").text();
    $("#SerieReal").val(SerieReal);
  });
}

$(document).ready(function () {
  init();
});



$(function(){

  $("#form-agregar-anticipo").validate({
    ignore: '',
    rules: {
      cliente:  { required: true, minlength: 1 },
      fecha:    { required: true },
      monto:    { required: true, minlength: 2 }
    },
    messages: {
      cliente:  { required: "Seleccione un cliente", },
      fecha:    { required: "Campo requerido", },
      monto:    { required: "Campo requerido", },
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
      guardar_editar_anticipo(form);
    },
  }); 







});




function pad(n, length) {
  var n = n.toString();
  while (n.length < length) n = "0" + n;
  return n;
}