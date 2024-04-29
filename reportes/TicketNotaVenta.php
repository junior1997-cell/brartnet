<?php
require '../vendor/autoload.php';
use Luecano\NumeroALetras\NumeroALetras;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

date_default_timezone_set('America/Lima'); $date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';    
$scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/venta_romero/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1){session_start();} 

if (!isset($_SESSION["user_nombre"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['facturacion'] == 1) { 
    
    require_once "../modelos/Facturacion.php";                                        // Incluímos la clase Venta
    
    $facturacion    = new Facturacion();                                              // Instanciamos a la clase con el objeto venta
    $numero_a_letra = new NumeroALetras();                                            // Instanciamos a la clase con el objeto venta

    if (!isset($_GET["id"])) { echo "Datos incompletos (indefinido)"; die(); }        // Validamos la existencia de la variable
    if (empty($_GET["id"])) {  echo "Datos incompletos (".$_GET["id"].")"; die(); }   // validamos el valor de la variable
    
    $empresa        = $facturacion->datos_empresa();    
    $venta          = $facturacion->mostrar_detalle_venta($_GET["id"]);

    $html_venta = ''; $cont = 1;

    if ( empty($venta['data']['venta']) ) { echo "Comprobante no existe"; die();  }


    // $logo_empresa = "../files\logo\\" . $empresa['data']['logo'];
    $logo_empresa = "../assets/images/brand-logos/logo1.png";

    $gravada = "";
    $exonerado = "";

    // if ($reg->nombretrib == "IGV") {
    //   $gravada = $reg->subtotal;
    //   $exonerado = "0.00";
    // } else {
      $gravada = $venta['data']['venta']['venta_subtotal'];
      $exonerado = $venta['data']['venta']['venta_subtotal'];
    // }

    // PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ================================================================================
    // require_once "../modelos/Rutas.php";
    // $rutas = new Rutas();
    // $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    // $Prutas = $Rrutas->fetch_object();
    // $rutafirma = $Prutas->rutafirma; // ruta de la carpeta FIRMA
    // $data[0] = "";

    // if ($reg->estado == '5') {
    //   $boletaFirm = $reg->numero_ruc . "-" . $reg->tipo_documento_06 . "-" . $reg->numeracion_07;
    //   $sxe = new SimpleXMLElement($rutafirma . $boletaFirm . '.xml', null, true);
    //   $urn = $sxe->getNamespaces(true);
    //   $sxe->registerXPathNamespace('ds', $urn['ds']);
    //   $data = $sxe->xpath('//ds:DigestValue');
    // } else {
    //   $data[0] = "";
    // }       

    // detalle x producto ================================================================================
    
    $cantidad = 0;
    foreach ($venta['data']['detalle'] as $key => $val) {      
    
      $html_venta .= '<tr >'.       
       '<td>' . floatval($val['cantidad'])  . '</td>' .
       '<td >' . strtolower($val['nombre_producto']) . '</td>' .
       '<td style="text-align: right;">' . number_format( floatval($val['precio_venta']) , 2, '.', ',') . '</td>' .
       '<td style="text-align: right;">' . number_format( floatval($val['subtotal']) , 2, '.', ',') . '</td>' .
       '</tr>';
      $cantidad += floatval($val['cantidad']);
    }

    // Generar QR ================================================================================
    
    $dataTxt = $empresa['data']['numero_documento'] . "|" . 6 . "|" . $venta['data']['venta']['serie_comprobante'] . "|" . 
    $venta['data']['venta']['numero_comprobante'] . "|0.00|" . $venta['data']['venta']['venta_total'] . "|" . $venta['data']['venta']['fecha_emision_format'] . "|" . 
    $venta['data']['venta']['nombre_tipo_documento'] . "|" . $venta['data']['venta']['numero_documento'] . "|";

    $filename = $venta['data']['venta']['serie_y_numero_comprobante'] . '.png';
    $qr_code = QrCode::create($dataTxt)->setEncoding(new Encoding('UTF-8'))->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)->setSize(600)->setMargin(10)->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));

    $label = Label::create( $venta['data']['venta']['serie_y_numero_comprobante'])->setTextColor(new Color(255, 0, 0)); // Create generic label  
    $writer = new PngWriter(); // Create IMG
    $result = $writer->write($qr_code, label: $label); 
    $result->saveToFile(__DIR__.'/generador-qr/ticket/'.$filename); // Save it to a file  
    $logoQr = $result->getDataUri();// Generate a data URI

    //NUMERO A LETRA ================================================================================
    $venta_total = $venta['data']['venta']['venta_total'];
    $total_en_letra = $numero_a_letra->toInvoice( $venta_total , 2, " SOLES" );     

    ?>
    <html>

    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title><?php echo $venta['data']['venta']['nombre_comprobante'] .' - '. $venta['data']['venta']['serie_y_numero_comprobante'] ; ?></title>
      
      <!-- Bootstrap Css -->
      <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Style Css -->
      <link href="../assets/css/styles.min.css" rel="stylesheet">
      <link href="../assets/css/style_new.css" rel="stylesheet">

      <!-- Style tiket -->      
      <style> @media print {  .tm_hide_print {  display: none !important;  }  } </style>
    </head>

    <body style="background-color: white; display: flex;  justify-content: center;  align-items: center;">
      
      <div class="d-block align-items-center justify-content-between tm_hide_print">
        <a  type="button" class="btn btn-outline-info p-1 mb-2 m-l-5px w-40px" href="javascript:window.print()" data-bs-toggle="tooltip" title="Imprimir Ticket">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
          </svg>
        </a>

        <button type="button" class="btn btn-warning p-1 mb-2 m-l-5px w-40px" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="decargar_imagen();">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
        </button>      
      </div>    

      <!-- codigo imprimir -->
      <div id="iframe-img-descarga" style="background-color: #f0f1f7; border-radius: 5px;">

        <br>
        <!-- Detalle de empresa -->
        <table border="0" align="center" width="230px">
          <tbody>
            <tr><td align="center"><img src="<?php echo $logo_empresa; ?>" width="<?php echo ($empresa['data']['logo_c_r'] == 0 ? 150 : 100);?>"></td></tr>
            <tr align="center"><td style="font-size: 14px">.::<strong> <?php echo mb_convert_encoding($empresa['data']['nombre_comercial'], 'ISO-8859-1', 'UTF-8'); ?> </strong>::.</td></tr>
            <tr align="center"><td style="font-size: 10px"> <?php echo mb_convert_encoding($empresa['data']['nombre_razon_social'], 'ISO-8859-1', 'UTF-8'); ?> </td></tr>
            <tr align="center"><td style="font-size: 14px"> <strong> R.U.C. <?php echo $empresa['data']['numero_documento']; ?> </strong> </td></tr>
            <tr align="center"><td style="font-size: 10px"> <?php echo mb_convert_encoding($empresa['data']['domicilio_fiscal'], 'ISO-8859-1', 'UTF-8') . ' <br> ' . mb_convert_encoding($empresa['data']['telefono1'], 'ISO-8859-1', 'UTF-8') . "-" . mb_convert_encoding($empresa['data']['telefono2'], 'ISO-8859-1', 'UTF-8'); ?> </td></tr>
            <tr align="center"><td style="font-size: 10px"> <?php echo mb_convert_encoding($empresa['data']['correo'], 'ISO-8859-1', 'UTF-8'); ?> </td></tr>
            <tr align="center"><td style="font-size: 10px"> <?php echo mb_convert_encoding($empresa['data']['web'], 'ISO-8859-1', 'UTF-8'); ?> </td></tr>
            <tr><td style="text-align: center;"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
            <tr><td align="center"> <strong style="font-size: 14px"> NOTA DE VENTA ELECTRÓNICA </strong> <br> <b style="font-size: 14px"><?php echo $venta['data']['venta']['serie_y_numero_comprobante'] ; ?> </b></td></tr>
            <tr><td style="text-align: center;"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
          </tbody>
        </table>

        <!-- Datos cliente -->
        <table border="0" align="center" width="230px" style="font-size: 12px">
          <tbody>
            <tr align="left"><td><strong>Cliente:</strong> <?php echo $venta['data']['venta']['cliente_nombre_completo'] ; ?> </td> </tr>
            <tr align="left"><td><strong>Doc.:</strong> <?php echo $venta['data']['venta']['nombre_tipo_documento'] . ' - ' . $venta['data']['venta']['numero_documento'] ; ?></td> </tr>
            <tr align="left"><td><strong>Dir.:</strong> <?php echo $venta['data']['venta']['direccion'] ; ?></td></tr>
            <tr align="left"><td><strong>Emisión:</strong> <?php echo $venta['data']['venta']['fecha_emision_format'] ; ?> </td></tr>          
            <tr align="left"><td><strong>Moneda:</strong> SOLES</td> </tr>
            <tr align="left"><td><strong>Atención:</strong> <?php echo $venta['data']['venta']['user_en_atencion']; ?> </td></tr>
            <tr><td><strong>Tipo de pago:</strong> <?php echo $venta['data']['venta']['metodo_pago'] ; ?> </td></tr>
            <tr><td><strong>Nro referencia:</strong> <?php echo $venta['data']['venta']['mp_serie_comprobante'] == null || $venta['data']['venta']['mp_serie_comprobante'] == '' ? '-': $venta['data']['venta']['mp_serie_comprobante']; ?> </td></tr>
            <tr><td><strong>Observación:</strong> <?php echo $venta['data']['venta']['observacion_documento'] ; ?> </td></tr>
          </tbody>
        </table>        

        <!-- Mostramos los detalles de la venta en el documento HTML -->
        <table border="0" align="center" style="font-size: 12px !important; width: 230px !important;">
          <thead>
            <tr><td colspan="4"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td> </tr>
            <tr><th>Cant.</th> <th>Producto</th> <th>P.U.</th> <th>Importe</th></tr>
            <tr><td colspan="4"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
          </thead>        
          <tbody style="font-size: 11px !important;">
            <?php  echo $html_venta;  ?>
          </tbody>        
        </table>      
        
        <!-- Division -->
        <table border='0'  align='center' width='230px' style='font-size: 12px' >
          <tr><td><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
          <tr></tr>
        </table>
        
        <!-- Detalles de totales sunat -->
        <table border='0'  align="center" width='230px' style='font-size: 12px'>
          <tr><td colspan="5" style="text-align: right;"><strong>Descuento </strong></td>    <td>:</td> <td style="text-align: right;"> <?php echo $venta['data']['venta']['venta_descuento']; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>Op. Gravada </strong></td>  <td>:</td> <td style="text-align: right;"> <?php echo $gravada; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>Op. Exonerado </strong></td><td>:</td> <td style="text-align: right;"> <?php echo $exonerado; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>Op. Inafecto </strong></td> <td>:</td> <td style="text-align: right;">0.00</td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>ICBPER</strong></td>        <td>:</td> <td style="text-align: right;"> <?php echo '0.00'; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>I.G.V.</strong></td>        <td>:</td> <td style="text-align: right;"> <?php echo $venta['data']['venta']['impuesto']; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>Imp. Pagado</strong></td>   <td>:</td> <td style="text-align: right;"> <?php echo $venta['data']['venta']['total_recibido']; ?> </td></tr>
          <tr><td colspan="5" style="text-align: right;"><strong>Vuelto</strong></td>        <td>:</td> <td style="text-align: right;"> <?php echo $venta['data']['venta']['total_vuelto']; ?> </td></tr>
          <!--<tr><td colspan='5'><strong>I.G.V. 18.00 </strong></td><td >:</td><td><?php echo $reg->sumatoria_igv_18_1; ?></td></tr>-->
          <tr><td colspan="5" style="text-align: right;"><strong>Importe a pagar </strong></td>         <td>:</td> <td style="text-align: right;"><strong> <?php echo $venta_total ?> </strong></td></tr>
        </table>        

        <!-- Mostramos los totales de la venta en el documento HTML -->
        <table border='0' align="center" width='230px' style='font-size: 12px' >                
          <tr><td colspan="3"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
          <tr><td colspan="3"><strong>Son: </strong> <?php echo $total_en_letra; ?> </td></tr>
          <tr><td colspan="3"><div style="border-bottom: 1px dotted black; margin-top: 8px; margin-bottom: 8px;" ></div></td></tr>
        </table>

        <br>

        <div style="text-align: center;">
          <img src=<?php echo $logoQr; ?> width="150" height="150"><br>
          <label>  <?php /*echo $reg->hashc; */ ?>  </label>
          <br>
          <br>
          <label>Representación impresa de la Nota de <br> Venta Electrónica. Este documento <br> no valido para sunat.<br>
            <?php /*echo utf8_decode(htmlspecialchars_decode($datose->webconsul)) */ ?>
          </label>
          <br>
          <br>
          <label><strong>.:: GRACIAS POR SU COMPRA ::.</strong></label>
        </div>
        <p>&nbsp;</p>

      </div>

      <!-- Popper JS -->
      <script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Dropzone JS -->
      <script src="../assets/libs/dom-to-image-master/dist/dom-to-image.min.js"></script>

      <script>
        function decargar_imagen() {
          
          var titulo = document.title; // Obtener el título de la página

          domtoimage.toJpeg(document.getElementById('iframe-img-descarga'), { quality: 0.95 }).then(function (dataUrl) {
            var link = document.createElement('a');
            link.download = `${titulo}.jpeg`;
            link.href = dataUrl;
            link.click();
          });
        }
      </script>
    </body>

    </html>
    <?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>