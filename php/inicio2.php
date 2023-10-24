<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $posgrado_id = $_GET['posgrado_id'];
    $revision_id = $_GET['revision_id'];
    $evaluacion_id = $_GET['evaluacion_id'];
    $archivo_evaluacion = $_GET['archivo_evaluacion'];
    require_once 'php/posgrado.php';
    $registro = Posgrado::getDatosDetalle($posgrado_id);
    extract($registro);
    $logo = 'img/logos/' . strtolower($division_id) . '.png';
    $archivo = 'archivos/' . $evaluacion_id . '/' . $archivo_evaluacion;
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
        <h3 class="float-start">Concluir evaluación</h3>
        <div class="float-end">
        <a class="btn btn-outline-success" href="inicio.php" title="Regresar a la página principal">
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

      <table class="table table-borderless table-condensed table-hover mb-4 w-50 mx-auto">
        <tr>
          <td class="border border-0">
          <h3 class="text-end"><?= $nombre ?></h2>
            <h5 class="text-end"><?= $nombre_division ?></h4>
            <p class="lead text-end">Número de referencia: <?= $referencia ?></p>
            <p class="text-center"><a href="<?= $archivo ?>" class="btn btn-info"><i class="bi bi-check-circle"></i> Descargar pre-evaluación</a></p>
          </td>
          <td class="border border-0">
            <figure>
            <img src="<?= $logo ?>" width="80px">
            </figure>
          </td>
        </tr>
      </table>
      
      <fieldset class="reset-fieldset form-group border rounded-3 p-3 mb-4 w-75 mx-auto">
        <legend class="reset-fieldset fs-5 w-auto px-2">Evaluación</legend>
        <!--<p class="text-center"><a href=""><i class="bi bi-file-earmark-excel"></i> Descargar formato de evaluación</a></p>-->
        <form class="was-validated" id="carga" name="carga" method="post" enctype="multipart/form-data" action="inicio2-action.php">
          <input type="hidden" name="revision_id" value="<?= $revision_id ?>" />
          <input type="hidden" name="evaluacion_id" value="<?= $evaluacion_id ?>" />
          
          <div class="row g-3 align-items-center mb-3">
            <div class="col-md-2">
              <label for="archivo" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Formato</label>
            </div>
            <div class="col-auto">
            <a href="docs/Formato.xlsx"><i class="bi bi-file-earmark-excel"></i> Descargar formato de evaluación</a>
            </div>
          </div>
          
          <div class="row g-3 align-items-center mb-3">
            <div class="col-md-2">
              <label for="archivo" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Evaluación</label>
            </div>
            <div class="col-md-7">
              <input type="file" name="archivo" id="archivo" class="form-control" aria-label="archivo" autofocus required
                     accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              <div class="invalid-feedback">Selecciona el archivo .xlsx</div>
            </div>
          </div>

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
          <!--<div class="row g-3 align-items-center mb-3">
            <div class="col-md-2">
              <label for="calificacion" class="fw-bold d-flex justify-content-end align-items-end pe-3 col-form-label">Calificación</label>
            </div>
            <div class="col-md-2">
              <input type="number" class="form-control" name="calificacion" id="calificacion" required>
            </div>
          </div>-->
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
            <a class="btn btn-secondary ps-5 pe-5" href="inicio.php">Cancelar</a>
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