afiliados.controller('FechasController', function(ngTableParams, $scope, $http, $routeParams, $location, $filter) {

    switch (localStorage.getItem("login")) {
        case '1':
            $location.path('/fechas');
            break;
        default:
            $location.path('/admin');
    }

    $scope.fecha = {};

    $scope.Afiliados = function() {
        $http.get('sistema/afiliadosFecha/php/afiliadosFecha.php', {
            params: {
                inicio: $scope.fecha.inicio,
                fin: $scope.fecha.fin
            }
        }).success(function(afiliados) {

            $scope.data = afiliados;
            $scope.tableParams = new ngTableParams({
                page: 1, // show first page
                count: 5, // count per page
                total: $scope.data.length,
                sorting: {
                    Orden: 'asc' // initial sorting
                }
            }, {
                total: $scope.data.length, // length of data
                getData: function($defer, params) { // use build-in angular filter
                    var orderedData = params.sorting ?
                        $filter('orderBy')($scope.data, params.orderBy()) :
                        data;
                    orderedData = params.filter ?
                        $filter('filter')(orderedData, params.filter()) :
                        orderedData;


                    $scope.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

                    params.total(orderedData.length); // set total for recalc pagination
                    $defer.resolve($scope.users);
                }
            });
            $scope.total = $scope.data.length;
        });
        if(total == null || total == 0){
        	toaster.pop('error', "Error", 'La busqueda no tiene resultados', null, 'trustedHtml');
        }
        var inArray = Array.prototype.indexOf ?
            function(val, arr) {
                return arr.indexOf(val)
            } :
            function(val, arr) {
                var i = arr.length;
                while (i--) {
                    if (arr[i] === val) return i;
                }
                return -1
            };

    }



})
