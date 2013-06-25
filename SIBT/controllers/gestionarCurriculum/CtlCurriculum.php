<?php

session_start();
include_once '../../entities/InfoLaboral.php';
include './../../entities/Certificacion.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../entities/Curso.php';
include_once '../../entities/Idioma.php';

class CtlCurriculum {

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

            //Modificar
            case 3;
                echo "<h1>Modificar</h1>";
                break;

            //Listar
            case 4;
                echo "<h1>Listar</h1>";
                break;

            //Registrar
            case 'registrar';
                echo "<h1>He registrado tus datos $GET[nomAlum].
                            Tu Dirección es: $GET[dirAlum]</h1>";
                break;

            //Lista todas las Información Laboral del alumno
            case 'inLabListar';
                //Se invoca el metodo que se encarga de generar la lista
                $this->listarInfoLaboral($idAlum, NULL);
                break;

            //Obtiene los datos de la información laboral y los muestra para su edición
            case 'inLabFrmEditar';
                //Obtenemos el ID de la infoLaboral que sera modificada
                $idInfoLab = $GET['id'];
                $this->mostrarFrmModificar($idInfoLab);
                break;

            //Actualiza en la BD los datos de la información laboral
            case 'inLabModificar';
                if ($this->modificarInfoLaboral($GET['id'], $GET)) {

                    $this->listarInfoLaboral($idAlum, "La información laboral ha sido registrada");
                } else {
                    $this->listarInfoLaboral($idAlum, "Ha ocurrido un error al registrar la información laboral");
                }
                break;

            //Obtiene los datos de la información laboral y los muestra para su edición
            case 'inLabFrmRegistrar';
                //Incluimos la boundary formulario de infoAcademica y luego creamos un objeto de ella
                include_once '../../boundaries/curriculum/FormularioInfoAcademica.php';
                new FormularioInfoAcademica();
                break;

            case 'inLabRegistrar';

                if ($this->agregarInfoLaboral($idAlum, $GET)) {

                    $this->listarInfoLaboral($idAlum, "La información laboral ha sido registrada");
                } else {
                    $this->listarInfoLaboral($idAlum, "Ha ocurrido un error al registrar la información laboral");
                }

                break;
                
            case 'certi_listar';
                echo "<h1>Mis certificaciones</h1>";
                $certificacion = new Certificacion();
                echo $certificacion->listarCertificaciones();

                echo "<input type=\"button\" name=\"Agregar\" value=\"Agregar Certificaci�n\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_registrar', 'vacio', 'contenido');\">";
                echo "<input type='button' value='Regresar' onclick='ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_listar', 'vacio', 'contenido');'>";
                break;
                
            case 'certi_registrar';
                if(!isset($GET['ce_id']) && !isset($GET['btnAceptar']) ) {	//Si no se ha cargado el formulario se incluye
                	include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                } else if($GET['btnAceptar'] == 'Registrar' ) {
                	$certificacion = new Certificacion();
                	if($certificacion->registrarCertificacion($GET, 1)){
                		echo "<h1 class=respuesta>Registro realizado con �xito</h1><br/>";
                	}else{
                		echo "<h1 class=respuesta>Error al registrar</h1><br/>";
                	}
                }
                break;
                
            case 'certi_editar';
                $certificacion = new Certificacion();
                if(!isset($registro) && !isset($GET['ce_id'])){
                	$registro = $certificacion->buscarCertificacion($GET['id']);
                	include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                }else if($GET['btnAceptar'] == 'Editar' && isset($GET['ce_id'])){
                	if($certificacion->editarCertificacion($GET)){
                		echo "<h1 class=respuesta>Registro actualizado con �xito</h1><br/>";
                	}else{
                		echo "<h1 class=respuesta>Error al actualizar</h1><br/>";
                	}
                }
                break;
                
//          Idiomas y Cursos 

            case "AgregarIdioma"; 
            	include '../../boundaries/curriculum/frmRegisIdioma.php';
            	break;
                
            case "Idiomas"; 
            	$this->menuIdiomas();
            	break;            	
            	
            case "RegistrarIdioma";
				break;
            case "AgregarCurso";
            	include '../../boundaries/curriculum/frmRegisCurso.php';
            	break;                
            
            case "RegistrarCurso";
            	$this->registrarCurso();
            	break;      

            case "Cursos"; // Se muestran los Cursos Disponibles
            	$this->menuCrusos();
            	break;

            case "EditarCurso";
				$this->editarCursos();
            	break;
            	
            case "ActualizarCurso";
				$this->actualizarCursos();	
            	break;
            	            
            case "EditarRuta";
            	$this->editarRuta();
            	break;            	
        }
    }

    //Recibe el ID de la info laboral que se quiere modificar, muestra los valores para su futura edición
    //Autor: García Solis Eduardo
    function mostrarFrmModificar($idInfoLab) {
        include_once '../../boundaries/curriculum/FormularioInfoAcademica.php';

        //Creamos un objeto para obtener los datos de la infoLaboral
        $infoLab = new InfoLaboral();
        $infoLab = $infoLab->obtener($idInfoLab);

        new FormularioInfoAcademica($infoLab[0]);
    }

    //Recibe en un array todos lo datos necesarios para regitrar una nueva entrada de información laboral
    //Autor: García Solis Eduardo
    function agregarInfoLaboral($idAlum, $GET) {
        
        //Declaramos los datos NO obligatorios, para que no sean variables indefinidas
        $GET['jefe'] = ( isset($GET['jefe']) ? $GET['jefe'] : "" );
        $GET['logros'] = ( isset($GET['logros']) ? $GET['logros'] : "" );

        //Creamos un objeto para porder regitrar los datos de la infoLaboral
        $infoLab = new InfoLaboral();

        return ($infoLab->guardar($idAlum, $GET['nomEmp'], $GET['puesto'], $GET['jefe'], $GET['descAct'], $GET['logros'], $GET['anios']));
    }
    
    //Recibe en un array todos lo datos necesarios para regitrar una nueva entrada de información laboral
    //Autor: García Solis Eduardo
    function modificarInfoLaboral($idInfoLab, $GET) {
        
        //Declaramos los datos NO obligatorios, para que no sean variables indefinidas
        $GET['jefe'] = ( isset($GET['jefe']) ? $GET['jefe'] : "" );
        $GET['logros'] = ( isset($GET['logros']) ? $GET['logros'] : "" );

        //Creamos un objeto para porder regitrar los datos de la infoLaboral
        $infoLab = new InfoLaboral();

        return ($infoLab->modificar($idInfoLab, $GET['nomEmp'], $GET['puesto'], $GET['jefe'], $GET['descAct'], $GET['logros'], $GET['anios']));
    }

    //Este Método se encarga de generar la lista de la información laboral del alumno
    //Autor: García Solis Eduardo
    function listarInfoLaboral($idAlum, $mensaje) {

        //Importo la boundary que genera la lista a partir de un array
        include_once '../../boundaries/curriculum/ListaInfoLaboral.php';

        //Creo un objeto inforlaboral
        $lista = new InfoLaboral();

        //Obtengo de la BD la consulta que se pasa a array
        $lista = $lista->listar($idAlum);

        //Objeto que arma la lista apartir de un array
        new ListaInfoLaboral($lista, $mensaje);
    }
    
    function registrarIdioma() {
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
       		$errMsj .= "No se ha llenado el mínimo de campos obligatorios <br>";	
      		$err = true;
      	} else {
      		if (!is_numeric($porcentajeEscritura) && !is_numeric($porcentajeLectura) && !is_numeric($porcentajeOral)) {
				$errMsj = "Debe ser numerico";
				$err = true;            			
        	} else {
				if ($porcentajeEscritura>100 || $porcentajeLectura>100 || $porcentajeOral>100) {
            		$errMsj .= "El porcentaje no puede ser mayor a 100";	
            		$err = true;
            	}
        	}
        }
        if ($err == false) {
        	$idioma1 = new Idioma();
        	if (!$idioma1->guardarAlumno($_SESSION['idUsuario'], $idioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura)) {
            	$err = true;
            	$errMsj = "Ocurrió un error inesperado";	
            }
        }
        if ($err) {
            include '../../boundaries/curriculum/frmRegisIdioma.php';	
		} else {
        	echo "El idioma ha sido registrado";
		}    	
    }
    /**
     * 
     * Menu de Idiomas, si ya hay idiomas registrados los muestra, si no hay idiomas disponibles se muestra el formulario de registro de Idioma.
     * @author Benjamín Aguirre García
     * 
     */
	function menuIdiomas() {
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
    					<td ali				gn='center'> $row[cu_fecha_conclusion] </td>
    					<td> <input type=\"button\" value=\"Editar\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarCurso' , '$row[cu_id]', 'contenido')\" </td>
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

    /**
	 * 
	 * Verifica los datos de un cruso y registra el curso a un alumno.
	 * @author Benjamín Aguirre García
	 * 
	 */        
	function registrarCurso () {
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
		}
    
		
    function menuCrusos() {
		$strCursos = $this->obtenerCursos($_SESSION['idUsuario']);
		if ($strCursos == null) {
			include '../../boundaries/curriculum/frmRegisCurso.php';
		} else {
			echo $strCursos;
			echo  "	<table width='1000'> <tr>
    					<td>  <input type=\"button\" value=\"Agregar Curso\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarCurso' , 'vacio', 'contenido')\">
    					 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')\"> </td>
					</tr> </table>";		
		}    	
    }
    
    function editarRuta() {
		$nombreCurso = $_GET['nombreCurso'];
        $fechaParticipacion = $_GET['fechaParticipacion'];
        include '../../boundaries/curriculum/frmRegisCurso.php';
    }
    
    function editarCursos() {
		$idCurso = $_GET['idCurso'];
       	$curso1 = new Curso();
       	$curso  = $curso1->obtenerCurso($idCurso);
       	$nombreCurso = $curso[0][cu_nombre];
       	$fechaParticipacion = $curso[0][cu_fecha_conclusion];
       	$rutaImg = $curso[0][cu_ruta_constancia];
		include '../../boundaries/curriculum/frmRegisCurso.php';    	
    }
    
    function actualizarCursos() {
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
    }
}

new CtlCurriculum($_GET);
?>