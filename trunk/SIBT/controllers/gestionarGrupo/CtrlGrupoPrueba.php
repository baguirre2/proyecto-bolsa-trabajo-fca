<?php 

include '../../entities/Grupos_select.php';

class CtlGrupo{
	    function __construct($_GET) {
	    	ECHO"LLEGUE";
        $opc = $_GET['opc'];
        
        switch ($opc) {
			//mostrar formulario
			case 1:
				include '../../boundaries/Grupos/frmConsultarGrupos.php';
				$grps= new Grupos_select();
				$datos_formulario = $grps->obtenerDatosTotales();
				$grupos = new FrmConsultarGrupos($datos_formulario); 
				echo "hiola llegue";
				break;		
			//el case 2 sirve para llamar insertar registros	
			case 2:
				/*$mensaje1 = "En construccion";
				echo $mensaje1;
				echo '<pre>';
				var_dump($_GET);
				echo '</pre>';*/
				$datosGrupo=$_GET;
				$grpInsertar=new Grupos();
				$grpInsertar->insertarGrupo($datosGrupo);
				break;
			case 3:
           		 break;
            	
				
		}
	}
}
new CtlGrupo($_GET);
?>