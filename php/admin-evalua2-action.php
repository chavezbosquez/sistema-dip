<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $posgrado_id = $_POST['posgrado_id'];
    $clave_evaluacion = $_POST['clave_evaluacion'];
    // Recibir valores
    $dictamen = $_POST['dictamen'];
    $calificacion = $_POST['calificacion'];
    $observaciones = $_POST['observaciones'];

    require_once 'php/bd.php';
    $fecha = date("Y/m/d", time());
    //die("{$referencia},{$clave_evaluacion},{$dictamen},{$calificacion},{$observaciones}");
    $pdo = BaseDeDatos::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE evaluacion SET fecha_fin=?,calificacion=?,dictamen=?,observaciones=?,estatus=? WHERE evaluacion_id = ?";
    try {
      $cons = $pdo->prepare($sql);
      $cons->execute( array($fecha, $calificacion, $dictamen, $observaciones, "Finalizada", $clave_evaluacion) );
    } catch(PDOException $e) {
      echo("Error en la consulta");
      die($e->getMessage());  
    }

    BaseDeDatos::desconectar();
    header("location: admin.php?opcion=3");
  }