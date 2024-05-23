<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Reporte_x_trabajador
{
	public $id_usr_sesion; public $id_persona_sesion; public $id_trabajador_sesion;
	//Implementamos nuestro constructor
	public function __construct()
	{
		$this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
		$this->id_persona_sesion = isset($_SESSION['idpersona']) ? $_SESSION["idpersona"] : 0;
		$this->id_trabajador_sesion = isset($_SESSION['idpersona_trabajador']) ? $_SESSION["idpersona_trabajador"] : 0;
	}
	/*T-- paepelera --desacctivar
	C-- crear
	R-- read
	U-- actualizar
	D-- delete -- eliminar*/

	// validar inicio de sesión del usuario cliente
	public function verificar($login, $clave){
		$sql = "SELECT pc.idpersona_cliente, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial
		FROM persona_cliente AS pc
		INNER JOIN persona AS p ON pc.idpersona = p.idpersona
		WHERE landing_user = '$login' AND landing_password = '$clave'
		AND estado = 1 AND estado_delete = 1";
		$user = ejecutarConsultaSimpleFila($sql); if ($user['status'] == false) {  return $user; } 
		$data = [ 'status'=>true, 'message'=>'todo okey','data'=> ['usuario' => $user['data']]  ];
    return $data;
	}

	//Implementar un método para listar los registros
	public function tabla_principal_cliente($filtro_trabajador, $filtro_anio_pago, $filtro_p_all_mes_pago, $filtro_tipo_comprob)	{

		$filtro_sql_trab  = ''; $filtro_sql_ap  = ''; $filtro_sql_mp  = ''; $filtro_sql_tc  = '';

		/*filtro_trabajador: 7
		filtro_anio_pago: 2024
		filtro_p_all_mes_pago: Mayo
		filtro_tipo_comprob: 03*/

		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') { $filtro_sql_trab = "AND pt.idpersona_trabajador = '$this->id_trabajador_sesion'";	}

		if ( empty($filtro_trabajador) 	   || $filtro_trabajador 	   == 'TODOS' ) { } else{	$filtro_sql_trab	= "AND pt.idpersona_trabajador = '$filtro_trabajador'";	}
		if ( empty($filtro_anio_pago) 	   || $filtro_anio_pago 		 == 'TODOS' ) { } else{ $filtro_sql_ap 	= "AND v.name_year             = '$filtro_anio_pago'";	}
		if ( empty($filtro_p_all_mes_pago) || $filtro_p_all_mes_pago == 'TODOS' ) { } else{	$filtro_sql_mp 		= "AND v.name_month            = '$filtro_p_all_mes_pago'";	}
		if ( empty($filtro_tipo_comprob)   || $filtro_tipo_comprob   == 'TODOS' ) { } else{	$filtro_sql_tc 		= "AND v.tipo_comprobante      = '$filtro_tipo_comprob'";	}
		
		$sql = "SELECT v.idventa, 		
		CASE 
		WHEN p1.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p1.nombre_razonsocial, ' ', p1.apellidos_nombrecomercial) 
		WHEN p1.tipo_persona_sunat = 'JURÍDICA' THEN p1.nombre_razonsocial 
		ELSE '-'
		END AS nombre_completoCliente, 
		i.abreviatura as tipoDocumentoCliente, 
		CASE v.tipo_comprobante WHEN '03' THEN 'BOLETA' WHEN '07' THEN 'NOTA CRED.' ELSE tc.abreviatura END AS tp_comprobante_v2,
		p1.numero_documento nroDocumentoCliente, p1.celular as cellCliente, 
		p1.foto_perfil as foto_perfilCliente, pc.idpersona_cliente as idCliente, 
		p2.nombre_razonsocial as nombre_completoTrabajador, 
		pt.idpersona_trabajador as idTrabajador,tc.abreviatura as tipo_comprobante, v.user_created, 
		u.idusuario, u.idpersona, pu.nombre_razonsocial as user_created_pago  ,
		v.crear_enviar_sunat, v.es_cobro,  CONCAT(v.serie_comprobante,'-', v.numero_comprobante) as correlativo, v.fecha_emision, v.name_day, 
		v.name_month, v.name_year, v.periodo_pago, v.periodo_pago_format, CONCAT(v.periodo_pago_month,' ', v.periodo_pago_year ) as peridoPago,
		v.venta_total total_general,vd.subtotal_no_descuento as total_Pag_servicio , v.observacion_documento, 
		v.estado, v.estado_delete, v.created_at, v.updated_at, v.user_trash, v.user_delete, v.user_created, v.user_updated
		FROM venta as v
    INNER JOIN venta_detalle as vd on v.idventa = vd.idventa
		INNER JOIN sunat_c01_tipo_comprobante as tc on v.tipo_comprobante = tc.codigo
		INNER JOIN persona_cliente as pc on v.idpersona_cliente= pc.idpersona_cliente
		INNER JOIN persona_trabajador as pt on pc.idpersona_trabajador = pt.idpersona_trabajador
		INNER JOIN persona as p1 on pc.idpersona = p1.idpersona
		INNER JOIN sunat_c06_doc_identidad as i on p1.tipo_documento=i.code_sunat  
		INNER JOIN persona as p2 on pt.idpersona = p2.idpersona
		INNER JOIN usuario as u on v.user_created = u.idusuario
		INNER JOIN persona as pu on u.idpersona = pu.idpersona
		WHERE v.estado='1' and v.estado_delete ='1' and v.es_cobro='SI' and vd.um_nombre='SERVICIOS'
		
		$filtro_sql_trab $filtro_sql_ap $filtro_sql_mp $filtro_sql_tc
		ORDER BY v.idventa DESC";
		return ejecutarConsulta($sql);
	}

	// ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════
	public function select2_filtro_trabajador()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "WHERE pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT LPAD(pt.idpersona_trabajador, 5, '0') as idtrabajador, pt.idpersona_trabajador, pt.idpersona,  per_t.nombre_razonsocial
		FROM  persona_cliente as pc 	
		INNER JOIN persona_trabajador as pt ON pt.idpersona_trabajador = pc.idpersona_trabajador
		INNER JOIN persona as per_t ON per_t.idpersona = pt.idpersona
		$filtro_id_trabajador
		GROUP BY pc.idpersona_trabajador
		ORDER BY per_t.nombre_razonsocial;";
		return ejecutarConsulta($sql);
	}

	
	public function select2_filtro_anio_pago()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT DISTINCT v.name_year as anio_cancelacion
		FROM venta as v 
    INNER JOIN persona_cliente as pc on v.idpersona_cliente = pc.idpersona_cliente
		$filtro_id_trabajador
		ORDER BY v.name_year DESC;";
		return ejecutarConsulta($sql);
	}

	public function select2_filtro_mes_pago()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT DISTINCT v.name_month as mes_cancelacion
		FROM venta as v 
    INNER JOIN persona_cliente as pc on v.idpersona_cliente = pc.idpersona_cliente
		$filtro_id_trabajador
		ORDER BY v.name_month DESC;";
		return ejecutarConsulta($sql);
	}

	public function select2_filtro_tipo_comprob()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT DISTINCT v.tipo_comprobante, tc.abreviatura
		FROM venta as v 
    INNER JOIN sunat_c01_tipo_comprobante as tc on v.tipo_comprobante = tc.codigo
    INNER JOIN persona_cliente as pc on v.idpersona_cliente = pc.idpersona_cliente
    where v.es_cobro = 'si'		$filtro_id_trabajador
		ORDER BY tc.abreviatura DESC;";
		return ejecutarConsulta($sql);
	}



}
