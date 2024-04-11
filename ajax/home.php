<?php
ob_start();

  require_once "../modelos/Home.php";
  $home = new Home();

  switch ($_GET["op"]) {

    case 'mostrar_tecnico_redes':
      $rspta = $home->mostrar_tecnico_redes();
      echo json_encode($rspta, true);

    break;

    case 'mostrar_planes':
      $rspta = $home->mostrar_planes();
      echo json_encode($rspta, true);

    break;

  }




ob_end_flush();