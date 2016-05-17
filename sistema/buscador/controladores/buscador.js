afiliados.controller('buscadorController', function($scope, $http, $routeParams, $location) {

    $( "#resultado_ok" ).hide();

   $scope.totalEcologistas = function(){
        $http.get('sistema/buscador/php/totalEcologistas.php', {
            params: {
                rut: 1
            }
        }).success(function(total) {
            $scope.total = total;
        }).error(function(total){

        })
    }
    $scope.totalEcologistas();

    $scope.envio = function() {
        $http.get('sistema/buscador/php/obtieneAfiliado.php', {
            params: {
                rut: $scope.afiliado.rut
            }
        }).success(function(existe) {
            if(existe){
                $scope.persona = existe;
                $("#resultado_ok").show();
                $("#invitacion").hide();
                $("#noafiliado").hide();
                $("#noexiste").hide();
                $("#existe").show();
                $("#resultado").show();
                $http.get('sistema/buscador/php/obtieneInformacion.php', {
                    params: {
                        region: $scope.persona[0].Region,
                    }
                }).success(function(datos){
                    $scope.encargado = datos;
                    console.log(datos);
                    if($scope.encargado[0].conteo == 0){
                        alert("No  hay presidente regional");
                        $("#invitacion").hide();
                        $("#noafiliado").hide();
                        $("#existe").hide();
                        $("#noexiste").show();
                        $("#resultado").show();
                    }
                }).error(function(datos){
                    alert("Error al cargar datos del presidente regional");
                })
                }else{
                    alert("No Esta Afiliado");
                    $("#resultado_ok").show();
                    $("#invitacion").hide();
                    $("#noafiliado").show();
                    $("#noexiste").hide();
                    $("#existe").hide();
                    $("#resultado").hide();

                }
        }).error(function(existe) {
            alert("Problema en conectar a la base de datos, intente mas tarde");

        })
    }
})
