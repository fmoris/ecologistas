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

 $inicio = $_GET['inicio'];
 $fin = $_GET['fin'];



    $result = mysqli_query($conexion,"SELECT afiliados.Fecha_afiliado as 'Fecha_afiliado',
                                             afiliados.Nombre as 'Nombre',
                                             afiliados.Region as 'Region',
                                             regiones.Region as 'NombreRegion',
                                             afiliados.Rut as 'Rut',
                                             circu.Nombre as 'circu',
                                             afiliados.Estado as 'codEstado',
                                             estados.nombre as 'Estado'
                                             FROM afiliados, regiones, circu,estados
                                             WHERE afiliados.Circu LIKE circu.Codigo
                                             AND regiones.Numero like afiliados.Region
                                             AND afiliados.estado LIKE estados.id
                                             AND afiliados.Estado LIKE 1
                                             AND (afiliados.Fecha_afiliado BETWEEN '$inicio' AND '$fin' )");

mysqli_query($result, "SET NAMES 'utf8'");
mysqli_query($result, "SET CHARACTER SET 'utf8'");

/// crea un arreglo general vacio
$resultadoOrdenado = array();
// el arreglo se popula en este bucle
while($row = mysqli_fetch_array($result)){
    // crea un objeto donde se incluyen los datos del registro
    $usuario = array();
    $usuario["fecha_ingreso"] = $row['Fecha_afiliado'];
    $usuario["Nombre"] = $row['Nombre'];
    $usuario["Region"] = $row['Region'];
    $usuario["NombreRegion"] = $row['NombreRegion'];
    $usuario["RUT"] = $row['Rut'];
    $usuario["circu"] = $row['circu'];
    $usuario["codEstado"] = $row['codEstado'];
    $usuario["estado"] = $row['Estado'];

/// inserta el objeto con los datos de registro, dentro del arreglo general
    array_push($resultadoOrdenado, $usuario);
}
    echo json_encode($resultadoOrdenado);


/// una vez populado el arreglo general con datos, se convierte a Json



?>
