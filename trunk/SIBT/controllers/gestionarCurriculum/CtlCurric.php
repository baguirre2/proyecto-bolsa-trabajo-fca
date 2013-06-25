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
                
            case "AgregarIdioma"; 
            	include '../../boundaries/curriculum/frmRegisIdioma.php';
            	break;
                
            case "Idiomas"; // Se muestran los Cursos Disponibles
            	$strIdiomas = $this->obtenerIdiomas($_SESSION['idUsuario']);
				if ($strIdiomas == null) {
					include '../../boundaries/curriculum/frmRegisIdioma.php';
				} else {
					echo $strIdiomas;
					echo  "	<table width='1000'> <tr>
    							<td>  <input type=\"button\" value=\"Agregar Idioma\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 'AgregarCurso' , 'vacio', 'contenido')\">
    							 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 1 , 'vacio', 'contenido')\"> </td>
							</tr> </table>";		
				}
            	break;            	
            	
            case "RegistrarIdioma";
            	$nombreIdioma = $_GET['nombreIdioma'];
            	$porcentajeEscritura = $_GET['escritura'];
            	$porcentajeLectura = $_GET['lectura'];
            	$porcentajeOral = $_GET['oral'];
            	$err = false;
        		if (!isset($nombreIdioma)) {
            		$errMsj .= "Debe tener un nombre el Idioma <br>";
            		$err = true;
            	}            	
            	if (!isset($porcentajeEscritura) || !isset($porcentajeLectura) || !isset($porcentajeOral)) {
            		if ($porcentajeEscritura>100 || $porcentajeLectura>100 || $porcentajeOral>100) {
            			$errMsj .= "El porcentaje no puede ser mayor a 100";	
            		} else {
            			$errMsj .= "Debes de Seleccionar un porcentaje <br>";	
            		}
            		$err = true;
            	} else {
            		if (!is_numeric($porcentajeEscritura) && !is_numeric($porcentajeLectura) && !is_numeric($porcentajeOral)) {
						$errMsj = "Debe ser numerico";            			
            		}
            	}
            	/*if ($err == false) {
            		$Cuso1 = new Curso();
            		if (!$Cuso1->guardar($_SESSION['idUsuario'], $nombreCurso, $fechaParticipacion, $rutaImg)) {
            			$err = true;
            			$errMsj = "Ocurrió un error inesperado";	
            		}
            	}
            	if ($err) {*/
            		include '../../boundaries/curriculum/frmRegisIdioma.php';	
//            	} else {
//            		echo "El curso ha sido registrado";
//            	}
				break;
            case "AgregarCurso";
            	include '../../boundaries/curriculum/frmRegisCurso.php';
            	break;

            case "EditarCurso";
            	$idCurso = $_GET['idCurso'];

            	$curso1 = new Curso();
            	$curso  = $curso1->obtenerCurso($idCurso);
            	$nombreCurso = $curso[0][cu_nombre];
            	$fechaParticipacion = $curso[0][cu_fecha_conclusion];
            	$rutaImg = $curso[0][cu_ruta_constancia];
				include '../../boundaries/curriculum/frmRegisCurso.php';
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
            		include '../../boundaries/curriculum/frmRegisCurso.php';
            	} else {
            		echo "El curso ha sido modificado";
            	}
								
					
            	break;
            case "Cursos"; // Se muestran los Cursos Disponibles
            	$strCursos = $this->obtenerCursos($_SESSION['idUsuario']);
				if ($strCursos == null) {
					include '../../boundaries/curriculum/frmRegisCurso.php';
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
            		include '../../boundaries/curriculum/frmRegisCurso.php';	
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
   
    /**
     * 
     * Se obtienen los cursos y se les da un formato para ser mostrados al usuario.
     * @author Benjamín Aguirre García
     * @param $idAlumno id del Alumno actual.
     * @return $strCursos Cadena que contiene los cursos con su formato de tabla, si no se encuentran cursos regresa nulo.
     */
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
    		$strCursos = null;
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

    /**
     * 
     * Obtiene los idiomas y les da formato de tabla para ser mostradas al usuario.
     * @author Benjamín Aguirre García
     * @param $idAlumno id del Alumno.
     * @return $strIdiomas Regresa los idiomas asociados al Alumno. So no cuenta con Idiomas regresa nulo. 
     */
    function obtenerIdiomas ($idAlumno) {
    	$strIdiomas = "
    		<table width='1000'> 
    			<thead>
    				<tr> 
    					<th colspan='3'> Cursos </th> 	
    				</tr> <tr> 
    					<th> Nombre del Curso </th> <th> Fecha de Participación </th> <th>   </th> 
    				</tr> 
  				</thead>
  			"; 
    	$idioma1 = new Idioma();
    	$arrIdiomas =$idioma1->obtener($_SESSION['idUsuario']);
    	if ($arrIdiomas== null) {
    		$strIdiomas = null;
    	} else {
    		$strCursos .= "<tbody>";

			foreach ($arrIdiomas as $row) {
				$strIdiomas .= "
    				<tr>
    					<form id='$row[id_id]'>
    					<td align='center'> $row[id_nombre] <input type='hidden' value='$row[id_id]' name='idCurso' id='idCuso'> </td>
    					<td align='center'> $row[id_nivel_escrito] </td>
    					<td align='center'> $row[id_nivel_oral] </td>
    					<td align='center'> $row[id_nivel_lectura] </td>
    					<td> <input type=\"button\" value=\"Editar\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurric.php', 'EditarCurso' , '$row[id_id]', 'contenido')\" </td>
    					</form>
					</tr>";		
			}
			$strIdiomas .= "</tbody></table>";
    	}
    	return $strIdiomas;
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