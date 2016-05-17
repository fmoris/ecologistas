<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../php/coneccion.php');

    $result = mysqli_query($conexion,"SELECT regiones.Region as 'region', COUNT( afiliados.Rut ) AS  'conteo'
                                      FROM afiliados, regiones
                                      WHERE afiliados.Region = regiones.Numero
                                      GROUP BY Region");

mysqli_query($result, "SET NAMES 'utf8'");
mysqli_query($result, "SET CHARACTER SET 'utf8'");

/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $usuario = array();
    $usuario["region"] = $row['region'];
    $usuario["conteo"] = $row['conteo'];


/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $usuario);
}
    echo json_encode($resultadoOrdenado);


/// una vez populado el arreglo general con datos, se convierte a Json



?>
