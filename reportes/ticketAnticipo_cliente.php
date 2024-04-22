<?php
require '../vendor/autoload.php';
use Luecano\NumeroALetras\NumeroALetras;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

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

      $rspta = $anticipo->imprimir_anticipo($_GET["id"]);
      $datos = $anticipo->empresa();

      // Generar QR
      $dataTxt = "
        Cliente: " . $rspta['data']['nombre_razonsocial'] .' ' . $rspta['data']['apellidos_nombrecomercial']. "
        Fecha Enisión: " . $rspta['data']['fecha_anticipo'] . "
        Total: " . $rspta['data']['total'] . "
        Contáctanos: ".$datos['data']['telefono1']."
      ";
      $filename = $rspta['data']['serie_comprobante'] . '-' . $rspta['data']['numero_comprobante'] . '.png';
      $qr_code = QrCode::create($dataTxt)->setEncoding(new Encoding('UTF-8'))->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)->setSize(600)->setMargin(10)->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));

      $label = Label::create( $rspta['data']['serie_comprobante'] . '-' . $rspta['data']['numero_comprobante'])->setTextColor(new Color(255, 0, 0)); // Create generic label  
      $writer = new PngWriter(); // Create IMG
      $result = $writer->write($qr_code, label: $label); 
      $result->saveToFile(__DIR__.'/generador-qr/anticipos_de_cliente/'.$filename); // Save it to a file  
      $dataUri = $result->getDataUri();// Generate a data URI
      
      
        
          ?>
          <br>
          <table border="0" align="center" width="230px">
              <tbody>
                  <tr align="center"><td><img src="../assets/modulo/empresa/logo/<?php echo ($datos['data']['logo']); ?>" width="<?php echo ($datos['data']['logo_c_r'] == 0 ? 150 : 100); ?>"> </td> </tr>
                  
                  <tr align="center">
                    <td style="font-size: 14px"> 
                      .::<strong> <?php echo utf8_decode(htmlspecialchars_decode($datos['data']['nombre_comercial'])); ?> </strong>::. 
                    </td> 
                  </tr>

                  <tr align="center"><td style="font-size: 10px"><?php echo $datos['data']['nombre_razon_social']; ?></td></tr>
                  <tr align="center"><td style="font-size: 14px"><strong> R.U.C. <?php echo $datos['data']['numero_documento']; ?></strong></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode($datos['data']['domicilio_fiscal']) . ' <br> ' . $datos['data']['telefono1'] . "-" . $datos['data']['telefono2']; ?></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode(strtolower($datos['data']['correo'])); ?></td></tr>
                  <tr align="center"><td style="font-size: 10px"><?php echo utf8_decode(strtolower($datos['data']['web'])); ?></td></tr>

                  <tr align="center"><td>=====================================</td></tr>
                  <tr><td align="center"><strong> ANTICIPO DE CLIENTE </strong></br> <b style="font-size: 14px"><?php echo $rspta['data']['serie_comprobante']; ?>-<?php echo $rspta['data']['numero_comprobante'];?></b> </td></tr>
                  <tr align="center"><td>=====================================</td></tr>
              </tbody>
          </table>

          <table border="0" align="center">
            <tbody>
              <tr><td><strong>Cliente:</strong></td><td><?php echo $rspta['data']['nombre_razonsocial'];?> <?php echo $rspta['data']['apellidos_nombrecomercial'];?></td></tr>
              <tr><td><strong>RUC/DNI:</strong></td><td><?php echo $rspta['data']['numero_documento']; ?></td></tr>
              <tr><td><strong>Dirección:</strong></td><td><?php echo $rspta['data']['direccion']; ?></td></tr>
              <tr><td><strong>F. de emisión:</strong></td><td><?php echo $rspta['data']['fecha_anticipo'] ?></td></tr>
              <tr><td><strong>Moneda:</strong></td><td>SOLES</td></tr>
            </tbody>
          </table>


      <br>     

      <!-- Mostramos los detalles de la venta en el documento HTML -->
      <table border="0" align="center" width="280px" style="font-size: 12px;">
        <tr><td align="center">----------------------------------------------------------------</td></tr>
        <tr><td align="center"><h2><b>MONTO ANTICIPO </br>s/ <?php echo $rspta['data']['total']?></b></h2></td></tr>
        <tr><td align="center">----------------------------------------------------------------</td></tr>
      </table>

      <?php 
        $num_total = $numero_a_letra->toInvoice( $rspta['data']['total'], 2, " SOLES" );
      ?>
      
      <table border='0' align='center' width="250px" style='font-size: 12px' >
        <tr><td></br><strong>Pagaste: </strong> <?php echo $num_total; ?></td></tr>
      </table>   

      <!-- Mostramos los totales de la venta en el documento HTML -->
      <table border='0' width='250px' style='font-size: 12px; margin-top: 10px;' align="center">
        <tr><td align='right'><strong>TOTAL: <?php echo $rspta['data']['total'] ?></strong></td></tr>
        <tr><td colspan="5">&nbsp;</td></tr>
        
        <tr><td align="center"><img src=<?php echo $dataUri; ?> width="90" height="auto"></td></tr>
        <tr><td colspan="5">&nbsp;</td></tr>
        <?php if ($datos['status']) { ?> <tr><td colspan="5" align="center"><?php echo utf8_decode($datos['data']['nombre_razon_social']) ?></td></tr> <?php } ?>
        <tr><td colspan="5" align="center">::.GRACIAS POR SU COMPRA.::</td></tr>
      </table>
      <br>
      <table border='0' width='250px' style='font-size: 12px; margin-top: 10px;' align="center">
        <tr><td colspan="5" align="center"><span class="text-muted">Ticket emitido. No valido para SUNAT</span></td></tr>
        
      </table>
      
    </body>    
    </html>
  <?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>