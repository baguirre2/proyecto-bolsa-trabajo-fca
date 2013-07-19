<?php 

include '../../entities/Grupo.php';

class CtlGrupo{
	    function __construct($global_GET) {
	    	
        $opc = $_GET['opc'];
        
        switch ($opc) {
			//mostrar formulario
			case 1:
				include '../../boundaries/grupo/frmAgregarGrupo.php';
				$grp= new Grupo();
				$datos_formulario = $grp->obtenerDatosGrupo();
				$frmAgregarGrupo = new FrmAgregarGrupo($datos_formulario);
				break;		
			//el case 2 sirve para llamar insertar registros	
			case 2:
				//este case es para agregar grupo, esl cual es llamado desde la clase frmAgregarGrupo
				/*$mensaje1 = "En construccion";
				echo $mensaje1;
				echo '<pre>';	
				var_dump($_GET);
				echo '</pre>';*/
				$datosGrupo=$_GET;			
				$grpInsertar=new Grupo();
				
				$id_profesor=$_GET["pr_id"];
				$id_taller=$_GET["ta_id"];
				$id_aula=$_GET["au_id"];
				$nombre_grupo=$_GET["gr_nombre"];
				$estado_aprobacion=$_GET["gr_estado_aprobacion"];
				$fecha_inicioSF=$_GET["gr_fecha_inicio"];
				$fecha_finSF=$_GET["gr_fecha_fin"];
				
				//FORMATEO FECHAS DE dd:mm:yyyy a yyyy:mm:dd, ya que asi lo acepta postgresql
				$fecha_inicio=date("Y-m-d", strtotime($fecha_inicioSF) );
				$fecha_fin=date("Y-m-d", strtotime($fecha_finSF) );
				
				$grpInsertar->insertarGrupo($id_profesor, $id_taller, $id_aula, $nombre_grupo, $estado_aprobacion, $fecha_inicio, $fecha_fin);
				break;
			case 3:
				//CONSULTAR GRUPO
				 include '../../boundaries/grupo/frmConsultarGrupo.php';
				 $cg = new Grupo();
				 $datos_tabla = $cg->obtenerDatosTabla();	 
				 $campos = array();
				 $campos[] = 'gr_id';
				 $campos[] = 'gr_nombre';
				 $campos[] = 'ta_nombre';
				 $campos[] = 'pe_nombre';
				 $campos[] = 'au_lugar';
				 $campos[] = 'gr_fecha_inicio';
				 $campos[] = 'gr_fecha_fin';				 
				 $frmConsultarGrupo = new FrmConsultarGrupo($datos_tabla,$campos);		 
           		 break;
            	
           		 case 4:
           		 	//ELIMINAR GRUPO
           		 	//var_dump($_GET);          		 	
           		 	$grupo_id = $_GET['gr_id'];
           		 	$borrar=new Grupo();
           		 	$borrar->borraGrupo($grupo_id); 	
           		 	break;
           		 case 5:
           		 	//MODIFICAR GRUPO
           		 	include '../../boundaries/grupo/frmActualizarGrupo.php';
           		 	
           		 	$grp1= new Grupo();
           		 	$datos_formulario = $grp1->obtenerDatosGrupo();
           		 	  		 	
           		 	$grp= new Grupo();
           		 	$grupo_id=$_GET['gr_id'];
           		 	$datos_formulario2 = $grp->obtenerDatosActualizacion($grupo_id);
           		 	$frmActualizarGrupo = new FrmActualizarGrupo($grupo_id,$datos_formulario,$datos_formulario2);
           		 	break;	

           		 case 6:
           		 	/*echo '<pre>';
           		 	var_dump($_GET);
           		 	echo '</pre>';*/
           		 	
           		 	$id_grupo=$_GET["grupo_id"];
           		 	$id_profesor=$_GET["pr_id"];
           		 	$id_taller=$_GET["ta_id"];
           		 	$id_aula=$_GET["au_id"];
           		 	$nombre_grupo=$_GET["gr_nombre"];
           		 	$estado_aprobacion=$_GET["gr_estado_aprobacion"];
           		 	$fecha_inicioSF=$_GET["gr_fecha_inicio"];
           		 	$fecha_finSF=$_GET["gr_fecha_fin"];
           		 	
           		 	//FORMATEO FECHAS DE dd:mm:yyyy a yyyy:mm:dd, ya que asi lo acepta postgresql
           		 	$fecha_inicio=date("Y-m-d", strtotime($fecha_inicioSF) );
           		 	$fecha_fin=date("Y-m-d", strtotime($fecha_finSF) );
           		 	
           		 	$grpActualizar = new Grupo();
           		 	$grpActualizar->actualizarGrupo($id_grupo,$id_profesor, $id_taller, $id_aula, $nombre_grupo, $estado_aprobacion, $fecha_inicio, $fecha_fin);
           		 	break;
		}
	}
}
new CtlGrupo($_GET);
?>