<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }

require_once "../modelos/Gasto_de_trabajador.php";
$gasto_trab = new Gasto_de_trabajador();

date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

$idgasto_de_trabajador  = isset($_POST["idgasto_de_trabajador"]) ? limpiarCadena($_POST["idgasto_de_trabajador"]) : "";

$idtrabajador      = isset($_POST["idtrabajador"]) ? limpiarCadena($_POST["idtrabajador"]) : "";
$descr_gastos      = isset($_POST["descr_gastos"]) ? limpiarCadena($_POST["descr_gastos"]) : "";
$tp_comprobante    = isset($_POST["tp_comprobante"]) ? limpiarCadena($_POST["tp_comprobante"]) : "";
$serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
$fecha             = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$idproveedor       = isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "";
$sub_total         = isset($_POST["sub_total"]) ? limpiarCadena($_POST["sub_total"]) : "";
$igv               = isset($_POST["igv"]) ? limpiarCadena($_POST["igv"]) : "";
$val_igv           = isset($_POST["val_igv"]) ? limpiarCadena($_POST["val_igv"]) : "";
$total_gasto       = isset($_POST["total_gasto"]) ? limpiarCadena($_POST["total_gasto"]) : "";
$descr_comprobante = isset($_POST["descr_comprobante"]) ? limpiarCadena($_POST["descr_comprobante"]) : "";
$img_comprob       = isset($_POST["doc_old_1"]) ? limpiarCadena($_POST["doc_old_1"]) : "";


switch ($_GET["op"]){

  case 'guardar_editar':
    //guardar img_comprob fondo
    if ( !file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name']) ) {
      $img_comprob = $_POST["doc_old_1"];
      $flat_img = false; 
    } else {          
      $ext = explode(".", $_FILES["doc1"]["name"]);
      $flat_img = true;
      $img_comprob = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext);
      move_uploaded_file($_FILES["doc1"]["tmp_name"], "../assets/modulo/gasto_de_trabajador/" . $img_comprob);          
    }

    if ( empty($idgasto_de_trabajador) ) { #Creamos el registro

      $rspta = $gasto_trab->insertar($idtrabajador, $descr_gastos, $tp_comprobante, $serie_comprobante, 
      $fecha, $idproveedor, $sub_total, $igv, $val_igv, $total_gasto, $descr_comprobante, $img_comprob);
      echo json_encode($rspta, true);

    } else { # Editamos el registro

      $rspta = $gasto_trab->editar($idgasto_de_trabajador, $idtrabajador, $descr_gastos, $tp_comprobante, $serie_comprobante, 
      $fecha, $idproveedor, $sub_total, $igv, $val_igv, $total_gasto, $descr_comprobante, $img_comprob);
      echo json_encode($rspta, true);
    }


  break;

  case 'listar_tabla':
    $rspta = $gasto_trab->listar_tabla();
    $data = []; $count = 1;

    if($rspta['status'] == true){

      foreach($rspta['data'] as $key => $value){

        // -------------- CONDICIONES --------------
        $nombre_trabajador = empty($value['apellidos_nombrecomercial']) && empty($value['nombre_razonsocial']) 
          ? "Trabajador no encontrado" 
          : $value['nombre_razonsocial'] . ' ' . $value['apellidos_nombrecomercial'];

        $imagen_perfil = empty($value['foto_perfil']) ? "../assets/images/faces/21.jpg" : "../assets/images/persona/perfil/{$value['foto_perfil']}";

        $descripcion = empty($value['descripcion_comprobante']) ? '<span class="text-danger">Sin Descripción</span>' : '<textarea class="border-0" style="background-color: transparent;" readonly>' .($value['descripcion_comprobante']). '</textarea>';
      
        $data[] = [
          "0" => $count++,
          "1" =>  '<div class="hstack gap-2 fs-15">' .
                    '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar_gasto_de_trabajador('.($value['idgasto_de_trabajador']).')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>'.
                    '<button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar_gasto('.$value['idgasto_de_trabajador'].'.,\''.$value['nombre_razonsocial'].'\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>'.
                    '<button class="btn btn-icon btn-sm btn-info-light" onclick="mostrar_detalles_gasto('.($value['idgasto_de_trabajador']).')" data-bs-toggle="tooltip" title="Ver"><i class="ri-eye-line"></i></button>'.
                  '</div>',
          "2" => ($value['fecha_ingreso']),
          "3" => '<div class="d-flex align-items-center">' .
                    '<img src="'.$imagen_perfil.'" alt="Avatar" class="avatar avatar-lg avatar-rounded">' .
                    '<div class="ms-3">' .
                      '<div class="fw-bold">' . $nombre_trabajador . '</div>' .
                      '<div class="text-muted">' .$value['cargo'] . '</div>' .
                    '</div>' .
                  '</div>',
          "4" => 's/ '.($value['precio_con_igv']),
          "5" => $descripcion,
          "6" => !empty($value['comprobante']) ? '<div class="d-flex justify-content-center"><button class="btn btn-icon btn-sm btn-info-light" onclick="mostrar_comprobante('.($value['idgasto_de_trabajador']).');" data-bs-toggle="tooltip" title="Ver"><i class="ti ti-file-dollar fs-24"></i></button></div>' : 
            '<div class="d-flex justify-content-center"><button class="btn btn-icon btn-sm btn-danger-light" data-bs-toggle="tooltip" title="no encontrado"><i class="ti ti-file-alert fs-24"></i></button></div>',
          "7" => ($value['estado'] == '1') ? '<span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Registrado</span>' : '<span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Inhalido</span>'
        ];
      }
      $results =[
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
      ];
      echo json_encode($results);

    } else { echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data']; }
  break;

  case 'desactivar':
    $rspta = $gasto_trab->desactivar($_GET["id_tabla"]);
    echo json_encode($rspta, true);
  break;

  case 'eliminar':
    $rspta = $gasto_trab->eliminar($_GET["id_tabla"]);
    echo json_encode($rspta, true);
  break;

  case 'listar_trabajador':
    $rspta = $gasto_trab->listar_trabajador(); $cont = 1; $data = "";
    if($rspta['status'] == true){
      foreach ($rspta['data'] as $key => $value) {
        $data .= '<option  value=' . $value['idpersona']  . '>' . $value['nombre'] . ' '. $value['apellido'] . '</option>';
      }

      $retorno = array(
        'status' => true, 
        'message' => 'Salió todo ok', 
        'data' => '<option>SELECCIONE</option>'.$data, 
      );
      echo json_encode($retorno, true);

    } else { echo json_encode($rspta, true); }      
  break;

  case 'listar_proveedor':
    $rspta = $gasto_trab->listar_proveedor(); $cont = 1; $data = "";
    if($rspta['status'] == true){
      foreach ($rspta['data'] as $key => $value) {
        $data .= '<option  value=' . $value['idpersona']  . '>' . $value['nombre'] . ' '. $value['apellido'] . '</option>';
      }

      $retorno = array(
        'status' => true, 
        'message' => 'Salió todo ok', 
        'data' => '<option  value="1" >NINGUNO</option>'.$data, 
      );
      echo json_encode($retorno, true);

    } else { echo json_encode($rspta, true); }      
  break; 

  case 'mostrar_gasto_trabajador':
    $rspta = $gasto_trab->ver_gasto_trabajador($idgasto_de_trabajador);
    echo json_encode($rspta, true);
  break;

  case 'mostrar_detalle_gasto':
    $rspta = $gasto_trab->mostrar_detalle_gasto($idgasto_de_trabajador);
    echo json_encode($rspta, true);
  break;

  // case "select2TipoTrabajador":

  //   $rspta = $ajax_general->select2_tipo_trabajador(); $cont = 1; $data = "";

  //   if ($rspta['status'] == true) {

  //     foreach ($rspta['data'] as $key => $value) {

  //       $data .= '<option  value=' . $value['idtipo_trabajador']  . '>' . $value['nombre'] . '</option>';
  //     }

  //     $retorno = array(
  //       'status' => true, 
  //       'message' => 'Salió todo ok', 
  //       'data' => '<option  value="1" >NINGUNO</option>'.$data, 
  //     );

  //     echo json_encode($retorno, true);

  //   } else {

  //     echo json_encode($rspta, true); 
  //   }        
  // break;

}

ob_end_flush();