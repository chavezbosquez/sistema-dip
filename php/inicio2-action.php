<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    // Recibir valores
    $revision_id   = $_POST['revision_id'];
    $evaluacion_id = $_POST['evaluacion_id'];
    $dictamen = $_POST['dictamen'];
    $observaciones = $_POST['observaciones'];
    var_dump($_POST);
    
    set_time_limit(0);  // Necesario para: [php fatal error: maximum execution time of 30 seconds exceeded]
    if ($_FILES["archivo"]["error"] > 0) {
      die("Error al cargar el archivo. ¿Archivo demasiado grande? C&oacute;digo de retorno: " . $_FILES["archivo"]["error"] . "<br />");
      $error = 2;
    }
    $el_archivo = $_FILES["archivo"]["name"];
    $extension = substr($el_archivo, strlen($el_archivo) - 4);
    if ($extension != "xlsx") {
      die("Archivo no v&aacute;lido (No es Excel).");
      $error = 1;
    }

    $hoy = new DateTime();
    $anho = $hoy->format("Y");
    
    $fecha = date("Y/m/d", time());
    /* 1. Nombre del archivo */
    $nombre_archivo = $revision_id . ".xlsx";
    $directorio = "archivos/" . $evaluacion_id . "/";
    $_FILES["archivo"]["name"] = $nombre_archivo;
    if ( !move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $_FILES["archivo"]["name"]) ) {
      echo($nombre_archivo);
      die ("Error al copiar el archivo. Código: " . $_FILES["archivo"]["error"]);
    }
    
    require_once 'php/bd.php';
    $pdo = BaseDeDatos::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE revision SET fecha_fin=?,dictamen=?,observaciones=?,archivo_revision=?,estatus=? WHERE revision_id = ?";
    try {
      $cons = $pdo->prepare($sql);
      $cons->execute( array($fecha, $dictamen, $observaciones, $nombre_archivo, "Finalizada", $revision_id) );
    } catch(PDOException $e) {
      echo("Error en la consulta");
      die($e->getMessage());  
    }

    /* Actualizar tabla <evaluacion> */
    $sql = "UPDATE evaluacion SET estatus=? WHERE evaluacion_id = ?";
    try {
      $cons = $pdo->prepare($sql);
      $cons->execute( array("En proceso", $evaluacion_id) );
    } catch(PDOException $e) {
      echo("Error en la consulta");
      die($e->getMessage());
    }
    
    BaseDeDatos::desconectar();
    header("location: inicio.php");
  }