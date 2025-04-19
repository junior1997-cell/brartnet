CREATE PROCEDURE `sp_mes_cobrado_cliente` (
  IN idcliente INT
)
BEGIN

SELECT 
  CASE 
    WHEN lvd.estado_mes IS NULL THEN  
      CASE 
        WHEN DATE_FORMAT(mes_c.year_month_date, '%Y-%m') < DATE_FORMAT(CURDATE(), '%Y-%m') THEN 'DEUDA' 
        WHEN DATE_FORMAT(mes_c.year_month_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') THEN 
          CASE 
            WHEN DATE_FORMAT(CURDATE(), '%Y-%m-%d') <= fecha_cancelacion THEN 'PENDIENTE'  
            WHEN DATE_FORMAT(CURDATE(), '%Y-%m-%d') > fecha_cancelacion THEN 'DEUDA' 
            ELSE '--' 
          END
        WHEN DATE_FORMAT(mes_c.year_month_date, '%Y-%m') > DATE_FORMAT(CURDATE(), '%Y-%m') THEN 'PENDIENTE' 
        ELSE '-'
      END
    ELSE lvd.estado_mes 
  END AS estado_pagado,
  mes_c.*, fn_capitalize_texto(mes_c.name_month) as nombre_mes_capitalize,  fn_capitalize_texto(SUBSTRING( mes_c.name_month , 1, 3)) as nombre_mes_recortado, lvd.idventa, lvd.idventa_detalle, 
  CASE WHEN lvd.fecha_emision_format IS NOT NULL THEN lvd.fecha_emision_format ELSE  '' END as fecha_emision_format, lvd.subtotal, lvd.tipo, lvd.pr_nombre, lvd.tipo_comprobante, lvd.serie_comprobante, lvd.numero_comprobante, lvd.tipo_comprobante_v2,
  lvd.tecnico_cobro , lvd.foto_perfil_tecnico_cobro,
  -- Mes corte
  lvd.idmes_cortado, lvd.mc_observacion
  FROM ( 
    SELECT mc.* 
    FROM mes_calendario AS mc
    WHERE year_month_date 
    BETWEEN
    -- Fecha minima
    ( select min_date from vw_cliente_fechas_min_max WHERE idpersona_cliente = idcliente ) AND 
    -- Fecha Maxima
    ( select max_date from vw_cliente_fechas_min_max WHERE idpersona_cliente = idcliente ) 
  ) AS mes_c
  LEFT JOIN( 
    SELECT 
    -- venta
    'PAGADO' AS estado_mes, v.idventa, v.idpersona_cliente, v.tipo_comprobante, v.serie_comprobante, v.numero_comprobante, DATE_FORMAT(v.fecha_emision, '%d, %b %Y - %h:%i %p') as fecha_emision_format, CASE v.tipo_comprobante WHEN '03' THEN 'BOLETA' WHEN '07' THEN 'NOTA CRED.' ELSE tc.abreviatura END AS tipo_comprobante_v2,
    -- detalle de venta
    vd.idventa_detalle,  vd.subtotal, vd.tipo, vd.pr_nombre, vd.periodo_pago, vd.periodo_pago_format, vd.periodo_pago_month, vd.periodo_pago_year,
    -- tecnico asociado
    CONCAT( fn_capitalize_texto(SUBSTRING_INDEX(p1.nombre_razonsocial, ' ', 1)),' ', fn_capitalize_texto(SUBSTRING_INDEX(p1.apellidos_nombrecomercial, ' ', 1))) AS tecnico_asociado,
    CONCAT( fn_capitalize_texto(SUBSTRING_INDEX(pu.nombre_razonsocial, ' ', 1)),' ', fn_capitalize_texto(SUBSTRING_INDEX(pu.apellidos_nombrecomercial, ' ', 1))) AS tecnico_cobro,
    p1.foto_perfil as foto_perfil_tecnico, pu.foto_perfil as foto_perfil_tecnico_cobro,
    -- Mes cortado
    NULL as idmes_cortado , NULL as mc_observacion
    FROM venta_detalle AS vd
    INNER JOIN venta AS v ON vd.idventa = v.idventa AND v.idpersona_cliente = idcliente         -- Datos de venta cabecera
    INNER JOIN persona_cliente AS pc ON pc.idpersona_cliente = v.idpersona_cliente              -- Datos del cliente
    INNER JOIN persona_trabajador as pt on pt.idpersona_trabajador = pc.idpersona_trabajador    -- Datos del Tecnico a cargo
    INNER JOIN persona as p1 on p1.idpersona = pt.idpersona                                     -- Datos del Tecnico a cargo
    LEFT JOIN usuario as u ON u.idusuario = v.user_created                                      -- Datos del Tecnico que cobro
    LEFT JOIN persona as pu ON pu.idpersona = u.idpersona                                       -- Datos del Tecnico que cobro
    INNER JOIN sunat_c01_tipo_comprobante AS tc ON tc.idtipo_comprobante = v.idsunat_c01        -- Tipo de comprobane emitido
    WHERE vd.es_cobro='SI' AND v.estado_delete = 1 AND v.estado='1' AND  v.sunat_estado in ('ACEPTADA', 'POR ENVIAR') AND v.tipo_comprobante IN ('01','03','12')
    UNION ALL
    SELECT 
    -- venta
    'CORTADO' AS estado_mes, NULL as idventa, mc.idpersona_cliente, NULL as tipo_comprobante, NULL as serie_comprobante, NULL as numero_comprobante, DATE_FORMAT(mc.created_at, '%d, %b %Y - %h:%i %p') as fecha_emision_format, NULL as tipo_comprobante_v2,
    -- detalle de venta
    NULL as idventa_detalle,  NULL as subtotal, NULL as tipo, NULL as pr_nombre, mc.periodo_cortado as periodo_pago, mc.periodo_cortado_format as periodo_pago_format, mc.periodo_cortado_month as periodo_pago_month, mc.periodo_cortado_year as periodo_pago_year,
    -- tecnico asociado
    ('' COLLATE utf8mb4_spanish_ci) as tecnico_asociado, CONCAT( fn_capitalize_texto(SUBSTRING_INDEX(pu.nombre_razonsocial, ' ', 1)) COLLATE utf8mb4_spanish_ci ,' ', fn_capitalize_texto(SUBSTRING_INDEX(pu.apellidos_nombrecomercial, ' ', 1)) COLLATE utf8mb4_spanish_ci)  as tecnico_cobro, NULL as foto_perfil_tecnico, NULL as foto_perfil_tecnico_cobro,
    -- Mes cortado
    mc.idmes_cortado, mc.observacion as mc_observacion
    FROM mes_cortado as mc 
    LEFT JOIN usuario as u ON u.idusuario = mc.user_created                                         -- Datos del Tecnico que cobro
    LEFT JOIN persona as pu ON pu.idpersona = u.idpersona   WHERE mc.idpersona_cliente = idcliente  -- Datos del Tecnico que cobro
  ) AS lvd ON mes_c.year_month = lvd.periodo_pago 
  ORDER by mes_c.year_month DESC;

END