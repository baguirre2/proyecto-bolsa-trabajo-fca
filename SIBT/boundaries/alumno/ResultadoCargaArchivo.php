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
                <link href="../../webroot/css/estilo.css" rel="stylesheet" type="text/css" />
                <link href="../../webroot/css/menu.css" rel="stylesheet" type="text/css" />
            </head>

            <body>
                <script type="text/javascript" src="../../webroot/js/jquery-1.10.1.js"></script>	
                <script type="text/javascript" src="../../webroot/js/funAJAX.js"></script>	
                <script type="text/javascript" src="../..webroot/js/validar.js"></script>
                <?php include_once 'menu2.html'; ?>

                <div id="contenido">
                    
                </div>
                
                <div id="pie"></div>
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