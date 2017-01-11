var app = angular.module("myApp", ["ngRoute", 'easypiechart', 'datatables', 'ngResource', 'datatables.bootstrap', 'datatables.buttons', 'datatables.columnfilter', 'angularModalService', 'ngAnimate', 'ngSanitize' ]);
app.config(function($routeProvider, $sceProvider) {

    $routeProvider
    .when("/", {
        templateUrl : "views/main.php"
    })
    .when("/contactos", {
        templateUrl : "views/contact.php"
    })
    .when("/addcontacto", {
        templateUrl : "views/addcontacto.php"
    })
    .when("/vercontacto", {
        templateUrl : "views/vercontacto.php"
    })
    .when("/verlista", {
        templateUrl : "views/verlista.php"
    })
    .when("/contactoslista/:listName", {
        templateUrl : "views/contactoslista.php",
        controller: "contactolista_dos"
    })
    .when("/verdesuscrito", {
        templateUrl : "views/verdesuscrito.php"
    })
    .when("/verrebotado", {
        templateUrl : "views/verrebotado.php"
    })
    .when("/verfiltro", {
        templateUrl : "views/verfiltro.php"
    })
    .otherwise({redirectTo: '/'});

    //$sceProvider.enabled(false);
});

app.controller('myCtrl', function($scope, $http) {
    $http.get("v1/user/name")
    .then(function(response) {
        if(response.data.status == true)
            $scope.nameUsr = response.data.nom;
    });

    $http.get("v1/user/notify")
    .then(function(response) {
        $scope.numNotify = response.data.num;
        $scope.notify = response.data.data;
    });
});