<?php

/**
 * @version 1.0
 */
session_start();

include '../../entities/InterfazBD.php';
include '../../entities/Curso.php';

class CtlCurric {
    function __construct() {
        
        $opc = $_GET['opc'];
        
        switch ($opc) {
            //Mostrar menú
            case 1; include '../../boundaries/curriculum/menuCurr.html';
                break;

            case "AgregarCurso";
            	include '../../boundaries/curriculum/frmCursRegis.php';
            	break;

            case "EditarCurso";
            	$idCurso = $_GET['idCurso'];

            	$curso1 = new Curso();
            	$curso  = $curso1->obtenerCurso($idCurso);
            	$nombreCurso = $curso[0][cu_nombre];
            	$fechaParticipacion = $curso[0][cu_fecha_conclusion];
            	$rutaImg = $curso[0][cu_ruta_constancia];
				include '../../boundaries/curriculum/frmCursRegis.php';
            	break;
            	
            case "ActualizarCurso";
            	$idCurso = $_GET['idCurso'];
            	$nombreCurso = $_GET['nombreCurso'];            	
            	$fechaParticipacion = $_GET['fechaParticipacion'];
            	$rutaImg = $_GET['rutaImg'];
                    	$err = false;
        		if (!isset($nombreCurso)) {
            		$errMsj .= "Debe tener un nombre el Curso <br>";
            		$err = true;
            	}            	
            	if (!isset($fechaParticipacion)) {
            		$errMsj .= "Fecha Inválida <br>";
            		$err = true;
            	}
                if (!isset($rutaImg)) {
            		$errMsj .= "Debes Ingresar una ruta <br>";
            		$err = true;
            	}
            	if ($err == false) {
            		$curso1 = new Curso();
            		if (!$curso1->actualizar($idCurso, $nombreCurso, $fechaParticipacion, $rutaImg)) {
            			$err = true;
            			$errMsj = "Ocurrió un error inesperado";	
            		}
            	}            	
            	if ($err) {
            		include '../../boundaries/curriculum/frmCursRegis.php';	
            	} else {
            		echo "El curso ha sido modificado";
            	}
								
					
            	break;
            case "Cursos"; // Se muestran los Cursos Disponibles
            	$strCursos = $this->obtenerCursos($_SESSION['idUsuario']);
//            	echo $_SESSION['idUsuario'];
				if ($strCursos == null) {
					include '../../boundaries/curriculum/frmCursRegis.php';	
				} else {
					echo $strCursos;
					echo  "	<table width='1000'> <tr>
    							<td>  <input type=\"button\" value=\"Agregar Curso\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 'AgregarCurso' , 'vacio', 'contenido')\">
    							 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 1 , 'vacio', 'contenido')\"> </td>
							</tr> </table>";		
				}
            	break;
            
            case "RegistrarCurso";
            	$nombreCurso = $_GET['nombreCurso'];
            	$fechaParticipacion = $_GET['fechaParticipacion'];
            	$rutaImg = $_GET['rutaImg'];
            	$err = false;
        		if (!isset($nombreCurso)) {
            		$errMsj .= "Debe tener un nombre el Curso <br>";
            		$err = true;
            	}            	
            	if (!isset($fechaParticipacion)) {
            		$errMsj .= "Fecha Inválida <br>";
            		$err = true;
            	}
                if (!isset($rutaImg)) {
            		$errMsj .= "Debes Ingresar una ruta <br>";
            		$err = true;
            	}
            	if ($err == false) {
            		$Cuso1 = new Curso();
            		if (!$Cuso1->guardar($_SESSION['idUsuario'], $nombreCurso, $fechaParticipacion, $rutaImg)) {
            			$err = true;
            			$errMsj = "Ocurrió un error inesperado";	
            		}
            	}
            	if ($err) {
            		include '../../boundaries/curriculum/frmCursRegis.php';	
            	} else {
            		echo "El curso ha sido registrado";
            	}
				
            	break;
            //Mostrar Formularo de Registro
            case 'infoAcademica'; 
				           
            echo "<h1>&nbsp;</h1>";
            //Llamar al modelo para listar la informaci�n acad�mica que tiene el alumno
            //Mostrar en cada una la opci�n de editar si est� confirmado
            $resultados = $this->listarGradosAcademicos();
            //var_dump($resultados);
            
            $registros = "";
            for ($i=0; $i <= count($resultados)-1; $i++) {
            	$registros .= "<tr><td>".$resultados[$i]['inac_escuela']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_promedio']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_fecha_inicio']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_fecha_termino ']."</td>";
            	$registros .= ($resultados[$i]['esau_id'] == 1)? "<td>EDITAR</td></tr>" : "<td>NO EDITAR</td></tr>";
            }
            
            echo "
                        <table>
                        <thead>
                        <tr>
                        <th>Escuela</th>
                        <th>Promedio</th>
                        <th>Fecha inicio</th>
                        <th>Fecha término</th>
                        <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody> $registros
                    	</tbody>
                        
                    ";
            print "<tr>
					<td><input type='button' value='Registrar' onclick='ajax('controllers/gestionarCurriculum/CtlCurric.php', 'registrar', 'frmRegis', 'resFrmRegis')'/></td>
					<td><input name='btnCancelar' type='submit' id='btnCancelar' value='Cancelar' /></td>
				    </tr></table>";     
            
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
   
    function obtenerCursos ($idAlumno)  {
    	$strCursos = "
    		<table width='1000'> 
    			<thead>
    				<tr> 
    					<th colspan='3'> Cursos </th> 	
    				</tr> <tr> 
    					<th> Nombre del Curso </th> <th> Fecha de Participación </th> <th>   </th> 
    				</tr> 
  				</thead>
  			"; 
    	
    	$Cursos1 = new Curso();
    	$arrCursos = $Cursos1->obtener($idAlumno);
    	if ($arrCursos == null) {
    		return null;
    	} else {
    		$strCursos .= "<tbody>";

			foreach ($arrCursos as $row) {
				$strCursos .= "
    				<tr>
    					<form id='$row[cu_id]'>
    					<td align='center'> $row[cu_nombre] <input type='hidden' value='$row[cu_id]' name='idCurso' id='idCuso'> </td>
    					<td align='center'> $row[cu_fecha_conclusion] </td>
    					<td> <input type=\"button\" value=\"Editar\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 'EditarCurso' , '$row[cu_id]', 'contenido')\" </td>
    					</form>
					</tr>";		
			}
			$strCursos .= "</tbody></table>";
    	}
    	return $strCursos;
    }
    
    public function listarGradosAcademicos($alumno = NULL){
    	$conexion = new InterfazBD();
    	$query = "SELECT * FROM ingsw.informacion_academica WHERE al_id=1 ";
    	$resultados = $conexion->consultar($query);
    	if($resultados != false){
    		//echo "Conexi�n hecha";
    		return $resultados;
    	}else{
    		echo "<p class=respuesta>No existen registros</p>";
    		return false;
    	}
    	$conexion->cerrarConexion();
    }
}

$CtlCurric1 = new CtlCurric ();
?>