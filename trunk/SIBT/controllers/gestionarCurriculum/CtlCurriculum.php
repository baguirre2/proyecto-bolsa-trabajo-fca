<?php

session_start();
include_once '../../entities/InfoLaboral.php';
include_once './../../entities/Certificacion.php';
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

            //Mostrar Formularo de Registroo
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
                if (!isset($GET['ce_id']) && !isset($GET['btnAceptar'])) { //Si no se ha cargado el formulario se incluye
                    include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                } else if ($GET['btnAceptar'] == 'Registrar') {
                    $certificacion = new Certificacion();
                    if ($certificacion->registrarCertificacion($GET, 1)) {
                        echo "<h1 class=respuesta>Registro realizado con �xito</h1><br/>";
                    } else {
                        echo "<h1 class=respuesta>Error al registrar</h1><br/>";
                    }
                }
                break;

            case 'certi_editar';
                $certificacion = new Certificacion();
                if (!isset($registro) && !isset($GET['ce_id'])) {
                    $registro = $certificacion->buscarCertificacion($GET['id']);
                    include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                } else if ($GET['btnAceptar'] == 'Editar' && isset($GET['ce_id'])) {
                    if ($certificacion->editarCertificacion($GET)) {
                        echo "<h1 class=respuesta>Registro actualizado con �xito</h1><br/>";
                    } else {
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
            	$this->menuCursos();
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
            	            	
            //Mostrar la información académica del alumno, una la opción de editar si está confirmado
            case 'infoAcademica';

                echo "&nbsp;";
                $resultados = $this->listarGradosAcademicos();
                $registros = "";
                for ($i = 0; $i <= count($resultados) - 1; $i++) {
                    $infoAc_id = $resultados[$i]['inac_id'];
                    $registros .= "<tr><td>" . $resultados[$i]['inac_universidad'] . "</td>";
                    $registros .= "<td>" . $resultados[$i]['inac_escuela'] . "</td>";
                    $registros .= "<td>" . $resultados[$i]['inac_promedio'] . "</td>";
                    $registros .= "<td>" . $resultados[$i]['inac_fecha_inicio'] . "</td>";
                    $registros .= "<td>" . $resultados[$i]['inac_fecha_termino'] . "</td>";
                    $registros .= ($resultados[$i]['esau_id'] != 1) ? "<td><form id=\"frmListar\"><input type=\"hidden\" name=\"id_infoAca\" value=\"$infoAc_id\"><input type=\"button\" value=\"Editar\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'editar', 'frmListar', 'contenido')\"></td></tr>" : "<td></td></tr>";
                }
                $this->mostrarInfoAcademica($resultados, $registros);
                break;

            //Editar	
            case 'editar';
                $resultados = $this->listarGradosAcademicos();
                include '../../boundaries/curriculum/frmCurrRegis.php';
                break;


            //Modificar
            case 'actualizar';
                echo "Tus datos se han actualizado";
                break;

            //Registrar
            case 'registrar';
                $this->registrarGradoAcademico();
                break;

            case 'formRegistrar';
                include '../../boundaries/curriculum/frmCurrRegis.php';
                break;
            case 'llenarListaEstudios';
                $id_nivel = $GET['id'];
                $this->listarEstudiosFCA($id_nivel);
                break;
            //Mi objetivo profesional
            case 'objProf'; include '../../boundaries/curriculum/objProf.php';
                break;
				
			case 'editObj'; include '../../boundaries/curriculum/frmObjEdit.html';
                break;
			case 'agregarObj'; include '../../boundaries/curriculum/frmObjAgre.html';
                break;
			case 'actualizarObj'; 
				$transaccionBD = new InterfazBD();
				$transaccionBD->insertar("UPDATE ingsw.alumno SET al_objetivos_profesionales = '$GET[txtEditar]' WHERE al_id = 5;");
			echo "<h3>Tus datos se han actualizado.</h3>";
                break;
			case 'crearObj'; 
				$transaccionBD = new InterfazBD();
				$transaccionBD->insertar("UPDATE ingsw.alumno SET al_objetivos_profesionales = '$GET[objProfAgre]' WHERE al_id = 5;");
			echo "<h3>Tus objetivo profesional se ha creado.</h3>";
                break;
			// Fin Mi objetivo profesional
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
                if ($porcentajeEscritura > 100 || $porcentajeLectura > 100 || $porcentajeOral > 100) {
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
            echo "	<table width='1000'> <tr>
    					<td>  <input type=\"button\" value=\"Agregar Idioma\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarCurso' , 'vacio', 'contenido')\">
    					 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')\"> </td>
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
    function obtenerCursos($idAlumno) {
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
    function obtenerIdiomas($idAlumno) {
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
        $arrIdiomas = $idioma1->obtener($_SESSION['idUsuario']);
        if ($arrIdiomas == null) {
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
    					<td> <input type=\"button\" value=\"Editar\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarCurso' , '$row[id_id]', 'contenido')\" </td>
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
    function registrarCurso() {
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

   function menuCursos() {
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

    /**
     * Funcion para mostrar la información academica del alumno
     * @author Liliana Luna
     * @param
     * */
    public function mostrarInfoAcademica($resultados, $registros) {
        echo "	<table>
						<thead>
						<tr>
						<th>Universidad</th>
						<th>Escuela</th>
						<th>Promedio</th>
						<th>Fecha inicio</th>
						<th>Fecha t&eacute;rmino</th>";
        echo ($resultados[$i]['esau_id'] != 1) ? "<th>Acciones</th>" : "";
        echo "</tr>
						</thead>
						<tbody>" . $registros . "
						</tbody>";
        echo "<tr>
						<td><input type=\"button\" value=\"Agregar grado academico\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'formRegistrar', 'vacio', 'contenido')\"></td>
						<td><input name='btnCancelar' type='button' id='btnCancelar' value='Cancelar' onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 1, 'vacio', 'contenido')\"/></td>
						</tr></table>";
    }

    /**
     * Funcion para listar los grados académicos
     * @author Liliana Luna 
     * @param 
     * */
    public function listarGradosAcademicos() {
        $conexion = new InterfazBD2();
        $query = "SELECT * FROM ingsw.informacion_academica WHERE al_id=2 ";
        $resultados = $conexion->consultar($query);
        if ($resultados != false) {
            return $resultados;
        } else {
            return $resultados;
        }
        $conexion->cerrarConexion();
    }

    /**
     * Funcion para listar los estudios de la FCA
     * @author Liliana Luna
     * @param
     * */
    public function listarEstudiosFCA($nivel) {
        $conexion = new InterfazBD2();
        $query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivel";
        //$query = "SELECT * FROM ingsw.estudio_fca";
        $resultados = $conexion->consultar($query);
        /* if($resultados != false){
          //echo "Exito";
          return $resultados;
          }else{
          //echo "Error";
          return $resultados;
          } */
        echo "<select name=\"lstNombre\">";
        //$resultados = $this->listarEstudiosFCA();
        for ($i = 0; $i <= count($resultados) - 1; $i++) {
            echo "<option value=\"";
            echo $resultados[$i]['esfc_descripcion'];
            echo "\">";
            echo $resultados[$i]['esfc_descripcion'];
            echo "</option>";
        }
        echo "</select>";

        $conexion->cerrarConexion();
    }

    /**
     * Funcion para registrar un grado academico
     * @author Liliana Luna 
     * @param 
     * */
    public function registrarGradoAcademico() {
        $conexion = new InterfazBD2();
        $nombreGrado = $GET[lstNombre];
        $universidad = $GET[txtUniversidad];
        $escuela = $GET[txtEscuela];
        $nvl = $GET[btnNivel];
        switch ($nvl) {
            case 'Licenciatura';
                $nivel = 1;
                break;
            case 'Especializacion';
                $nivel = 2;
                break;
            case 'Maestria';
                $nivel = 3;
                break;
            case 'Doctorado';
                $nivel = 4;
                break;
        }
        //aquí deberá obtenerse la carrera del alumno, de la sesión iniciada
        $carrera = 'Informática';


        $query_select = "select a.esfc_id from ingsw.estudio_fca as a JOIN ingsw.nivel_estudio as b
		on (b.nies_id = a.nies_id and a.esfc_descripcion='$nombreGrado' and a.nies_id=$nivel )";

        $resultados = $conexion->consultar($query_select);
        if ($resultados != false) {
            $esfc_id = $resultados[0]['esfc_id'];
        } else {
            $esfc_id = 0;
        }
        $estado = $GET[lstEstado];

        switch ($estado) {
            case 'En curso';
                $esac_id = 1;
                break;
            case 'Truncado';
                $esac_id = 2;
                break;
            case 'Terminado';
                $esac_id = 3;
                break;
            case 'Titulado';
                $esac_id = 4;
                break;
            case 'Graduado';
                $esac_id = 5;
                break;
        }

        $fechaInicio = $GET[txtFechaInicio];
        $fechaTermino = $GET[txtFechaTermino];
        $promedio = $GET[txtPromedio];

        $query = "INSERT INTO ingsw.informacion_academica (al_id, esac_id, esfc_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_fecha_termino, inac_ruta_constancia)
				 VALUES (2, $esac_id, $esfc_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$fechaTermino', 'Ruta de la constancia') ";

        //echo "Nivel: ". $nivel." Query:  ".$query;

        $resultado = $conexion->insertar($query, inac_id);

        if (($resultado == false) || ($resultado == 0)) {
            echo "<p class=respuesta>No registrado. Error</p>";
        } else {
            echo "<p class=respuesta>El grado acad&eacute;mico ha sido registrado</p>";
        }

        $conexion->cerrarConexion();
    }

}

new CtlCurriculum($_GET);
?>