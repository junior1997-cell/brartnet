<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Reader\XmlReader;

use Luecano\NumeroALetras\NumeroALetras;

date_default_timezone_set('America/Lima');

require "../config/Conexion_v2.php";
$numero_a_letra = new NumeroALetras();

$empresa_f  = $facturacion->datos_empresa();
$venta_f    = $facturacion->mostrar_detalle_venta($idventa); ##echo $rspta['id_tabla']; echo  json_encode($venta_f , true);  die();

if (empty($venta_f['data']['venta'])) {
  # code...
} else {

  // Emrpesa emisora =============
  $e_razon_social       = mb_convert_encoding($empresa_f['data']['nombre_razon_social'], 'ISO-8859-1', 'UTF-8');
  $e_comercial          = $empresa_f['data']['nombre_comercial'];
  $e_domicilio_fiscal   = $empresa_f['data']['domicilio_fiscal'];
  $e_tipo_documento     = $empresa_f['data']['tipo_documento'];
  $e_numero_documento   = $empresa_f['data']['numero_documento'];
  
  $e_distrito           = $empresa_f['data']['distrito'];
  $e_provincia          = $empresa_f['data']['provincia'];
  $e_departamento       = $empresa_f['data']['departamento'];
  $e_codubigueo       = $empresa_f['data']['codubigueo'];

  // Cliente receptor =============
  $c_nombre_completo    = $venta_f['data']['venta']['cliente_nombre_completo'];
  $c_tipo_documento     = $venta_f['data']['venta']['tipo_documento'];
  $c_numero_documento   = $venta_f['data']['venta']['numero_documento'];
  $c_direccion          = $venta_f['data']['venta']['direccion'];

  $fecha_emision        = $venta_f['data']['venta']['fecha_emision'];
  $serie_comprobante    = $venta_f['data']['venta']['serie_comprobante'];
  $numero_comprobante   = $venta_f['data']['venta']['numero_comprobante'];
  $venta_total          = floatval($venta_f['data']['venta']['venta_total']);

  //NUMERO A LETRA =============
  $venta_total    = $venta_f['data']['venta']['venta_total'];
  $total_en_letra = $numero_a_letra->toInvoice($venta_total, 2, " SOLES");

  // if ($column['proigv'] == "Gravada") {

  //   $tipoafecto = "10";
  //   $igv = "18";
  //   $totalImpuestos = $column['Igv'];
  //   $setIgv = $column['Igv'];
  // } else if ($column['proigv'] == "No Gravada") {

    $tipoafecto = "20";
    $igv = "0";
    $totalImpuestos = "0";
    $setIgv = "0";
  // }

  // Cliente
  $client = new Client();
  $client->setTipoDoc($c_tipo_documento)
    ->setNumDoc($c_numero_documento)
    ->setRznSocial($c_nombre_completo);

  // Emisor
  $address = (new Address())
    ->setUbigueo($e_codubigueo )
    ->setDepartamento($e_departamento)
    ->setProvincia($e_provincia)
    ->setDistrito($e_distrito)
    ->setUrbanizacion('-')
    ->setDireccion($e_domicilio_fiscal)
    ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

  // Emisor
  $company = (new Company())
    ->setRuc($e_numero_documento )
    ->setRazonSocial($e_razon_social)
    ->setNombreComercial($e_comercial)
    ->setAddress($address);

  // Venta
  $invoice = (new Invoice())
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101') // Catalog. 51
    ->setTipoDoc('03')
    ->setSerie($serie_comprobante)
    ->setCorrelativo($numero_comprobante)
    ->setFechaEmision(new DateTime($fecha_emision . '-05:00'))
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda('PEN')
    ->setClient($client)
    ->setMtoOperExoneradas($venta_total)
    ->setMtoIGV(0)
    ->setTotalImpuestos(0)
    ->setValorVenta($venta_total)
    ->setSubTotal($venta_total)
    ->setMtoImpVenta($venta_total)
    ->setCompany($company);

  $i = 0;
  $arrayItem = [];

  foreach ($venta_f['data']['detalle'] as $key => $val) {
    $nombre_producto  = mb_convert_encoding($val['nombre_producto'], 'ISO-8859-1', 'UTF-8');
    $subtotal         = floatval($val['subtotal']);
    $cantidad         = floatval($val['cantidad']);
    $precio_venta     = floatval($val['precio_venta']);  
    $um_nombre        = $val['um_nombre'];
    $um_abreviatura    = $val['um_abreviatura'];

    $item = (new SaleDetail())
      ->setCodProducto($val['codigo'])
      ->setUnidad($um_abreviatura)
      ->setCantidad($cantidad )
      ->setDescripcion($nombre_producto)
      ->setMtoBaseIgv($subtotal)
      ->setPorcentajeIgv(0) // 18%
      ->setIgv(0)
      ->setTipAfeIgv('20')
      ->setTotalImpuestos(0)
      ->setMtoValorVenta($subtotal)
      ->setMtoValorUnitario($precio_venta)
      ->setMtoPrecioUnitario($precio_venta);

    $arrayItem[$i] = $item;
    $i++;
  }

  $legend = (new Legend())
    ->setCode('1000')
    ->setValue($total_en_letra);

  $invoice->setDetails($arrayItem)
    ->setLegends([$legend]);

  /* 
    * ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    * Envío a SUNAT
    + ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    */

  $result = $see->send($invoice);

  // Guardar XML firmado digitalmente.
  $nombre_xml = '../assets/modulo/facturacion/boleta/' . $invoice->getName() . '.xml';
  file_put_contents($nombre_xml,  $see->getFactory()->getLastXml());

  // Verificamos que la conexión con SUNAT fue exitosa.
  if (!$result->isSuccess()) {
    // Mostrar error al conectarse a SUNAT.
    $sunat_error = limpiarCadena("Codigo Error: " . $result->getError()->getCode() . " \n Mensaje Error: " . $result->getError()->getMessage());
    $code = (int)$result->getError()->getCode();
     if ($code === 0) {
      $sunat_estado = 'ACEPTADA' ;      
    } else if ($code >= 2000 && $code <= 3999) {
      $sunat_estado = 'RECHAZADA' ;
    } else {
      /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
      /*code: 0100 a 1999 */
      $sunat_estado = 'Excepción: ' . $code;
    }
    $sunat_code = $code;
    // exit();
  } else {

    // Guardamos el CDR
    $nombre_de_cdr = '../assets/modulo/facturacion/boleta/R-' . $invoice->getName() . '.zip';
    file_put_contents($nombre_de_cdr, $result->getCdrZip());


    /* 
      * ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
      * Lectura del CDR 
      + ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
      */

    $cdr = $result->getCdrResponse();

    $code = (int)$cdr->getCode();

    if ($code === 0) {
      $sunat_estado = 'ACEPTADA' ;
      if (count($cdr->getNotes()) > 0) {
        $sunat_estado = 'OBSERVACIONES' . PHP_EOL;
        // $sunat_observacion = $cdr->getNotes(); # Corregir estas observaciones en siguientes emisiones. var_dump()
        foreach ($cdr->getNotes() as $key => $val) {
          $sunat_observacion .= $val . "<br>";
        }
      }
    } else if ($code >= 2000 && $code <= 3999) {
      $sunat_estado = 'RECHAZADA' ;
    } else {
      /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
      /*code: 0100 a 1999 */
      $sunat_estado = 'Excepción: ' . $code;
    }
    $sunat_code = $code;
    $sunat_mensaje = $cdr->getDescription() . PHP_EOL;

    /* 
      * ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
      * Lectura del codgo Hash 
      + ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
      */

    $parser = new XmlReader();
    $archivoXml = file_get_contents($nombre_xml);
    $documento = $parser->getDocument($archivoXml);
    $sunat_hash = $documento->getElementsByTagName('DigestValue')->item(0)->nodeValue;
  }
}
