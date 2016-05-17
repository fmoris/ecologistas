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

 $region = $_GET['region'];
 $nombre = $_GET['nombre'];
 $rut = $_GET['rut'];

if (!$nombre && !$rut){
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
                                             AND regiones.Numero LIKE '%$region%'
                                             ORDER BY circu.Nombre,afiliados.Region");
}else{

$result = mysqli_query($conexion,"SELECT afiliados.Fecha_afiliado as 'Fecha_afiliado',
                                  afiliados.Nombre as 'Nombre',
                                  afiliados.Region as 'Region',
                                  regiones.Region as 'NombreRegion',
                                  afiliados.Rut as 'Rut',
                                  circu.Nombre as 'circu',
                                  afiliados.Estado as 'codEstado',
                                  estados.nombre as 'Estado'
                                  FROM afiliados, regiones, circu, estados
                                  WHERE afiliados.Circu LIKE circu.Codigo
                                  AND regiones.Numero like afiliados.Region
                                  AND afiliados.Estado LIKE 1
                                  AND afiliados.estado LIKE estados.id
                                  AND afiliados.Nombre like '%$nombre%'
                                  AND regiones.Numero LIKE '%$region%'
                                  AND afiliados.Rut LIKE '%$rut%'
                                  ORDER BY circu.Nombre,afiliados.Region");
}
mysqli_query($result, "SET NAMES 'utf8'");
mysqli_query($result, "SET CHARACTER SET 'utf8'");

if($result->num_rows > 0 ){
    /** Se agrega la libreria PHPExcel */
    require_once '../../../php/PHPExcel.php';
    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();
    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Codedrinks") // Nombre del autor
        ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
        ->setTitle("Reporte Excel con PHP y MySQL") // Titulo
        ->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias
    $tituloReporte = "Afiliados";
    $titulosColumnas = array('RUT', 'NOMBRE', 'COMUNA', 'REGION');
    // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:D1');

    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1',$tituloReporte) // Titulo del reporte
        ->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
        ->setCellValue('B3',  $titulosColumnas[1])
        ->setCellValue('C3',  $titulosColumnas[2])
        ->setCellValue('D3',  $titulosColumnas[3]);
    //Se agregan los datos de los alumnos

     $i = 4; //Numero de fila donde se va a comenzar a rellenar
     while ($fila = $result->fetch_array()) {
         $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$i, $fila['Rut'])
             ->setCellValue('B'.$i, $fila['Nombre'])
             ->setCellValue('C'.$i, $fila['circu'])
             ->setCellValue('D'.$i, $fila['NombreRegion']);
         $i++;
     }
    for($i = 'A'; $i <= 'D'; $i++){
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Afiliados');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);

    // Inmovilizar paneles
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Afiliados.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
    }
    else{
        print_r('No hay resultados para mostrar');
    }
?>
