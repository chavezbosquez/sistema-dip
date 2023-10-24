<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema DIP</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-icons.css">
  <link rel="stylesheet" href="css/stylo.css">
  <script src="js/bootstrap.min.js"></script>
</head>

<body role="document">
  <header>
    <div class="jumbotron container display-4 rounded-bottom">
      <div class="escudo"></div>
      <div class="dip"></div>
    </div>
  </header>
  <main role="main" class="card container container-fluid body-content rounded p-4 mb-4">
    <div class="row p-2">
      <div class="clearfix mb-2">
        <h2 class="float-start">Bienvenido <?php echo($_SESSION["login"]); ?></h2>
        <div class="float-end">
          <a class="btn btn-secondary" href="php/salir.php">
            <i class="bi bi-x-square"></i>
            Cerrar sesión
          </a>
        </div>
      </div>
      <hr>
      <figure class="text-center">
        <img src="img/ujat.png" width="150px">
      </figure>

      <!-- Información del posgrado -->
      <p class="lead">Maestría en Ciencias de la Computación</p>

      <div style="margin-bottom: 50px;"></div>
      </div>
    </div>
  </main>

  <footer class="footer container rounded">
    <div class="clearfix small mb-2">
      <p class="float-start">© 2023 Dirección de Investigación</p>
      <div class="float-end">Universidad Juárez Autónoma de Tabasco</div>
    </div>
  </footer>

</body>

</html>

<?php
  }
?>