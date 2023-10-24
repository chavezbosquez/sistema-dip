<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    //
    $posgrado_id = $_GET['posgrado_id'];
    require_once 'php/posgrado.php';
    $registro = Posgrado::getDatosGenerales($posgrado_id);
    extract($registro);
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
          <td class="text-right">Número de referencia</td>
          <td class="fw-bold"><?= $referencia ?></td>
        </tr>
        <tr>
          <td class="text-right">Acrónimo</td>
          <td><?= $acronimo ?></td>
        </tr>
        <tr>
          <td class="text-right">División</td>
          <td><?= $division_id ?></td>
        </tr>
        <tr>
          <td class="text-right">Responsable</td>
          <td><?= $responsable_id ?></td>
        </tr>
        <tr>
          <td class="text-right">SNP <img src="img/conahcyt.png" width="20px"></td>
          <td><?= $snp ?></td>
        </tr>
        <tr>
          <td class="text-right">Periodicidad de ingreso</td>
          <td><?= $periodicidad ?></td>
        </tr>
        <tr>
          <td class="text-right">Plan de estudios</td>
          <td><?= $plan ?></td>
        </tr>
        <tr>
          <td class="text-right">Orientación</td>
          <td><?= $orientacion ?></td>
        </tr>
        <tr>
          <td class="text-right">Modalidad</td>
          <td><?= $modalidad ?></td>
        </tr>
        <tr>
          <td class="text-right">Fecha de autorización</td>
          <!--<td class="font-weight-bold"><?php echo date("d/m/Y",strtotime($fecha_consejo)); ?></td>-->
          <td><?php echo($fecha_consejo); ?></td>
        </tr>
        <tr>
          <td class="text-right">Año reestructuración</td>
          <td><?= $anho_reestructura ?></td>
        </tr>
        <tr>
          <td class="text-right">Observación</td>
          <td><?= $observacion ?></td>
        </tr>
        </tbody>
  </table>
</body>

</html>

<?php
  }
?>