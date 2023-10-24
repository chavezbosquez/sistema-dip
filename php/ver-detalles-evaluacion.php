<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    //
    $evaluacion_id = $_GET['evaluacion_id'];
    require_once 'php/posgrado.php';
    $registro = Posgrado::getDetalleEvaluacion($evaluacion_id);
    extract($registro);
    $listaCIP = Posgrado::getEvaluadoresCIP($evaluacion_id);
    $archivo = 'archivos/' . $evaluacion_id . '/' . $archivo_evaluacion;
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
          <td class="text-right">Clave de la evaluación</td>
          <td class="fw-bold"><?= $evaluacion_id ?></td>
        </tr>
        <tr>
          <td class="text-right">Fecha de inicio</td>
          <td><?php echo date("d/m/Y",strtotime($fecha_inicio)); ?></td>
        </tr>
        <tr>
          <td class="text-right">Fecha de terminación</td>
          <!--<td><?= (gettype($archivo_evaluacion) == null) ? '[]' : $fecha_fin ?></td>-->
          <td><?= (is_null($fecha_fin)) ? '[Pendiente]' : $fecha_fin ?></td>
        </tr>
        <tr>
          <td class="text-right">Calificación</td>
          <td><?= (is_null($calificacion)) ? '[Pendiente]' : $calificacion ?></td>
        </tr>
        <tr>
          <td class="text-right">Dictamen</td>
          <td><?= (is_null($dictamen)) ? '[Pendiente]' : $dictamen ?></td>
        </tr>
        <tr>
          <td class="text-right">Observaciones</td>
          <td><?= (is_null($observaciones)) ? '[Pendiente]' : $observaciones ?></td>
        </tr>
        <tr>
          <td class="text-right">Formato DIP-01 (Archivo de evaluación)</td>
          
          <td><?php echo("<a href='{$clave}{$archivo}'>{$archivo_evaluacion}</a>"); ?></td>
        </tr>
        <tr>
          <td class="text-right">Estatus</td>
          <td><?= $estatus ?></td>
        </tr>
        </tbody>
  </table>
  <div class="alert alert-info p-1" role="alert">
    <h6>Evaluadores de la CIP:</h6>
  </div>
  <ol>
    <?php foreach ($listaCIP as $revisor) {
      extract($revisor);
      echo("<li><span class='fw-bold'>{$nombre}</span> - {$division_id}</li>");
    } ?>
  </ol>
</body>

</html>

<?php
  }
?>