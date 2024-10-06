<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }

date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

require_once "../modelos_client/Ver_pagos.php";
$ver_pagos = new Ver_pagos();

switch ($_GET["op"]) {
  // ══════════════════════════════════════ VALIDAR SESION CLIENTE ══════════════════════════════════════
  case 'ver_pagos_cliente':

    $rspta  = $ver_pagos->ver_pagos(); 

    echo json_encode($rspta, true);

  break;

  case 'filtro_pagos_year':
    
    $rspta  = $ver_pagos->filtro_pagos_year(); 

    echo json_encode($rspta, true);
    
  break ;

  case 'filtro_pagos_month':
    
    $rspta  = $ver_pagos->filtro_pagos_month(); 

    echo json_encode($rspta, true);
    
  break ;

}

ob_end_flush();