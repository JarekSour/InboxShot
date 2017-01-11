app.controller('chart1', function ($scope, $http) {
    $scope.options = {
        animate:{ duration:2000, enabled:true },
        barColor:function(percent) {
            percent /= 100;
            return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
        },
        scaleColor:false,
        lineWidth:20,
        lineCap:'butt',
        size:175
    };

    $http.get("v1/campaign/graphic/fidelizar")
    .then(function(response) {
        $scope.porcent = response.data.porce;
        $scope.percent = response.data.porce;
        $scope.open    = response.data.aper;
        $scope.process = response.data.envi;
        $("#loaderFI").fadeOut();
    });
});

app.controller('chart2', function ($scope, $http) {

    $scope.options = {
        animate:{ duration:2000, enabled:true },
        barColor:function(percent) {
            percent /= 100;
            return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
        },
        scaleColor:false,
        lineWidth:20,
        lineCap:'butt',
        size:175
    };

    $http.get("v1/campaign/graphic/vender")
    .then(function(response) {
        $scope.porcent = response.data.porce;
        $scope.percent = response.data.porce;
        $scope.open    = response.data.aper;
        $scope.process = response.data.envi;
        $("#loaderVE").fadeOut();
    });
});

app.controller('chart3', function ($scope, $http) {

    $scope.options = {
        animate:{ duration:2000, enabled:true },
        barColor:function(percent) {
            percent /= 100;
            return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
        },
        scaleColor:false,
        lineWidth:20,
        lineCap:'butt',
        size:175
    };

    $http.get("v1/campaign/graphic/invitar")
    .then(function(response) {
        $scope.porcent = response.data.porce;
        $scope.percent = response.data.porce;
        $scope.open    = response.data.aper;
        $scope.process = response.data.envi;
        $("#loaderIN").fadeOut();
    });
});