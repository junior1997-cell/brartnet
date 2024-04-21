<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Anticipo_cliente
  {

    //Implementamos nuestro constructor
    public $id_usr_sesion; 
    // public $id_empresa_sesion;
    //Implementamos nuestro constructor
    public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
    {
      $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
      // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
    }


    public function tabla_clientes() {

      $sql= "SELECT 
              ac.idpersona_cliente,
              p.nombre_razonsocial AS nombres,
              p.apellidos_nombrecomercial AS apellidos,
              SUM(CASE WHEN ac.tipo = 'EGRESO' THEN ac.total * -1 ELSE ac.total END) AS total_anticipo
            FROM anticipo_cliente ac
            INNER JOIN persona_cliente pc ON ac.idpersona_cliente = pc.idpersona_cliente
            INNER JOIN persona p ON pc.idpersona = p.idpersona
            GROUP BY ac.idpersona_cliente";
      return ejecutarConsulta($sql);
    } 


    public function tabla_anticipos($idpersona_cliente){
      $sql = "SELECT 
                ac.idanticipo_cliente,
                ac.idpersona_cliente,
                p.nombre_razonsocial AS nombres, 
                p.apellidos_nombrecomercial AS apellidos,
                ac.tipo, 
                ac.fecha_anticipo,
                ac.descripcion, 
                stp_a.abreviatura AS tc_anticipo,  
                ac.serie_comprobante AS sc_anticipo, 
                ac.numero_comprobante AS nc_anticipo,
                stp_v.abreviatura AS tc_venta, 
                v.serie_comprobante AS sc_venta, 
                v.numero_comprobante AS nc_venta,
                ac.total,
                CASE 
                  WHEN ac.tipo = 'EGRESO' THEN ac.total * -1
                  ELSE ac.total 
                END AS monto_anticipo,
                SUM(CASE WHEN ac.tipo = 'EGRESO' THEN ac.total * -1 ELSE ac.total END) OVER (PARTITION BY ac.idpersona_cliente) AS total_anticipo
            FROM 
              anticipo_cliente ac
              LEFT JOIN venta v ON ac.idventa = v.idventa
              INNER JOIN persona_cliente pc ON ac.idpersona_cliente = pc.idpersona_cliente
              INNER JOIN persona p ON pc.idpersona = p.idpersona
              LEFT JOIN sunat_c01_tipo_comprobante stp_v ON v.tipo_comprobante = stp_v.idtipo_comprobante
              LEFT JOIN sunat_c01_tipo_comprobante stp_a ON ac.tipo_comprobante = stp_a.codigo
            WHERE 
              ac.idpersona_cliente = '$idpersona_cliente'
            GROUP BY
              ac.idanticipo_cliente,
              ac.idpersona_cliente,
              p.nombre_razonsocial,
              p.apellidos_nombrecomercial";
      return ejecutarConsulta($sql);

    }

    public function insertar($idpersona_cliente, $fecha,$descripcion, $tipo, $total, $tipo_comprobante, $serie, $numero){
      $sql = "INSERT INTO anticipo_cliente(idpersona_cliente,fecha_anticipo,descripcion,tipo,total,tipo_comprobante,serie_comprobante,numero_comprobante) VALUES ('$idpersona_cliente','$fecha','$descripcion','$tipo','$total', '$tipo_comprobante', '$serie', '$numero')";
      $insertar = ejecutarConsulta_retornarID($sql, 'C'); if ($insertar['status'] == false) {  return $insertar; } 
      return $insertar;
    }

    public function ticket_anticipo($idanticipo_cliente){
      $sql = "SELECT  
                ac.idanticipo_cliente,
                ac.idpersona_cliente, 
                p.nombre_razonsocial, 
                p.apellidos_nombrecomercial, 
                sdi.abreviatura,
                p.numero_documento,
                p.direccion,
                ac.fecha_anticipo,
                ac.serie_comprobante,
                ac.numero_comprobante,
                ac.total
              FROM anticipo_cliente ac
              INNER JOIN persona_cliente pc ON ac.idpersona_cliente = pc.idpersona_cliente
              INNER JOIN persona p ON pc.idpersona = p.idpersona
              INNER JOIN sunat_c06_doc_identidad sdi ON p.tipo_documento = sdi.idsunat_c06_doc_identidad
              WHERE ac.idanticipo_cliente = '$idanticipo_cliente'";
      return ejecutarConsultaSimpleFila($sql);
    }

    public function numeracion($ser){
      $sql = "SELECT COALESCE(MAX(numero_comprobante) + 1, 1) AS NnumSerieActual
              FROM sunat_c01_tipo_comprobante stc
              INNER JOIN anticipo_cliente ac ON stc.serie = '$ser'";
      return ejecutarConsulta($sql);
    }

    public function selectSerie(){
      $sql = "SELECT serie FROM sunat_c01_tipo_comprobante WHERE codigo='102' GROUP BY serie";
      return ejecutarConsulta($sql);
    }

    public function select_cliente()	{
      
      $sql="SELECT pc.idpersona_cliente, p.nombre_razonsocial AS nombres, p.apellidos_nombrecomercial AS apellidos
            FROM persona_cliente pc
            INNER JOIN persona p ON pc.idpersona = p.idpersona;";
      return ejecutarConsultaArray($sql);   
    }


    public function empresa(){
      $sql = "SELECT * FROM empresa WHERE numero_documento = '20610630431'";
      return ejecutarConsultaSimpleFila($sql);
    }


  }