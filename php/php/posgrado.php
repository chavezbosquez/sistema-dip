<?php
class Posgrado {

	public function __construct() {
		exit('Función init no permitida');
	}

	public static function getPosgradosSinEvaluar() {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT posgrado_id,acronimo,referencia,nombre,division_id,snp,plan,orientacion 
						FROM posgrado WHERE posgrado_id NOT IN (SELECT posgrado_id FROM evaluacion) ORDER BY division_id";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	public static function getPosgradosEnEvaluacion() {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT posgrado.posgrado_id, acronimo,posgrado.nombre AS nombre, posgrado.division_id, referencia,
						evaluacion_id, fecha_inicio, evaluacion.estatus
						FROM posgrado, evaluacion
						WHERE evaluacion.estatus <> 'Finalizada' AND posgrado.posgrado_id = evaluacion.posgrado_id ORDER BY fecha_inicio";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	public static function getPosgradosEvaluados() {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT posgrado.posgrado_id, acronimo,referencia, nombre,division_id,
						fecha_inicio, fecha_fin, evaluacion_id
						FROM posgrado, evaluacion 
						WHERE evaluacion.estatus = 'Finalizada' AND posgrado.posgrado_id = evaluacion.posgrado_id ORDER BY fecha_fin";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	public static function getDetalleEvaluacion($evaluacion_id) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT posgrado.nombre, posgrado.division_id,
						evaluacion_id, fecha_inicio,fecha_fin, calificacion, dictamen, observaciones, archivo_evaluacion, evaluacion.estatus
						FROM posgrado, evaluacion
						WHERE evaluacion_id = '{$evaluacion_id}' AND posgrado.posgrado_id = evaluacion.posgrado_id LIMIT 1";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
		return $registro;
	}

	/* SELECT usuario.nombre,usuario.division
	FROM usuario,revision,evaluacion
	WHERE evaluacion.clave = 'archivos/DACA-MSA-2023/'  
	AND evaluacion.clave = revision.evaluacion AND revision.evaluador = usuario.clave */
	public static function getEvaluadoresCIP($evaluacion_id) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT revision_id, usuario.nombre, usuario.division_id
						FROM usuario, revision, evaluacion
						WHERE evaluacion.evaluacion_id = '{$evaluacion_id}' 
						AND evaluacion.evaluacion_id = revision.evaluacion_id AND revision.revisor_id = usuario.clave";
						$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	public static function getRevision($clave_revision) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT fecha_fin,dictamen,observaciones,archivo_revision,estatus
    				FROM revision WHERE revision_id='{$clave_revision}' LIMIT 1";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

	// Util [solo en ver-detalles-usuario.php] para mostrar la liga al archivo de evaluación
	public static function getRevisionEvaluacion($clave_revision) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT fecha_fin,dictamen,observaciones,archivo_revision,estatus,evaluacion_id
    				FROM revision WHERE revision_id='{$clave_revision}' LIMIT 1";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

	public static function getDatosGenerales($posgrado_id) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT referencia,acronimo,division_id,snp,periodicidad,plan,orientacion,modalidad,fecha_consejo,anho_reestructura,observacion,responsable_id
    				FROM posgrado WHERE posgrado_id='{$posgrado_id}' LIMIT 1";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}
  
	public static function getDatosDetalle($posgrado_id) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT posgrado.nombre AS nombre,posgrado.division_id AS division_id,referencia,snp,periodicidad,plan,orientacion,modalidad,fecha_consejo,anho_reestructura,observacion,responsable_id,
            division.nombre AS nombre_division
            FROM posgrado,division
						WHERE posgrado_id='{$posgrado_id}' AND posgrado.division_id=division.division_id LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

  /* Obtener la fecha límite para titularse */
  public static function getFechaFatal($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    //$sql = "SELECT fecha FROM documento WHERE tesis='{$folio}' AND tipo_documento='F4' LIMIT 1";
    $sql = "SELECT fecha_fatal FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $f = $cons->fetchColumn();
    if ( !isset($f) ) {
      return(null);
    }
    $f = strtotime($f);
    $n = strtotime('+ 1 year', $f);
    $fecha = date('d/m/Y', $n);

		BaseDeDatos::desconectar();
    return($fecha);
  }

}
?>