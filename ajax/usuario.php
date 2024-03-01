<?php
ob_start();

if (strlen(session_id()) < 1) { session_start(); } //Validamos si existe o no la sesión

require_once "../modelos/Usuario.php";
$usuario = new Usuario();

date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";

$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";


switch ($_GET["op"]) {
  case 'guardaryeditar':

    if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
      $imagen = $_POST["imagenactual"];
    } else {
      $ext = explode(".", $_FILES["imagen"]["name"]);
      if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
        $imagen = $date_now .'__'. random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
      }
    }
    if (empty($clave)) {
      // Si la variable $clave está vacía, se obtiene la clave actual del usuario y se usa para actualizar el registro
      $usuario_actual = $usuario->mostrar($idusuario);
      $clavehash = $usuario_actual['clave'];
    } else {
      // Si la variable $clave tiene un valor, se usa ese valor para actualizar el registro
      $clavehash = hash("SHA256", $clave);
    }

    if (empty($idusuario)) {
      $rspta = $usuario->insertar($nombre, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso'], $_POST['serie'], $_POST['empresa']);
      echo json_encode($rspta, true);
    } else {
      $rspta = $usuario->editar($idusuario, $nombre, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso'], $_POST['serie'], $_POST['empresa']);
      echo json_encode($rspta, true);
    }
  break;

  case 'desactivar':
    $rspta = $usuario->desactivar($idusuario);
    echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
  break;


  case 'activar':
    $rspta = $usuario->activar($idusuario);
    echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
  break;


  case 'mostrar':
    $rspta = $usuario->mostrar($idusuario);
    //Codificar el resultado utilizando json
    echo json_encode($rspta, true);
  break;

  case 'validar_usuario':
    $rspta = $usuario->validar_usuario($_GET["idusuario"],$_GET["login"]);
    //Codificar el resultado utilizando json
    echo json_encode($rspta, true);
  break;


  case 'listar':
    $rspta = $usuario->listar();
    //Vamos a declarar un array

    $data = array();

    while ($reg = $rspta['data']->fetch_object()) {
      // Mapear el valor numérico a su respectiva descripción
      

      $img = empty($reg->imagen) ? 'no-perfil.jpg' : $reg->imagen ;

      $data[] = array(
        "0" => '<div class="hstack gap-2 fs-15">' .
          '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar(' . $reg->idusuario . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>'.
          ($reg->estado ? '<button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="desactivar(' . $reg->idusuario . ')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>':
          '<button class="btn btn-icon btn-sm btn-success-light product-btn" onclick="activar(' . $reg->idusuario . ')" data-bs-toggle="tooltip" title="Activar"><i class="fa fa-check"></i></button>'
          ).
        '</div>'
        ,        
        "1" =>'<div class="d-flex flex-fill align-items-center">
          <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen"><span class="avatar"> <img src="../assets/modulo/usuario/perfil/' . $img . '" alt=""> </span></div>
          <div>
            <span class="d-block fw-semibold text-primary">'.$reg->nombre_razonsocial .' '. $reg->apellidos_nombrecomercial.'</span>
            <span class="text-muted">'.$reg->tipo_documento .' '. $reg->numero_documento.'</span>
          </div>
        </div>',
        "2" => $reg->login,
        "3" => $reg->cargo_trabajador,
        "4" => $reg->celular,
        "5" => $reg->correo,
        "6" => ($reg->estado) ? '<span class="badge bg-success-transparent">Activado</span>' : '<span class="badge bg-danger-transparent">Inhabilitado</span>'
      );
    }
    $results = array(
      "sEcho" => 1, //Información para el datatables
      "iTotalRecords" => count($data),  //enviamos el total registros al datatable
      "iTotalDisplayRecords" => count($data),  //enviamos el total registros a visualizar
      "aaData" => $data
    );
    echo json_encode($results);

  break;

  case 'permisos':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Permiso.php";
    $permiso = new Permiso();
    $rspta = $permiso->listar_todos_permisos();

    $id = $_GET['id'];
    $marcados = $usuario->listarmarcados($id); # Obtener los permisos asignados al usuario

    $valores = array(); # Declaramos el array para almacenar todos los permisos marcados

    foreach ($marcados['data'] as $key => $val) { array_push($valores, $val['idpermiso']); } # Almacenar los permisos asignados al usuario en el array

    //Mostramos la lista de permisos en la vista y si están o no marcados
    echo '<div class="row gy-2" >';
    foreach ($rspta['data']['agrupado'] as $key => $val1) {   
      echo '<div class="col-lg-4 col-xl-3 col-xxl-3 mt-3 mb-2" >';
      echo '<span>'.$val1['modulo'].'</span>';
      foreach ($val1['submodulo'] as $key => $val2) {
        $sw = in_array($val2['idpermiso'], $valores) ? 'checked' : '';
        echo '<div class="custom-toggle-switch d-flex align-items-center mb-1">
          <input id="permiso_' . $val2['idpermiso'] . '" name="permiso[]" type="checkbox" ' . $sw . ' value="' . $val2['idpermiso'] . '">
          <label for="permiso_' . $val2['idpermiso'] . '" class="label-primary"></label><span class="ms-3">' . $val2['submodulo'] . '</span>
        </div>';
      }  
      echo '</div>';
    }
    echo '</div>';
  break;

  case 'permisosEmpresa':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Permiso.php";
    $permiso = new Permiso();
    $rspta = $permiso->listarEmpresa();

    
    $id = $_GET['id'];
    $marcados = $usuario->listarmarcadosEmpresa($id); # Obtener los permisos asignados al usuario
  
    $valores = array(); # Declaramos el array para almacenar todos los permisos marcados

    while ($per = $marcados['data']->fetch_object()) { array_push($valores, $per->idempresa); } # Almacenar los permisos asignados al usuario en el array

    //Mostramos la lista de permisos en la vista y si están o no marcados
    echo '<div class="row gy-2" >';
    foreach ($rspta['data'] as $key => $val) {
     
      if ($key % 3 === 0) {   echo '<div class="col-lg-3" >';   } # abrimos el: col-lg-2
     
      $sw = in_array($val['idempresa'], $valores) ? 'checked' : '';
      echo '<div class="custom-toggle-switch d-flex align-items-center mb-1">
        <input id="empresa_' . $val['idempresa'] . '" name="empresa[]" type="checkbox" ' . $sw . ' value="' . $val['idempresa'] . '">
        <label for="empresa_' . $val['idempresa'] . '" class="label-primary"></label><span class="ms-3">' . $val['nombre_razon_social'] . '</span>
      </div>';
     
      if (($key + 1) % 3 === 0 || $key === count($rspta['data']) - 1) { echo "</div>"; } # cerramos el: col-lg-2
    }
    echo '</div>';
  break;

  case 'permisosEmpresaTodos':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Permiso.php";
    $permiso = new Permiso();
    $rspta = $permiso->listarEmpresa();
    $marcados = $usuario->listarmarcadosEmpresaTodos();
    //Declaramos el array para almacenar todos los permisos marcados
    $valores = array();

    //Almacenar los permisos asignados al usuario en el array
    while ($per = $marcados['data']->fetch_object()) {
      array_push($valores, $per->idempresa);
    }

    //Mostramos la lista de permisos en la vista y si están o no marcados
    echo '<div class="row gy-2" >';
    foreach ($rspta['data'] as $key => $val) {
      if ($key % 3 === 0) {   echo '<div class="col-lg-3" >';   } # abrimos el: col-lg-2
      echo '<div class="custom-toggle-switch d-flex align-items-center mb-1">
        <input id="empresa_' . $val['idempresa'] . '"  name="empresa[]" value="' . $val['idempresa'] . '" type="checkbox" >
        <label for="empresa_' . $val['idempresa'] . '" class="label-primary"></label><span class="ms-3">' . $val['nombre_razon_social'] . '</span>
      </div>';
      if (($key + 1) % 3 === 0 || $key === count($rspta['data']) - 1) { echo "</div>"; } # cerramos el: col-lg-2
    }
    echo '</div>';
  break;

  case 'series':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Numeracion.php";
    $numeracion = new Numeracion();
    $rspta = $numeracion->listarSeries();

    //Obtener los permisos asignados al usuario
    $id = $_GET['id'];
    $marcados = $usuario->listarmarcadosNumeracion($id);
    //Declaramos el array para almacenar todos los permisos marcados
    $valores = array();

    //Almacenar los permisos asignados al usuario en el array
    while ($per = $marcados['data']->fetch_object()) {
      array_push($valores, $per->idsunat_usuario_comprobante);
    }

    //Mostramos la lista de permisos en la vista y si están o no marcados
    echo '<div class="row gy-2" >';
    foreach ($rspta['data'] as $key => $val) {

      if ($key % 3 === 0) {   echo '<div class="col-lg-4 col-xl-3 col-xxl-3" >';   } # abrimos el: col-lg-2      
      
      $sw = in_array($val['idtipo_comprobante'], $valores) ? 'checked' : '';
      echo '<div class="custom-toggle-switch d-flex align-items-center mb-1">
        <input id="serie_' . $val['idtipo_comprobante'] . '" name="serie[]" value="' . $val['idtipo_comprobante'] . '" type="checkbox" ' . $sw . '>
        <label for="serie_' . $val['idtipo_comprobante'] . '" class="label-primary"></label><span class="ms-3">' . $val['abreviatura'] .': <b>'.  $val['serie'] . '-' . $val['numero'] . '</b></span>
      </div>';
      if (($key + 1) % 3 === 0 || $key === count($rspta['data']) - 1) { echo "</div>"; } # cerramos el: col-lg-2
    }
    echo '</div>';
  break;

  case 'seriesnuevo':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Numeracion.php";
    $numeracion = new Numeracion();
    $rspta = $numeracion->listarSeriesNuevo();
    
    while ($reg = $rspta['data']->fetch_object()) { 
      echo '<li> <input type="checkbox" name="serie[]" value="' . $reg->idtipo_comprobante . '">' . $reg->serie . '-' . $reg->numero . ' </li>';
    }
  break;

  case 'verificar':

    $logina   = $_POST['logina'];
    $clavea   = $_POST['clavea'];
    $st       = $_POST['st'];

    //Hash SHA256 en la contraseña
    //$clavehash=$clavea;
    $clavehash = hash("SHA256", $clavea);

    $rspta  = $usuario->verificar($logina, $clavehash);
    // $rspta2 = $usuario->onoffTempo($st);
    // $rspta3 = $usuario->consultatemporizador();    

    if (!empty($rspta['data']['usuario'])) {

      // Mapear el valor numérico a su respectiva descripción
      $cargo = '';
      switch ($rspta['data']['usuario']['cargo']) {
        case 0: $cargo = "Administrador"; break;
        case 1: $cargo = "Ventas"; break;
        case 2: $cargo = "Logistica"; break;
        case 3: $cargo = "Contabilidad"; break;
      }
      //Declaramos las variables de sesión
      $_SESSION['idusuario']      = $rspta['data']['usuario']['idusuario'];
      $_SESSION['user_nombre']    = $rspta['data']['usuario']['nombres'];
      $_SESSION['user_apellido']  = $rspta['data']['usuario']['nombres'];
      $_SESSION['user_tipo_doc']  = $rspta['data']['usuario']['tipo_documento'];
      $_SESSION['user_num_doc']   = $rspta['data']['usuario']['numero_documento'];
      $_SESSION['user_cargo']     = $cargo;
      $_SESSION['user_imagen']    = $rspta['data']['usuario']['foto_perfil'];
      $_SESSION['user_login']     = $rspta['data']['usuario']['login'];

      // $_SESSION['idusuario_empresa']  = $rspta['data']['sucursal']['idusuario_empresa'];
      // $_SESSION['idempresa']          = $rspta['data']['sucursal']['idempresa'];
      // $_SESSION['empresa_nrs']        = $rspta['data']['sucursal']['nombre_razon_social'];    
      // $_SESSION['empresa_nc']         = $rspta['data']['sucursal']['nombre_comercial'];
      // $_SESSION['empresa_ruc']        = $rspta['data']['sucursal']['numero_ruc'];     
      // $_SESSION['empresa_domicilio']  = $rspta['data']['sucursal']['domicilio_fiscal'];        
      // $_SESSION['empresa_iva']        = $rspta['data']['sucursal']['igv'];

      // $_SESSION['estadotempo']        = $rspta3['data']['estado'];      
      
      $marcados = $usuario->listarmarcados($rspta['data']['usuario']['idusuario']);         # Obtenemos los permisos del usuario
      $grupo    = $usuario->listar_grupo_marcados($rspta['data']['usuario']['idusuario']);  # Obtenemos los permisos del usuario
      // $usuario->savedetalsesion($rspta['data']['usuario']['idusuario']);                    # Guardamos los datos del usuario al iniciar sesion.

      $valores = array();           # Declaramos el array para almacenar todos los permisos marcados
      $valores_agrupado = array();  # Declaramos el array para almacenar todos los permisos marcados

      foreach ($marcados['data'] as $key => $val) { array_push($valores, $val['idpermiso']);  } # Almacenamos los permisos marcados en el array      
      
      foreach ($grupo['data'] as $key => $val) { array_push($valores_agrupado, $val['modulo']);  }  # Almacenamos los permisos marcados en el array
        
      in_array('Compras', $valores_agrupado)           ? $_SESSION['compra'] = 1             : $_SESSION['compra']           = 0;        
      in_array('Articulo', $valores_agrupado)          ? $_SESSION['articulo'] = 1           : $_SESSION['articulo']         = 0;         
      in_array('Caja', $valores_agrupado)              ? $_SESSION['caja'] = 1               : $_SESSION['caja']             = 0;       
      in_array('Realizar Venta', $valores_agrupado)    ? $_SESSION['realizar_venta'] = 1     : $_SESSION['realizar_venta']   = 0;        
      in_array('Comprobante', $valores_agrupado)       ? $_SESSION['comprobante'] = 1        : $_SESSION['comprobante']      = 0;        
      in_array('Resumen de baja', $valores_agrupado)   ? $_SESSION['resumen_de_baja'] = 1    : $_SESSION['resumen_de_baja']  = 0;         
      in_array('Reporte', $valores_agrupado)           ? $_SESSION['reporte'] = 1            : $_SESSION['reporte']          = 0;         
      in_array('Administracion', $valores_agrupado)    ? $_SESSION['administracion'] = 1     : $_SESSION['administracion']   = 0;         
      in_array('Planilla Personal', $valores_agrupado) ? $_SESSION['planilla_personal'] = 1  : $_SESSION['planilla_personal']= 0;        
      in_array('SUNAT', $valores_agrupado)             ? $_SESSION['SUNAT'] = 1              : $_SESSION['SUNAT']            = 0;        
      in_array('Empresa', $valores_agrupado)           ? $_SESSION['empresa'] = 1            : $_SESSION['empresa']          = 0;           

      // Inicio
      in_array(1, $valores) ? $_SESSION['dashboard']              = 1 : $_SESSION['dashboard'] = 0;
      // Compras
      in_array(2, $valores) ? $_SESSION['proveedores']            = 1 : $_SESSION['proveedores'] = 0;
      in_array(3, $valores) ? $_SESSION['lista_de_compras']       = 1 : $_SESSION['lista_de_compras'] = 0;
      // Articulo
      in_array(4, $valores) ? $_SESSION['producto']               = 1 : $_SESSION['producto'] = 0;
      in_array(5, $valores) ? $_SESSION['servicio']               = 1 : $_SESSION['servicio'] = 0;
      in_array(6, $valores) ? $_SESSION['categoria_y_marca']      = 1 : $_SESSION['categoria_y_marca'] = 0;
      in_array(7, $valores) ? $_SESSION['unidad_de_medida']       = 1 : $_SESSION['unidad_de_medida'] = 0;
      in_array(8, $valores) ? $_SESSION['stok_precio']            = 1 : $_SESSION['stok_precio'] = 0;
      in_array(9, $valores) ? $_SESSION['tranferencia_de_stock']  = 1 : $_SESSION['tranferencia_de_stock'] = 0;
      in_array(10, $valores) ? $_SESSION['inventario']            = 1 : $_SESSION['inventario'] = 0;
      // Caja
      in_array(11, $valores) ? $_SESSION['caja_chica']            = 1 : $_SESSION['caja_chica'] = 0;
      in_array(12, $valores) ? $_SESSION['ingreso_egreso']        = 1 : $_SESSION['ingreso_egreso'] = 0;
      // POS
      in_array(13, $valores) ? $_SESSION['POS']                   = 1 : $_SESSION['POS'] = 0;
      // Realizar Venta
      in_array(14, $valores) ? $_SESSION['boleta']                = 1 : $_SESSION['boleta'] = 0;
      in_array(15, $valores) ? $_SESSION['factura']               = 1 : $_SESSION['factura'] = 0;
      in_array(16, $valores) ? $_SESSION['nota_de_venta']         = 1 : $_SESSION['nota_de_venta'] = 0;
      in_array(17, $valores) ? $_SESSION['Cotizacion']            = 1 : $_SESSION['Cotizacion'] = 0;
      in_array(18, $valores) ? $_SESSION['nota_de_credito']       = 1 : $_SESSION['nota_de_credito'] = 0;
      in_array(19, $valores) ? $_SESSION['nota_de_debito']        = 1 : $_SESSION['nota_de_debito'] = 0;
      in_array(20, $valores) ? $_SESSION['guia_de_remision']      = 1 : $_SESSION['guia_de_remision'] = 0;
      in_array(21, $valores) ? $_SESSION['cliente']               = 1 : $_SESSION['cliente'] = 0;
      // Comprobante
      in_array(22, $valores) ? $_SESSION['estado_de_envio']       = 1 : $_SESSION['estado_de_envio'] = 0;
      in_array(23, $valores) ? $_SESSION['anulados']              = 1 : $_SESSION['anulados'] = 0;
      in_array(24, $valores) ? $_SESSION['validar_solo_factura']  = 1 : $_SESSION['validar_solo_factura'] = 0;
      in_array(25, $valores) ? $_SESSION['validar_solo_boleta']   = 1 : $_SESSION['validar_solo_boleta'] = 0;
      // Resumen de baja
      in_array(26, $valores) ? $_SESSION['anular_boleta']         = 1 : $_SESSION['anular_boleta'] = 0;
      in_array(27, $valores) ? $_SESSION['anular_factura']        = 1 : $_SESSION['anular_factura'] = 0;
      in_array(28, $valores) ? $_SESSION['anular_nota_de_credito']= 1 : $_SESSION['anular_nota_de_credito'] = 0;
      // Creditos
      in_array(29, $valores) ? $_SESSION['creditos_Pendientes']   = 1 : $_SESSION['creditos_Pendientes'] = 0;
      // Kardex
      in_array(30, $valores) ? $_SESSION['kardex_por_articulos']  = 1 : $_SESSION['kardex_por_articulos'] = 0;
      // Reporte
      in_array(31, $valores) ? $_SESSION['venta_dia_mes']         = 1 : $_SESSION['venta_dia_mes'] = 0;
      in_array(32, $valores) ? $_SESSION['venta_por_vendedor']    = 1 : $_SESSION['venta_por_vendedor'] = 0;
      in_array(33, $valores) ? $_SESSION['venta_agrupada']        = 1 : $_SESSION['venta_agrupada'] = 0;
      in_array(34, $valores) ? $_SESSION['venta_por_cliente']     = 1 : $_SESSION['venta_por_cliente'] = 0;
      in_array(35, $valores) ? $_SESSION['PLE_ventas']            = 1 : $_SESSION['PLE_ventas'] = 0;
      in_array(36, $valores) ? $_SESSION['reporte_compras']       = 1 : $_SESSION['reporte_compras'] = 0;
      in_array(37, $valores) ? $_SESSION['margen_de_ganancia']    = 1 : $_SESSION['margen_de_ganancia'] = 0;
      in_array(38, $valores) ? $_SESSION['correo_enviado']        = 1 : $_SESSION['correo_enviado'] = 0;
      // Administracion
      in_array(39, $valores) ? $_SESSION['usuario']               = 1 : $_SESSION['usuario'] = 0;
      // Planilla Personal
      in_array(40, $valores) ? $_SESSION['registrar_trabajador']  = 1 : $_SESSION['registrar_trabajador'] = 0;
      in_array(41, $valores) ? $_SESSION['tipo_de_seguro']        = 1 : $_SESSION['tipo_de_seguro'] = 0;
      in_array(42, $valores) ? $_SESSION['boleta_de_pago']        = 1 : $_SESSION['boleta_de_pago'] = 0;
      // SUNAT
      in_array(43, $valores) ? $_SESSION['tipo_de_tributos']      = 1 : $_SESSION['tipo_de_tributos'] = 0;
      in_array(44, $valores) ? $_SESSION['documento_de_identidad']= 1 : $_SESSION['documento_de_identidad'] = 0;
      in_array(45, $valores) ? $_SESSION['tipo_de_afeccion_IGV']  = 1 : $_SESSION['tipo_de_afeccion_IGV'] = 0;
      in_array(46, $valores) ? $_SESSION['correlativo_numeracion']= 1 : $_SESSION['correlativo_numeracion'] = 0;
      in_array(47, $valores) ? $_SESSION['cargar_certificado']    = 1 : $_SESSION['cargar_certificado'] = 0;
      // Empresa
      in_array(48, $valores) ? $_SESSION['empresa_configuracion'] = 1 : $_SESSION['empresa_configuracion'] = 0;
      in_array(49, $valores) ? $_SESSION['correo_SMTP']           = 1 : $_SESSION['correo_SMTP'] = 0;
      in_array(50, $valores) ? $_SESSION['notificaciones']        = 1 : $_SESSION['notificaciones'] = 0;
      

      $data = [ 'status'=>true, 'message'=>'todo okey','data'=> $rspta['data']  ];
      echo json_encode($data, true);
    }else{
      $data = [ 'status'=>true, 'message'=>'todo okey','data'=>[]   ];
      echo json_encode($data, true);
    }
    
  break;

  case 'salir':     
    session_unset();  //Limpiamos las variables de sesión  
    session_destroy(); //Destruìmos la sesión
    header("Location: ../index.php"); //Redireccionamos al login
  break;    
}

ob_end_flush();

// switch ($reg->tipo_documento) {
//   case '01': $nombres = "FACTURA";   break;
//   case '03': $nombres = "BOLETA";   break;
//   case '07': $nombres = "NOTA DE CRÉDITO"; break;
//   case '08': $nombres = "NOTA DE DEBITO"; break;
//   case '09': $nombres = "GUIA REMISION REMITENTE"; break;
//   case '12': $nombres = "TICKET DE MAQUINA REGISTRADORA"; break;
//   case '13': $nombres = "DOCUM. EMIT. POR BANC. & SEG."; break;
//   case '18': $nombres = "SBS"; break;
//   case '31': $nombres = "DOC. EMIT. POR AFP"; break;
//   case '50': $nombres = "NOTA DE PEDIDO"; break;
//   case '56': $nombres = "GUIA REMISION TRANSPOR."; break;
//   case '99': $nombres = "ORDEN DE SERVICIO"; break;
//   case '20': $nombres = "COTIZACION"; break;
//   case '30': $nombres = "DOCUMENTO COBRANZA"; break;
//   case '90': $nombres = "BOLETAS DE PAGO"; break;
//   default:  break;
// }
