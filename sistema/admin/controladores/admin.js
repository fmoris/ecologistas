afiliados.controller('adminController', function(ngTableParams, $scope, $http, $routeParams, $location, $filter) {

    $scope.resultado = false;
    $scope.afiliado = {};
    $scope.Numero = {};

      switch (localStorage.getItem("login")) {
                    case '1':
                        $location.path('/buscador');
                        break;
                    default:
                        $location.path('/admin');
                }

    $scope.listaRegiones = function() {
        $http.get('sistema/admin/php/listaRegiones.php')
            .success(function(regiones) {
                $scope.listaRegiones = regiones;
            })
    }

    $scope.Afiliados = function() {

        console.log($scope.Numero);
        $http.get('sistema/admin/php/listaAfiliados.php', {
            params: {
                region: $scope.Numero.Numero,
                nombre: $scope.nombre,
                rut: $scope.rut
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

    $scope.edita = function(afiliado) {
        $scope.afiliado = afiliado;
    }

    $scope.editaAfiliado = function() {
        $http.post('sistema/admin/php/editaAfiliado.php', $scope.afiliado)
            .success(function(data) {
                alert("Datos Actualizados con Exito");
            })
    }
    /*
    Exportar a Excel
    */
    $scope.exportData = function() {
        $http.get('sistema/admin/php/exportarExcel.php', {
            params: {
                region: $scope.Numero.Numero,
                nombre: $scope.nombre,
                rut: $scope.rut
            }
        }).success(function(data) {
                console.log(data);
                //window.open('pagina.php?id='+id,'_blank');
                window.open('sistema/admin/php/exportarExcel.php?region='+$scope.Numero.Numero,'_blank');
        }).error(function(data) {
                console.log(data);
        })
    }



})
