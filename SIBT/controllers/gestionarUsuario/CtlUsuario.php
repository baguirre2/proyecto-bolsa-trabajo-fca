<?php
/*
 * Archivo: Class CtlUsuario
 * Autor:	Victor M. Morales Reyes
 * Fecha:	Martes 27/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

include_once '../../entities/Usuario.php';
include_once '../../entities/InterfazBD2.php';

class CtlUsuario {

    function __construct($GET) {

        $opc = $GET['opc'];

        //En esta línea se obtendra el ID del alumno, por un objeto SESSION
        $idAlum = 1;

        switch ($opc) {
			case 'agregar_usuario';  
            	$usuario = new Usuario();
            	$consultaTipo = $usuario->obtenerTipoUsuario();
				if (!$consultaTipo) {
					echo"Error en la conexión con la base de datos.";
				}
				include '../../boundaries/usuario/frmRegistroUsuario.html';
            	break;
            case 'registrar_usuario';
				$usuario = new Usuario();
            	
				if ($consultaTipo = $usuario->registrarUsuario($GET)){
					echo "<h1>El usuario ha sido agregado<h1>";
				}
				
            	break;
			case 'regresar';
				echo "<h1>Gestionar Usuario<h1>";
				
            	break;
            	
    
		}
    }
}

new CtlUsuario($_GET);
?>