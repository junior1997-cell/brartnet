<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Ver_pagos
{

  //Implementamos nuestro constructor
  public $id_usr_sesion_client;
  public $id_empresa_sesion;
  //Implementamos nuestro constructor
  public function __construct($id_usr_sesion_client = 0, $id_empresa_sesion = 0)
  {
    $this->id_usr_sesion_client =  isset($_SESSION['idpersona_cliente']) ? $_SESSION['idpersona_cliente'] : 0;
    // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
  }

  // validar inicio de sesión del usuario cliente
  public function ver_pagos($estado, $anio)
  {
    $filtro = "";
    $est = (!empty($estado)) ? ($estado == 'pagado' ? "lvd.idventa IS NOT NULL" : "lvd.idventa IS NULL") : "";
    $an = !empty($anio) ? "mes_c.name_year='$anio'" : "";
    
    if (!empty($est) || !empty($an)) {
        $filtro = "WHERE " . trim("$est AND $an", " AND ");
    }

    $data_p = "";

    $sql = "SELECT mes_c.*, lvd.idventa, lvd.idventa_detalle, lvd.subtotal,
                lvd.tipo, lvd.pr_nombre, lvd.tipo_comprobante, lvd.serie_comprobante, 
                lvd.numero_comprobante
            FROM ( SELECT mc.* FROM
                    mes_calendario AS mc
                WHERE year_month_date BETWEEN(
                    SELECT CASE WHEN pc.fecha_afiliacion < '2024-05-01' THEN '2024-05-01' ELSE pc.fecha_afiliacion
                END AS min_date
            FROM persona_cliente AS pc
            WHERE pc.idpersona_cliente = '$this->id_usr_sesion_client'
            ) AND(SELECT MAX(vd.periodo_pago_format)
                FROM venta_detalle AS vd
                INNER JOIN venta AS v ON vd.idventa = v.idventa AND v.idpersona_cliente = '$this->id_usr_sesion_client'
                WHERE vd.es_cobro='SI' AND v.estado_delete = 1 AND v.estado='1' AND  v.sunat_estado = 'ACEPTADA' AND v.tipo_comprobante IN ('01','03','12')) ) AS mes_c
            LEFT JOIN( SELECT vd.*, v.tipo_comprobante, v.serie_comprobante, v.numero_comprobante
                FROM venta_detalle AS vd
                INNER JOIN venta AS v ON vd.idventa = v.idventa AND v.idpersona_cliente = '$this->id_usr_sesion_client'
                WHERE vd.es_cobro='SI' AND v.estado_delete = 1 AND v.estado='1' AND  v.sunat_estado = 'ACEPTADA' AND
                v.tipo_comprobante IN ('01','03','12')
            ) AS lvd ON    mes_c.year_month = lvd.periodo_pago
            $filtro
            ORDER by mes_c.year_month DESC;";

//var_dump($sql);die();
    $data_pagos = ejecutarConsultaArray($sql);
    if ($data_pagos['status'] == false) {
      return $data_pagos;
    }

    if (!empty($data_pagos['data'])) {
      
      foreach ($data_pagos['data'] as $key => $value) {
        $src = !empty($value['idventa']) ? "assets/icons_pgos_c/alegre.png" : "assets/icons_pgos_c/triste.png";
        $icon_download = !empty($value['idventa']) ? "#1de125;" : "#f04747;";
        $tipo_servicio = !empty($value['idventa']) ? $value['tipo'] : "Por Pagar";
        $name_comprobante = !empty($value['idventa']) ? $value['pr_nombre'] : "Por Pagar";
        $descr_donl = !empty($value['idventa']) ? "Ver Comprobante" : "Sin Comprobante";
        $num_comprobante = !empty($value['idventa']) ? $value['serie_comprobante'] . '- ' . $value['numero_comprobante'] : "- - - - - - - -";
        $onclick = !empty($value['idventa']) ? 'onclick="ver_comprobante( \'' . $value['idventa'] . '\', \'' . $value['tipo_comprobante'] . '\',\'' .$num_comprobante. '\');"' : "";

        $data_p .= '<li style="padding:0px">
                  <div class="timeline-time text-end">
                    <span class="date">' . $value['name_year'] . '</span>
                    <span class="time d-inline-block" style=" font-size: small; ">' . $value['name_month'] . '</span>
                  </div>
                  <div class="timeline-icon">
                    <a href="javascript:void(0);"></a>
                  </div>
                  <div class="timeline-body">
                    <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                      <div class="avatar avatar-md online me-3 mt-sm-0 mt-4">
                        <img alt="avatar" src=' . $src . '>
                      </div>
                      <div class="flex-fill">
                        <div class="d-flex">
                          <div class="mt-sm-0 mt-2">
                            <p class="mb-0 fs-14 fw-semibold" style="text-align: left;">' . $tipo_servicio . '</p>
                            <p class="mb-0 text-muted" style="text-align: left;">Tipo Servicio :' . $name_comprobante . '</p>

                          </div>
                          <div class="ms-auto" style="cursor:pointer">
                            <div class="card custom-card shadow-none bg-light">
                              <div class="card-body p-2">
                                <a  '.$onclick.' >
                                  <div class="d-flex justify-content-between flex-wrap">
                                    <div class="file-format-icon mt-2">
                                      <i class="fa-solid fa-download fa-2xl" style="color: ' . $icon_download . '"></i>
                                    </div>
                                    <div>
                                      <span class="fw-semibold mb-1"> '.$descr_donl.' </span>
                                      <span class="fs-8 d-block text-muted text-end">
                                        ' . $num_comprobante . '
                                      </span>
                                    </div>
                                  </div>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>';

  
      };
    }else{

      $data_p ='<div class="card border-0 m-3">
                    <div class="alert alert-secondary border border-secondary mb-0 p-2">
                      <div class="d-flex align-items-start">
                        <div class="me-2">
                          <svg class="flex-shrink-0 svg-secondary" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                            <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"></path>
                            <path d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
                          </svg>
                        </div>
                        <div class="text-secondary w-100">
                          <div class="fw-semibold d-flex justify-content-between">Eres un cliente Responsable </div>
                          <div class="fs-12 op-8 mb-1 mt-3">Reciba un cordial saludo de parte de la administración. Agradecemos su compromiso y responsabilidad como cliente, y estamos aquí para brindarle el mejor servicio posible.</div>

                        </div>
                      </div>
                    </div>
                  </div>';

    }

    //$data_p $data_pagos['data']
    return $return = ['status' => true, 'message' => 'todo okey', 'data' => $data_p];
  }

  public function mostrar_datos_cliente() {    

    $sql = "SELECT * FROM vw_cliente_all where idpersona_cliente = $this->id_usr_sesion_client ;";
    return ejecutarConsultaSimpleFila($sql);

  }

  public function filtro_pagos_year()
  {
    $data_year='';

    $sql_year = "SELECT DISTINCT mes_c.name_year
    FROM ( SELECT mc.* FROM mes_calendario AS mc WHERE year_month_date 
    BETWEEN( SELECT CASE WHEN pc.fecha_afiliacion < '2024-05-01' THEN '2024-05-01' ELSE pc.fecha_afiliacion END AS min_date FROM persona_cliente AS pc WHERE pc.idpersona_cliente = '$this->id_usr_sesion_client' ) AND
    (SELECT MAX(vd.periodo_pago_format)
                FROM venta_detalle AS vd
                INNER JOIN venta AS v ON vd.idventa = v.idventa AND v.idpersona_cliente = '$this->id_usr_sesion_client'
                WHERE vd.es_cobro='SI' AND v.estado_delete = 1 AND v.estado='1' AND  v.sunat_estado = 'ACEPTADA' AND v.tipo_comprobante IN ('01','03','12')) ) AS mes_c
    ORDER by mes_c.year_month DESC;";

    $year = ejecutarConsultaArray($sql_year);

    if ($year['status'] == false) {
      return $year;
    }
   
    foreach ($year['data'] as $key => $value) {
      $data_year .= '<span class="badge rounded-pill bg-secondary-transparent p-2 m-1 fs-12 btn_year class_year'.$value['name_year'].'" onclick="year_a('. $value['name_year'] .');" style="cursor:pointer">'. $value['name_year'] .'</span>';
    };

    return $return = ['status' => true, 'message' => 'todo okey', 'data' => $data_year];

  }
  

  public function filtro_pagos_month()
  {
    $data_month = ''; 

    $sql_month = "SELECT DISTINCT mes_c.name_month 
    FROM ( SELECT mc.* FROM mes_calendario AS mc WHERE year_month_date BETWEEN( SELECT CASE WHEN pc.fecha_afiliacion < '2024-05-01' THEN '2024-05-01' ELSE pc.fecha_afiliacion END AS min_date FROM persona_cliente AS pc WHERE pc.idpersona_cliente = '$this->id_usr_sesion_client' ) AND(NOW())) AS mes_c 
    ORDER by mes_c.year_month DESC;";

    $month= ejecutarConsultaArray($sql_month);

    if ($month['status'] == false) {
      return $month;
    }
    
    foreach ($month['data'] as $key => $val) {
      $data_month .= '<button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">'. $val['name_month'] .'</button>';
    };

    return $return = ['status' => true, 'message' => 'todo okey', 'data' => $data_month];

  }
}
