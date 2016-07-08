var afiliados = angular.module('afiliados', ['ngRoute',
                                             'ngTable',
                                             'toaster',
                                             'ngAnimate'
                                            ]);
afiliados.config(['$routeProvider',
    function($routeProvider) {

        $routeProvider
            .when('/', {
                templateUrl: 'sistema/buscador/buscador.html',
                controller: 'buscadorController'
            })
            .when('/buscador', {
                templateUrl: 'sistema/admin/admin.html',
                controller: 'adminController'
            })
            .when('/admin', {
                templateUrl: 'sistema/login/login.html',
                controller: 'loginController'
            })
            .when('/estadisticas', {
                templateUrl: 'sistema/estadisticas/estadisticas.html',
                controller: 'estadisticasController'
            })
            .when('/fechas', {
                templateUrl: 'sistema/afiliadosFecha/afiliadosFecha.html',
                controller: 'FechasController'
            })
            .when('/region', {
                templateUrl: 'sistema/afiliadosRegion/afiliadosRegion.html',
                controller: 'regionController'
            })
            .when('/regionales', {
                templateUrl: 'sistema/regionales/regionales.html',
                controller: 'regionalesController'
            })
            .otherwise({
                redirectTo: '/'
            })
    }
]);

afiliados.filter('dateToISO', function() {
  return function(input) {
        if(input){
            input = new Date(input).toISOString();
            return input;
        }
  };
});

