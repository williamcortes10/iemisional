<?php
	include("../../class/ultimatemysql/mysql.class.php");
	$conx = new MySQL();
	if (! $conx->Open("appacademy", "localhost", "root", "")) {
		$conx->Kill();
	}
	$idmateria = $_POST['idmateria'];
	$idaula = $_POST['idaula'];
	echo "
		<label>Estandar/Competencia
			<span class='small'>Eliga estandar</span>
			</label>
			<select  id='idestandarbc'>";
				$sql = "SELECT e.*  FROM estandares e WHERE e.idmateria_fk = $idmateria AND e.grado = '$idaula'";
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						echo "<option value='".$row->codigo."'>".$row->descripcion."</option>";
						
					}
						
				} else {
					echo "<option>No existen estandares</option>";
				}
				
			echo "</select>";
?>