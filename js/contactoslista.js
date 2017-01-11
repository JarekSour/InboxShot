app.controller('contactolista_dos', ServerSideProcessingCtrl);

function ServerSideProcessingCtrl($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTDefaultOptions, $http, $q, $routeParams, $resource) {
	var vm = this;
	DTDefaultOptions.setLoadingTemplate('<div class="text-center"><img style="height:40px" src="images/loading.gif"><p class="text-loading2">Cargando...</p></div>');
	var name = $routeParams.listName;
	vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
		var defer = $q.defer();
		$http.get( 'v1/list/list/' + name ).then(function(result) {
			defer.resolve(result.data.data);
			vm.nomList = name;
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
	DTColumnBuilder.newColumn('email').withTitle('E-MAIL'),
	DTColumnBuilder.newColumn('firstname').withTitle('NOMBRE'),

	DTColumnBuilder.newColumn('email').withTitle('E-MAIL'),
	DTColumnBuilder.newColumn('lastname').withTitle('APELLIDO'),
	];
}