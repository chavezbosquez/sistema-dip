<?php
  session_start();
  if ( (isset($_SESSION['login'])) && ($_SESSION['login'] != '') ) {
    header("location: inicio.php");
  } else  //Mostrar errores de validación de usuario, en caso de que lleguen
    if( isset( $_POST['error'] ) ) {
      $clave  = $_POST['clave'];
      $contra = $_POST['contra'];
    }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema DIP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons.css">
    <link rel="stylesheet" href="css/stylo.css">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
    <script src="js/jquery-3.7.1.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>-->
    <script src="js/popper.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>-->
    <script src="js/bootstrap.min.js"></script>    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>-->
    <script src="js/bootbox.all.min.js"></script>
  </head>
  <body role="document">
    <header>
      <div class="jumbotron container display-4 rounded-bottom">
        <div class="escudo"></div>
        <div class="dip"></div>
      </div>
    </header>
    <main role="main" class="card container container-fluid body-content rounded p-4 mb-4">
      <div class="row m-2">
        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
          <h2><i class="bi bi-lock-fill"></i> Acceso</h2>
          <form action="php/login.php" method="post" role="form">
            <div class="form-group mb-2">
              <label class="control-label" for="clave">Nombre de usuario</label>
              <input class="form-control" data-val="true" data-val-required="Nombre de usuario es obligatorio." id="clave" name="clave" type="text" autofocus required value="<?php echo (isset($clave)) ? $clave : ''; ?>">
              <span class="field-validation-valid text-danger" data-valmsg-for="clave" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group mb-4">
              <label class="control-label" for="contra">Contrase&#241;a</label>
              <input autocomplete="off" class="form-control" data-val="true" data-val-required="Contraseña es obligatoria." id="contra" name="contra" type="password" required value="<?php echo (isset($contra)) ? $contra : ''; ?>">
              <span class="field-validation-valid text-danger" data-valmsg-for="contra" data-valmsg-replace="true"></span>
            </div>
            <div class="d-grid">
              <button class="btn btn-info" type="submit">Ingresar</button>
            </div>
            <!--<hr>
            <div class="form-group">
              <a href="">¿Ha olvidado su contraseña?</a>
            </div>-->
            </form>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-0 col-lg-offset-1" style="margin-left: 50px; margin-top: 20px;">
          <h1>Sistema de Evaluación de los Programas de Estudio de Posgrados de la UJAT 2023</h1>
          <!--
            <p class="text-justify">De acuerdo a la normatividad vigente, todas las Unidades Responsables deben realizar el proceso de entrega durante el presente año.</p>
          -->
            <p class="text-justify"><a href="docs/lineamientos2023.pdf" target="_blank">Lineamientos para la Evaluación de los Programas de Estudio de Posgrados de la UJAT</a>.</p>
        </div>
      </div>
      <div style="margin: 100px;"></div>
    </main>
    
    <footer class="footer container rounded">
      <div class="clearfix small mb-2">
        <p class="float-start">© 2023 Dirección de Investigación</p>
        <div class="float-end">Universidad Juárez Autónoma de Tabasco</div>
      </div>
    </footer>
    <!--
    <p>Content here. <a class="show-alert" href="#">Alert!</a></p>
    <script>
    $(document).on('click', '.show-alert', function (e) {
      bootbox.error('<h3>Acceso denegado</h3>Hello world!', function () {
        console.log('Alert Callback');
      });
    });
  </script>
  -->
  </body>
  <?php
    if (isset($_POST['error'])) {
      echo('<script>');
      //echo('document.addEventListener("DOMContentLoaded", function() {  bootbox.alert("Credenciales de acceso incorrectas.");  });');
      //echo('$( document ).ready(function() {  bootbox.alert("Credenciales de acceso incorrectas.");    });');
      echo('$(function() {  bootbox.alert("Credenciales de acceso incorrectas.");  })');
      echo('</script>');
    }
  ?>
</html>