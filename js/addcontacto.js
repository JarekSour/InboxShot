app.directive('ngFiles', ['$parse', function ($parse) {
	function fn_link(scope, element, attrs) {
		var onChange = $parse(attrs.ngFiles);
		element.on('change', function (event) {
			onChange(scope, { $files: event.target.files });
		});
	};
	return {
		link: fn_link
	}
}]);

app.directive('onReadFile', function ($parse) {
	return {
		restrict: 'A',
		scope: false,
		link: function(scope, element, attrs) {
			var fn = $parse(attrs.onReadFile);

			element.on('change', function(onChangeEvent) {
				var reader = new FileReader();

				reader.onload = function(onLoadEvent) {
					scope.$apply(function() {
						fn(scope, {$fileContent:onLoadEvent.target.result});
					});
				};
				reader.readAsText((onChangeEvent.srcElement || onChangeEvent.target).files[0]);
			});
		}
	};
});

app.directive('filestyle', function(){
	return {
		restrict:'AC',
		scope: true,
		link: function (scope, element, attrs) 
		{
			var options = 
			{
				'input': attrs.input === 'false' ? false : true,
				'icon': attrs.icon === 'false' ? false : true,
				'buttonBefore': attrs.buttonBefore === 'true' ? true : false,
				'disabled': attrs.disabled === 'true' ? true : false,
				'size': attrs.size,
				'buttonText': "&nbsp;&nbsp;Examinar",
				'buttonName': attrs.buttonName,
				'iconName': attrs.iconName,
				'badge': attrs.badge === 'false' ? false : true,
				'placeholder': attrs.placeholder
			};
			$(element).filestyle(options);
		}
	};
});

app.controller('addcontacto', ['$scope', '$http', function($scope, $http){

	$scope.loading = false;

	$scope.showCsv = function() {
		$("#tabSelect1").slideUp(1000);
		$("#tabSelect2").fadeIn();
		$("#menu2").fadeOut();
		$("#menu1").fadeIn('slow');
	};

	$scope.showForm = function() {
		$("#tabSelect1").slideUp(1000);
		$("#tabSelect2").fadeIn();
		$("#menu1").fadeOut();
		$("#menu2").fadeIn('slow');
	};

	$scope.backMenu = function() {
		$("#tabSelect1").slideDown(1000);
		$("#tabSelect2").fadeOut();
	};

	$scope.showContent = function($fileContent){
		var contents = $fileContent;
		contents = contents.split('\n');

		head = [];
		body = [];
		for (var line = 0; line < contents.length; line++) {
			var aux = contents[line].split(',');

			if (line == 0) {
				for (var val in aux) {
					head.push(aux[val]);
				}
			} else {

				row = {};
				if (aux.length > 1) {
					for(var i = 0; i < aux.length; i++){

						row[head[i]] = aux[i];
					}
				} else {
					for(var i = 0; i < aux.length; i++){
						row[head[i]] = aux[i];
					}
				}

				body.push(row);
			}
		}
		$scope.thead = head;
		$scope.tbody = body;
	};

	var formdata = new FormData();
	$scope.getTheFiles = function ($files) {
		angular.forEach($files, function (value, key) {
			formdata.append(key, value);
		});
	};

	$scope.sendFormCsv = function() {
		$scope.txtloading = 'Validando y guardando contactos ...';
		$scope.loading = true;

		var request = {
			method: 'POST',
			url: 'v1/contact/upload/0',
			data: formdata,
			headers: {
				'Content-Type': undefined
			}
		};

		$http(request)
		.success(function (response) {
			$scope.loading = false;
			var obj = angular.fromJson(response)
			bootbox.alert(obj.msg);
		});
	};

	$scope.sendForm = function(){
		$scope.txtloading = 'Validando y guardando contacto ...';
		$scope.loading = true;

		var data = $.param({
			nombre 	 : $scope.txtNombre,
			apellido : $scope.txtApellido,
			correo 	 : $scope.txtCorreo,
			sexo 	 : $scope.slcSexo,
			fecha 	 : $scope.txtNacimiento,
			grupo    : $scope.txtNota,
			telefono : $scope.txtFijo,
			celular  : $scope.txtMovil,
			pais 	 : $scope.txtPais,
			ciudad 	 : $scope.txtCiudad,
			empresa  : $scope.txtEmpresa,
			http 	 : $scope.txtWeb
		});

		var config = {
			headers : {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		}

		$http.post("v1/contact/new", data, config)
		.then(function(response) {
			$scope.loading = false;
			var obj = angular.fromJson(response.data)
			bootbox.alert(obj.msg);
		});
	}




}]);