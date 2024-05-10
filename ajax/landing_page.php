<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); } //Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['configuracion'] == 1) {

    require_once "../modelos/Landing_page.php";

    $landing_page = new landing_page();

    $idplan                 = isset($_POST["idplan"]) ? limpiarCadena($_POST["idplan"]) : "";
    $caracteristicas = isset($_POST["caracteristicas"]) ? limpiarCadena($_POST["caracteristicas"]) : "";

    $idpreguntas_frecuentes = isset($_POST["idpreguntas_frecuentes"]) ? limpiarCadena($_POST["idpreguntas_frecuentes"]) : "";
    $pregunta_pf            = isset($_POST["pregunta_pf"]) ? limpiarCadena($_POST["pregunta_pf"]) : "";
    $respuesta_pf           = isset($_POST["respuesta_pf"]) ? limpiarCadena($_POST["respuesta_pf"]) : "";


    switch ($_GET["op"]) {

      // <<<<<<<<<<<<<<<<<<<<<<<< P L A N E S >>>>>>>>>>>>>>>>>>>>>>

      case 'tabla_principal_plan':

        require "../modelos/Plan.php";
        $plan = new plan();

        $rspta = $plan->tabla_principal_plan();
        //Vamos a declarar un array
        $data = [];
        $cont = 1;

        $toltip = '<script> $(function() { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

        if ($rspta['status'] == true) {

          foreach ($rspta['data'] as $key => $value) {

            $data[] = array(
              "0" => $cont++,
              "1" => '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar_plan(' . $value['idplan'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>'.
                     ' <button class="btn btn-icon btn-sm btn-info-light product-btn" onclick="editar_estado_landing(' . $value['idplan'] . ', \'' . encodeCadenaHtml($value['landing_estado']) . '\')" >'.
                     (($value['landing_estado'] == '1') ? '</i> <i class="fe fe-eye" data-bs-toggle="tooltip" title="Visible"></i>' : '</i> <i class="fe fe-eye-off" data-bs-toggle="tooltip" title="Oculto"></i>') .
                     '</button>',         
              "2" => $value['nombre'],
              "3" => $value['costo'],
              "4" => ($value['landing_estado'] == '1') ? '<span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Visible</span>' : '<span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Oculto</span>'
            );
          }
          $results = [
            'status'=> true,
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data,
          ];
          echo json_encode($results, true);
        } else {
          echo $rspta['code_error'] . ' - ' . $rspta['message'] . ' ' . $rspta['data'];
        }

      break;

      case 'editar_estadoLanding':
        $rspta = $landing_page->editar_estadoLanding($_POST['idplan'], $_POST['landing_estado']);
        echo json_encode($rspta, true);
      break;

      case 'editar_plan':
        $rspta = $landing_page->editar_plan($idplan, $caracteristicas);
        echo json_encode($rspta, true);
      break;


      // <<<<<<<<<<<<<<<<<<<<<<<< P R E G U N T A S   F R E C U E N T E S >>>>>>>>>>>>>>>>>>>>>>

      case 'guardar_y_editar_pregFrec':
        if (empty($idpreguntas_frecuentes)) {
          $rspta = $landing_page->insertar($pregunta_pf, $respuesta_pf);
          echo json_encode($rspta, true);
        } else {
          $rspta = $landing_page->editar($idpreguntas_frecuentes, $pregunta_pf, $respuesta_pf);
          echo json_encode($rspta, true);
        }
      break;

      case 'desactivar':
        $rspta = $landing_page->desactivar($_GET["id_tabla"]);
        echo json_encode($rspta, true);
      break;

      case 'eliminar':
        $rspta = $landing_page->eliminar($_GET["id_tabla"]);
        echo json_encode($rspta, true);
      break;

      case 'mostrar_pregFrec':
        $rspta = $landing_page->mostrar_pregFrec($idpreguntas_frecuentes);
        echo json_encode($rspta, true);
      break;

      case 'tabla_principal_PregFerct':
        $rspta = $landing_page->tabla_principal_PregFerct();
        //Vamos a declarar un array
        $data = [];
        $cont = 1;

        $toltip = '<script> $(function() { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

        if ($rspta['status'] == true) {

          foreach ($rspta['data'] as $key => $value) {

            $data[] = array(
              "0" => $cont++,
              "1" => '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar_pregFrec(' . $value['idpreguntas_frecuentes'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>'.
                ' <button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar_pregFrec(' . $value['idpreguntas_frecuentes'] . ', \'' . encodeCadenaHtml($value['pregunta']) . '\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>',         
              "2" => $value['pregunta'],
              "3" => '<div style="overflow: auto; resize: vertical; height: 70px;">'. $value['respuesta'] .'</div>',
              "4" => ($value['estado'] == '1') ? '<span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Activo</span>' : '<span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Desactivado</span>'

            );
          }
          $results = [
            'status'=> true,
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data,
          ];
          echo json_encode($results, true);
        } else {
          echo $rspta['code_error'] . ' - ' . $rspta['message'] . ' ' . $rspta['data'];
        }

      break;

      case 'salir':
        //Limpiamos las variables de sesión
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
      break;

      default:
        $rspta = ['status' => 'error_code', 'message' => 'Te has confundido en escribir en el <b>swich.</b>', 'data' => []];
        echo json_encode($rspta, true);
      break;

      }


  } else {
    $retorno = ['status'=>'nopermiso', 'message'=>'No tienes acceso a este modulo, pide acceso a tu administrador', 'data' => [], 'aaData' => [] ];
    echo json_encode($retorno);
  }  
}
ob_end_flush();
