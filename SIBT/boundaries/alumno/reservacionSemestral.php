<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Reservaciones de Laboratorio</title>
        <link href="webroot/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="webroot/css/menu.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <script type="text/javascript" src="./include/funAJAX.js"></script>	
        <?php include("menu.php"); ?>

        <div id="contenido">

            <?php
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//directorio donde se almacenaran los archivos 
            $directorio = '../archivos/';
//extensiones permitidos a subir 
            $ext_permitidas = Array("csv", "CSV", "txt");
//errores 
            $error = Array(1 => "Extension no valida",
                2 => "Archivo mayor a 3mb",
                3 => "Archivo no cargado por POST");

            $error2 = array();

            $nombre_archivo = basename($_FILES['userfile']['name']); //obtenemos el nombre del archivo 
            $tipos = count($ext_permitidas); //numero de extensiones 
            $ext = explode(".", $nombre_archivo); //obtenemos la extension del archivo 
//verificamos que la extension se encuentre entre las permitidas 
            $ban = 'error';
            for ($x = 0; $x < $tipos; $x++) {
                if ($ext[1] == $ext_permitidas[$x])
                    $ban = 1;
            }

            if ($ban == 'error') {
                echo "<h4>Error: $error[1] </h4>";

//verificamos que el tamano sea menor a 3145728 bytes (3mb)                 
            } else if ($_FILES['userfile']['size'] > 3145728) {
                echo "<h4>Error: $error[2] </h4>";
                $ban = 'error';

//verificamos que el archivo sea valido y cargado por HTTP POST de PHP                 
            } else if (!(is_uploaded_file($_FILES['userfile']['tmp_name']))) {
                echo "<h4>Error: $error[3] </h4>";
                $ban = 'error';

//sino hay errores movemos el archivo temporal a nuestra carpeta                 
            } else if ($ban != 'error') {
                move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio . $nombre_archivo);
                echo "<h4>El archivo es valido y fue cargado con exito.</h4>";
                echo"<h4>Archivo: $nombre_archivo</h4>";

//Validacion de las fechas
                $fechaIni = $_POST['fechaInicio'];
                $fechaFin = $_POST['fechaFin'];

                if ($fechaFin == "" || $fechaIni == "") {
                    echo "<h4>Ingresa la fecha de inicio y la fecha final del semestre</h4>";
                } else {
                    $fechaIni = explode("-", $fechaIni);
                    $fechaIni = $fechaIni[2] . "/" . $fechaIni[1] . "/" . $fechaIni[0];
                    $fechaFin = explode("-", $fechaFin);
                    $fechaFin = $fechaFin[2] . "/" . $fechaFin[1] . "/" . $fechaFin[0];

                    include_once '../../controllers/ManejadorCSV.php';

                    $manCSV = new ManejadorCSV();
                    $manCSV->setFechaIni($fechaIni); //<-----Aquí metes la fechaIni del usuario
                    $manCSV->setFechaFin($fechaFin); //<-----Aquí metes la fechaFin del usuario

                    $CSV = $manCSV->abrirArchivo("../archivos/$nombre_archivo"); //<---Aquí le das la dirección del archivo, una vez que se cargo al servidor

                    while (( $regis = $manCSV->extraerRegistro($CSV)) != FALSE) {

                        $manCSV->procesarRegistro($regis);
                    }
                    fclose($CSV);
                }
            } else {
                echo "<h4>Vuelve a intentar";
            }
            ?>
        </div>
        <div id="pie"></div>﻿
