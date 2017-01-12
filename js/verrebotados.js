app.controller('rebotados', verRebotados);

function verRebotados($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTDefaultOptions, $http, $q, $resource) {
	var vm = this;
	DTDefaultOptions.setLoadingTemplate('<div class="text-center"><img style="height:40px" src="images/loading.gif"><p class="text-loading2">Cargando...</p></div>');

	vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
		var defer = $q.defer();
		$http.get( 'v1/list/rebotado' ).then(function(result) {
			defer.resolve(result.data.data);
			vm.numRebotados = "Número de contactos rebotados : " + result.data.data.length;
		});
		return defer.promise;
	})
	.withOption('createdRow', function createdRow(row, data, dataIndex) {
		$compile(angular.element(row).contents())($scope);
	})
	.withLanguageSource('//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Spanish.json')
	.withDOM("<'row'<'col-md-offset-6 col-sm-6 text-right marginTopLess-tresiete'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5 marginTop-treinta'i><'col-sm-7 text-right'p>>")
	.withBootstrap()
	.withButtons([
		'colvis',
		'print',
		'excel'
		]);

	vm.dtColumns = [
	DTColumnBuilder.newColumn('email').withTitle('E-mail'),
	DTColumnBuilder.newColumn('friendlyerrormessage').withTitle('Mensaje'),
	DTColumnBuilder.newColumn(null).withTitle('Eliminar').notSortable()
	.renderWith(actionHtml),
	];

	function actionHtml(data, type, full, meta) {
		return '<button class="btn btn-danger btn-sm" data-email="' + data.email + '" ng-click="showCase.deletecontact($event)">'+
		'   <i class="fa fa-trash" aria-hidden="true"></i>'+
		'</button>';
	}

	vm.deletecontact = function (item) {
		var x = item.currentTarget.getAttribute("data-email");

		bootbox.dialog({
			message: "¿ Esta seguro que desea eliminar el contacto ?",
			title: "Eliminar contacto desuscrito",
			buttons: {
				success: {
					label: "Eliminar",
					className: "btn-success btn-sm",
					callback: function () {
						$http.get("v1/contact/delete/" + x)
						.then(function(response) {
							if(response.data.status == true){
							}
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
}

app.controller('verrebotado',  function($scope, $http, ModalService){

	$scope.deleteAllRebotado = function(){
		$http.get("v1/list/rebotado/deleteall")
		.then(function(response) {
			bootbox.alert(response.data.msg);

			// if(response.data.status == true)
			// 	verRebotados.reload();
		});
	}

});