<!DOCTYPE html>
<html ng-app='MyFirtsApp'>
<head>
	<meta charset="utf-8">
	<title>Aprende AngularJS desde cero</title>
</head>
<body ng-controller="FirstController">
	<p>
		Tengo {{20+6}} años
	</p>
	<p>
		<input type="text" ng-model="nuevoComentario.comentario"><br/><br/>
		<input type="text" ng-model="nuevoComentario.username"><br>
		<button ng-click="agregarComentario()">Agregar comentario+ </button>
		<h3>Comentarios</h3>
		<ul>
			<li ng-repeat="comentario in comentarios">
				{{comentario.comentario}} - <strong>{{comentario.username}}</strong>
			</li>
		</ul>
	</p>
<script type="text/javascript" src="lib/angular.min.js"></script>
<script type="text/javascript" src="lib/bootstrap4beta/js/bootstrap.min.js"></script>
<script type="text/javascript" src="app/app.js"></script>
</body>
</html>