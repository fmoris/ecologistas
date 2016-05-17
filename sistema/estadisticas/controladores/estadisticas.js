afiliados.controller('estadisticasController', function(ngTableParams, $scope, $http, $routeParams, $location, $filter) {

    switch (localStorage.getItem("login")) {
        case '1':
            $location.path('/estadisticas');
            break;
        default:
            $location.path('/admin');
    }




})
