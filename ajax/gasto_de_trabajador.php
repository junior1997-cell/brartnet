<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }

require_once "../modelos/Gasto_de_trabajador.php";
$gasto_trab = new Gasto_de_trabajador();

date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';


switch ($_GET["op"]){

  case 'listar':
    $rspta = $gasto_trab->listar();
    $data = []; $count = 1;

    if($rspta['status'] == true){

      foreach($rspta['data'] as $key => $value){
        $data[] = [
          "0" => $count++,
          "1" =>  '<div class="hstack gap-2 fs-15">' .
                    '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar()" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>'.
                    ($value['estado'] == '1' ? '<button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="desactivar()" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>':
                    '<button class="btn btn-icon btn-sm btn-success-light product-btn" onclick="activar()" data-bs-toggle="tooltip" title="Activar"><i class="fa fa-check"></i></button>').
                    '<button class="btn btn-icon btn-sm btn-info-light" onclick="mostrar()" data-bs-toggle="tooltip" title="Ver"><i class="ri-eye-line"></i></button>'.
                  '</div>',
          "2" => ($value['fecha_ingreso']),
          "3" => '<div class="d-flex align-items-center">' .
                    '<img src="../assets/images/persona/perfil/'.($value['foto_perfil']).'" alt="Avatar" class="avatar avatar-lg avatar-rounded">' .
                    '<div class="ms-3">' .
                      '<div class="fw-bold">' . htmlspecialchars($value['nombres']) . '</div>' .
                      '<div class="text-muted">' . htmlspecialchars($value['cargo']) . '</div>' .
                    '</div>' .
                  '</div>',
          "4" => 's/ '.($value['monto']),
          "5" => '<textarea class="border-0" readonly>' . htmlspecialchars($value['descripcion']) . '</textarea>',
          "6" => '<button class="btn btn-icon btn-sm btn-info-light" onclick="mostrar()" data-bs-toggle="tooltip" title="Ver"><i class="ti ti-file-dollar fs-24"></i></button>',
          "7" => ($value['estado'] == '1') ? '<span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Registrado</span>' : '<span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Invalido</span>'
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

}

ob_end_flush();