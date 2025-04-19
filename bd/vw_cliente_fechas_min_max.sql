SELECT
  pc.idpersona_cliente,
  pc.idpersona,
  -- Obtener la fecha mínima
  CASE
    WHEN vd.fecha_minima_cobro IS NOT NULL THEN vd.fecha_minima_cobro
    WHEN pc.fecha_afiliacion < '2024-05-01' THEN '2024-05-01'
    ELSE pc.fecha_afiliacion
  END AS min_date,
  -- Obtener la fecha máxima
  CASE
    WHEN vd.fecha_maxima_cobro > CURDATE() THEN vd.fecha_maxima_cobro
    WHEN pc.fecha_cancelacion > CURDATE() THEN CURDATE()
    ELSE 
      CASE WHEN DATE_FORMAT(CURDATE(), '%d') > DATE_FORMAT(pc.fecha_cancelacion, '%d') THEN CURDATE()
        ELSE TIMESTAMPADD(MONTH, -1, CURDATE())
      END
  END AS max_date,
  CONCAT(
    CASE
      WHEN vd.fecha_maxima_cobro > CURDATE() THEN DATE_FORMAT(vd.fecha_maxima_cobro, '%Y')
      WHEN pc.fecha_cancelacion > CURDATE() THEN DATE_FORMAT(CURDATE(), '%Y')
      ELSE CASE
        WHEN DATE_FORMAT(CURDATE(), '%d') > DATE_FORMAT(pc.fecha_cancelacion, '%d') THEN DATE_FORMAT(CURDATE(), '%Y')
        ELSE DATE_FORMAT(TIMESTAMPADD (MONTH, -1, CURDATE()), '%Y')
      END
    END,
    '-12-01'
  ) AS max_date_mc, pc.fecha_cancelacion
FROM  persona_cliente AS pc
  LEFT JOIN (
    -- Subconsulta para obtener la fecha mínima de cobro y la fecha máxima
    SELECT
      MIN(vd_mc.periodo_pago_format) AS fecha_minima_cobro,
      STR_TO_DATE(CONCAT(DATE_FORMAT(MAX(vd_mc.periodo_pago_format), '%Y-%m'), '-', (select DATE_FORMAT(fecha_cancelacion, '%d') from persona_cliente where idpersona_cliente = vd_mc.idpersona_cliente) ), '%Y-%m-%d' ) AS fecha_maxima_cobro,
      vd_mc.idpersona_cliente
    FROM (
      SELECT vd.periodo_pago_format, v.idpersona_cliente
      FROM venta_detalle AS vd 
      INNER JOIN venta AS v ON vd.idventa = v.idventa
      WHERE vd.es_cobro = 'SI' AND v.estado_delete = 1 AND v.estado = '1' AND v.sunat_estado IN ('ACEPTADA', 'POR ENVIAR') AND v.tipo_comprobante IN ('01', '03', '12')
      GROUP BY v.idpersona_cliente
      UNION ALL
      SELECT periodo_cortado_format as periodo_pago_format, idpersona_cliente  FROM mes_cortado
    ) AS vd_mc
    GROUP BY vd_mc.idpersona_cliente
  ) AS vd ON vd.idpersona_cliente = pc.idpersona_cliente