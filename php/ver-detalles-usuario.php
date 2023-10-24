<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    //
    $revision_id = $_GET['revision_id'];
    include_once 'php/posgrado.php';
    $revision = Posgrado::getRevisionEvaluacion($revision_id);
    extract($revision);
    $archivo = 'archivos/' . $evaluacion_id . '/' . $archivo_revision;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema DIP</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body role="main">
<table class="table table-striped table-hover">
      <tbody>
        <tr class="table-info">
          <td class="text-right">Clave de la revisión</td>
          <td class="fw-bold"><?= $revision_id ?></td>
        </tr>
        <tr>
          <td class="text-right">Fecha de envío</td>
          <td><?= $fecha_fin ?></td>
        </tr>
        <!--<tr>
          <td class="text-right">Calificación</td>
          <td><?= $calificacion ?></td>
        </tr>-->
        <tr>
          <td class="text-right">Dictamen</td>
          <td><code><?= $dictamen ?></code></td>
        </tr>
        <tr>
          <td class="text-right">Observaciones</td>
          <td class="fst-italic"><?= $observaciones ?></td>
        </tr>
        <tr>
          <td class="text-right">Archivo</td>
          <td><?php echo("<a href='{$archivo}'>{$archivo_revision}</a>"); ?></td>
        </tr>
        <tr>
          <td class="text-right">Estatus</td>
          <td><?= $estatus ?></td>
        </tr>
        </tbody>
  </table>
</body>

</html>

<?php
  }
?>