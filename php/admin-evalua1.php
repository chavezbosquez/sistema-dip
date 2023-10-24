<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $posgrado_id = $_GET['posgrado_id'];
    require_once 'php/posgrado.php';
    $registro = Posgrado::getDatosDetalle($posgrado_id);
    extract($registro);
    $logo = 'img/logos/' . strtolower($division_id) . '.png';
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
  <script>
    function contarCIP() {
      var seleccionados = document.querySelectorAll('input[type="checkbox"]:checked').length;
      if (seleccionados >= 3) {
        return true;
      } else {
        alert('Debes seleccionar al menos 3 revisores');
        //return false;
      }
    }
  </script>
  <style>
    input:checked + label {
      color: #157347 !important;
    }
    input:checked {
      border: 1px solid #198754 !important;
    }
  </style>
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
        <h3 class="float-start">Evaluar posgrado</h3>
        <div class="float-end">
        <a class="btn btn-outline-success" href="admin.php?opcion=1" title="Regresar a la página principal">
          <i class="bi bi-arrow-left-circle"></i>
          Regresar
        </a>
          <a class="btn btn-outline-secondary" href="php/salir.php">
            <i class="bi bi-x-square"></i>
            Cerrar sesión
          </a>
        </div>
      </div>
      <hr>

      <table class="table table-borderless table-condensed table-hover mb-2 w-50 mx-auto">
        <tr>
          <td class="border border-0">
          <figure>
            <img src="<?= $logo ?>" width="100px">
          </figure>
          </td>
          <td class="border border-0">
            <h2><?= $nombre ?></h2>
            <h4><?= $nombre_division ?></h4>
            <p class="lead">Número de referencia: <?= $referencia ?></h5>
          </td>
        </tr>
      </table>
      <p></p>
      
      <form class="was-validated border rounded-3 p-3 w-75 mx-auto" id="carga" name="carga" method="post" enctype="multipart/form-data" action="admin-evalua1-action.php" onsubmit="return contarCIP()">
        <input type="hidden" name="posgrado_id" value=<?= $posgrado_id ?>>
        <div class="mb-4 col-md-7">
          <label for="archivo" class="form-label fs-5">1. Cargar formato DP-01</label>:
          <div class="mb-3">
          <input type="file" name="archivo" id="archivo" class="form-control" aria-label="archivo" autofocus required 
                 accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            <div class="invalid-feedback">Selecciona el archivo .xlsx</div>
          </div>
        </div>
        <p class="fs-5">2. Selecciona al menos 3 evaluadores de la CIP:</p>
        <div class="col-6 mb-5">
        <?php
          include_once 'php/usuario.php';
          $listaCIP = Usuario::getCIP();
          foreach ($listaCIP as $registro) {
            extract($registro);
        ?>
          <div class="form-check mb-3">
            <input class="form-check-input border-danger" style="font-size: 1.1rem;" type="checkbox" value="<?= $clave ?>" id="<?= $clave ?>" name="lista-cip[]">
            <label class="fw-boldform-check-label text-danger" style="font-size: 1.1rem;" for="<?= $clave ?>">
              <?= $nombre . ' - ' . $division_id ?>
            </label>
            <!--<div class="invalid-feedback">
              DACyTI
            </div>-->
          </div>
          <?php } ?>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary me-2">Comenzar evaluación</button>
          <a class="btn btn-secondary ps-5 pe-5" href="admin.php?opcion=1">Cancelar</a>
        </div>
  </form>
      
  </main>

  <footer class="footer container rounded">
    <div class="clearfix small mb-2">
      <p class="float-start">© 2023 Dirección de Investigación</p>
      <div class="float-end">Universidad Juárez Autónoma de Tabasco</div>
    </div>
  </footer>

  <script src="js/dialogos.js"></script>

</body>
</html>

<?php
  }
?>