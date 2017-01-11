app.controller('verlista', ['$scope', '$http', function($scope, $http){

	$scope.txtloading = 'Cargando listas de contactos ...';
	$scope.loading = true;

	$http.get("v1/list/list")
	.then(function(response) {
		$scope.list = response.data.data;
		$scope.loading = false;
	});

	$scope.newList = function(){
		
		bootbox.prompt({ 
			size: "medium",
			title: "Ingrese nombre de la lista",
			callback: function(result){
				$http.get("v1/list/new/" + result)
				.then(function(response) {
					if(response.data.status == true)
						$scope.list.push({ 'listname':result, 'count': 0, 'dateadded':response.data.date });
					bootbox.alert(response.data.msg);
				});
			}
		});
	}

	$scope.deleteList = function(item){

		bootbox.dialog({
			message: "Esta seguro que desea eliminar la lista ?",
			title: "Alerta!",
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success btn-sm",
					callback: function () {
						var x = item.currentTarget.getAttribute("data-name");
						$http.get( "v1/list/delete/" + x )
						.then(function(response) {
							if(response.data.status == true)
								$(item.currentTarget).parent('li').parent('ul').parent('div').parent('td').parent('tr').fadeOut();
							bootbox.alert(response.data.msg);
						});
					}
				},
				danger: {
					label: "Cancelar",
					className: "btn-danger btn-sm",
					callback: function () {}
				}
			}
		});
	}



}]);