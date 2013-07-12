<?php

//error_reporting (E_ALL & ~E_NOTICE);

/**
 * En este caso se usará esta parte para las pruebas hasta que se tenga desarrollado el modulo de Usuarios.
 * @author Benjamín Aguirre García
 * 
 */
//Se inicia la sesión en PHP. 
session_start();
// Se debe de poder almacenar el tipo de usuario, seleccionen con el que van a probar. 
// Alumno, Coordinador, Profesor, Reclutador
$_SESSION['TipoUsuario'] = 'Alumno'; 
// Aqui pongan el id del Usuario con el que están haciendo pruebas, 
$_SESSION['idUsuario'] = 1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Reservaciones de Laboratorio</title>
        <link href="webroot/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="webroot/css/menu.css" rel="stylesheet" type="text/css" />
         <!--Css de las tablas-->
        <link href="webroot/css/demo_table.css" rel="stylesheet" type="text/css" />
        <link href="webroot/css/TableTools.css" rel="stylesheet" type="text/css" />
        <link href="webroot/css/lightbox.css" rel="stylesheet" type="text/css" />	
 		
        <script type="text/javascript" src="webroot/js/jquery-1.10.1.js"></script>	
                	
                
                <!--Agrega funcionalidad de tabla deben ir antes de funAjax -->
                <script type="text/javascript" src="webroot/js/jquery.dataTables.js"></script>
                <script type="text/javascript" src="webroot/js/TableTools.js"></script>
                <script type="text/javascript" src="webroot/js/ZeroClipboard.js"></script>
                <script type="text/javascript" src="webroot/js/lightbox-2.6.min.js"></script>
                
                <script type="text/javascript" src="webroot/js/funAJAX.js"></script>	
                <script type="text/javascript" src="webroot/js/validar.js"></script>	

    </head>

    <body>
      
       
        <?php include("boundaries/layout/menu.html"); ?>

        <div id="contenido"></div>
        <div id="pie"></div>
        <form id="vacio"></form>

    </body>
</html>