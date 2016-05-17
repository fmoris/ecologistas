afiliados.controller('loginController', function(ngTableParams, $scope, $http, $routeParams, $location, $filter, toaster) {

switch (localStorage.getItem("login")) {
                    case '1':
                        $location.path('/estadisticas');
                        break;
                }

$scope.login = function() {
        $http.get('sistema/login/php/login.php', {
            params: {
                password: $scope.password
            }
        }).success(function(usuario) {
            if (usuario == 0) {
               toaster.pop('error', "Error", 'Datos Ingresados Incorrectamente', null, 'trustedHtml');
            } else {

                localStorage.setItem("login", ""+usuario);

                $scope.id =  localStorage.getItem("id");

                $location.path('/estadisticas');


                //$location.path('/buscaOrdenes');
            }
        }).error(function(usuario) {
            toaster.pop('error', "Error", 'Error al buscar usuario', null, 'trustedHtml');
        })
    }
})
