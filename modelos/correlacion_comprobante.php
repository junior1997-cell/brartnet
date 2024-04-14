<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Correlacion_comprobante
  {
    //Implementamos nuestro constructor
    public $id_usr_sesion;   // public $id_empresa_sesion;

    public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )   {
      $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
      // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
    }

    function listar_tabla(){
      $sql = "SELECT * FROM sunat_c01_tipo_comprobante WHERE estado_delete = 1 ORDER BY estado DESC, codigo ASC";
      return ejecutarConsulta($sql);
    }

    public function validar($nombre)	{
      $sql="SELECT * from sunat_c01_tipo_comprobante where nombre='$nombre'";
      return ejecutarConsultaArray($sql);
    }

    public function insertar($codigo, $nombre, $abreviatura, $serie, $numero, $un1001) {

      $sql="INSERT INTO sunat_c01_tipo_comprobante(codigo, nombre, abreviatura, serie, numero, un1001)
      VALUES('$codigo', '$nombre', '$abreviatura', '$serie', '$numero', '$un1001')";  
      $insertar =  ejecutarConsulta_retornarID($sql);  if ($insertar['status'] == false) {  return $insertar; } 
      
      return $insertar;
    }

    public function editar($id, $codigo, $nombre, $abreviatura, $serie, $numero, $un1001) {

      $sql="UPDATE sunat_c01_tipo_comprobante SET  serie = '$serie', numero = '$numero'
      WHERE idtipo_comprobante='$id'";
      $editar =  ejecutarConsultaArray($sql);   if ( $editar['status'] == false) {return $editar; } 

      if ( empty($editar['data']) ) {
        
        $sql="UPDATE sunat_c01_tipo_comprobante SET  serie = '$serie', numero = '$numero'
        WHERE idtipo_comprobante='$id'";
        return ejecutarConsulta($sql);   

      } else {
        # code...
      }       
    }

    public function mostrar($id){
      $sql = "SELECT * FROM sunat_c01_tipo_comprobante Where idtipo_comprobante = '$id'";
      return ejecutarConsultaSimpleFila($sql);
    }
   
    public function desactivar($id) {      
      $sql="UPDATE sunat_c01_tipo_comprobante SET estado='0' WHERE idtipo_comprobante='$id'";
      return ejecutarConsulta($sql);        
    }

    public function activar($id) {
      $sql="UPDATE sunat_c01_tipo_comprobante SET estado='1' WHERE idtipo_comprobante='$id'";
      return ejecutarConsulta($sql);
    }

    public function eliminar($id) {      
      $sql="UPDATE sunat_c01_tipo_comprobante SET estado_delete='0' WHERE idtipo_comprobante='$id'";
      return  ejecutarConsulta($sql);  
    }

    public function listar_crl_comprobante($tipos){
      $sql="SELECT idtipo_comprobante, codigo, abreviatura AS tipo_comprobante, serie
      FROM sunat_c01_tipo_comprobante WHERE codigo in ($tipos) ;";
      return ejecutarConsultaArray($sql);
    }    

  }
?>