var tabla_productos;

function init(){

  // listar_tabla();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $(".btn-guardar").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-producto").submit(); }  });

	$("#guardar_registro_categoria").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-categoria").submit(); } });
	$("#guardar_registro_marca").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-marca").submit(); } });
	$("#guardar_registro_u_m").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-u-m").submit(); } });

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/producto.php?op=select_categoria", '#categoria', null);
  lista_select2("../ajax/producto.php?op=select_u_medida", '#u_medida', null);
  lista_select2("../ajax/producto.php?op=select_marca", '#marca', null);


  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════ 
  $("#filtro_categoria").select2({  theme: "bootstrap4", placeholder: "Seleccione categoria", allowClear: true, });
  $("#filtro_unidad_medida").select2({  theme: "bootstrap4", placeholder: "Seleccione unidad medida", allowClear: true, });
  $("#filtro_marca").select2({  theme: "bootstrap4", placeholder: "Seleccione marca", allowClear: true, });

}

//  :::::::::::::::: P R O D U C T O :::::::::::::::: 

function limpiar_form_producto(){

	$('#idproducto').val('');
  
	$('#tipo').val('PR');
	$('#codigo').val('');
	$('#codigo_alterno').val('');
	$('#categoria').val('').trigger('change');
	$('#u_medida').val('58').trigger('change'); // por defecto: NIU
	$('#marca').val('').trigger('change');
	$('#nombre').val('');
	$('#descripcion').val('');
	$('#stock').val('');
	$('#stock_min').val('');
	$('#precio_v').val('');
	$('#precio_c').val('');
	$('#precio_x_mayor').val('');
	$('#precio_dist').val('');
	$('#precio_esp').val('');

  $("#imagenProducto").val("");
  $("#imagenactualProducto").val("");
  $("#imagenmuestraProducto").attr("src", "../assets/modulo/productos/no-producto.png");
  $("#imagenmuestraProducto").attr("src", "../assets/modulo/productos/no-producto.png").show();
  var imagenMuestra = document.getElementById('imagenmuestraProducto');
  if (!imagenMuestra.src || imagenMuestra.src == "") {
    imagenMuestra.src = '../assets/modulo/productos/no-producto.png';
  }


  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

function show_hide_form(flag) {
	if (flag == 1) {
    $(".card-header").show();
		$("#div-tabla").show();
		$(".div-form").hide();

		$(".btn-agregar").show();
		$(".btn-guardar").hide();
		$(".btn-cancelar").hide();
		
	} else if (flag == 2) {
    $(".card-header").hide();
		$("#div-tabla").hide();
		$(".div-form").show();

		$(".btn-agregar").hide();
		$(".btn-guardar").show();
		$(".btn-cancelar").show();
	}
}

function listar_tabla(filtro_categoria = '', filtro_unidad_medida = '', filtro_marca = ''){
  tabla_productos = $('#tabla-productos').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_productos) { tabla_productos.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [0,13,14,12,10,11,4,5,6,7,8], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [0,13,14,12,10,11,4,5,6,7,8], }, title: 'Lista de Productos', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [0,13,14,12,10,11,4,5,6,7,8], }, title: 'Lista de Productos', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    "ajax":	{
			url: `../ajax/producto.php?op=listar_tabla&categoria=${filtro_categoria}&unidad_medida=${filtro_unidad_medida}&marca=${filtro_marca}`,
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
        $('.buscando_tabla').hide()
      },
      dataSrc: function (e) {
				if (e.status != true) {  ver_errores(e); }  return e.aaData;
			},
		},
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); }
      // columna: #
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap text-center") }
      // columna: #
      if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
      // columna: 5
      if (data[15] == 1 ) { $("td", row).eq(1).attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'No tienes opcion a modificar'); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]],
    columnDefs:[
      { targets: [10,11,12,13,14,15],  visible: false,  searchable: false,  },
    ],
  }).DataTable();
}


function mostrar_producto(idproducto){
  limpiar_form_producto();
	show_hide_form(2);
	$('#cargando-1-fomulario').hide();	$('#cargando-2-fomulario').show(); 
	$.post("../ajax/producto.php?op=mostrar", { idproducto: idproducto }, function (e, status) {
		e = JSON.parse(e);

		$('#idproducto').val(e.data.idproducto);
    $('#categoria').val(e.data.idcategoria).trigger('change');
    $('#u_medida').val(e.data.idsunat_unidad_medida).trigger('change');
    $('#marca').val(e.data.idmarca).trigger('change');

    $('#codigo').val(e.data.codigo);
    $('#codigo_alterno').val(e.data.codigo_alterno);
    $('#nombre').val(e.data.nombre);
    $('#descripcion').val(e.data.descripcion);
    $('#stock').val(e.data.stock);
    $('#stock_min').val(e.data.stock_minimo);
    $('#precio_v').val(e.data.precio_venta);
    $('#precio_c').val(e.data.precio_compra);
    $('#precio_x_mayor').val(e.data.precioB);
    $('#precio_dist').val(e.data.precioC);
    $('#precio_esp').val(e.data.precioD);

    $("#imagenmuestraProducto").show();
		$("#imagenmuestraProducto").attr("src", "../assets/modulo/productos/" + e.data.imagen);
		$("#imagenactualProducto").val(e.data.imagen);

    $('#cargando-1-fomulario').show();	$('#cargando-2-fomulario').hide();
    $('#form-agregar-producto').valid();
	});	
}

function mostrar_detalle_producto(idproducto){
  $("#modal-ver-detalle-producto").modal('show');
  $.post("../ajax/producto.php?op=mostrar_detalle_producto", { idproducto: idproducto }, function (e, status) {
    e = JSON.parse(e);
    if (e.status == true) {

      $("#html-detalle-producto").html(e.data);
      $("#html-detalle-imagen").html(doc_view_download_expand(e.imagen, 'assets/modulo/productos/', e.nombre_doc, '100%', '400px'));
      
    }else{
      ver_errores(e);
    }
  }).fail( function(e) { ver_errores(e); } );
}


$(document).ready(function () {
  init();
});

function mayus(e) {
  e.value = e.value.toUpperCase();
}


$(function () {
  $('#categoria').on('change', function() { $(this).trigger('blur'); });
  $('#u_medida').on('change', function() { $(this).trigger('blur'); });
  $('#marca').on('change', function() { $(this).trigger('blur'); });

  //  :::::::::::::::::::: F O R M U L A R I O   P R O D U C T O ::::::::::::::::::::
  $("#form-agregar-producto").validate({
    ignore: "",
    rules: {           
      codigo:         { required: true, minlength: 2, maxlength: 20, },       
      categaria:    	{ required: true },       
      u_medida:    		{ required: true },       
      marca:    			{ required: true },       
      nombre:    			{ required: true, minlength: 2, maxlength: 250,  },       
      descripcion:    { minlength: 2, maxlength: 500, },       
      stock:          { required: true, min: 0, step: 0.01,},       
      stock_min:      { required: true, min: 0, step: 0.01,}, 
      precio_v:       { required: true, min: 0, step: 0.01,},       
      precio_c:       { required: true, min: 0, step: 0.01,},	
      precio_x_mayor: { min: 0, step: 0.01,},	
      precio_dist:    { min: 0, step: 0.01,},	
      precio_esp:     { min: 0, step: 0.01,},	
      codigo_alterno: { required: true, minlength: 4, maxlength: 20,
        remote: {
          url: "../ajax/producto.php?op=validar_code_producto",
          type: "get",
          data: {
            action: function () { return "validar_codigo";  },
            idproducto: function() { var idproducto = $("#idproducto").val(); return idproducto; }
          }
        }
      },
    },
    messages: {     
      cogido:    			{ required: "Campo requerido", },
      categaria:    	{ required: "Seleccione una opción", },
      u_medida:    		{ required: "Seleccione una opción", },
      marca:    			{ required: "Seleccione una opción", },
      nombre:    			{ required: "Campo requerido", }, 
      descripcion:    { minlength: "Minimo {0} caracteres.", },       
      stock:          { required: "Campo requerido", step: 'Maximo 2 decimales.'},       
      stock_min:      { required: "Campo requerido", step: 'Maximo 2 decimales.'}, 
      precio_v:       { required: "Campo requerido", step: 'Maximo 2 decimales.'},       
      precio_c:       { required: "Campo requerido", step: 'Maximo 2 decimales.'},	
      precio_x_mayor: { step: 'Maximo 2 decimales.'},	
      precio_dist:    { step: 'Maximo 2 decimales.'},	
      precio_esp:     { step: 'Maximo 2 decimales.'},
      codigo_alterno:    			{ required: "Campo requerido", remote:"Código en uso."},
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
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600);
      guardar_editar_producto(e);      
    },
  });


  $('#categoria').rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $('#u_medida').rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $('#marca').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function reload_idcategoria(){ lista_select2("../ajax/producto.php?op=select_categoria", '#categoria', null, '.charge_idcategoria'); }
function reload_idmarca(){ lista_select2("../ajax/producto.php?op=select_marca", '#marca', null, '.charge_idmarca'); }
function reload_idunidad_medida(){ lista_select2("../ajax/producto.php?op=select_u_medida", '#u_medida', null, '.charge_idunidad_medida'); }
