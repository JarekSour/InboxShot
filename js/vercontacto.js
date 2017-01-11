app.controller('ServerSideProcessingCtrl', ServerSideProcessingCtrl);

function ServerSideProcessingCtrl($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTDefaultOptions, $http, $q) {
	var vm = this;
	DTDefaultOptions.setLoadingTemplate('<div class="text-center"><img style="height:40px" src="images/loading.gif"><p class="text-loading2">Cargando...</p></div>');
	
	vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
		var defer = $q.defer();
		$http.get('v1/contact/list').then(function(result) {
			defer.resolve(result.data.data);
			vm.numContact = 'Número de contactos : '+result.data.data.length;
		});
		return defer.promise;
	})
	.withOption('createdRow', createdRow)
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
	DTColumnBuilder.newColumn(null).withTitle('CONF').notSortable()
	.renderWith(actionHtml),
	DTColumnBuilder.newColumn('email').withTitle('E-MAIL'),
	DTColumnBuilder.newColumn('firstname').withTitle('NOMBRE'),
	DTColumnBuilder.newColumn('lastname').withTitle('APELLIDO'),
	DTColumnBuilder.newColumn('gender').withTitle('SEXO').notVisible(),
	DTColumnBuilder.newColumn('birthdate').withTitle('FEC. NACIMIENTO').notVisible(),
	DTColumnBuilder.newColumn('notes').withTitle('GRUPO').notVisible(),
	DTColumnBuilder.newColumn('phone').withTitle('TEL. FIJO').notVisible(),
	DTColumnBuilder.newColumn('mobilenumber').withTitle('TEL. MOVIL').notVisible(),
	DTColumnBuilder.newColumn('country').withTitle('PAIS').notVisible(),
	DTColumnBuilder.newColumn('city').withTitle('CIUDAD').notVisible(),
	DTColumnBuilder.newColumn('organizationname').withTitle('EMPRESA').notVisible(),
	DTColumnBuilder.newColumn('websiteurl').withTitle('WEB EMPRESA').notVisible()
	];

	function actionHtml(data, type, full, meta) {
		return '<button class="btn btn-success btn-sm" data-email="' + data.email + '" ng-click="showcontact($event)">'+
		'   <i class="fa fa-cog" aria-hidden="true"></i>'+
		'</button>';
	}

	function createdRow(row, data, dataIndex) {
		$compile(angular.element(row).contents())($scope);
	}
}

app.controller('vercontacto',  function($scope, $http, ModalService){

	$scope.showcontact = function (item) {

		window.localStorage.setItem("currentEmail", item.currentTarget.getAttribute("data-email"))

		ModalService.showModal({
			templateUrl: 'modal-detail-contact',
			controller: "ComplexController",				
		}).then(function(modal) {
			modal.element.modal();
			modal.close.then(function(result) {
				console.log("Name: " + result.name + ", age: " + result.age);
			});
		});
	}
});

app.controller('ComplexController', ['$scope', '$element', 'close', '$http' ,function($scope, $element, close, $http) {
		var x = window.localStorage.getItem("currentEmail");
		
		$http.get( "v1/contact/get/" + x )
		.success(function(response) {
			$scope.gra = 'https://www.gravatar.com/avatar/'+response.gra;
			$scope.nom = response.nom ;
			$scope.ape = response.ape ;
			$scope.ema = response.mai ;
			$scope.fec = response.fec ;
			$scope.gru = response.gru ;
			$scope.fon = response.fon ;
			$scope.cel = response.cel ;
			$scope.pai = response.pai ;
			$scope.ciu = response.ciu ;
			$scope.emp = response.emp ;
			$scope.web = response.web ;
		});

		$scope.save = function() {
			console.log($scope.ema);
		};

		$scope.delete = function() {
			console.log($scope.ema+ " - " +$scope.nom );
		};

	}]);