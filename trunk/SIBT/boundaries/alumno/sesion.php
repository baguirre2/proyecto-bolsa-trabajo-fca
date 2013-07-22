<?php
class CtlSesion{
	    function __construct($global_GET) {
	    	
        $opc = $_GET['opc'];
        
        switch ($opc) {
			//mostrar formulario
			case 1:
                            switch($_GET['usuario']){
                                case 1:
                                    $usuario = 'Admin';
                                break;
                                case 2:
                                    $usuario = 'Responsable';
                                break;
                                case 3:
                                     $usuario = 'Reclutador';
                                break;
                                case 4:
                                    $usuario = 'Alumno';
                                break;
                            }
				
                            include_once 'menu2.php';	
				
			break;		
			
        }
     }
            
}
new CtlSesion($_GET);
?>
