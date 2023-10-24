<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    if ( !isset($_GET['opcion']) ) {
      $opcion = 1;
    } else {
      $opcion  = $_GET['opcion'];
    }
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
        <h3 class="float-start">Bienvenido <?php echo($_SESSION["login"]); ?></h3>
        <div class="float-end">
          <a class="btn btn-outline-secondary" href="php/salir.php">
            <i class="bi bi-x-square"></i>
            Cerrar sesión
          </a>
        </div>
      </div>
      <hr>
      <figure class="text-center">
        <img src="img/ujat.png" width="150px">
      </figure>

      <!--
        Menú: 
        - Posgrados sin revisar
        - Posgrados en revisión
        - Posgrados revisados
      -->
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link <?php if ($opcion==1) echo('active') ?>" id="nav-posgrados-tab" data-bs-toggle="tab" data-bs-target="#nav-posgrados" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><span><i class="bi bi-table"></i> Posgrados sin evaluar</span></button>
          <button class="nav-link <?php if ($opcion==2) echo('active') ?>" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><span><i class="bi bi-exclamation-triangle-fill"></i> Posgrados en evaluación</span></button>
          <button class="nav-link <?php if ($opcion==3) echo('active') ?>" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><span><i class="bi bi-check-circle"></i> Posgrados evaluados</span></button>
          <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled><i class="bi bi-people-fill"></i> Usuarios</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane <?php if ($opcion==1) echo('show active') ?>" id="nav-posgrados" role="tabpanel" aria-labelledby="nav-posgrados-tab" tabindex="0"><?php include_once 'posgrados-sin-evaluar.html' ?></div>
        <div class="tab-pane <?php if ($opcion==2) echo('show active') ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0"><?php include_once 'posgrados-en-evaluacion.html' ?></div>
        <div class="tab-pane <?php if ($opcion==3) echo('show active') ?>" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0"><?php include_once 'posgrados-evaluados.html' ?></div>
        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
      </div>      
    </div>
</div>
    
  <?php include_once 'js/ventana-modal.html' ?>

  </main>

  <footer class="footer container rounded">
    <div class="clearfix small mb-2">
      <p class="float-start">© 2023 Dirección de Investigación</p>
      <div class="float-end">Universidad Juárez Autónoma de Tabasco</div>
    </div>
  </footer>

</body>

  <!--<script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/popper.min.js"></script>-->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ventana-modal.js"></script>

</html>

<?php
  }
?>