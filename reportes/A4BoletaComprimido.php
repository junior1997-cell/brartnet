
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


  foreach ($venta['data']['detalle'] as $key => $reg) {
    $html_venta .= '<tr>
      <td class="px-1 celda-b-r-1px text-center" >'.$cont++.'</td>
      <td class="px-1 celda-b-r-1px text-center" >'.$reg['codigo'].'</td>
      <td class="px-1 celda-b-r-1px text-align">'.$reg['nombre_producto'].'</td>
      <td class="px-1 celda-b-r-1px text-center" >'.$reg['um_abreviatura'].'</td>
      <td class="px-1 celda-b-r-1px text-center" >'.$reg['cantidad'].'</td>
      <td class="px-1 celda-b-r-1px text-right" >'.number_format( floatval($reg['precio_venta']) , 2, '.',',').'</td>
      <td class="px-1 celda-b-r-1px text-right" >'.number_format(floatval($reg['descuento']) , 2, '.',',').'</td>
      <td class="px-1 celda-b-r-1px text-right">'.number_format( floatval($reg['subtotal']) , 2, '.',',').'</td>
    </tr>';
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

<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $venta['data']['venta']['nombre_comprobante'] .' - '. $venta['data']['venta']['serie_y_numero_comprobante'] ; ?></title>
  <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
  <meta name="Author" content="Spruko Technologies Private Limited">
  <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

  <!-- Bootstrap Css -->
  <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Style Css -->
  <link href="../assets/css/styles.min.css" rel="stylesheet">
  <!-- Style propio -->
  <link rel="stylesheet" href="../assets/css/style_new.css">

</head>

<body onload="window.print();" style="background-color: white !important;">

  <!-- End Switcher -->
  <div class="container-lg" >
    <div class="row justify-content-center">
      <div class="row gy-4 justify-content-center">
        <div class="col-xl-9">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">     
              <div class="d-flex flex-fill flex-wrap gap-4">
                <div class="avatar avatar-xl"><img src="<?php echo $logo_empresa; ?>" alt="" style="width: 100px; height: auto;"></div>
                <div>
                  <h6 class="mb-1 fw-semibold"><?php echo mb_convert_encoding($empresa['data']['nombre_comercial'], 'ISO-8859-1', 'UTF-8'); ?></h6>                  
                  <div class="fs-10 mb-0 "><?php echo mb_convert_encoding($empresa['data']['domicilio_fiscal'], 'ISO-8859-1', 'UTF-8'); ?></div>
                  <div class="fs-10 mb-0 text-muted contact-mail text-truncate"><?php echo mb_convert_encoding($empresa['data']['correo'], 'ISO-8859-1', 'UTF-8'); ?></div>
                  <div class="fs-10 mb-0 text-muted"><?php echo mb_convert_encoding($empresa['data']['telefono1'], 'ISO-8859-1', 'UTF-8'); ?> - <?php echo mb_convert_encoding($empresa['data']['telefono2'], 'ISO-8859-1', 'UTF-8'); ?></div>
                </div>
              </div>              
            </div>
            <div class="text-center col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
              <div class="border border-dark">
                <div class="m-2">                  
                  <h6 class="text-muted mb-2"> RUC: <?php echo $empresa['data']['numero_documento']; ?> </h6>
                  <h6>BOLETA DE VENTA ELECTRONICA</h6>
                  <h5><?php echo $venta['data']['venta']['serie_y_numero_comprobante']; ?></h5>
                </div>                
              </div>              
            </div>
          </div>
        </div>
        <div class="col-xl-9">
          <table class="font-size-10px">
            <tr>
              <th style="font-size: 12px;">Fecha de Emisión</th>
              <td style="font-size: 12px;">: <?php echo $venta['data']['venta']['fecha_emision_format']; ?></td>
            </tr>
            <tr>
              <th style="font-size: 12px;">Señor(a)</th>
              <td style="font-size: 12px;">: <?php echo $venta['data']['venta']['cliente_nombre_completo']; ?></td>
            </tr>
            <tr>
              <th style="font-size: 12px;">N° Documento</th>
              <td style="font-size: 12px;">: <?php echo $venta['data']['venta']['nombre_tipo_documento'] . ' - ' . $venta['data']['venta']['numero_documento']; ?></td>
            </tr>
            <tr>
              <th style="font-size: 12px;">Dirección</th>
              <td style="font-size: 12px;">: <?php echo $venta['data']['venta']['direccion']; ?></td>
            </tr>            
            <tr>
              <th style="font-size: 12px;">Observación</th>
              <td style="font-size: 12px;">: <?php echo $venta['data']['venta']['observacion_documento'] ; ?></td>
            </tr>
          </table>
        </div>
        
        <div class="col-xl-9">
          <div class="table-responsive">
            <table class="text-nowrap border border-dark mt-1 w-100">
              <thead class="border border-dark">
                <tr >
                  <th class="celda-b-r-1px text-center">#</th>
                  <th class="celda-b-r-1px text-center">CODIGO</th>
                  <th class="celda-b-r-1px text-center">DESCRIPTION</th>
                  <th class="celda-b-r-1px text-center">UM</th>
                  <th class="celda-b-r-1px text-center">CANTIDAD</th>
                  <th class="celda-b-r-1px text-center">PRECIO UND</th>
                  <th class="celda-b-r-1px text-center">DCTO</th>
                  <th class="celda-b-r-1px text-center">SUB TOTAL</th>
                </tr>
              </thead>
              <tbody >
              <?php echo $html_venta; ?>
                                       
              </tbody>
            </table>
          </div>
        </div>        

        <div class="col-xl-9">             
          
          <table  style="width: 100% !important;">            
            <tr>   
              <td class="font-size-12px">
                <span class="">SON: <b><?php echo $total_en_letra; ?> </b>  </span><br>
                <span class="text-muted">Representación impresa de la Nota de Venta Electrónica, puede ser consultada en <?php echo mb_convert_encoding($empresa['data']['nombre_razon_social'], 'ISO-8859-1', 'UTF-8'); ?></span>
              </td>  
              <td>
                <table class="text-nowrap w-100 table-bordered font-size-10px">
                  <tbody>
                    <tr><th class="text-center" colspan="2">CUENTAS BANCARIAS</th></tr>
                    <!-- filtramos los datos <<< SI la cuenta existe ENTONCES se muestran sus datos >>>> de lo contrario se ocultan :) ------>
                    <?php if (!empty($empresa['data']['cuenta1'])) : ?>
                      <tr>
                        <td class="px-1" rowspan="2"><?php echo $empresa['data']['banco1']; ?></td>
                        <td class="px-1">Cta: <?php echo $empresa['data']['cuenta1']; ?></td>                          
                      </tr>
                      <tr>                          
                        <td class="px-1">CCI: <?php echo $empresa['data']['cci1']; ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($empresa['data']['cuenta2'])) : ?>
                      <tr>
                        <td class="px-1" rowspan="2"><?php echo $empresa['data']['banco2']; ?></td>
                        <td class="px-1">Cta: <?php echo $empresa['data']['cuenta2']; ?></td>                        
                      </tr>
                      <tr>                        
                        <td class="px-1">CCI: <?php echo $empresa['data']['cci2']; ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($empresa['data']['cuenta3'])) : ?>
                      <tr>
                        <td class="px-1" rowspan="2"><?php echo $empresa['data']['banco3']; ?></td>
                        <td class="px-1">Cta: <?php echo $empresa['data']['cuenta3']; ?></td>                        
                      </tr>
                      <tr>                        
                        <td class="px-1">CCI: <?php echo $empresa['data']['cci3']; ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($empresa['data']['cuenta4'])) : ?>
                      <tr>
                        <td class="px-1" rowspan="2"><?php echo $empresa['data']['banco4']; ?></td>
                        <td class="px-1">Cta: <?php echo $empresa['data']['cuenta4']; ?></td>                        
                      </tr>
                      <tr>                        
                        <td class="px-1">CCI: <?php echo $empresa['data']['cci4']; ?></td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </td>                 
              <td align="center"><img src=<?php echo $logoQr; ?> width="90" height="auto"></td>
              <td>
                <div class="border border-dark rounded-1">
                  <div class="m-1">
                    <table class="text-nowrap w-100">
                      <tbody>
                        <tr>
                          <td scope="row"><p class="mb-0 font-size-12px">Sub Total</p></td> <th>:</th>
                          <td align="right"><p class="mb-0 "><?php echo $venta['data']['venta']['venta_subtotal']; ?></p></td>
                        </tr>            
                        <tr>
                          <td scope="row"><p class="mb-0 font-size-12px">Descuento </p></td><th>:</th>
                          <td align="right"><p class="mb-0 "><?php echo $venta['data']['venta']['venta_descuento']; ?></p></td>
                        </tr>  
                        <tr>
                          <td scope="row"><p class="mb-0 font-size-12px">IGV <span class="text-danger">(0%)</span> </p></td> <th>:</th>
                          <td align="right"><p class="mb-0 "><?php echo $venta['data']['venta']['impuesto']; ?></p></td>
                        </tr>            
                        <tr>
                          <th scope="row"><p class="mb-0 fs-16">Total</p></th> <th>:</th>
                          <td align="right"><p class="mb-0 fw-semibold fs-16"><?php echo $venta_total; ?></p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </td>
            </tr>    

          </table>                         
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row .gy-3 -->
    </div>
    <!-- /.row .justify-->
  </div>  

</body>

</html>

<?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>