<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  Class Home
  {
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    function mostrar_tecnico_redes(){
      $sql = "SELECT p.nombre_razonsocial nombre, p.apellidos_nombrecomercial apellidos, ct.nombre cargo, p.foto_perfil
              FROM persona p
              JOIN cargo_trabajador ct ON p.idcargo_trabajador = ct.idcargo_trabajador
              WHERE p.idcargo_trabajador = 5";
      $mostrar = ejecutarConsultaArray($sql); if($mostrar['status'] == false){return $mostrar;}
      return $mostrar;
    }

    function mostrar_planes(){
      $sql = "SELECT nombre AS plan, costo FROM plan WHERE estado = 1 AND estado_delete = 1";
      $plan = ejecutarConsultaArray($sql); if($plan['status'] == false){return $plan;}
      return $plan;
    }


  }
?>