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

// use Melihovv\Base64ImageDecoder\Base64ImageEncoder;


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
    
    $empresa_f        = $facturacion->datos_empresa();    
    $venta_f          = $facturacion->mostrar_detalle_venta($_GET["id"]);   

    if ( empty($venta_f['data']['venta']) ) { echo "Comprobante no existe"; die();  }

    $logo_empresa = "../assets/images/brand-logos/logo1.png";      
    // $encoder = Base64ImageEncoder::fromFileName($logo_empresa, $allowedFormats = ['jpeg', 'png', 'gif']);    
    // $encoder->getMimeType(); // image/jpeg for instance
    // $encoder->getContent(); // base64 encoded image bytes.
    // $logo_empresa_b64 = $encoder->getDataUri(); // a base64 data-uri to use in HTML or CSS attributes.

    // Emrpesa emisora ================================================================================
    $e_razon_social       = mb_convert_encoding($empresa_f['data']['nombre_razon_social'], 'UTF-8', mb_detect_encoding($empresa_f['data']['nombre_razon_social'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_comercial          = mb_convert_encoding($empresa_f['data']['nombre_comercial'], 'UTF-8', mb_detect_encoding($empresa_f['data']['nombre_comercial'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_domicilio_fiscal   = mb_convert_encoding($empresa_f['data']['domicilio_fiscal'], 'UTF-8', mb_detect_encoding($empresa_f['data']['domicilio_fiscal'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_tipo_documento     = $empresa_f['data']['tipo_documento'];
    $e_numero_documento   = $empresa_f['data']['numero_documento'];
    $e_telefono1          = $empresa_f['data']['telefono1'];
    $e_telefono2          = $empresa_f['data']['telefono2'];
    $e_correo             = mb_convert_encoding($empresa_f['data']['correo'], 'UTF-8', mb_detect_encoding($empresa_f['data']['correo'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_web                = mb_convert_encoding($empresa_f['data']['web'], 'UTF-8', mb_detect_encoding($empresa_f['data']['web'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_web_consulta_cp    = mb_convert_encoding($empresa_f['data']['web_consulta_cp'], 'UTF-8', mb_detect_encoding($empresa_f['data']['web_consulta_cp'], "UTF-8, ISO-8859-1, ISO-8859-15", true));

    $e_distrito           = mb_convert_encoding($empresa_f['data']['distrito'], 'UTF-8', mb_detect_encoding($empresa_f['data']['distrito'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_provincia          = mb_convert_encoding($empresa_f['data']['provincia'], 'UTF-8', mb_detect_encoding($empresa_f['data']['provincia'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_departamento       = mb_convert_encoding($empresa_f['data']['departamento'], 'UTF-8', mb_detect_encoding($empresa_f['data']['departamento'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $e_codubigueo         = mb_convert_encoding($empresa_f['data']['codubigueo'], 'UTF-8', mb_detect_encoding($empresa_f['data']['codubigueo'], "UTF-8, ISO-8859-1, ISO-8859-15", true));

    // Cliente receptor ================================================================================
    $c_nombre_completo    = mb_convert_encoding($venta_f['data']['venta']['cliente_nombre_completo'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['cliente_nombre_completo'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $c_tipo_documento     = $venta_f['data']['venta']['tipo_documento'];
    $c_tipo_documento_name= $venta_f['data']['venta']['nombre_tipo_documento'];
    $c_numero_documento   = $venta_f['data']['venta']['numero_documento'];
    $c_direccion          = mb_convert_encoding($venta_f['data']['venta']['direccion'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['direccion'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $c_nc_serie_y_numero  = mb_convert_encoding($venta_f['data']['venta']['nc_serie_y_numero'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['nc_serie_y_numero'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    
    // Data comprobante ================================================================================
    $metodo_pago          = mb_convert_encoding($venta_f['data']['venta']['metodo_pago'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['metodo_pago'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $mp_serie_comprobante = $venta_f['data']['venta']['mp_serie_comprobante'] == null || $venta_f['data']['venta']['mp_serie_comprobante'] == '' ? '-': mb_convert_encoding($venta_f['data']['venta']['mp_serie_comprobante'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['mp_serie_comprobante'], "UTF-8, ISO-8859-1, ISO-8859-15", true));

    $user_en_atencion     = mb_convert_encoding($venta_f['data']['venta']['user_en_atencion'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['user_en_atencion'], "UTF-8, ISO-8859-1, ISO-8859-15", true));

    $fecha_emision        = $venta_f['data']['venta']['fecha_emision'];
    $fecha_emision_format = $venta_f['data']['venta']['fecha_emision_format'];
    $fecha_emision_dmy    = $venta_f['data']['venta']['fecha_emision_dmy'];
    $fecha_emision_hora12 = $venta_f['data']['venta']['fecha_emision_hora12'];
    $serie_comprobante    = $venta_f['data']['venta']['serie_comprobante'];
    $numero_comprobante   = $venta_f['data']['venta']['numero_comprobante'];
    $serie_y_numero_comprobante   = $venta_f['data']['venta']['serie_y_numero_comprobante'];
    $tipo_comprobante     = $venta_f['data']['venta']['tipo_comprobante'];
    $nombre_comprobante   = $venta_f['data']['venta']['tipo_comprobante'] == '12' ? 'NOTA DE VENTA' : ( $venta_f['data']['venta']['tipo_comprobante'] == '07' ? 'NOTA DE CRÉDITO' : $venta_f['data']['venta']['nombre_comprobante']);

    $venta_subtotal       = number_format( floatval($venta_f['data']['venta']['venta_subtotal']), 2, '.', ',' );
    $venta_subtotal_no_dcto = number_format( (floatval($venta_f['data']['venta']['venta_subtotal']) + floatval($venta_f['data']['venta']['venta_descuento'])), 2, '.', ',' );
    $venta_descuento      = number_format( floatval($venta_f['data']['venta']['venta_descuento']), 2, '.', ',' );
    $venta_igv            = number_format( floatval($venta_f['data']['venta']['venta_igv']), 2, '.', ',' );
    $venta_total          = number_format( floatval($venta_f['data']['venta']['venta_total']), 2, '.', ',' );
    $impuesto             = floatval($venta_f['data']['venta']['impuesto']). " %";
    $total_recibido       = number_format( floatval($venta_f['data']['venta']['total_recibido']), 2, '.', ',' );
    $total_vuelto         = number_format( floatval($venta_f['data']['venta']['total_vuelto']), 2, '.', ',' );

    $gravada              = "0.00";
    $exonerado            = number_format( floatval($venta_f['data']['venta']['venta_subtotal']), 2, '.', ',' );  

    $observacion_documento= mb_convert_encoding($venta_f['data']['venta']['observacion_documento'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['observacion_documento'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $sunat_hash           = mb_convert_encoding($venta_f['data']['venta']['sunat_hash'], 'UTF-8', mb_detect_encoding($venta_f['data']['venta']['sunat_hash'], "UTF-8, ISO-8859-1, ISO-8859-15", true));


    // detalle x producto ================================================================================
    $html_venta = ''; $cont = 1; $cantidad = 0;
    
    foreach ($venta_f['data']['detalle'] as $key => $val) {      
    
      $html_venta .= '<tr class="item-list">'.       
        '<td style="text-align: center; padding-left: 8px; font-size: 10px;">' . floatval($val['cantidad'])  . '</td>' .
        '<td style="text-align: center; padding-left: 8px; font-size: 10px;">' . $val['um_abreviatura_a']  . '</td>' .
       '<td style="padding: 0.5rem; text-align: left; font-size: 10px; word-break: break-all;">' . ($val['codigo']) . '</td>' .
       '<td style="padding: 0.5rem; text-align: left;  font-size: 10px; overflow-wrap: break-word;">' . ($val['nombre_producto']) . '</td>' .
       '<td style="padding: 0.5rem; text-align: right; font-size: 10px;">' . number_format( floatval($val['precio_venta']) , 2, '.', ',') . '</td>' .
       '<td style="padding: 0.5rem; text-align: right; font-size: 10px;">' . number_format( floatval($val['descuento']) , 2, '.', ',') . '</td>' .
       '<td style="text-align: right; padding-right: 8px; font-size: 10px;">' . number_format( floatval($val['subtotal_no_descuento']) , 2, '.', ',') . '</td>' .
       '</tr>';
      $cantidad += floatval($val['cantidad']);
    }

    // Generar QR ================================================================================
    
    $dataTxt = $e_numero_documento . "|" . 6 . "|" . $serie_comprobante . "|" . $numero_comprobante . "|0.00|" . $venta_total . "|" . $fecha_emision_format . "|" . $c_tipo_documento_name . "|" . $c_numero_documento . "|";

    $filename = $serie_y_numero_comprobante . '.png';
    $qr_code = QrCode::create($dataTxt)->setEncoding(new Encoding('UTF-8'))->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)->setSize(600)->setMargin(10)->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));

    $label = Label::create( $serie_y_numero_comprobante)->setTextColor(new Color(255, 0, 0)); // Create generic label  
    $writer = new PngWriter(); // Create IMG
    $result = $writer->write($qr_code, label: $label); 
    $result->saveToFile(__DIR__.'/generador-qr/ticket/'.$filename); // Save it to a file  
    $logoQr = $result->getDataUri();// Generate a data URI

    //NUMERO A LETRA ================================================================================       
    $total_en_letra = $numero_a_letra->toInvoice( floatval($venta_f['data']['venta']['venta_total']) , 2, " SOLES" );     

    // NOMBRE DE COMPROBANTE ================================================================================    
    $nombre_archivo_pdf = $nombre_comprobante .'-'. $c_numero_documento .'-'.  $serie_y_numero_comprobante;

    ?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title> <?php echo $nombre_archivo_pdf;?> </title>
  
  <style>
    @page { size: A4; }

    * {
      -webkit-print-color-adjust: exact !important;/* Chrome, Safari */        
      color-adjust: exact !important;/*Firefox*/        
    }

    .flex { display: flex; }
    .header-primary {align-items: center; justify-content: center;  }
    .image-logo {     
      height: 120px; width: 65%;
      background-repeat: no-repeat; 
      background-position: center; background-size: contain; 
      /* filter: grayscale(100%); */
    }
    .image-logo-container {
      height: 120px; width: 100%;
      background-color: #a5a5a5 !important; 
      border: 1px solid gray;
      border-radius: 5px;
      text-align: center;
    }

    .document-header {
      width: 50%;
      border: 1px solid gray;
      padding: 0em 1em 0 1em;
      text-align: center;
      border-radius: 7px;
      background-color: #dedede;
      -webkit-print-color-adjust: exact;
      line-height: 0.5;
      align-self: stretch;
      padding-top: 17px;
      font-size: 15px;
    }

    .table-products thead th { padding: 5px 8px;  }
    .table-products tbody tr:nth-of-type(odd) {  background-color: #F4F4F5; -webkit-print-color-adjust: exact; }
    .table-products { border-collapse: collapse; width: 100%; font-size: 12px; }
    .table-footer { width: 40%; float: right; font-size: 12px; padding: 8px; }
    .text-nowrap { white-space: nowrap !important; }

    /* min-width = como minimo ─|──────── */
    @media (min-width: 992px) {

      .justify-a4-documento{ display: flex;  justify-content: center;  align-items: start; }

    }

    /* max-width = como maximo ────────| */
    @media (max-width:991.98px) {
      .justify-a4-btn{ display: flex;  justify-content: center;  align-items: start; }
    }

    @media print {
      @page { size: A4; }

      * {
        -webkit-print-color-adjust: exact !important;/* Chrome, Safari */        
        color-adjust: exact !important;/*Firefox*/        
      }
      .tm_hide_print {  display: none !important;  }
      .flex { display: flex; }
      .header-primary {align-items: center; justify-content: center;  }
      .image-logo {     
      height: 120px; width: 65%;
        background-repeat: no-repeat; 
        background-position: center; background-size: contain; 
        filter: grayscale(100%);
      }
      .image-logo-container {
        height: 120px; width: 100%;
        background-color: #a5a5a5 !important; 
        border: 1px solid gray;
        border-radius: 5px;
        text-align: center;
      }

      .document-header {
        width: 50%;
        border: 1px solid gray;
        padding: 0em 1em 0 1em;
        text-align: center;
        border-radius: 7px;
        background-color: #dedede;
        -webkit-print-color-adjust: exact;
        line-height: 0.5;
        align-self: stretch;
        padding-top: 17px;
        font-size: 15px;
      }

      .table-products thead th { padding: 5px 8px;  }
      .table-products tbody tr:nth-of-type(odd) {  background-color: #F4F4F5; -webkit-print-color-adjust: exact; }
      .table-products { border-collapse: collapse; width: 100%; font-size: 12px; }
      .table-footer { width: 40%; float: right; font-size: 12px; padding: 8px; }
    }
  </style>
</head>

<body class="justify-a4-documento" style="background-color: white !important; "><!---->
  <div class="tm_hide_print justify-a4-btn">
    <button type="button" style="margin-bottom: 5px;">
      <a  type="button" class="btn btn-outline-info p-1 mb-2 m-l-5px w-40px" href="javascript:window.print()" data-bs-toggle="tooltip" title="Imprimir Ticket">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
          <polyline points="6 9 6 2 18 2 18 9"></polyline>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
          <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
      </a>
    </button>
    <br>
    <button type="button" class="btn btn-warning p-1 mb-2 m-l-5px w-40px" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="decargar_imagen();" style="cursor: pointer;">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <polyline points="21 15 16 10 5 21"></polyline>
      </svg>
    </button>      
  </div>   

  <div id="iframe-img-descarga" style="background-color: #fcfcff; font-family: sans-serif; font-size: 12px; width: 780px !important; border-radius: 5px;">
    <div style="padding: 10px;"> 
    
      <div class="flex header-primary" style="margin-bottom: 15px;">
        
        <div style="width: 50%; padding-left: 0px; padding-right: 10px;">         
          <div class="image-logo-container"> 
            <center> <div class="image-logo" style="background-image: url(&quot;../assets/images/brand-logos/logo1.png&quot;);"></div></center>
          </div>
        </div>
        
        <div class="document-header">
          <div class="document-header-content text-nowrap"><strong style="display: block; margin-bottom: 5px;">
            <p>R.U.C. N° <?php echo $e_numero_documento;?></p>
            <p style="text-transform: uppercase; font-size: 19px;"><?php echo $nombre_comprobante;?> electrónica</p>
            </strong> <strong style="display: block; font-size: 19px;"> <p><?php echo $serie_y_numero_comprobante;?></p> </strong>
          </div>
        </div>
      </div>
      <div>
        <div style="display: inline-block; vertical-align: top; width: 46.9%; border-radius: 7px; margin-right: 16px;">
          <table style="width: 100%; padding: 0px; font-size: 12px;">
            <tbody>
              <tr>
                <td><strong style="margin-bottom: 0px;"> <?php echo $e_razon_social;?> </strong></td>
              </tr> <!---->
              <tr>
                <td><?php echo $e_domicilio_fiscal;?></td>
              </tr> <!---->
              <tr><td><b>Correo:</b> <?php echo $e_correo;?></td></tr>
              <tr><td><b>Cel.:</b> <?php echo $e_telefono1 .' - ' . $e_telefono2;?></td></tr>
            </tbody>
          </table>
        </div>
        <div style="display: inline-block; vertical-align: top; width: 50%; border: 1px solid gray; border-radius: 7px; margin-bottom: 15px;">
          <table style="width: 100%; padding: 0.5em; font-size: 12px;">
            <tbody>
              <tr>
                <td width="30%"><strong>Fecha emisión</strong></td> <td style="width: 1rem; text-align: right;">:</td> <td><?php echo $fecha_emision_format;?></td>
              </tr> 
              <tr>
                <td width="30%"><strong>Señor(es)</strong></td> <td style="width: 1rem; text-align: right;">:</td> <td> <?php echo $c_nombre_completo;?> </td>
              </tr>
              <tr>
                <td width="30%"><strong><?php echo $c_tipo_documento_name;?></strong></td> <td style="width: 1rem; text-align: right;">:</td> <td><span><?php echo $c_numero_documento;?></span></td>
              </tr>
              <tr>
                <td width="30%"><strong>Dirección</strong></td> <td style="width: 1rem; text-align: right;">:</td> <td> <?php echo $c_direccion;?></td>
              </tr> 
              <?php if ($tipo_comprobante == '07') {?>
              <tr>
                <td width="30%"><strong>Doc. Baja</strong></td> <td style="width: 1rem; text-align: right;">:</td> <td> <?php echo $c_nc_serie_y_numero;?></td>
              </tr> 
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <div style="border: 1px solid gray; border-radius: 7px;">
        <table role="grid" class="table-products" style="table-layout: fixed;">
          <thead>
            <tr role="row">
              <th role="columnheader" style="text-align: center; width: 50px;">Cant.</th>
              <th role="columnheader" style="text-align: center; width: 50px;">Unidad</th>
              <th role="columnheader" style="text-align: left; width: 110px;"> Código </th>
              <th role="columnheader" style="text-align: left; width: auto;">Descripción</th>
              <th role="columnheader" style="text-align: right; width: 100px;">P.U.</th> 
              <th role="columnheader" style="text-align: right; width: 100px;">Dcto.</th> 
              <th role="columnheader" style="text-align: right; width: 80px;"> Total  </th>
            </tr>
          </thead>
          <tbody class="text-nowrap" style="border-bottom: 1px solid gray; border-top: 1px solid gray;">
            
            <?php echo $html_venta;?>
            <!-- <tr class="item-list">
              <td style="text-align: center; padding-left: 8px; font-size: 10px;"> 1.00 </td>
              <td style="padding: 0.5rem; text-align: center; font-size: 10px;"> UNIDAD </td>
              <td style="padding: 0.5rem; text-align: left; font-size: 10px; word-break: break-all;"> PIURA &nbsp;  </td>
              <td style="padding: 0.5rem; text-align: left; min-width: 200px; font-size: 10px; overflow-wrap: break-word;">
                FACTURACION POR SERVICIO DE CORRESPONSALI CORRESPONDIENTE AL MES DE ABRIL 2024 <br></td>
              <td style="padding: 0.5rem; text-align: right; font-size: 10px;"> 136.40</td> 
              <td style="text-align: right; padding-right: 8px; font-size: 10px;"> 136.40 </td>
            </tr> -->
          </tbody>
        </table>
        <div style="overflow: hidden;">
          <table class="table-footer">
            <tbody>
              <tr>
                <td style="float: right; text-transform: uppercase;">  Subtotal</td>
                <td style="text-align: right;"> S/ </td>
                <td style="float: right;"><?php echo $venta_subtotal_no_dcto;?></td>
              </tr>
              <tr>
                <td style="float: right; text-transform: uppercase;">  Descuento</td>
                <td style="text-align: right;"> S/ </td>
                <td style="float: right;"><?php echo $venta_descuento;?></td>
              </tr>
              <tr>
                <td style="float: right; text-transform: uppercase;">  OP. Exonerada</td>
                <td style="text-align: right;"> S/ </td>
                <td style="float: right;"><?php echo $venta_subtotal?></td>
              </tr> 
              <tr>
                <td style="text-align: right;">I.G.V</td>
                <td style="text-align: right;"> S/ </td>
                <td style="text-align: right;">0.00</td>
              </tr> 
              <tr>
                <td style="text-align: right; font-weight: bolder;">TOTAL</td>
                <td style="text-align: right; font-weight: bolder;"> S/ </td>
                <td style="text-align: right; font-weight: bolder;"><?php echo $venta_total;?> </td>
              </tr> 
            </tbody>
          </table>
        </div>
      </div>
      <div style="border: 1px solid gray; border-radius: 7px; padding: 7px; font-size: 12px; overflow: hidden; margin-top: 15px; line-height: 1.5;">
        <div style="display: inline-block; vertical-align: top;">
          <div>
            <div><strong>IMPORTE EN LETRAS</strong>: <span><?php echo $total_en_letra;?></span></div> <!---->
            <!----> <!----> <!----> <!----> <!----> <!---->
            <div><strong>RESUMEN</strong>: <span> <?php echo $sunat_hash ;?></span></div> <!---->
          </div>
          <div style="margin-top: 10px;"></div>
        </div>
        <div style="display: inline-block; float: right; margin: -7px;">
          <img  src="<?php echo $logoQr;?>" width="100px">
        </div>
      </div> <!---->
      <div style="margin-top: 15px;">
        <div style="border: 1px solid gray; padding: 7px; font-size: 12px; border-radius: 7px;">
          <strong>OBSERVACIONES</strong>: <br> <span style="white-space: pre-wrap;"><?php echo $observacion_documento;?></span><br></div> <!---->
        <div style="border: 1px solid gray; padding: 7px; font-size: 12px; border-radius: 7px; margin-top: 15px;">
          <div>
            <strong>FORMA DE PAGO: </strong> <span>Contado</span> 
            <?php if ($tipo_comprobante != '07') {?> | 
            <strong><span><?php echo $metodo_pago;?>:</strong> <span><?php echo $total_recibido;?></span> |
            <strong>VUELTO:</strong> <span><?php echo $total_vuelto;?></span>
            <?php }?>
          </div> <!---->
        </div> <!---->
        <div style="text-align: center; font-size: 11px; margin-top: 15px;">
          Representación impresa de la <b style=" text-transform: lowercase;"><?php echo $nombre_comprobante;?></b>  electrónica. Consulte su documento en <strong> <?php echo $e_web;?> </strong>
        </div>
      </div>
    </div>
  </div>
  <!-- Popper JS -->
  <script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Dropzone JS -->
  <script src="../assets/libs/dom-to-image-master/dist/dom-to-image.min.js"></script>

  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
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