<?php
  /* Gestiona el acceso al Sistema DIP con 3 tipos de usuario: 
    - Admin
    - Responsable de programa
    - Integrante de la Comisión Institucional de Posgrado (CIP) */
  session_start();
  $clave = $_POST['clave'];
  $contra = $_POST['contra'];
  //$ok = false;
  require 'bd.php';
  require 'utiles.php';
  $pdo = BaseDeDatos::conectar();
  $consulta = $pdo->query("SELECT contra,nombre,rol,estatus FROM usuario WHERE clave='{$clave}' LIMIT 1",PDO::FETCH_ASSOC);
  $registro = $consulta->fetch();
  if ($registro) {
    if ($registro['contra'] == $contra && $registro['estatus'] == Utiles::$ACTIVO) {
      /* Datos del usuario actual */
      $_SESSION['login']  = $clave;
      $_SESSION['nombre'] = $registro['nombre'];
      //if ($registro['rol'] == 'Administrador') {
      // Si el rol es el de Administrador
      if (strcasecmp($registro['rol'], 'Administrador') == 0) {
        $_SESSION['admin'] = Utiles::$ADMIN;
        echo "<form name='formulario' method='post' action='../admin.php'></form>";
      } else if (strcasecmp($registro['rol'], 'CIP') == 0) {
        $_SESSION['admin'] = Utiles::$CIP;
        echo "<form name='formulario' method='post' action='../inicio.php'></form>";
      } else {
        $_SESSION['admin'] = Utiles::$COORDINADOR;
        echo "<form name='formulario' method='post' action='../responsable.php'></form>";
      }
      //$ok = true;
    } else {
      echo("<form name='formulario' method='post' action='../index.php'>
			      <input type='hidden' name='error' value='1'>
		 	      <input type='hidden' name='clave' value='{$clave}'/>
		 	      <input type='hidden' name='contra' value='{$contra}'>
		        </form>");
    }
  }
  /*if ($ok) {
    if ($_SESSION['admin'] == 1) {
      echo "<form name='formulario' method='post' action='../admin.php'>
            </form>";
    } else {
      echo "<form name='formulario' method='post' action='../responsable.php'>
            </form>";
    }
  } else {
    echo "<form name='formulario' method='post' action='../index.php'>
			   <input type='hidden' name='error' value='1'>
		 	   <input type='hidden' name='clave' value='{$clave}'/>
		 	   <input type='hidden' name='contra' value='{$contra}'>
		     </form>";
  }*/
  BaseDeDatos::desconectar();
?>
<script> 
  //Redireccionar a la página correspondiente usando el formulario creado
  document.formulario.submit();
</script>
