afiliados.controller('regionalesController', function(ngTableParams, $scope, $http, $routeParams, $location, $filter) {

    $scope.afiliadosRegion = function() {
        $http.get('sistema/regionales/php/afiliadosRegion.php')
            .success(function(afiliados) {
                $scope.afiliados = afiliados;
                console.log($scope.afiliados);
            })
    }
})
