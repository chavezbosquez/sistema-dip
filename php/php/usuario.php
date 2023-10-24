<?php
class Usuario {

	public function __construct() {
		exit('Función init no permitida');
	}

	public static function getCIP() {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT clave,nombre,division_id FROM usuario WHERE rol = 'CIP' AND estatus = 'Activo'";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	public static function getRevisionesAsignadas($usuario) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT revision_id, evaluacion.evaluacion_id, archivo_evaluacion,
						posgrado.posgrado_id, referencia,posgrado.nombre AS posgrado, posgrado.division_id AS division, division.nombre AS nombre_division
						FROM revision, evaluacion, posgrado, division
						WHERE revision.revisor_id = '{$usuario}' AND revision.estatus <> 'Finalizada' AND
									revision.evaluacion_id = evaluacion.evaluacion_id AND evaluacion.posgrado_id = posgrado.posgrado_id AND
									posgrado.division_id = division.division_id";
						//AND  rol = 'CIP' AND estatus = 'Activo'
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $lista = array();
		foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      array_push($lista, $registro);
		}
		BaseDeDatos::desconectar();
		return $lista;
	}

	/*SELECT revision.clave AS clave_revision, evaluacion.clave AS clave_evaluacion, posgrado.nombre AS posgrado, posgrado.division AS division
		FROM revision,evaluacion,posgrado
		WHERE revision.revisor_cip = 'dacyti' AND revision.evaluacion=evaluacion.clave AND evaluacion.posgrado=posgrado.referencia;*/
		public static function getHistorialRevisiones($usuario) {
			require_once 'bd.php';
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT evaluacion.evaluacion_id, archivo_revision, 
							revision_id,revision.fecha_fin AS fecha_fin,
							referencia,posgrado.nombre AS posgrado, posgrado.division_id AS division
							FROM revision, evaluacion, posgrado
							WHERE revision.revisor_id = '{$usuario}' AND revision.estatus = 'Finalizada' AND
										revision.evaluacion_id = evaluacion.evaluacion_id AND evaluacion.posgrado_id = posgrado.posgrado_id";
			$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
			$lista = array();
			foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
				array_push($lista, $registro);
			}
			BaseDeDatos::desconectar();
			return $lista;
		}

}
?>