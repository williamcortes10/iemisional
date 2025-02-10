<?php

//CALCULAR PUESTOS ALGORITMO 2
function puestoPeriodoAlg2($id, $idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

//$conxp = new ConxMySQL($dominio,$usuario,$pass,$bd);
	
	///calcular tabla de promedios
	$consulta="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n
					INNER JOIN estudiante e
					ON n.idestudiante=e.idestudiante
					INNER JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo 
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consulta2="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n
					INNER JOIN estudiante e
					ON n.idestudiante=e.idestudiante
					INNER JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo 
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.idestudiante =  '$id'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($consulta2);
	$promedioEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=$promedioEst["Promedio"];
	$conxp->result_free($consultapuestoarrayEst);
	$countpuesto=1;
	if ($resultado = $conxp->query($consulta)) {
		/* obtener un array asociativo */
		while ($fila = $conxp->records_array($resultado)) {
			if($fila['Promedio']===$promEst){
				break;
			}else{
				$countpuesto++;
			}
		}

		/* liberar el conjunto de resultados */
		$conxp->result_free($resultado);
	}
	
	$conxp->close_conex();
	//fin ubicar puesto
	
    return $countpuesto;
    
}
function puesto_promedio($id, $idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

//$conxp = new ConxMySQL($dominio,$usuario,$pass,$bd);
	
	///calcular tabla de promedios
	$consulta="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM estudiante e 
					LEFT JOIN notas n
					ON n.idestudiante=e.idestudiante
					LEFT JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo 
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consulta2="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM estudiante e 
					LEFT JOIN notas n
					ON n.idestudiante=e.idestudiante
					LEFT JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.idestudiante =  '$id'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($consulta2);
	$promedioEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=$promedioEst["Promedio"];
	$conxp->result_free($consultapuestoarrayEst);
	$countpuesto=1;
	if ($resultado = $conxp->query($consulta)) {
		/* obtener un array asociativo */
		while ($fila = $conxp->records_array($resultado)) {
			if($fila['Promedio']===$promEst){
				break;
			}else{
				$countpuesto++;
			}
		}

		/* liberar el conjunto de resultados */
		$conxp->result_free($resultado);
	}
	
	$conxp->close_conex();
	//fin ubicar puesto
	
    return array($countpuesto,$promEst);
    
}
function tabla_promedios($idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

//$conxp = new ConxMySQL($dominio,$usuario,$pass,$bd);
	
	///calcular tabla de promedios
	$consulta="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM estudiante e 
					LEFT JOIN notas n
					ON n.idestudiante=e.idestudiante
					LEFT JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo 
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$promedios=array();
	if ($resultado = $conxp->query($consulta)) {
		/* obtener un array asociativo */
		$puntero=0;
		while ($fila = $conxp->records_array($resultado)) {
			$promedios[$puntero]=$fila["Promedio"];
			$puntero++;
		}

		/* liberar el conjunto de resultados */
		$conxp->result_free($resultado);
	}
	
	$conxp->close_conex();
	//fin ubicar puesto
	
    return $promedios;
    
}
function tabla_promedios_con_comportamiento($idaula, $aniolectivo, $periodo, $final, $total_materias){

//include($GLOBALS["base_url"].'/bdConfig.php');
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolectivo'";
$consulta = $conxp->query($sql);    
$records = $conxp->records_array($consulta);
$num_periodos = $records['num_periodos'];
$tipo_periodo = $records['tipo_periodo'];
//$conxp = new ConxMySQL($dominio,$usuario,$pass,$bd);
	
	///calcular tabla de promedios
	if(($periodo==$num_periodos or $periodo=='F') and $final=='S'){
		$consulta="	SELECT DISTINCT
					  ROUND((SUM(n.vn)/($total_materias*$num_periodos)), 3) AS Promedio
					FROM estudiante e
					  INNER JOIN matricula m
						ON e.idestudiante = m.idestudiante AND e.habilitado = 'S'
					  INNER JOIN notas n
						ON m.idestudiante = n.idestudiante AND m.aniolectivo = n.aniolectivo
					WHERE m.aniolectivo = $aniolectivo AND n.periodo <= $num_periodos AND m.idaula = $idaula AND m.tipo_matricula = 'R'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;";
	}else{
		$consulta="	
					SELECT DISTINCT
					  ROUND((SUM(n.vn)/$total_materias), 2) AS Promedio
					FROM estudiante e
					  INNER JOIN matricula m
						ON e.idestudiante = m.idestudiante AND e.habilitado = 'S'
					  INNER JOIN notas n
						ON m.idestudiante = n.idestudiante AND m.aniolectivo = n.aniolectivo
					WHERE m.aniolectivo = $aniolectivo AND n.periodo = $periodo AND m.idaula = $idaula AND m.tipo_matricula = 'R'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;";
	}
	$promedios=array();
	
	if ($resultado = $conxp->query($consulta)) {
		/* obtener un array asociativo */
		$puntero=0;
		while ($fila = $conxp->records_array($resultado)) {
			$promedios[$puntero]=$fila["Promedio"];
			$puntero++;
		}

		/* liberar el conjunto de resultados */
		$conxp->result_free($resultado);
	}
	$conxp->close_conex();
	//fin ubicar puesto
    return $promedios;
    
}
//Promedio periodo
function promedioPeriodoAlg2($id, $idaula, $aniolectivo, $periodo){
//$conxp = new ConxMySQL("localhost","root","","appacademy");
	$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
	//consultar promedio de estudiante a buscar
	$consulta2="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM estudiante e 
					LEFT JOIN notas n
					ON n.idestudiante=e.idestudiante
					LEFT JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.idestudiante =  '$id'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($consulta2);
	$promedioEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=round($promedioEst["Promedio"],2);
	//fin consulta promedio estudiante
	$conxp->result_free($consultapuestoarrayEst);
	$conxp->close_conex();
    return $promEst;
    
}
//Promedio periodo
function promedio_periodo_con_comportamiento($id, $idaula, $aniolectivo, $periodo, $final, $total_materias){
//$conxp = new ConxMySQL("localhost","root","","appacademy");
	$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
	$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolectivo'";
    $consulta = $conxp->query($sql);    
    $records = $conxp->records_array($consulta);
    $num_periodos = $records['num_periodos'];
    $tipo_periodo = $records['tipo_periodo'];
	//Recuperamos el numero de decimales configurados para el año lectivo
	$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolectivo LIMIT 1";
	$consulta = $conxp->query($sql);    
	$records = $conxp->records_array($consulta);
	$numero_decimales = $records['numero_decimales'];
	if(empty($numero_decimales)){
		$numero_decimales = 2;
	}
	//consultar promedio de estudiante a buscar
	if(($periodo==$num_periodos or $periodo=='F') and $final=='S'){
		/*$consulta2="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
					FROM estudiante e 
					LEFT JOIN notas n
					ON n.idestudiante=e.idestudiante
					LEFT JOIN matricula m
					ON e.idestudiante = m.idestudiante
					AND m.aniolectivo=n.aniolectivo
					WHERE
					e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.idestudiante =  '$id'
					AND m.aniolectivo =$aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo <= 3
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";*/
		$consulta2="	
					SELECT DISTINCT ROUND( SUM( notas.vn )/($total_materias*$num_periodos), 3 ) AS Promedio
					FROM estudiante
					  INNER JOIN matricula
						ON estudiante.idestudiante = matricula.idestudiante 
						AND matricula.idestudiante = '$id' 
						AND matricula.aniolectivo = $aniolectivo AND matricula.idaula = $idaula
					  INNER JOIN notas 
						ON matricula.idestudiante = notas.idestudiante 
						AND matricula.aniolectivo = notas.aniolectivo 
						AND matricula.tipo_matricula = notas.tipo_nota 
						AND notas.periodo <= $num_periodos AND notas.tipo_nota = 'R'
					GROUP BY notas.idestudiante
					ORDER BY Promedio DESC";
		$consultapuestoarrayEst = $conxp->query($consulta2);
		$promedioEst = $conxp->records_array($consultapuestoarrayEst);
		$promEst=number_format(round($promedioEst["Promedio"],3), 3);
	}else{
		
		$consulta2="	
					SELECT DISTINCT ROUND( SUM( notas.vn )/$total_materias , 2 ) AS Promedio
					FROM estudiante
					  INNER JOIN matricula
						ON estudiante.idestudiante = matricula.idestudiante 
						AND matricula.idestudiante = '$id' 
						AND matricula.aniolectivo = $aniolectivo AND matricula.idaula = $idaula
					  INNER JOIN notas 
						ON matricula.idestudiante = notas.idestudiante 
						AND matricula.aniolectivo = notas.aniolectivo 
						AND matricula.tipo_matricula = notas.tipo_nota 
						AND notas.periodo = $periodo AND notas.tipo_nota = 'R'
					GROUP BY notas.idestudiante
					ORDER BY Promedio DESC";
		$consultapuestoarrayEst = $conxp->query($consulta2);
		$promedioEst = $conxp->records_array($consultapuestoarrayEst);
		$promEst=number_format(round($promedioEst["Promedio"],$numero_decimales), $numero_decimales);
	}
	
	
	
	//fin consulta promedio estudiante
	$conxp->result_free($consultapuestoarrayEst);
	$conxp->close_conex();
    return $promEst;
    
}
function promedioAnioAlg2($id, $idaula, $aniolectivo, $periodoi, $periodof){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria !=  '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=round($recordspuestoarrayEst['Promedio'],1);
	//fin consulta promedio estudiante
	
    return $promEst;
    
}
function promedioSem($id, $idaula, $aniolectivo, $periodoi, $periodof){
//$conxp = new ConxMySQL("localhost","root","","appacademy");
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria !=  '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=round($recordspuestoarrayEst['Promedio'],3);
	//fin consulta promedio estudiante
	
    return $promEst;
    
}
function promedioSemMateria($id, $idaula, $aniolectivo, $periodoi, $periodof, $idmateria){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria =  '$idmateria'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=number_format((float)$recordspuestoarrayEst['Promedio'],1,".",",");
	//fin consulta promedio estudiante
	
    return $promEst;
    
}
function promedioAnioSem($id, $idaula, $aniolectivo){
	if($aniolectivo<2017){	
		$promediosem1=promedioSem($id, $idaula, $aniolectivo,1,2);
		$promediosem2=promedioSem($id, $idaula, $aniolectivo,3,4);
		//$promEst= round(($promediosem1+$promediosem2)/2, 3, PHP_ROUND_HALF_UP);
		$promEst= round(($promediosem1+$promediosem2)/2, 3);
		//fin consulta promedio estudiante
	}else{
		$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

		$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= 1 and n.periodo <= 3
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=number_format((float)$recordspuestoarrayEst['Promedio'],3,".",",");
	}
    return $promEst;   
}
function puestoAnioSem($id, $idaula, $aniolectivo){
	$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	if($aniolectivo<2017){
		$sqlarraypuestoEst="	
					SELECT DISTINCT e.* 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idmateria!=49
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					ORDER BY n.idestudiante DESC;
					";
	}else{
		$sqlarraypuestoEst="	
					SELECT DISTINCT e.* 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					ORDER BY n.idestudiante DESC;
					";
	}
	
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$promEst=0;
	$hasPromedio = array();
	$puestoId ="";
	while($recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst)){
		$promEst++;
		array_push($hasPromedio,promedioAnioSem($recordspuestoarrayEst['idestudiante'], $idaula, $aniolectivo));
	}
	//fin consulta promedio estudiante
	$hasPromedioUnique=array_unique($hasPromedio);
	rsort($hasPromedioUnique);
	foreach($hasPromedioUnique as $key =>$valor){
		$promedioId=promedioAnioSem($id, $idaula, $aniolectivo);
		if($promedioId==$valor){
			$puestoId=$key;
		}
	}
    return $puestoId+1;   
}
function promedioAnioSemMateria($id, $idaula, $aniolectivo, $idmateria){
	if($aniolectivo<2017){
		$promediosem1=promedioSemMateria($id, $idaula, $aniolectivo,1,2, $idmateria);
		$promediosem2=promedioSemMateria($id, $idaula, $aniolectivo,3,4, $idmateria);
		$promEst= round(($promediosem1+$promediosem2)/2, 1, PHP_ROUND_HALF_UP);
	}else{
		$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
		$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolectivo'";
		$consulta = $conxp->query($sql);    
		$records = $conxp->records_array($consulta);
		$num_periodos = $records['num_periodos'];
		//consultar promedio de estudiante a buscar
		$sqlarraypuestoEst="	
						SELECT ROUND( SUM( n.vn )/$num_periodos, 2 ) AS Promedio 
						FROM notas n, matricula m, estudiante e
						WHERE n.idestudiante = m.idestudiante
						AND n.idestudiante=e.idestudiante
						AND n.idestudiante='$id'
						AND e.habilitado='S'
						AND m.idaula =  '$idaula'
						AND m.aniolectivo =$aniolectivo
						AND m.aniolectivo = n.aniolectivo
						AND m.tipo_matricula = 'R'
						AND n.periodo >= 1 and n.periodo <= $num_periodos
						AND n.idmateria =  '$idmateria'
						GROUP BY n.idestudiante
						ORDER BY Promedio DESC;
						";
		$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
		$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
		$promEst=number_format((float)$recordspuestoarrayEst['Promedio'],1,".",",");
	}
	
	//fin consulta promedio estudiante
    return $promEst;   
}

function promedioParcialMateria($id, $idaula, $aniolectivo, $idmateria, $periodo){
	
		$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
		
		//consultar promedio de estudiante a buscar
		$sqlarraypuestoEst="	
						SELECT ROUND( SUM( n.vn )/$periodo, 2 ) AS Promedio 
						FROM notas n, matricula m, estudiante e
						WHERE n.idestudiante = m.idestudiante
						AND n.idestudiante=e.idestudiante
						AND n.idestudiante='$id'
						AND e.habilitado='S'
						AND m.idaula =  '$idaula'
						AND m.aniolectivo =$aniolectivo
						AND m.aniolectivo = n.aniolectivo
						AND m.tipo_matricula = 'R'
						AND n.periodo >= 1 and n.periodo <= $periodo
						AND n.idmateria =  '$idmateria'
						AND n.idmateria!=49
						GROUP BY n.idestudiante
						ORDER BY Promedio DESC;
						";
		$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
		$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
		$promEst=number_format((float)$recordspuestoarrayEst['Promedio'],1,".",",");
	
	//fin consulta promedio estudiante
    return $promEst;   
}
function promedioAnioAlg2Materia($id, $idaula, $aniolectivo, $periodoi, $periodof, $idmateria){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria =  '$idmateria'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=round($recordspuestoarrayEst['Promedio'],1, PHP_ROUND_HALF_UP);
	//fin consulta promedio estudiante
	
    return $promEst;
    
}
function puestoAnioAlg2($id, $idaula, $aniolectivo, $periodoi, $periodof){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	///calcular tabla de promedios
	$sqlarraypuesto="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 1 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarray = $conxp->query($sqlarraypuesto);
	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 1 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo >= $periodoi and n.periodo <= $periodof
					AND n.idmateria != '49'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
				$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
				$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
				$promEst=$recordspuestoarrayEst['Promedio'];
				//fin consulta promedio estudiante
				//ubicando puesto segun promedio
				$countpuesto=1;
				while($recordspuestoarray = $conxp->records_array($consultapuestoarray)){
					if($recordspuestoarray['Promedio']==$promEst){
						break;
					}else{
						$countpuesto++;
					}
				}
				//fin ubicar puesto
				
				return $countpuesto;
				
			}
			
function promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo, $periodoi, $periodof, $idmateria){
$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);

	//consultar promedio de estudiante a buscar
	$sumNotas=0;
	$numP=0;
	for($p=$periodoi; $p<=$periodof; $p++){
		$sqlnotaR="SELECT vn FROM notas n, matricula m, estudiante e WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante AND n.idestudiante='$id' AND e.habilitado='S'
					AND m.idaula =  '$idaula' AND m.aniolectivo =$aniolectivo AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R' AND n.periodo = $p AND n.idmateria =  '$idmateria'";
		$cnotaR = $conxp->query($sqlnotaR);
		if($recordsCnotaR = $conxp->records_array($cnotaR)){
			$notaR=$recordsCnotaR['vn'];
		}else{
			$notaR=0;
		}
		
		$sqlnotaNV="SELECT vn FROM notas n, matricula m, estudiante e WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante AND n.idestudiante='$id' AND e.habilitado='S'
					AND m.idaula =  '$idaula' AND m.aniolectivo =$aniolectivo AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'N' AND n.periodo = $p AND n.idmateria =  '$idmateria'";
		$cnotaNV = $conxp->query($sqlnotaNV);
		if($recordsCnotaNV = $conxp->records_array($cnotaNV)){
			$notaNV=$recordsCnotaNV['vn'];
		}else{
			$notaNV=0;
		}
		if($notaNV>$notaR){
			$sumNotas+=$notaNV;
		}else{
			$sumNotas+=$notaR;
		}
		$numP++;
		
		if(($p==2 or $p==4) and $periodoi==1 and $periodof==4){
			if($p==2){$pNvSem=5;}elseif($p==4){$pNvSem=6;}
			$sqlnotaNV="SELECT vn FROM notas n, matricula m, estudiante e WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante AND n.idestudiante='$id' AND e.habilitado='S'
					AND m.idaula =  '$idaula' AND m.aniolectivo =$aniolectivo AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'N' AND n.periodo = $pNvSem AND n.idmateria =  '$idmateria'";
			$cnotaNV = $conxp->query($sqlnotaNV);
			if($recordsCnotaNV = $conxp->records_array($cnotaNV)){
				$notaNV=$recordsCnotaNV['vn'];
			}else{
				$notaNV=0;
			}
			$promEst= round(($sumNotas/$numP), 1, PHP_ROUND_HALF_UP);
			if($notaNV>$promEst){
				$sumNotas=$notaNV;
				$numP=1;
			}
			
		}
	}
	$promEst= round(($sumNotas/$numP), 1, PHP_ROUND_HALF_UP);
	//fin consulta promedio estudiante
	
    return $promEst;
		$conxp->close_conex();

    
}
function numero_asignaturas_salon($idaula, $aniolectivo){
	$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
	if($aniolectivo==2020 or $aniolectivo<2017){
		$sql="SELECT DISTINCT idmateria FROM clase WHERE idaula=$idaula AND aniolectivo=$aniolectivo AND idmateria!=49";
	}else{
		$sql="SELECT DISTINCT idmateria FROM clase WHERE idaula=$idaula AND aniolectivo=$aniolectivo ";
	}
	$consulta = $conxp->query($sql);
	$total=$conxp->get_numRecords($consulta);
	return (int)$total;

}
// Función para encontrar el puesto y el promedio según el idestudiante
function encontrarPuestoYPromedioPorId($datos, $idestudiante) {
    foreach ($datos as $estudiante) {
        foreach ($estudiante as $materia) {
            foreach ($materia as $info) {
                if ($info["idestudiante"] == $idestudiante) {
                    return [
                        "puesto" => $info["puesto"],
                        "promedio" => $info["promedio"]
                    ];
                }
            }
        }
    }
    return null; // Si no se encuentra el estudiante con ese ID
}

function obtenerNotaPorcentualArea($agrupado, $idestudiante, $idarea_fk, $periodo) {
    foreach ($agrupado as $grupo) {
        if ($grupo['idestudiante'] == $idestudiante && 
            $grupo['idarea_fk'] == $idarea_fk &&
            $grupo['periodo'] == $periodo) {
            return [
                'nota_area' => $grupo['nota_area'],
                'porcentaje_calificado' => $grupo['porcentaje_calificado']
            ];
        }
    }
    // Retornar null si no se encuentra el grupo correspondiente
    return null;
}

function obtenerNotaPorcentualMateria($agrupado, $idestudiante, $idmateria, $periodo) {
    foreach ($agrupado as $grupo) {
        if ($grupo['idestudiante'] == $idestudiante && $grupo['periodo'] == $periodo) {
            foreach ($grupo['materias'] as $materia) {
                if ($materia['idmateria'] == $idmateria) {
                    return [
                        'vn' => $materia['vn'],
                        'notaporcentual' => $materia['notaporcentual'],
                        'porcentaje' => $materia['porcentaje']
                    ];
                }
            }
        }
    }
    // Retornar null si no se encuentra la materia para el estudiante y el periodo especificados
    return null;
}

function obtenerNotas_porcentuales($aniolect, $periodo, $idaula, $numero_decimales){
	$conxp = new ConxMySQL($GLOBALS["dominio"],$GLOBALS["usuario"],$GLOBALS["pass"],$GLOBALS["bd"]);
	// Llamar al procedimiento almacenado para consultar notas porcentuales del salón
	$sqlnporcentuales = "CALL ConsultarNotasPorcentuales($aniolect, $periodo, 'R', $idaula, $numero_decimales)";
	//agrupar resultados de notas
	$resultadoporcentual = mysqli_query($conxp->getConexion(), $sqlnporcentuales);
	$notas_porcentuales=Array();
	if ($resultadoporcentual->num_rows>0) {
		$datos = $conxp->records_array_assoc_all($resultadoporcentual);
		foreach ($datos as $dato) {
			$grupoKey = $dato['idestudiante'] . '-' . $dato['idarea_fk'] . '-' . $dato['nota_area'] . '-' . $dato['porcentaje_calificado'] . '-' . $dato['periodo'];
			
			if (!isset($agrupado[$grupoKey])) {
				$agrupado[$grupoKey] = [
					'idestudiante' => $dato['idestudiante'],
					'idarea_fk' => $dato['idarea_fk'],
					'nota_area' => $dato['nota_area'],
					'porcentaje_calificado' => $dato['porcentaje_calificado'],
					'periodo' => $dato['periodo'],
					'materias' => []
				];
			}
			
			$agrupado[$grupoKey]['materias'][] = [
				'idmateria' => $dato['idmateria'],
				'vn' => $dato['vn'],
				'notaporcentual' => $dato['notaporcentual'],
				'porcentaje' => $dato['porcentaje']
			];
		}

		// Convertir el array asociativo en un array indexado
		$notas_porcentuales = array_values($agrupado);

	}
	return $notas_porcentuales;

}

?>