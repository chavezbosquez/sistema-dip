<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $posgrado_id = $_POST['posgrado_id'];
    $listaCIP = $_POST['lista-cip'];

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

    include_once 'php/posgrado.php';
    $registro = Posgrado::getDatosGenerales($posgrado_id);
    extract($registro);

    $hoy = new DateTime();
    $anho = $hoy->format("Y");
    
    /* 1. Crear el directorio */
    $oldmask = umask(0);
    $clave_evaluacion = $division_id . '-' . $acronimo . "-" . $anho;
    $directorio = "archivos/" . $clave_evaluacion . "/";
    if ( !file_exists($directorio) ) {
      mkdir($directorio, 0777, true);
    } else {
      die("Error fatal: Ya existe el directorio. Contacte al Administrador del Sistema.");
    }
    umask($oldmask);
    
    $fecha = date("Y/m/d", time());
    ////$tamanho = ceil($_FILES["archivo"]["size"] / 1024);
    //move_uploaded_file($_FILES["archivo"]["tmp_name"], "archivos/" . $_FILES["archivo"]["name"]);
    /* 2. Nombre del archivo */
    $nombre_archivo = $clave_evaluacion . ".xlsx";
    $_FILES["archivo"]["name"] = $nombre_archivo;
    if ( !move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $_FILES["archivo"]["name"]) ) {
      echo($nombre_archivo);
      die ("Error al copiar el archivo: " . $_FILES["archivo"]["error"]);
    }
    require_once 'php/bd.php';
    $pdo = BaseDeDatos::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO evaluacion(evaluacion_id,fecha_inicio,archivo_evaluacion,estatus,posgrado_id,administrador_id) VALUES(?,?,?,?,?,?)";
    try {
      $cons = $pdo->prepare($sql);
      $cons->execute( array($clave_evaluacion, $fecha, $_FILES["archivo"]["name"], "Asignada", $posgrado_id, $_SESSION['login']) );
    } catch(PDOException $e) {
      echo("Error al crear la evaluación:");
      die($e->getMessage());  
    }

    /* Guardar los revisores de la CIP */
    foreach ($listaCIP as $clave_usuario) {
      $clave_revision = $clave_usuario . "-" . $division_id . "-" . $acronimo . "-" . $anho;
      $sql = "INSERT INTO revision(revision_id,estatus,evaluacion_id,revisor_id) VALUES(?,?,?,?)";
      try {
        $cons = $pdo->prepare($sql);
        $cons->execute( array($clave_revision, "Asignada", $clave_evaluacion, $clave_usuario) );
      } catch(PDOException $e) {
        echo("Error al crear la revisión:");
        die($e->getMessage());  
      }
    }
    BaseDeDatos::desconectar();
    //header("location: admin-evalua2.php?posgrado_id={$posgrado_id}&evaluacion_id={$clave_evaluacion}");
    header("location: admin.php?opcion=2");
  }