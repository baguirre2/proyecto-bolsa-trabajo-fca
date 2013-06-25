<?php

/**
 * @version 1.0
 */
session_start();
include_once '../../entities/InterfazBD.php';
include_once '../../entities/Curso.php';
include_once '../../entities/Idioma.php';

class CtlCurric {
    function __construct() {
        
        $opc = $_GET['opc'];
        
        switch ($opc) {
            //Mostrar menú
            case 1; include '../../boundaries/curriculum/menuCurr.html';
                break;
                



        }

    }
    
    
    
    
}

$CtlCurric1 = new CtlCurric ();
?>