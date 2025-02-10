<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Desplegar navegación</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Celeste 2.0 - <?php echo utf8_encode($ie);?></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Inicio</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Configuración<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header">Datos de la institución</li>	
						<li><a href="datos_institucion.php">Ver/Modificar</a></li>
						<li role="presentation" class="dropdown-header">Escala de calificación 1290</li>	
						<li><a href="crear_escala_1290.php">Nueva escala de calificación</a></li>
						<li><a href="ver_modificar_escala_1290.php">Ver/Modificar</a></li>
						<li role="presentation" class="dropdown-header">Periodo académico activo</li>	
						<li><a href="periodo_academico_activo.php">Ver/Modificar</a></li>
						<li role="presentation" class="dropdown-header">Acceso a sitios</li>	
						<li><a href="administrar_sitios.php">Administrar</a></li>
						
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Docentes<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header">Información Docente</li>
						<li><a href="../forms/docentes/nuevo_docente.php">Nuevo registro</a></li>
						<li><a href='../forms/docentes/actualizar_docente.php'>Actualizar/Eliminar</a></li>
						<li><a href='../forms/docentes/listado_docentes.php'>Reporte Docentes</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation" class="dropdown-header">Intensidad Horaria</li>
						<li><a href='../forms/clase/buscar_docente.php'>Asignar</a></li>
						<li><a href='../forms/clase/buscarupdel_clase.php'>Actualizar/Eliminar</a></li>
						<li><a href='../forms/clase/listado_cargaacademica.php'>Reporte Intensidad Horaria</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation" class="dropdown-header">Coordinadores de áreas</li>
						<li><a href='../forms/clase/buscar_docente_area.php'>Asignar</a></li>
						<li><a href='../forms/clase/buscarupdel_coorarea.php'>Actualizar/Eliminar</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Asignaturas<b class="caret"></b>
					</a>
					<ul class='dropdown-menu'>
						<li role="presentation" class="dropdown-header">Asignaturas</li>
						<li><a href='../forms/asignatura/nueva_asignatura.php'>Nuev registro</a></li>
						<li><a href='../forms/asignatura/actualizar_asignatura.php'>Actualizar</a></li>
						<li><a href='../forms/asignatura/listado_asignaturas.php'>Reporte de asignaturas</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Estudiante<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header">Información Estudiante</li>
						<li><a href='../forms/estudiantes/nuevo_estudiante.php'>Nuevo registro</a></li>
						<li><a href='../forms/estudiantes/actualizar_estudiante.php'>Actualizar/Eliminar</a></li>
						<li><a href='#'>Carga masiva de estudiantes</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation" class='dropdown-header'>Matrícula Regular/Nivelación</li>
						<li><a href='../forms/matricula/buscar_estudiante.php'>Nueva individual</a></li>
						<li><a href='../forms/matricula/buscar_grupo_estudiante.php'>Nueva grupo</a></li>
						<li><a href='../forms/matricula/buscarupdel_matricula.php'>Actualizar/Eliminar</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Salones<b class="caret"></b>
					<ul class="dropdown-menu">
						<li><a href='../forms/aula/nueva_aula.php'>Nuevo registro</a></li>
						<li><a href='../forms/aula/actualizar_aula.php'>Actualizar</a></li>
						<li><a href='../forms/aula/listado_salones.php'>Reporte de salones</a></li>
						
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Competencias Académicas<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li><a href="../forms/indicadores/nvcompetencia.php">Nueva</a></li>
					  <li><a href="../forms/indicadores/actelimcompetencia.php">Actualizar/Eliminar</a></li>
					  <li><a href="../forms/indicadores/selecionarcompetencia.php">Seleccionar Competencias</a></li>
					  <li><a href="../forms/indicadores/desselecionarcompetencia.php">Quitar Competencias</a></li>
					  <li><a href="../forms/indicadores/categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Calificaciones<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li role="presentation" class="dropdown-header">Regulares</li>
					  <li><a href="../forms/notas/buscar_estudiante.php">Ingresar Calificación</a></li>
					  <!--<li><a href="../forms/notas/eliminarcalificaciones.php">Eliminar Calificación</a></li>
					  <li role="presentation" class="divider"></li>
					  <li role="presentation" class="dropdown-header">Nivelación</li>
					  <li><a href="../forms/notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>-->
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  Reportes<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li role="presentation" class='dropdown-header'>Informe académico</li>
					  <li><a href='../forms/boletines/boletingeneral.php'>Grupo</a></li>
					  <li><a href='../forms/boletines/buscar_estudiante.php'>Individual</a></li>
					  <li role="presentation" class="divider"></li>
					  <li role="presentation" class='dropdown-header'>Certificados</li>
					  <li><a href='../forms/boletines/buscar_estudiantecert.php'>Buscar Estudiante</a></li>
					  <li role="presentation" class="divider"></li>
					  <li role="presentation" class='dropdown-header'>Estadisticas</li>
					  <li><a href='../forms/estadisticas/ccrendaca.php'>Rendimiento académico x desempeño</a></li>
					  <li><a href='../forms/estadisticas/ccrendacacompetencias.php'>Rendimiento académico x competencias</a></li>
					  <li><a href='../forms/estadisticas/aprobados_reprobados.php'>Estudiantes Aprobados y Reprobados</a></li>
					  <li><a href='../forms/estadisticas/aprobados_reprobados_recuperan.php'>Aprobados-Reprobados-Recuperan</a></li>
					  <li role="presentation" class='dropdown-header'>Calificaciones</li>
					  <li><a href="../forms/notas/listarcalificaciones.php">Grupo</a></li>
					  <li><a href="../forms/notas/sintesisxcurso.php">Sintesis</a></li>
					  <li role="presentation" class="divider"></li>
					  <li role="presentation" class='dropdown-header'>Otros</li><li role="presentation" class="divider"></li>
					  <li><a href='../forms/aula/listado_aula.php'>Reporte salones</a></li>
					  <li><a href='../forms/matricula/listado_matricular.php'>Reporte matrícula regular</a></li>
					  <li><a href='../forms/matricula/listado_matriculan.php'>Reporte matrícula nivelación</a></li>
					  <li><a href='../forms/estudiantes/listado_estudiantes.php'>Reporte estudiantes</a></li>
					  <li><a href='../forms/asignatura/listado_asignaturas.php'>Reporte de asignaturas</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  <span class="glyphicon glyphicon-user"></span>
					  <?php echo $user; ?><b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li><a href="logout.php">Cerrar sesión</a></li>
					</ul>
				</li>
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>