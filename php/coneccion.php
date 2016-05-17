<?php
require_once('bd.php');

#  Check database to host connection
if(!function_exists('mysql_connect'))
{
    echo 'PHP cannot find the mysql extension. MySQL is required for run. Aborting.';
    exit();
}

/*$conexion = @mysql_connect($server, $username_mysql, $password_mysql)*/
$conexion = mysqli_connect($server,$username_mysql,$password_mysql,$database_mysql)
or die('Error: Database to host connection: '.mysql_error());

$conexion->set_charset("utf8");

/*mysql_select_db($database_mysql, $conexion)
or die('Error: Select database: '.mysql_error());*/
?>
