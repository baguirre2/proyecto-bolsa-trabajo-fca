<?php

//Como podran ver dentro del constructor hay una copia indetica el index, solo cambian (bueno se adecuan) las direcciones de los CSS y del JS

class ResultadoCargaArchivo {

    public function __construct($mensaje) {

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
          <!-- Bootstrap -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="../../webroot/css/bootstrap.css" rel="stylesheet">
		<link href="../../webroot/css/capture.css" rel="stylesheet">
		<link href="../../webroot/css/animate.css" rel="stylesheet">
		<link href="../../webroot/css/font-awesome.css" rel="stylesheet">
         <!--Css de las tablas-->
        <link href="../../webroot/css/demo_table.css" rel="stylesheet" type="text/css" />
        <link href="../../webroot/css/TableTools.css" rel="stylesheet" type="text/css" />
        <link href="../../webroot/css/lightbox.css" rel="stylesheet" type="text/css" />       
        <link rel="stylesheet" type="text/css" href="../../webroot/css/smoothness/jquery-ui-1.10.3.custom.css"/>
        <link rel="stylesheet" type="text/css" href="../../webroot/css/smoothness/jquery-ui-1.10.3.custom.min.css"/>
        <link rel="stylesheet" type="text/css" href="../../webroot/css/jquery.timepicker.css" />
        
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        
        <script type="text/javascript" src="webroot/js/jquery-1.10.1.js"></script>      
                        
                
                <!--Agrega funcionalidad de tabla deben ir antes de funAjax -->
                <script type="text/javascript" src="../../webroot/js/jquery.dataTables.js"></script>
                <script type="text/javascript" src="../../webroot/js/TableTools.js"></script>
                <script type="text/javascript" src="../../webroot/js/ZeroClipboard.js"></script>
                <script type="text/javascript" src="../../webroot/js/lightbox-2.6.min.js"></script>
                
                <script type="text/javascript" src="../../webroot/js/funAJAX.js"></script>    
                <script type="text/javascript" src="../../webroot/js/validar.js"></script>    
                <script type="text/javascript" src="../../webroot/js/jquery-ui-1.10.3.custom.js"></script>
                <script type="text/javascript" src="../../webroot/js/jquery.timepicker.js"></script>
                <script type="text/javascript" src="../../webroot/js/function_calendario.js"></script>
                <script type="text/javascript" src="../../webroot/js/base.js"></script>
                 <!--Funcionamiento de las graficas-->
                 <script type="text/javascript" src="../../webroot/js/graficas.js"></script>
                 
        <script src="../../webroot/js/bootstrap.min.js"></script>
        <script src="../../webroot/js/twitter-bootstrap-hover-dropdown.js"></script>
        <script src="../../webroot/js/capture.js"></script>
        <script src="../../webroot/js/fixed-header.js"></script>
        <script src="../../webroot/js/modernizr.custom.js"></script>
        <script src="../../webroot/js/testimonials.js"></script>
        
        <script>
    function cambiarUsuario(usuario){
        $.get('sesion.php',{'opc':1,'usuario':usuario}, function(data){
            $('#div_menu').empty();
            $('#div_menu').append(data);
        });
    }
</script>
    </head>

        <body>
        
   

                        <div id="div_menu">
                                <?php include("menu2.php"); ?>

                        </div>


   

        <div class="white inner-page">
        	
        
            <div id="contenido" class="container">
                  <?php include("bienvenido_banner.html"); ?>
            </div><!--/container-->
        </div><!--/white-->


        <div class="footer">
            <div class="container">
                <div class="row" >
                    <div class="span9" >
                        <p class="copyright">
                        Hecho en México, DR © 2013. Esta página puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica. De otra forma requiere permiso previo por escrito de la institución. <a href="#"> Créditos</a> </p>
                    </div><!--/span 6-->
                    <div class="span3 social-icons">
                        <a href="http://www.unam.mx/" target="_blank"><i class="fontawesome-icon social circle-social icon-unam"></i></a>
                        <a href="http://www.fca.unam.mx/" target="_blank"><i class="fontawesome-icon social circle-social icon-fca"></i></a>
                    </div><!--/span 6-->
                </div><!--/row-->
            </div><!--/container-->
        </div><!--/footer-->
        
        
        <form id="vacio"></form>
        
        
        
    </body>
    <!-- Solo agregue este Script, el cual muestra un mensaje (que recibe el contructor como parametro), 
                    y una vez que se muestra, se redirecciona al index del sistema  -->
            <script type="text/javascript">
                //Esto hace que se lance al mensaje una vez que la pagina este cargada al 100%
                document.addEventListener('DOMContentLoaded', function () {
                    
                    //Una vez de que se cargo la pagina, autoejecuto inmediatamente el mensaje, al dar Aceptar el usuario, se redirecciona
                     setTimeout(function(){
                         alert ('<? echo $mensaje ?>');
                         window.location.href="../../";
                     },0);
                }, false);
                </script>	
</html>
        <?
    }

}
?>