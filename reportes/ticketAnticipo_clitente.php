<?php
require '../vendor/autoload.php';
use Luecano\NumeroALetras\NumeroALetras;
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => [] ];
  echo json_encode($retorno);
} else {
  if ($_SESSION['anticipos'] == 1) {
?>
    <html>

    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <link href="../assets/css/ticket.css" rel="stylesheet" type="text/css">
    </head>

    <body onload="window.print();">
      <?php

      $numero_a_letra = new NumeroALetras();

      require_once "../modelos/Anticipo_cliente.php";
      $anticipo = new Anticipo_cliente();

      $rspta = $anticipo->ticket_anticipo($_GET["id"]);
      $datos = $anticipo->empresa();
      
      if ($datos['status']) {
        
          ?>
          <br>
          <table border="0" align="center" width="230px">
              <tbody>
                  <tr align="center"><td><img src="../assets/modulo/empresa/logo/" width="<?php echo ($datos['data']['logo'] == 0 ? 150 : 100); ?>"> </td> </tr>
                  <tr align="center"><td style="font-size: 14px"> .::<strong> <?php echo utf8_decode(htmlspecialchars_decode($datos['data']['nombre_comercial'])); ?> </strong>::. </td> </tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo $datos['data']['nombre_razon_social']; ?></td></tr>
                  <tr align="center"><td style="font-size: 14px"><strong> R.U.C. <?php echo $datos['data']['numero_documento']; ?></strong></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode($datos['data']['domicilio_fiscal']) . ' <br> ' . $datos['data']['telefono1'] . "-" . $datos['data']['telefono2']; ?></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode(strtolower($datos['data']['correo'])); ?></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode(strtolower($datos['data']['web'])); ?></td></tr>
          <?php
        } else {echo "Error en la consulta: " . $datos['message']; } ?>

                  <tr align="center"><td>=====================================</td></tr>
                  <tr><td align="center"><strong> ANTICIPO DE CLIENTE </strong></br> <b style="font-size: 14px"><?php echo $rspta['data']['serie_comprobante']; ?>-<?php echo $rspta['data']['numero_comprobante'];?></b> </td></tr>
                  <tr align="center"><td>=====================================</td></tr>
              </tbody>
          </table>
      <table border="0" align="center" width="230px">
        <tbody>
          <tr align="left"><td><strong>Cliente:</strong></td><td><?php echo $rspta['data']['nombre_razonsocial'];?> <?php echo $rspta['data']['apellidos_nombrecomercial'];?></td></tr>
          <tr align="left"><td><strong>RUC/DNI:</strong></td><td><?php echo $rspta['data']['numero_documento']; ?></td></tr>
          <tr align="left"><td><strong>Dirección:</strong></td><td><?php echo $rspta['data']['direccion']; ?></td></tr>
          <tr align="left"><td><strong>F. de emisión:</strong></td><td><?php echo $rspta['data']['fecha_anticipo'] ?></td></tr>
          <tr align="left"><td><strong>Moneda:</strong></td><td>SOLES</td></tr>
        </tbody>
      </table>

      <br>     

      <!-- Mostramos los detalles de la venta en el documento HTML -->
      <table border="0" align="center" width="230px" style="font-size: 12px">
        <tr><td colspan="5">--------------------------------------------------------</td></tr>
        <tr><td colspan="5" align="center"><h2><b>MONTO ANTICIPO </br>s/ <?php echo $rspta['data']['total']?> </b></h2></td></tr>
        <tr><td colspan="5">--------------------------------------------------------</td></tr>
      </table>

      <?php 
        $num_total = $numero_a_letra->toInvoice( $rspta['data']['total'], 2, " SOLES" );
      ?>
      
      <table border='0'  align='center' width='230px' style='font-size: 12px' >
        <tr><td></br><strong>Pagaste: </strong> <?php echo $num_total; ?></td></tr>
      </table>   

      <!-- Mostramos los totales de la venta en el documento HTML -->
      <table border='0' width='220px' style='font-size: 12px; margin-top: 10px;' align="center">
        <tr><td align='right'><strong>TOTAL: <?php echo $rspta['data']['total'] ?></strong></td></tr>
        <tr><td colspan="5">&nbsp;</td></tr>

        <tr><td colspan="5">&nbsp;</td></tr>
        <?php if ($datos['status']) { ?> <tr><td colspan="5" align="center"><?php echo utf8_decode($datos['data']['nombre_razon_social']) ?></td></tr> <?php } ?>
        <tr><td colspan="5" align="center">::.GRACIAS POR SU COMPRA.::</td></tr>
      </table>
      <br>
    </body>    
    </html>
  <?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>