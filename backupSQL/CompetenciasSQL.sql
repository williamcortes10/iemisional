SELECT DISTINCT p.competencia FROM plan_curricular p
LEFT JOIN indicadoresestudiante ie ON ie.idindicador=p.consecutivo
LEFT JOIN notas n ON ie.idestudiante=n.idestudiante
AND ie.aniolectivo=n.aniolectivo
AND ie.periodo=n.periodo
AND ie.idmateria=n.idmateria
LEFT JOIN indicadoresboletin ib ON ie.idindicador=ib.idindicador
AND ie.aniolectivo=ib.aniolectivo
AND ie.periodo=ib.periodo
LEFT JOIN aula a ON a.grado=ib.grado
WHERE n.periodo=2
AND n.aniolectivo=2016
AND n.tipo_nota='R'
AND n.idestudiante='2180'
AND a.idaula=24
 