<?php
	include("../../class/ultimatemysql/mysql.class.php");
	$conx = new MySQL();
	if (! $conx->Open("appacademy", "localhost", "root", "")) {
		$conx->Kill();
	}
	$iddocente = $_POST['iddocente'];
	$aniolect = $_POST['aniolect'];
	echo "<label>Grado escolar
			<span class='small'>Eliga grado</span>
			</label>
			<select  id='idaula'>";
				$sql = "SELECT DISTINCT aula.* FROM aula, clase WHERE 
				clase.iddocente=$iddocente AND clase.idaula=aula.idaula 
				AND aniolectivo=$aniolect ORDER BY clase.idaula";
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						echo "<option value='".$row->idaula."'>".
						$row->descripcion."-G".$row->grupo."</option>";
					}
						
				} else {
					echo "<option value='null'>No se ha asignado carga académica</option>";
				}
	echo	"</select>";
?>