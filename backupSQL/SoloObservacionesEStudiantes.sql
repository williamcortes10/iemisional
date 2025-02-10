SELECT DISTINCT m.nombre_materia
FROM materia m
LEFT JOIN clase c ON m.idmateria=c.idmateria
LEFT JOIN notas n ON c.idmateria=n.idmateria
AND c.aniolectivo=n.aniolectivo
WHERE c.aniolectivo=2016
AND c.idaula=24
AND n.tipo_nota='R'
AND n.periodo=2
AND n.idestudiante='2180'