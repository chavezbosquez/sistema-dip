<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $nombre =  $_SESSION['nombre'];
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
        <h3 class="float-start"><span class="fs-4">Usuario:</span> <?php echo($nombre); ?></h3>
        <div class="float-end">
          <a class="btn btn-outline-secondary" href="php/salir.php">
            <i class="bi bi-x-square"></i>
            Cerrar sesión
          </a>
        </div>
      </div>
      <hr>
      <figure class='text-center mb-5'>
        <img src='img/ujat.png' width='150px'>
        <h3>Comisión Institucional de Posgrado</h3>
      </figure>
      <!-- No hay ninguna revisión asignada -->
      <?php
        include_once 'php/usuario.php';
        $lista = Usuario::getRevisionesAsignadas($usuario);
        if ( empty($lista) ) {
          echo("<div class='alert alert-info d-flex alert-dismissible fade show w-50 mx-auto mb-5s' role='alert'>
                  <br>
                  <p class='lead'>Usted no tiene ninguna evaluación que realizar.</p>
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>");
        } else {
          echo("<fieldset class='reset-fieldset form-group border rounded-3 pt-3 pb-4 ps-4 pe-4 mb-5 w-75 mx-auto'>
                  <legend class='reset-fieldset fs-5 w-auto px-2'>Evaluaciones asignadas:</legend>");
          echo("<table class='table border border-danger-subtle table-condensed table-hover mb-2'>");
          echo("<thead class='table-danger'>
                  <th>Posgrado</th>
                  <th>División</th>
                  <th>Acción</th>
                </thead>");
          foreach($lista as $registro) {
            extract($registro);
            $logo = 'img/logos/' . strtolower($division) . '.png';
            echo("<tr>");
            echo("<td><img src='{$logo}' width='40px'>{$posgrado}</td>");
            echo("<td class='align-middle'>{$nombre_division}</td>");
            echo("<td class='align-middle'><a href='inicio2.php?posgrado_id={$posgrado_id}&evaluacion_id={$evaluacion_id}&revision_id={$revision_id}&archivo_evaluacion={$archivo_evaluacion}' class='text-decoration-none'>Evaluar <i class='bi bi-box-arrow-up-right'></i></a></td>");
            echo("</tr>");
          }
          echo("
          </table>");
          echo("</fieldset>");
        }
      ?>
      
      <!-- Historial de revisiones  -->
      <fieldset class="reset-fieldset form-group border rounded-3 pt-3 ps-4 pe-4 mb-4 w-75 mx-auto">
        <legend class="reset-fieldset fs-5 w-auto px-2">Historial de revisiones</legend>
        <table class="table table-striped table-bordered table-sm table-hover text-center">
          <thead class="table-secondary">
            <th>Posgrado</th>
            <th>División</th>
            <th>Fecha</th>
            <th>Archivo</th>
            <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php
              require_once 'php/posgrado.php';
              $listaHistorial = Usuario::getHistorialRevisiones($usuario);
              foreach ($listaHistorial as $registro) {
                extract($registro);
                echo('<tr>');
                echo("<td class='text-start'>{$posgrado}</td>");
                echo("<td class='fw-bold'>{$division}</td>");
                echo("<td>{$fecha_fin}</td>");
                $directorio = "archivos/" . $evaluacion_id . "/";
                $archivo = $directorio . $archivo_revision;
                echo("<td><a href='{$archivo}'>{$archivo_revision}</a></td>");
                echo("<td><a href='' class='text-decoration-none' data-bs-toggle='modal' data-bs-target='#ventana-modal' data-bs-nombre='Evaluación: {$posgrado}' data-bs-url='ver-detalles-usuario.php?revision_id={$revision_id}' data-bs-tamanho='360px'><i class='bi bi-info-circle'></i> Ver detalles</a></td>");
                echo("</tr>");
              }
              if ( empty($listaHistorial) ) {
                echo("<tr><td colspan='8' class='text-start'>Ninguna evaluación realizada hasta el momento.</td></tr>");
              }
            ?>
          </tbody>
        </table>
      </fieldset>
    </div>
  </main>

  <footer class="footer container rounded">
    <div class="clearfix small mb-2">
      <p class="float-start">© 2023 Dirección de Investigación</p>
      <div class="float-end">Universidad Juárez Autónoma de Tabasco</div>
    </div>
  </footer>

  <?php include_once 'js/ventana-modal.html' ?>

</body>

  <!--<script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/popper.min.js"></script>-->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ventana-modal.js"></script>

</html>

<?php
  }
?>