<?php

include_once '../../entities/Alumno.php';
include_once '../../entities/InterfazBD2.php';

class CtlAlumno {

    function __construct($GET) {

        $opc = $GET['opc'];

        //En esta línea se obtendra el ID del alumno, por un objeto SESSION
        $idAlum = 1;

        switch ($opc) {

            //Mostrar Formulario para registro
            case 1;
                include '../../boundaries/curriculum/menuCurr.html';
                break;

            //Mostrar Formularo de Registro
            case 2;
                include '../../boundaries/curriculum/frmCurrRegis.html';
                break;

            case 'alumno_registrar';
	            if(!isset($GET['ce_id']) && !isset($GET['btnAceptar']) ) {	//Si no se ha cargado el formulario se incluye
	            	include('../../boundaries/alumno/frmRegistroAlumno.php');
	            } else if($GET['btnAceptar'] == 'Registrar' ) {
	            	$alumno = new Alumno();
	            	if($alumno->registrarAlumno($GET, $idAlum)){
	            		echo "<h1 class=respuesta>Registro realizado con éxito</h1><br/>";
	            	}else{
	            		echo "<h1 class=respuesta>Error al registrar</h1><br/>";
	            	}
	            }
            	break;
    
		}
    }
}

new CtlAlumno($_GET);
?>