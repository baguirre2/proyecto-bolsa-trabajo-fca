<?php

session_start();
include_once '../../entities/InfoLaboral.php';
include_once './../../entities/Certificacion.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../entities/Curso.php';
include_once '../../entities/Idioma.php';
include_once '../../entities/InfoAcademica.php';

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
                include_once '../../boundaries/curriculum/FormularioInfoLaboral.php';
                new FormularioInfoLaboral();
                break;

            case 'inLabRegistrar';

                if ($this->agregarInfoLaboral($idAlum, $GET)) {

                    $this->listarInfoLaboral($idAlum, "La información laboral ha sido registrada");
                } else {
                    $this->listarInfoLaboral($idAlum, "Ha ocurrido un error al registrar la información laboral");
                }

                break;

            case 'certi_listar';
                $certificacion = new Certificacion();
                echo $certificacion->listarCertificaciones();
                break;

            case 'certi_registrar';
                if (!isset($GET['ce_id']) && !isset($GET['btnAceptar'])) { //Si no se ha cargado el formulario se incluye
                    include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                } else if ($GET['btnAceptar'] == 'Registrar') {
                    $certificacion = new Certificacion();
                    if ($certificacion->registrarCertificacion($GET, $idAlum)) {
                        echo $certificacion->listarCertificaciones(1, null);
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
                        echo $certificacion->listarCertificaciones(2, null);
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
                $this->registrarIdioma();
                break;

            case "ActualizarIdioma";
                $this->actualizarIdioma();
                break;

            case "AgregarConstancia";
                if (isset($_GET['idIdioma'])) {
                    $idIdioma = $_GET['idIdioma'];
                }
                if (isset($_GET['escritura'])) {
                    $porcentajeEscritura = $_GET['escritura'];
                }
                if (isset($_GET['lectura'])) {
                    $porcentajeLectura = $_GET['lectura'];
                }
                if (isset($_GET['oral'])) {
                    $porcentajeOral = $_GET['oral'];
                }
                if (isset($_GET['anio'])) {
                    $anio = $_GET['anio'];
                }
                if (isset($_GET['rutaImg'])) {
                    $rutaImg = $_GET['rutaImg'];
                }
                if (isset($_GET['institucion'])) {
                    $institucion = $_GET['institucion'];
                }
                if (isset($_GET['AlumnoIdioma'])) {
                    $alumnoIdioma = $_GET['AlumnoIdioma'];
                }
                include '../../boundaries/curriculum/frmRegisIdioma.php';
                break;

            case "EditarIdioma";
                $this->editarIdioma();
                break;

            case "AgregarCurso";
                include '../../boundaries/curriculum/frmRegisCurso.php';
                break;

            case "RegistrarCurso";
                $this->registrarCurso();
                break;

            case "Cursos";
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
                
            case "ConsultarCurriculum";
            	include '../../boundaries/curriculum/frmBusqueda.php';
            	break;

            //Mostrar la informaci�n acad�mica del alumno, una la opci�n de editar si est� confirmado
			case 'infoAcademicaListar';				
				$this->mostrarInfoAcademica($idAlum);
				break;
				
			//Editar	
			case 'infoAcademicaFormEditar';
				$id_infoAca=$_GET[id];	
				//echo "Info aca en editar: ".$id_infoAca;			
				$resultados = $this->listarGradosAcademicos(2, $id_infoAca, $idAlum);
				include '../../boundaries/curriculum/frmInfoAcademicaEditar.php';				
				break;


			//Modificar
			case 'infoAcademicaActualizar'; 
				$this->actualizarGradoAcademico($idAlum);
				
				break;			

			//Registrar
			case 'infoAcademicaRegistrar';							
				$this->registrarGradoAcademico($idAlum);			
				break;
			
			case 'infoAcademicaFormRegistrar';
				include '../../boundaries/curriculum/frmInfoAcademicaRegis.html';
				break;
				
			case 'llenarListaEstudios';
				$id_nivel = $GET['id'];
				//$id_inac = $_GET[infoAc_id];
				//echo "Id de nivel en control: ".$id_nivel."<br>";
				//echo "Id de info ac en control: ".$id_inac."<br>";
				$this->listarEstudiosFCA($id_nivel, $id_inac);
				break;
            	                
            case "BuscarCurriculum";
            	echo "Buscando";
            	break;
            	
            case "IrAFavoritos":
            	echo "Favs";
            	break;

            case 'formRegistrar';
                include '../../boundaries/curriculum/frmCurrRegis.php';
                break;
            case 'llenarListaEstudios';
                $id_nivel = $GET['id'];
                $this->listarEstudiosFCA($id_nivel);
                break;

            //Mi objetivo profesional
            case 'objProf';
                include '../../boundaries/curriculum/objProf.php';
                break;

            case 'editObj';
                include '../../boundaries/curriculum/frmObjEdit.html';
                break;
            case 'agregarObj';
                include '../../boundaries/curriculum/frmObjAgre.html';
                break;
            case 'actualizarObj';
                $transaccionBD = new InterfazBD2();
                $GET['txtEditar'] = isset($GET['txtEditar']) ? $GET['txtEditar'] : "";
                $transaccionBD->ejecutarQuery("UPDATE ingsw.alumno SET al_objetivos_profesionales = '$GET[txtEditar]' WHERE al_id = $idAlum");
                echo "<h3>Tus datos se han actualizado.</h3>";
                include '../../boundaries/curriculum/objProf.php';
                break;
            case 'crearObj';
                $transaccionBD = new InterfazBD2();
                $transaccionBD->ejecutarQuery("UPDATE ingsw.alumno SET al_objetivos_profesionales = '$GET[objProfAgre]' WHERE al_id = $idAlum");
                echo "<h3>Tus objetivo profesional se ha creado.</h3>";
                include '../../boundaries/curriculum/objProf.php';
                break;

            // Fin Mi objetivo profesional

            /**
             * INICIO VALIDAR COSNTANCIAS 
             */
            case 'valiConst';
                $this->listarConstancias();

                break;

            //Recuperad Datos Constancia Certificaciones
            case 'valiEstMostrar';
                
                $this->mostrarConstancia($GET['tipo'], $GET['id']);
                break;
            /**
             * FIN VALIDAR COSNTANCIAS 
             */
        }
    }

    //Recibe el ID de la info laboral que se quiere modificar, muestra los valores para su futura edición
    //Autor: García Solis Eduardo
    function mostrarFrmModificar($idInfoLab) {
        include_once '../../boundaries/curriculum/FormularioInfoLaboral.php';

        //Creamos un objeto para obtener los datos de la infoLaboral
        $infoLab = new InfoLaboral();
        $infoLab = $infoLab->obtener($idInfoLab);

        new FormularioInfoLaboral($infoLab[0]);
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
    
    /**
     * 
     * Valida los datos de actualización del idioma, si encuentra nulo la ruta de la imagen no envia los datos de constancia, si encuentra errores durante la validación
     * incluye el formulario y muestra los errores encontrados. 
     * @author Benjamín Aguirre García
     */
	function actualizarIdioma () {
		
		if (isset($_GET['anio'])) { $anio = $_GET['anio']; }
		if (isset($_GET['rutaImg'])) { $rutaImg = $_GET['rutaImg']; }
		if (isset($_GET['institucion'])) { $institucion = $_GET['institucion']; }		
		$idIdioma = $_GET['idIdioma']; 
		$porcentajeEscritura = $_GET['escritura']; 
		$porcentajeLectura = $_GET['lectura']; 
		$porcentajeOral = $_GET['oral']; 
		$alumnoIdioma = $_GET['AlumnoIdioma'];	
	    $idioma1 = new Idioma();
	    
	    if (isset($rutaImg)) {
	    	$res = $idioma1->actualizar($idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $alumnoIdioma, $institucion, $anio, $rutaImg);
	    } else {
	    	$idioma1->actualizar($idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $alumnoIdioma);
	    }
	    if ($res) {
	    	echo "Se ha actualizado la información del Idioma";
	    } else {
	    	$errMsj = "Ha ocurrido un error";
	    	include '../../boundaries/curriculum/frmRegisIdioma.php';
	    }
	}

	/**
	 * 
	 * Obtiene los datos del Idioma seleccionado a partir del id de alumno_idioma e incluye el formulario de registro.
	 * @author Benjamín Aguirre García 
	 */
	function editarIdioma () {
        $alumnoIdioma = $_GET['AlumnoIdioma'];
        $idioma1 = new Idioma();
        $arrDatos = $idioma1->obtenerDatosIdioma($alumnoIdioma);
        $porcentajeEscritura = $arrDatos[0][niid_nivel_escrito];
        $porcentajeLectura = $arrDatos[0][niid_nivel_lectura];

        $porcentajeOral = $arrDatos[0][niid_nivel_oral];
        $anio = $arrDatos[0][idal_anio];
        $rutaImg = $arrDatos[0][idal_ruta_constancia];
        $institucion = $arrDatos[0][idal_institucion];

		$idIdioma =  $arrDatos[0][id_id];
		include '../../boundaries/curriculum/frmRegisIdioma.php';
	}    	
	
	/**
	 * 
	 * Gestiona las validaciones del registro de Idioma, si encuentra errores incluye el formulario de registro con los datos ingresados
	 * y los errores encontrados, de lo contrario intenta registrar el idioma si lo hace muestra un mensaje al usuario.
	 * @author Benjamín Aguirre García 
	 */	
    function registrarIdioma() {

        if (isset($_GET['idIdioma'])) {
            $idIdioma = $_GET['idIdioma'];
        }
        if (isset($_GET['escritura'])) {
            $porcentajeEscritura = $_GET['escritura'];
        }
        if (isset($_GET['lectura'])) {
            $porcentajeLectura = $_GET['lectura'];
        }
        if (isset($_GET['oral'])) {
            $porcentajeOral = $_GET['oral'];
        }
        if (isset($_GET['anio'])) {
            $anio = $_GET['anio'];
        }
        if (isset($_GET['rutaImg'])) {
            $rutaImg = $_GET['rutaImg'];
        }
        if (isset($_GET['institucion'])) {
            $institucion = $_GET['institucion'];
        }
        $err = false;
        if ($idIdioma == 0) {
            $errMsj = "Debes de Seleccionar un Idioma";
            $err = true;
        }

        if ($err == false) {
            $idioma1 = new Idioma();
            if (!isset($rutaImg)) {
                $res = $idioma1->guardarIdiomaAlumno($_SESSION['idUsuario'], $idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura);
            } else {
                $res = $idioma1->guardarIdiomaAlumno($_SESSION['idUsuario'], $idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $rutaImg, $institucion, $anio);
            }
            if (!res) {
                $err = true;
                $errMsj = "Ocurrió un error inesperado";
            }
        }
        if ($err) {
            include '../../boundaries/curriculum/frmRegisIdioma.php';
        } else {
            echo "El idioma ha sido registrado";
            $this->menuIdiomas();
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
    					<td>  <input type=\"button\" value=\"Agregar Idioma\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarIdioma' , 'vacio', 'contenido')\">
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
    					<th colspan='5'> Idiomas </th> 	
    				</tr> <tr> 
    					<th> Idioma </th> <th> Escritura </th> <th> Lectura </th> <th> Oral </th> <th>   </th> 
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
    					<form id='$row[idal_id]'>
    					<td align='center'> $row[id_nombre] <input type='hidden' value='$row[idal_id]' name='AlumnoIdioma' id='AlumnoIdioma'> </td>
    					<td align='center'> $row[niid_nivel_escrito] % </td>
    					<td align='center'> $row[niid_nivel_oral] % </td>
    					<td align='center'> $row[niid_nivel_lectura] % </td>
    					<td> <input type=\"button\" value=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarIdioma' , '$row[idal_id]', 'contenido')\" </td>
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
        	$this->menuCursos();
        }
    }

    /**
     * 
     * Si ya hay cursos asociados al Alumno los muestra, si no se dirige directamente a Registrar Curso.
     * @author Benjamín Aguirre García
     */
    function menuCursos() {
        $strCursos = $this->obtenerCursos($_SESSION['idUsuario']);
        if ($strCursos == null) {
            include '../../boundaries/curriculum/frmRegisCurso.php';
        } else {
            echo $strCursos;
            echo "	<table width='1000'> <tr>
    					<td>  <input type=\"button\" value=\"Agregar Curso\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarCurso' , 'vacio', 'contenido')\">
    					 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')\"> </td>
					</tr> </table>";
        }
    }

    /**
     * 
     * Permite editar la ruta de la imagen de constancias.
     * @author Benjamín Aguirre García
     *  
     */
    function editarRuta() {
        $idCurso = $_GET['idCurso'];
        $alumnoIdioma = $_GET['AlumnoIdioma'];
        if (isset($idCurso)) {
            $nombreCurso = $_GET['nombreCurso'];
            $fechaParticipacion = $_GET['fechaParticipacion'];
            include '../../boundaries/curriculum/frmRegisCurso.php';
        }
        if (isset($alumnoIdioma)) {
            $idIdioma = $_GET['idIdioma'];
            $porcentajeEscritura = $_GET['escritura'];
            $porcentajeLectura = $_GET['lectura'];
            $porcentajeOral = $_GET['oral'];
            $anio = $_GET['anio'];
            $rutaImg = $_GET['rutaImg'];
            $institucion = $_GET['institucion'];
            include '../../boundaries/curriculum/frmRegisIdioma.php';
        }
    }

    /**
     * 
     * Permite obtener los datos del curso para ser editados.
     * @author Benjamín Aguirre García
     */
    function editarCursos() {
        $idCurso = $_GET['idCurso'];
        $curso1 = new Curso();
        $curso = $curso1->obtenerCurso($idCurso);
        $nombreCurso = $curso[0][cu_nombre];
        $fechaParticipacion = $curso[0][cu_fecha_conclusion];
        $rutaImg = $curso[0][cu_ruta_constancia];
        include '../../boundaries/curriculum/frmRegisCurso.php';
    }

    /**
     * 
     * Valida la actualización del Curso y realiza la actualización, si hay errores incluye el formulario de actualización.
     * "@author Benjamín Aguirre García
     * 
     */
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
	 *Funcion para mostrar la informaci�n academica del alumno
	 *@author Liliana Luna
	 *@param
	 **/
	public function mostrarInfoAcademica($idAlum){
		echo "&nbsp;";
		$resultados = $this->listarGradosAcademicos(1,0, $idAlum);
		$registros = "";
		for ($i=0; $i <= count($resultados)-1; $i++) {
			$infoAc_id = $resultados[$i]['inac_id'];
			$registros .= "<tr><td>".$resultados[$i]['inac_universidad']."</td>";
			$registros .= "<td>".$resultados[$i]['inac_escuela']."</td>";
			$registros .= "<td>".$resultados[$i]['inac_promedio']."</td>";
			$registros .= "<td>".$resultados[$i]['inac_fecha_inicio']."</td>";
			$registros .= "<td>".$resultados[$i]['inac_fecha_termino']."</td>";
			$registros .= ($resultados[$i]['esau_id'] != 1)? "<td><form id=\"frmListar\"><input type=\"button\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormEditar', 'frmListar', 'contenido', $infoAc_id)\"></form></td></tr>" : "<td></td></tr>";
		}
		echo "	<table>
						<thead>
						<tr>
						<th>Universidad</th>
						<th>Escuela</th>
						<th>Promedio</th>
						<th>Fecha inicio</th>
						<th>Fecha t&eacute;rmino</th>";
		echo ($resultados[$i-1]['esau_id'] != 1)? "<th>Acciones</th>" : "";
		echo "</tr>
						</thead>
						<tbody>".$registros."
						</tbody>";
		echo "<tr>
						<td><input type=\"button\" value=\"Agregar grado academico\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormRegistrar', 'vacio', 'contenido')\"></td>
						<td><input name='btnCancelar' type='button' id='btnCancelar' value='Cancelar' onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaListar', 'vacio', 'contenido')\"/></td>
						</tr></table>";
	}

    /**
     *Funcion para listar los grados acad�micos
     *@author Liliana Luna 
     *@param 
     **/
	public function listarGradosAcademicos($opcion, $id_infoAca, $idAlum){
		//echo "Info aca en listar grados: ".$id_infoAca;
		$conexion = new InterfazBD2();
		if($opcion==1){
			$query = "SELECT * FROM ingsw.informacion_academica WHERE al_id=$idAlum ";
		}elseif ($opcion==2){
			$query = "SELECT * FROM ingsw.informacion_academica AS a JOIN ingsw.estudio_fca AS b
			ON a.esfc_id = b.esfc_id AND al_id=$idAlum and inac_id=$id_infoAca";
		}
		$resultados = $conexion->consultar($query);
		if($resultados != false){			
			return $resultados;
		}else{
			return $resultados;			
		}
		$conexion->cerrarConexion();
	}

    /**
	 *Funcion para listar los estudios de la FCA
	 *@author Liliana Luna
	 *@param
	 **/
	public function listarEstudiosFCA($nivel, $id_inac){
		//echo "Id nivel en listar: ".$id_nivel."<br>";	
		$conexion = new InterfazBD2();
		
		//if($id_inac !=0 ){
			$query = "SELECT esfc_id FROM ingsw.estudio_fca as b JOIN ingsw.informacion_academica as a
						ON a.esfc_id=b.esfc_id and a.inac_id=$id_inac";
			$resultados = $conexion->consultar($query);			
			$esfc_id = $resultados[0]['esfc_id'];			
		//}
		//else{
			$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivel";
			$resultados = $conexion->consultar($query);
			
			//$seleccion = ($esfc_id != 0)? "selected":"";
			
			echo "<select name=\"lstNombre\"><option>Seleccione...</option>";
			//$resultados = $this->listarEstudiosFCA();
			for ($i=0; $i <= count($resultados)-1; $i++) {
				echo "<option value=\"";
				echo $resultados[$i]['esfc_id'];
				echo "\">";
				echo $resultados[$i]['esfc_descripcion'];
				echo "</option>";
			}
			echo "</select>";
		//}		
		$conexion->cerrarConexion();
	}
	
    /**
     *Funcion para registrar un grado academico
     *@author Liliana Luna 
     *@param 
     **/
	public function registrarGradoAcademico($idAlum){
		$conexion = new InterfazBD2();
		$nombreGrado = $_GET[lstNombre];
		$universidad = $_GET[txtUniversidad];
		$escuela = $_GET[txtEscuela];
		$nvl = $_GET[btnNivel];			
		switch($nvl){
			case 'Licenciatura';
				$nivel=1;
				break;
			case 'Especializacion';
				$nivel=2;
				break;
			case 'Maestria';
				$nivel=3;
				break;
			case 'Doctorado';
				$nivel=4;
				break;			
		}		
				
		$esfc_id = $_GET[lstNombre];	
		//echo "esfc_id: ".$esfc_id;	
		
		$estado = $_GET[lstEstado];
		
		switch($estado){
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
		
		$fechaInicio = $_GET[txtFechaInicio];
		$fechaTermino = $_GET[txtFechaTermino];
		$promedio = $_GET[txtPromedio];
		$otro = $_GET[txtOtro];		
		
		//si ha escrito algo en otro, hay que registrarlo antes
		if($otro != ""){			
			$query = "insert into ingsw.estudio_otro(nies_id, esot_descripcion) values ($nivel, '$otro')";
			$resultado = $conexion->insertar($query, esot_id);	
			
			//if(($resultado == false) || ($resultado ==0)){				
				$query_select = "select max(esot_id) from ingsw.estudio_otro";				
				$resultados = $conexion->consultar($query_select);					
				if($resultados != false){					
					$esot_id = $resultados[0]['max'];
				}else{
					$esot_id = 0;
				}				
			//}else{				
			//}		
		}
		else{
			$esot_id = "null";
		}		
		
		$query_select = "select max(inac_id) from ingsw.informacion_academica";
		$resultados = $conexion->consultar($query_select);
			
		if($resultados != false){
			$inac_id_insertar = ($resultados[0]['max'])+1;
		}else{
			$inac_id_insertar = 0;
		}		
		
		if($otro != ""){
			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_fecha_termino, inac_ruta_constancia)
			VALUES ( $inac_id_insertar, $idAlum, $esac_id, null, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$fechaTermino', 'Ruta de la constancia') ";
		}else{		
			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_fecha_termino, inac_ruta_constancia)
				 VALUES ( $inac_id_insertar, $idAlum, $esac_id, $esfc_id, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$fechaTermino', 'Ruta de la constancia') ";
		}
		
		$resultado = $conexion->insertar($query, inac_id);
				
		if(($resultado == false) || ($resultado ==0)){
			echo "<h1>No registrado. Error</h1>";
		}else{
			echo "<h1>El grado acad&eacute;mico ha sido registrado</h1>";
			$this->mostrarInfoAcademica($idAlum);					
		}		
		
		//carga de imagen:
		/*$filResumen = $_FILES['filImagen']['tmp_name'];
		if($filImagen == ""){
			print "Debe seleccionar un archivo";		
		}
		
		date_default_timezone_set('America/Mexico_City');		
		$nombreImagen = "Img{$inac_id_insertar}.jpg";
		$ruta = "../../webroot/images/".$nombreImagen;		
		
		if(move_uploaded_file($_FILES['fil_imagen']['tmp_name'], $ruta)){
			print "Archivo Guardado";
		}else{
			print "Ocurri� un problema y el archivo no pudo ser guardado";
		}*/		
		
		$conexion->cerrarConexion();
	}
	
	/**
	 *Funcion para actualizar un grado academico
	 *@author Liliana Luna
	 *@param
	 **/
	public function actualizarGradoAcademico($idAlum){
		$conexion = new InterfazBD2();
		//$nombreGrado = $_GET[campoNombreTitulo];
		$universidad = $_GET[txtUniversidad];	//PARA PROBAR
		$escuela = $_GET[txtEscuela];			//PARA PROBAR
		$esfc_id = $_GET[esfc_id];
		$estado = $_GET[lstEstado];
	
		switch($estado){
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
	
		$fechaInicio = $_GET[txtFechaInicio];
		$fechaTermino = $_GET[txtFechaTermino];
		$promedio = $_GET[txtPromedio];
	
		$infoAc_id = $_GET[id];
	
		//echo "Informacion academica id en Actualizar: ". $infoAc_id;
	
		$campos_valores = array('inac_universidad'=>$universidad,'inac_escuela'=>$escuela,'inac_fecha_inicio'=>$fechaInicio, 'inac_fecha_termino'=>$fechaTermino, 'esac_id'=>$esac_id, 'inac_promedio'=>$promedio);
			
		//echo $campos_valores;
		/*foreach($campos_valores as $indice => $id)
			{
		echo $indice. " => " . $id . "<br>";
		}*/
	
		$resultado = $conexion->ejecutarUpdate('ingsw.informacion_academica', $campos_valores, " WHERE inac_id = $infoAc_id");
	
		if($resultado == false){
		echo "<h1>No actualizado. Error</h1>";
		}else{
			echo "<h1>El grado acad&eacute;mico ha sido actualizado</h1>";
			$this->mostrarInfoAcademica($idAlum);
			}
	
	
			//carga de imagen:
			/*$filResumen = $_FILES['filImagen']['tmp_name'];
			if($filImagen == ""){
			print "Debe seleccionar un archivo";
	
			}
	
			date_default_timezone_set('America/Mexico_City');
			$nombreImagen = "Img{$inac_id_insertar}.jpg";
			$ruta = "../../webroot/images/".$nombreImagen;
	
			if(move_uploaded_file($_FILES['fil_imagen']['tmp_name'], $ruta)){
			print "Archivo Guardado";
			}else{
			print "Ocurri� un problema y el archivo no pudo ser guardado";
			}*/
	
			$conexion->cerrarConexion();
	}
	
	
	
    public function listarConstancias() {
        include_once '../../boundaries/curriculum/ListaConstancias.php';

        $listCert = new Certificacion();
        $listCert = $listCert->listarPorEstado(2);

        $listInfAca = new InfoAcademica();
        $listInfAca = $listInfAca->listarPorEstado(2);

        $listCurs = new Curso();
        $listCurs = $listCurs->listarPorEstado(2);

        $listIdio = new Idioma();
        $listIdio = $listIdio->listarPorEstado(2);

        new ListaConstancias($listCert, $listInfAca, $listIdio, $listCurs);
    }

    public function mostrarConstancia($tipoCosnt, $idConsta) {
        
        switch ($tipoCosnt) {
            case 'cert';
                include_once '../../boundaries/curriculum/MostrarCertific.php';
                
                $certificado = new Certificacion();
                $certificado = $certificado->buscarCertificacion($idConsta);
                new MostrarCertific($certificado[0]);
                break;
            
            case 'infoLab';
                include_once '../../boundaries/curriculum/MostrarCertific.php';
                
                $certificado = new Certificacion();
                $certificado = $certificado->buscarCertificacion($idConsta);
                new MostrarCertific($certificado[0]);
                break;
            
            case 'curs';
                include_once '../../boundaries/curriculum/MostrarCurso.php';
                
                $curso = new Curso();
                $curso = $curso->obtenerCurso($idConsta);
                new MostrarCurso($curso[0]);
                break;
            
            case 'idio';
                include_once '../../boundaries/curriculum/MostrarIdioma.php';
                
                $idioma = new Idioma();
                $idioma = $idioma->obtenerDatosIdioma($idConsta);
                new MostrarIdioma($idioma[0]);
                break;
        }
    }

}

new CtlCurriculum($_GET);
?>