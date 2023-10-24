<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $posgrado_id = $_GET['posgrado_id'];
    $evaluacion_id = $_GET['evaluacion_id'];
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
</head>

<body role="document">
  <header>
    <div class="jumbotron container display-4 rounded-bottom">
      <div class="escudo"></div>
      <div class="dip"></div>
    </div>
  </header>
  <main role="main" class="card container container-fluid body-content rounded p-4 mb-4>
    <div class="row p-2">
      <div class="clearfix mb-2">
        <h3 class="float-start">Concluir evaluación</h3>
        <div class="float-end">
        <a class="btn btn-outline-success" href="admin.php?opcion=2" title="Regresar a la página principal">
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
          <h3 class="text-end"><?= $nombre ?></h2>
            <h5 class="text-end"><?= $nombre_division ?></h4>
            <p class="lead text-end">Número de referencia: <?= $referencia ?></p>
          </td>
          <td class="border border-0">
            <figure>
            <img src="<?= $logo ?>" width="80px">
            </figure>
          </td>
        </tr>
      </table>
      <p></p>
      <fieldset class="reset-fieldset form-group border rounded-3 p-3 mb-4 w-75 mx-auto">
        <legend class="reset-fieldset fs-5 w-auto px-2">Revisiones de la CIP</legend>
        <table class="table table-striped table-bordered table-hover text-center">
          <thead class="table-info">
            <th>Nombre</th>
            <th>División</th>
            <th>Estatus</th>
            <th>Fecha</th>
            <th>Dictamen</th>
            <th>Observaciones</th>
            <th>Archivo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              require_once 'php/posgrado.php';
              $listaCIP = Posgrado::getEvaluadoresCIP($evaluacion_id);
              foreach ($listaCIP as $registro) {
                extract($registro);
                $revision = Posgrado::getRevision($revision_id);
                extract($revision);
                echo('<tr>');
                echo("<td class='text-start'>{$nombre}</td>");
                echo("<td class='fw-bold'>{$division_id}</td>");
                echo("<td>{$estatus}</td>");
                if (is_null($fecha_fin)) {
                  echo("<td>[]</td>");
                } else {
                  echo("<td>{$fecha_fin}</td>");
                }
                if (is_null($dictamen)) {
                  echo("<td>[]</td>");
                } else {
                  echo("<td><code>{$dictamen}</code></td>");
                }
                if (is_null($observaciones)) {
                  echo("<td>[]</td>");
                } else {
                  echo("<td class='fst-italic'>{$observaciones}</td>");
                }
                if (is_null($archivo_revision)) {
                  echo("<td>[]</td>");
                } else {
                  $archivo = 'archivos/' . $evaluacion_id . '/' . $archivo_revision;
                  echo("<td><a href='{$archivo}'>{$archivo_revision}</a></td>");
                }
                echo("</tr>");
              }
              if ( empty($listaCIP) ) {
                echo("<tr><td colspan='8' class='text-start'>¿No hay revisores asignados? Contacte al administrador.</td></tr>");
              }
            ?>
          </tbody>
        </table>
      </fieldset>
      
      <fieldset class="reset-fieldset form-group border rounded-3 p-3 mb-4 w-75 mx-auto">
        <legend class="reset-fieldset fs-5 w-auto px-2">Evaluación</legend>
        <form class="was-validated" id="carga" name="carga" method="post" enctype="multipart/form-data" action="admin-evalua2-action.php">
          <input type="hidden" name="posgrado_id" value="<?= $posgrado_id ?>" /> 
          <input type="hidden" name="clave_evaluacion" value="<?= $evaluacion_id ?>" /> 
          <div class="row g-3 align-items-center mb-3">
            <div class="col-md-2">
              <label for="dictamen" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Dictamen</label>
            </div>
            <div class="col-auto">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dictamen" id="aprobado" value="Aprobado" required>
                <label class="form-check-label" for="aprobado">Aprobado</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dictamen" id="aprobado-observaciones" value="Aprobado con observaciones">
                <label class="form-check-label" for="aprobado-observaciones">Aprobado con observaciones</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dictamen" id="suspension-temporal" value="Suspensión temporal">
                <label class="form-check-label" for="suspension-temporal">Suspensión temporal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dictamen" id="suspension-definitiva" value="Suspensión definitiva">
                <label class="form-check-label" for="suspension-definitiva">Suspensión definitiva</label>
              </div>
            </div>
          </div>
          <div class="row g-3 align-items-center mb-3">
            <div class="col-md-2">
              <label for="calificacion" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Calificación</label>
            </div>
            <div class="col-md-2">
              <input type="number" class="form-control" name="calificacion" id="calificacion" required>
            </div>
          </div>
          <div class="row g-3 align-items-center mb-4">
            <div class="col-md-2">
              <label for="observaciones" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Observaciones y recomendaciones</label>
            </div>
            <div class="col-md-9">
              <textarea class="form-control" name="observaciones" id="observaciones" placeholder="" required></textarea>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary me-2">Concluir evaluación</button>
            <a class="btn btn-secondary ps-5 pe-5" href="admin.php?opcion=2">Cancelar</a>
          </div>
        </form>
      </fieldset>

      
      
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