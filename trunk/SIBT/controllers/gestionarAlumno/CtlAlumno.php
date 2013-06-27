<?php

include_once '../../entities/Alumno.php';
include_once '../../entities/InterfazBD2.php';

class CtlAlumno {

    function __construct($GET) {

        $opc = $GET['opc'];

        //En esta l�nea se obtendra el ID del alumno, por un objeto SESSION
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
            	$alumno = new Alumno();
	            if(!isset($GET['btnAceptar']) ) {
	            	$niveles_estudio = $alumno->listarNivelesEstudio();
	            	include('../../boundaries/alumno/frmRegistroAlumno.html');
	            }else if($GET['btnAceptar'] == 'Registrar' ) {
	            	if($alumno->registrarAlumno($GET)){
	            		echo "<h1 class=respuesta>Registro realizado con éxito</h1><br/>";
	            	}else{
	            		echo "<h1 class=respuesta>Error al registrar</h1><br/>";
	            	}
	            }
            	break;
            	
            case 'llenarListaEstudios';
            	$alumno = new Alumno();
            	$id_nivel = $GET['id'];
            	$alumno->listarEstudiosFCA($id_nivel);
            	break;
            	
            case 'llenarListaEstadosAcademicos';
            	$alumno = new Alumno();
            	$id_nivel = $GET['id'];
            	$alumno->listarEstadosAcademicos($id_nivel);
            	break;
    
		}
    }
}

new CtlAlumno($_GET);
?>