<?php

//include '../entitys/';

class CtlCurric {
    function __construct($_GET) {
        
        $opc = $_GET['opc'];
        
        switch ($opc) {
            
            //Mostrar Formulario para registro
            case 1; include '../../boundaries/curriculum/menuCurr.html';
                break;
            
            //Mostrar Formularo de Registro
            case 2; include '../../boundaries/curriculum/frmCurrRegis.html';
                break;
            
            //Modificar
            case 3; echo "<h1>Modificar</h1>";
                break;
            
            //Listar
            case 4; echo "<h1>Listar</h1>";
                break;
            
            //Registrar
            case 'registrar'; 
                            
                
                    echo "<h1>He registrado tus datos $_GET[nomAlum].
                            Tu Dirección es: $_GET[dirAlum]</h1>";
                break;
        }
    }
    
    //function registrarAlumno ($_GET) {
    //Recibe los datos de la petición y crea una Entity, que los almacena en la BD
    function registrarAlumno ($nom, $dir, $tel) {
        
    }
}

new CtlCurric ($_GET);
?>