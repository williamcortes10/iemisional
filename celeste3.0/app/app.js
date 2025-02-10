var app = angular.module('MyFirtsApp',[]);
app.controller("FirstController", function($scope){
	$scope.nombre = "William Eduardo Cortes Diaz";
	$scope.nuevoComentario = {};
	$scope.comentarios=[
		{
			comentario:"Buen tutorial",
			username:"codigofacilito"
		},
		{
			comentario:"Malísimo el tutorial",
			username:"otro_usuario"
		}
	];
	$scope.agregarComentario = function(){
		$scope.comentarios.push($scope.nuevoComentario);
		$scope.nuevoComentario = {};
	}
});