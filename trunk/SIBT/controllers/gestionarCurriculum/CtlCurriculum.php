<?php

session_start();

if ($_POST['opc'] == "RegistrarCurso" || $_POST['opc'] == "ActualizarCurso" || $_POST['opc'] == "RegistrarIdioma" || $_POST['opc'] == "ActualizarIdioma") {

include_once './entities/InfoLaboral.php';
include_once './entities/Certificacion.php';
include_once './entities/InterfazBD2.php';
include_once './entities/Curso.php';
include_once './entities/Idioma.php';
include_once './entities/InfoAcademica.php';
include_once './boundaries/curriculum/ResultadoCargaImagen.php';
include_once './entities/Alumno.php';
include_once './entities/Reclutador.php';
	
	
} else {

include_once '../../entities/InfoLaboral.php';
include_once './../../entities/Certificacion.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../entities/Curso.php';
include_once '../../entities/Idioma.php';
include_once '../../entities/InfoAcademica.php';
include_once '../../boundaries/curriculum/ResultadoCargaImagen.php';
include_once '../../entities/Alumno.php';
include_once '../../entities/Reclutador.php';
include_once '../../boundaries/curriculum/ListaInfoLaboral.php';
	
}


class CtlCurriculum {

	private $btnRegresar = " <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')\">";
    //function __construct($GET) {
	function __construct($GET, $FILES){

        $opc = $GET['opc'];
		if (isset($carga)) { $opc = $carga; } 
        //En esta línea se obtendra el ID del alumno, por un objeto SESSION
        $idAlum = 1;
        //Se obtendrá el id del Reclutador por medio de un objeto SESSION.
        $idReclutador = 1;
        

        switch ($opc) {


            //Mostrar Formulario para registro
            case 1;
            	  include("../../boundaries/layout/bienvenido_banner.html");
//                include '../../boundaries/curriculum/menuCurr.html';
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
                //Incluimos la boundary formulario de infolaboral y luego creamos un objeto de ella
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
                		echo $certificacion->listarCertificaciones($idAlum, null, 1);
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
                } else if ($GET['btnAceptar'] == 'Actualizar' && isset($GET['ce_id'])) {
                	if ($certificacion->editarCertificacion($GET)) {
                		echo $certificacion->listarCertificaciones($idAlum, null, 2);
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
                $this->menuIdiomas($idAlum);
                break;

            case "RegistrarIdioma";
                $this->registrarIdioma($idAlum);
                break;

            case "ActualizarIdioma";
                $this->actualizarIdioma();
                $this->menuIdiomas($idAlum);
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
                if (isset($_GET['file'])) {
                    $file = $_GET['file'];
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
				$this->registrarCurso($idAlum);
                break;

            case "Cursos";
                $this->menuCursos($idAlum);
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
				$id_infoAca=$_GET['id'];	
				//echo "Info aca en editar: ".$id_infoAca;			
				$resultados = $this->listarGradosAcademicos(2, $id_infoAca, $idAlum);
				include '../../boundaries/curriculum/frmInfoAcademicaEditar.php';				
				break;


			/*//Registrar
			//YA NO SE USA COMO OPC
			case 'infoAcademicaRegistrar';
			$this->registrarGradoAcademico($idAlum);
			break;

			//Modificar
			//YA NO SE USA COMO OPC
			case 'infoAcademicaActualizar'; 
				$this->actualizarGradoAcademico($idAlum);				
				break;	*/	
			
			case 'infoAcademicaFormRegistrar';
				include '../../boundaries/curriculum/frmInfoAcademicaRegis.html';
				break;
				
			case 'llenarListaEstudios';
				$id_nivel = $GET['id'];			
				
				$this->listarEstudiosFCA($id_nivel, (isset($id_inac) ? $id_inac : ""));
				break;

			case 'ImprimirFavorito';
				$this->imprimirFavoritos($idReclutador);
				break;
				
			case 'carInfoAcademicaImagenEditar';
				//obtenemos el nombre del archivo
				$nomFile = $FILES['userfile']['name'];
				if($nomFile != ""){
					$mensaje = $this->cargarImagenConstancia($FILES['userfile'], $idAlum, 2, $nomFile);
					new ResultadoCargaImagen($mensaje);
				}else{
					//Ir� directo a la edici�n
					$informacionAcademica = new InfoAcademica();
					$mensaje = $informacionAcademica->actualizarGradoAcademico($idAlum, $nomFile);
					new ResultadoCargaImagen($mensaje);
				}
				break;		
				
			case 'carInfoAcademicaImagenEditar';
				//obtenemos el nombre del archivo
				$nomFile = $FILES['userfile']['name'];
				if($nomFile != ""){
					$mensaje = $this->cargarImagenConstancia($FILES['userfile'], $idAlum, 2, $nomFile);
					new ResultadoCargaImagen($mensaje);
				}else{
					//Ir� directo a la edici�n
					$informacionAcademica = new InfoAcademica();
					$mensaje = $informacionAcademica->actualizarGradoAcademico($idAlum, $nomFile);
					new ResultadoCargaImagen($mensaje);
				}
				break;				
				
            	                

            case "BuscarCurriculum";
//            	echo "grado".$_GET['idGrado'];
            	$this->buscarCurriculum($_GET['idGrado']);
            	break;
            	
            case "IrAFavoritos";
            	$this->consultarFavortios($idReclutador);
            	break;
            	
            case "AgregarAFavoritos";
            	$agregar = true;
            
            case "EliminarDeFavoritos";
            	if (!isset($agregar)) {
            		$agregar = false;
            	}
            	$this->agregarEliminarFavorito($idAlum, $idReclutador, $agregar);
            	break;
           	
            case "CurriculumAlumno";
            	$idAlum = $_GET['idAlumno'];
            	$this->consultarCurriculum($idAlum, true, $idReclutador);
            	break;            	

            case "VerCurriculumCompleto";
            	$this->consultarCurriculum($idAlum, false);
            	break;
            	
            case 'formRegistrar';
                include '../../boundaries/curriculum/frmCurrRegis.php';
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
                echo "<h3>Tu objetivo profesional se ha creado.</h3>";
                include '../../boundaries/curriculum/objProf.php';
                break;

            // Fin Mi objetivo profesional

            /**
             * INICIO VALIDAR COSNTANCIAS 
             */
            case 'valiConst';
                $this->listarConstancias();

                break;

            //Recuperad Datos de la Constancia e invoca un método para mostrarla
            case 'valiEstMostrar';
                
                $this->mostrarConstancia($GET['tipo'], $GET['id']);
                break;

            //Valida la constancia cuyo ID es recibido
            case 'valEstaValidar';
                if ($this->cambiarEstadoConst($GET['id'], $GET['tipo'], TRUE)) {
                    echo '<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Se ha cambiado el estado de la constancia</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>';
                } else {
                    echo '<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Ha ocurrido un error al cambiar el estado de la constancia</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>';
                }
                
                $this->listarConstancias();
                break;
            
            //Rechaza la constancia cuyo ID es recibido
            case 'valEstaRechazar';
                
if ($this->cambiarEstadoConst($GET['id'], $GET['tipo'], TRUE)) {
                    echo '<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Se ha cambiado el estado de la constancia</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>';
                } else {
                    echo '<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Ha ocurrido un error al cambiar el estado de la constancia</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>';
                }
                
                $this->listarConstancias();
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
		
		if (isset($_POST['anio'])) { $anio = $_POST['anio']; }
		$ruta = $this->uploadbyIMG();
		if (isset($_POST['institucion'])) { $institucion = $_POST['institucion']; }		
		$idIdioma = $_POST['idIdioma']; 
		$porcentajeEscritura = $_POST['escritura']; 
		$porcentajeLectura = $_POST['lectura']; 
		$porcentajeOral = $_POST['oral']; 
		$alumnoIdioma = $_POST['AlumnoIdioma'];	
	    $idioma1 = new Idioma();
	    if ($ruta != null) {
	    	$res = $idioma1->actualizar($idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $alumnoIdioma, $institucion, $anio, $ruta);
	    } else {
	    	$idioma1->actualizar($idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $alumnoIdioma);
	    }
	    if ($res) {
                
	    	echo '<div class="inner-heading">
                                <div class="container">
                                    <div class="row">
                                        <div class="span12">
                                            <h1 class="animated fadeInDown delay1">Se ha actualizado la información del Idioma</h1>
                                            <p class="animated fadeInDown delay2"></p>
                                        </div>
                                    </div>
                                </div>
                    </div>';
	    } else {
	    	//$errMsj = "Ha ocurrido un error";
	    	if ($_POST['opc'] == "RegistrarIdioma" || $_POST['opc'] == "ActualizarIdioma") {
	    		include './boundaries/curriculum/frmRegisIdioma.php';
	    	} else {
	    		include '../../boundaries/curriculum/frmRegisIdioma.php';
	    	}
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
        $porcentajeEscritura = $arrDatos[0]['niid_nivel_escrito'];
        $porcentajeLectura = $arrDatos[0]['niid_nivel_lectura'];
        $porcentajeOral = $arrDatos[0]['niid_nivel_oral'];
        $anio = $arrDatos[0]['idal_anio'];
        $file = $arrDatos[0]['idal_ruta_constancia'];
        $institucion = $arrDatos[0]['idal_institucion'];
		$idIdioma =  $arrDatos[0]['id_id'];
		include '../../boundaries/curriculum/frmRegisIdioma.php';
	}    	
	
	/**
	 * 
	 * Gestiona las validaciones del registro de Idioma, si encuentra errores incluye el formulario de registro con los datos ingresados
	 * y los errores encontrados, de lo contrario intenta registrar el idioma si lo hace muestra un mensaje al usuario.
	 * @author Benjamín Aguirre García 
	 */	
    function registrarIdioma($idAlum) {

        if (isset($_POST['idIdioma'])) {
            $idIdioma = $_POST['idIdioma'];
        }
        if (isset($_POST['escritura'])) {
            $porcentajeEscritura = $_POST['escritura'];
        }
        if (isset($_POST['lectura'])) {
            $porcentajeLectura = $_POST['lectura'];
        }
    	if (isset($_POST['oral'])) {
            $porcentajeOral = $_POST['oral'];
        }
        if (isset($_POST['anio'])) {
            $anio = $_POST['anio'];
        }
        $res = $this->uploadbyIMG();
        if (isset($_POST['institucion'])) {
            $institucion = $_POST['institucion'];
        }
        $err = false;
        if ($idIdioma == 0) {
            $errMsj = "Debes de Seleccionar un Idioma";
            $err = true;
        }

        if ($err == false) {
            $idioma1 = new Idioma();
            if ($res == null) {
                $res = $idioma1->guardarIdiomaAlumno($idAlum, $idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura);
            } else {
                $res = $idioma1->guardarIdiomaAlumno($idAlum, $idIdioma, $porcentajeOral, $porcentajeEscritura, $porcentajeLectura, $res, $institucion, $anio);
            }
            if (!$res) {
                $err = true;
                $errMsj = "Ocurrió un error inesperado";
            }
        }
        if ($err) {
            include './boundaries/curriculum/frmRegisIdioma.php';
        } else {
            echo '<div class="inner-heading">
                            <div class="container">
                                <div class="row">
                                    <div class="span12">
                                        <h1 class="animated fadeInDown delay1">El idioma ha sido registrado</h1>
                                        <p class="animated fadeInDown delay2"></p>
                                    </div>
                                </div>
                            </div>
                </div>';
            $this->menuIdiomas($idAlum);
        }
    }

    /**
     * 
     * Menu de Idiomas, si ya hay idiomas registrados los muestra, si no hay idiomas disponibles se muestra el formulario de registro de Idioma.
     * @author Benjamín Aguirre García
     * 
     */
    function menuIdiomas($idAlum) {
        $strIdiomas = $this->obtenerIdiomas($idAlum);
        if ($strIdiomas == null) {
        	if ($_POST['RegistrarIdioma'] || $_POST['ActualizarIdioma']) {
        		include './boundaries/curriculum/frmRegisIdioma.php';
        	} else {
            	include '../../boundaries/curriculum/frmRegisIdioma.php';
        	}
        } else {
            echo "<input type=\"button\" value=\"Agregar Idioma\" id=\"Cancelar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarIdioma' , 'vacio', 'contenido')\">
    					 <input type=\"button\" value=\"Regresar\" id=\"Regresar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')\"> ";
            echo $strIdiomas;
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
    					<td> <i value=\"Editar\" id=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarCurso' , '$row[cu_id]', 'contenido')\" class=\"fontawesome-icon button circle-button green icon-edit\" ></td>
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
    		<table width='1000' class='tablas_sort'> 
    			<thead>
    				<tr> 
    					<th colspan='5'> Idiomas </th> 	
    				</tr> <tr> 
    					<th> Idioma </th> <th> Escritura </th> <th> Lectura </th> <th> Oral </th> <th>   </th> 
    				</tr> 
  				</thead>
  			";
        $idioma1 = new Idioma();
        $arrIdiomas = $idioma1->obtener($idAlumno);
        if ($arrIdiomas == null) {
            $strIdiomas = null;
        } else {
            $strIdiomas .= "<tbody>";

            foreach ($arrIdiomas as $row) {
                $strIdiomas .= "
    				<tr>
    					<form id='$row[idal_id]'>
    					<td align='center'> $row[id_nombre] <input type='hidden' value='$row[idal_id]' name='AlumnoIdioma' id='AlumnoIdioma'> </td>
    					<td align='center'> $row[niid_nivel_escrito] % </td>
    					<td align='center'> $row[niid_nivel_oral] % </td>
    					<td align='center'> $row[niid_nivel_lectura] % </td>
    					<td> <i value=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarIdioma' , '$row[idal_id]', 'contenido')\" class=\"fontawesome-icon button circle-button green icon-edit\"></td>
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
    function registrarCurso($idAlum) {
        $nombreCurso = $_POST['nombreCurso'];
        $fechaParticipacion = $_POST['fechaParticipacion'];
        $file = $_POST['file'];
        $err = false;
        if (!isset($nombreCurso)) {
            $errMsj .= "Debe tener un nombre el Curso <br>";
            $err = true;
        }
        if (!isset($fechaParticipacion)) {
            $errMsj .= "Fecha Inválida <br>";
            $err = true;
        }
        $res = $this->uploadbyIMG();
        if (!isset($file)) {
            $errMsj .= "Debes seleccionar una imagen <br>";
            $err = true;
        }
        if ($err == false) {
            $Cuso1 = new Curso();
            if (!$Cuso1->guardar($idAlum, $nombreCurso, $fechaParticipacion, $res)) {
                $err = true;
                $errMsj = "Ocurrió un error inesperado";
            }
        }
        if ($err) {
            include '../../boundaries/curriculum/frmRegisCurso.php';
        } else {
        	echo "El curso ha sido registrado";
        	$this->menuCursos($idAlum);
        }
    }

    /**
     * 
     * Si ya hay cursos asociados al Alumno los muestra, si no se dirige directamente a Registrar Curso.
     * @author Benjamín Aguirre García
     */
    function menuCursos($idAlum) {
        $strCursos = $this->obtenerCursos($idAlum);
        if ($strCursos == null) {
            include './boundaries/curriculum/frmRegisCurso.php';
        } else {
            echo $strCursos;
            echo "	<table width='1000'> <tr>
    					<td>  <input type=\"button\" value=\"Agregar Curso\" id=\"AgregarCurso\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarCurso' , 'vacio', 'contenido')\">
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
    	if (isset($_GET['idCurso'])) { $idCurso = $_GET['idCurso']; }
    	if (isset($_GET['AlumnoIdioma'])) { $alumnoIdioma = $_GET['AlumnoIdioma']; }
        if (isset($idCurso)) {
            $nombreCurso = $_GET['nombreCurso'];
            $fechaParticipacion = $_GET['fechaParticipacion'];
            //$file = $_GET['file'];
            include '../../boundaries/curriculum/frmRegisCurso.php';
        }
        if (isset($alumnoIdioma)) {
            $idIdioma = $_GET['idIdioma'];
            $porcentajeEscritura = $_GET['escritura'];
            $porcentajeLectura = $_GET['lectura'];
            $porcentajeOral = $_GET['oral'];
            $anio = $_GET['anio'];
            //$file = $_GET['file'];
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
        $nombreCurso = $curso[0]['cu_nombre'];
        $fechaParticipacion = $curso[0]['cu_fecha_conclusion'];
        $file = $curso[0]['cu_ruta_constancia'];
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
        $file = $_GET['file'];
        $err = false;
        if (!isset($nombreCurso)) {
            $errMsj .= "Debe tener un nombre el Curso <br>";
            $err = true;
        }
        if (!isset($fechaParticipacion)) {
            $errMsj .= "Fecha Inválida <br>";
            $err = true;
        }
    	if (isset($_GET['file'])) { $file = $_GET['file']; }
        $res = $this->uploadbyIMG();
        if ($res == false) {
            $errMsj .= "Error al almacenar la imagen";
            $err = true;
        }
        if ($err == false) {
            $curso1 = new Curso();
            if (!$curso1->actualizar($idCurso, $nombreCurso, $fechaParticipacion, $res)) {
                $err = true;
                $errMsj = "Ocurrió un error inesperado";
            }
        }
        if ($err) {
        	if ($_POST['opc'] == "ActualizarCurso") {
            	include './boundaries/curriculum/frmRegisCurso.php';
        	} else {
        		include '../../boundaries/curriculum/frmRegisCurso.php';
        	}
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
		echo "<div class=\"inner-heading\">
	   		<div class=\"container\">
	       		<div class=\"row\">
	           		<div class=\"span12\">
	               		<h1 class=\"animated fadeInDown delay1\">Informaci&oacute;n acad&eacute;mica</h1>
	           </div>
	       </div>
	   </div>";
		$resultados = $this->listarGradosAcademicos(1,0, $idAlum);
		$registros = "";
		for ($i=0; $i <= count($resultados)-1; $i++) {
			$infoAc_id = $resultados[$i]['inac_id'];
			$registros .= "<tr><td>".$resultados[$i]['esfc_descripcion']."</td>";			
			$registros .= "<td>".$resultados[$i]['inac_fecha_inicio']."</td>";
			$registros .= "<td>".$resultados[$i]['esac_tipo']."</td>";
			/*$registros .= ($resultados[$i]['esau_id'] != 1)? 	"<td><form id=\"frmListar\">
						<input type=\"button\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormEditar', 'frmListar', 'contenido', $infoAc_id)\">
					</form></td></tr>" : "<td></td></tr>";*/
			$registros .= ($resultados[$i]['esau_id'] != 1)? 	"<td><form id=\"frmListar\">
						<a href=\"#\">
							<i onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormEditar', 'frmListar', 'contenido', 6)\" class=\"fontawesome-icon button circle-button green icon-edit\">
							</i>
						</a>
						</form></td></tr>" : "<td></td></tr>";
		}		
		echo "<input type=\"button\" value=\"Agregar grado academico\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormRegistrar', 'vacio', 'contenido')\">";		
		echo "<table class=\"tablas_sort\">
						<thead>
						<tr>
						<th>Nombre de estudio</th>						
						<th>Fecha de inicio</th>
						<th>Estado</th>";
		echo "<th>Edici&oacute;n</th>";
		echo "</tr>	</thead>
						<tbody>".$registros."
						</tbody></table>";		
	}

    /**
     *Funcion para listar los grados acad�micos
     *@author Liliana Luna 
     *@param opcion: determina si se listan todos los grados acad�micos o uno en espec�fico (de la FCA u otro).
     **/
	public function listarGradosAcademicos($opcion, $id_infoAca, $idAlum){
		
		$conexion = new InterfazBD2();
		if($opcion==1){
			$query = "select a.inac_id, a.esau_id, b.esfc_descripcion, a.inac_fecha_inicio, c.esac_tipo FROM ingsw.informacion_academica AS a 
					JOIN ingsw.estudio_fca AS b ON a.esfc_id=b.esfc_id 
					JOIN ingsw.estado_academico AS c ON a.esac_id=c.esac_id AND a.al_id=".$idAlum."
					UNION ALL
					select a.inac_id, a.esau_id, b.esot_descripcion, a.inac_fecha_inicio, c.esac_tipo FROM ingsw.informacion_academica AS a 
					JOIN ingsw.estudio_otro AS b ON a.esot_id=b.esot_id 
					JOIN ingsw.estado_academico AS c ON a.esac_id=c.esac_id AND a.al_id=".$idAlum;				
		}elseif ($opcion==2){
			
			$query_otro = "SELECT esot_id FROM ingsw.informacion_academica where inac_id=$id_infoAca";
			$resultados_otro = $conexion->consultar($query_otro);
			
			$id_otro = $resultados_otro[0]['esot_id'];

			if($id_otro != ""){								
				$query = "SELECT * FROM ingsw.informacion_academica AS a JOIN ingsw.estudio_otro AS b
				ON a.esot_id = b.esot_id AND al_id=$idAlum and inac_id=$id_infoAca";
			}else{				
				$query = "SELECT * FROM ingsw.informacion_academica AS a JOIN ingsw.estudio_fca AS b
				ON a.esfc_id = b.esfc_id AND al_id=$idAlum and inac_id=$id_infoAca";
			}
						
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
		if ($id_inac != "") {				
			$query = "SELECT a.esfc_id FROM ingsw.estudio_fca as b JOIN ingsw.informacion_academica as a
			ON a.esfc_id=b.esfc_id and a.inac_id=$id_inac";
		}else{
			$query = "SELECT a.esfc_id FROM ingsw.estudio_fca as b JOIN ingsw.informacion_academica as a
			ON a.esfc_id=b.esfc_id";
		}
                
		$resultados = $conexion->consultar($query);			
		$esfc_id = $resultados[0]['esfc_id'];			
		
		$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivel";
		$resultados = $conexion->consultar($query);		
			
		echo "<select name=\"lstNombre\" class=\"required\"><option>Seleccione...</option>";
			
		for ($i=0; $i <= count($resultados)-1; $i++) {
			echo "<option value=\"";
			echo $resultados[$i]['esfc_id'];
			echo "\">";
			echo $resultados[$i]['esfc_descripcion'];				
			echo "</option>";
		}
		echo "</select>";
			
		$conexion->cerrarConexion();
	}
	
	/**
	 *Valida el archivo y le asigna lugar en el servidor.
	 *@author Garc�a Solis Eduardo - Liliana Luna
	 *@param Recibe el archivo a validar
	 **/
	
	public function cargarImagenConstancia($file, $idAlum, $opcion, $nomFile) {
	
		//Cadena que se enviara como resultado
		$res = "";
	
		$informacionAcademica = new InfoAcademica();
	
		if($opcion==1){
			//primero se hace el registro			
			$res .=$informacionAcademica->registrarGradoAcademico($idAlum, $nomFile);
		}elseif($opcion==2){
			//primero se hace la edici�n
			$infoAc_id = $_POST['id'];			
			$res .=$informacionAcademica->actualizarGradoAcademico($idAlum, $nomFile);
		}
	
		//directorio donde se almacenaran los archivos
		//$directorio = '../../controllers/gestionarCurriculum/';
		$directorio = '../../constancias/titulos_grados/';
	
		//extensiones permitidos a subir
		$extPermit = Array("jpg", "JPG", "png", "PNG");
	
		//Errores posibles
		$errores = Array(1 => "Extension no valida",
				2 => "Archivo mayor a 3mb",
				3 => "Archivo no cargado por POST");
	
		$nomFile = basename($file['name']); //obtenemos el nombre del archivo
		$extensiFile = explode(".", $nomFile); //obtenemos la extension del archivo
	
		//Verificamos que la extension se encuentre entre las permitidas
		$bandera = 'error';
		for ($x = 0; $x < count($extPermit); $x++) {
			if ($extensiFile[1] == $extPermit[$x])
				$bandera = 1;
		}
	
		if ($bandera == 'error') {
			$res .= "<h4>Error: $errores[1] </h4>";
	
			//verificamos que el archivo sea valido y cargado por HTTP POST de PHP
		} else if (!(is_uploaded_file($file['tmp_name']))) {
			$res .= "<h4>Error: $errores[3] </h4>";
			$bandera = 'error';
	
			//sino hay errores movemos el archivo temporal a nuestra carpeta
		} else if ($bandera != 'error') {
			move_uploaded_file($file['tmp_name'], $directorio . $nomFile);
			$res .= " El archivo ".$nomFile." es valido y fue cargado con exito.";
		}
	
		return $res;
	
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

        //new ListaConstancias($listCert, $listInfAca, $listIdio, $listCurs);
        new ListaConstancias($listCert, $listInfAca, $listIdio, $listCurs);
    }

    public function mostrarConstancia($tipoCosnt, $idConsta) {
        
        $idAlumno = new Alumno();
        $idAlumno = $idAlumno->getIdByIdConstac($idConsta, $tipoCosnt);
        
        switch ($tipoCosnt) {
            case 'cert';
                include_once '../../boundaries/curriculum/MostrarCertific.php';
                
                $certificado = new Certificacion();
                $certificado = $certificado->buscarCertificacion($idConsta);
                new MostrarCertific($certificado[0], $idAlumno);
                break;
            
            case 'infoLab';
                include_once '../../boundaries/curriculum/MostrarInfoAcademica.php';
                
                $infoAca = new InfoAcademica();
                $infoAca = $infoAca->obtenerByID($idConsta);
                new MostrarInfoAcademica($infoAca[0], $idAlumno);
                break;
            
            case 'curs';
                include_once '../../boundaries/curriculum/MostrarCurso.php';
                
                $curso = new Curso();
                $curso = $curso->obtenerCurso($idConsta);
                new MostrarCurso($curso[0], $idAlumno);
                break;
            
            case 'idio';
                include_once '../../boundaries/curriculum/MostrarIdioma.php';
                
                $idioma = new Idioma();
                $idioma = $idioma->obtenerDatosIdioma($idConsta);
                new MostrarIdioma($idioma[0], $idAlumno);
                break;
        }
    }

    public function cambiarEstadoConst ($idConst, $tipoCosnt, $accion) {
        
        switch ($tipoCosnt) {
            case 'cert';
                $certificado = new Certificacion();
                if ($accion) {
                    return $certificado->cambiarEstado($idConst, 1);
                } else {
                    return $certificado->cambiarEstado($idConst, 3);
                }
                break;
            
            case 'infoLab';
                $infoAcade = new InfoAcademica();
                if ($accion) {
                    return $infoAcade->cambiarEstado($idConst, 1);
                } else {
                    return $infoAcade->cambiarEstado($idConst, 3);
                }
                break;
            
            case 'curs';
                $curso = new Curso();
                if ($accion) {
                    return $curso->cambiarEstado($idConst, 1);
                } else {
                    return $curso->cambiarEstado($idConst, 3);
                }
                break;
            
            case 'idio';           
                $idioma = new Idioma();
                if ($accion) {
                    return $idioma->cambiarEstado($idConst, 1);
                } else {
                    return $idioma->cambiarEstado($idConst, 3);
                }
                break;
        }        
    }
    
	/**
	 * Busca los curriculums con respecto al grado de la consulta y muestra los resultados en forma de tabla, con la opción
	 * de ver curriculum que permite consultar el curriculum completo.
	 * @author Benjamín Aguirre García
	 * @param $idGrado Grado de Busqueda (Consultar el Diccionario de Datos).
	 */    
	public function buscarCurriculum($idGrado) {
		$infoAcademica = new InfoAcademica();
		$res = $infoAcademica->buscarPorGrado($idGrado);
		if ($res == null) {	
			echo "No hay resultados en la busqueda";
		} else {
				$strTable = "<table> 
					<thead> 
						<tr>
							<th colspan='4'> Resultados de Busqueda 
						<tr> 
							<th> Nombre del Alumno
							<th> Nivel Educativo 
							<th> Carrera
							<th>";
			foreach ($res AS $datos) {
				$strTable .= "<tbody>
								<form id='$datos[al_id]'>
								<tr>
									<td> $datos[pe_nombre] $datos[pe_apellido_paterno] $datos[pe_apellido_materno] <input type='hidden' id='idAlumno' name='idAlumno' value='$datos[al_id]'>
									<td> $datos[nies_descripcion]
									<td> $datos[esfc_descripcion]
									<td> <input type='button' value='Ver' onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'CurriculumAlumno' , '$datos[al_id]', 'contenido')\">
								</form> ";
								
			}
			echo $strTable;
		}
	}
    
	
	/**
	 * Junta todos los elementos de un Curriculum, obteniendolos de la función toString de cada clase que 
	 * conforma el Curriculum y lo muestra si existe la información, además si es un reclutador el que ejecuta la consulta
	 * se muestra el botón de Agregar (Si no esta agregado aun) o Eliminar de Favortios (Si ya esta agregado.  
	 * @author Benjamín Aguirre García
	 * @param $idAlumno ID del Alumno a consultar.
	 * @param $esReclutador Booleano que indica si: true es un reclutador, false si no es un reclutador el que ejecuta la consulta.
	 * @param $idReclutador Id del reclutador, si es que es el buscado.
	 */
    public function consultarCurriculum($idAlumno, $esReclutador, $idReclutador = 0) {
    	$alumno = new Alumno();
    	$btnAgregar = "<input type=\"button\" value=\"Agregar a Favoritos\" id=\"Agregar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarAFavoritos' , 'frmCurriculum', 'Respuesta')\">";
    	$btnEliminar = "<input type=\"button\" value=\"Eliminar de Favoritos\" id=\"Eliminar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EliminarDeFavoritos' , 'frmCurriculum', 'Respuesta')\">";
    	$btnImprimir = "<input type=\"button\" value=\"Imprimir\" id=\"Imprimir\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'ImprimirFavorito' , 'frmCurriculum', 'Respuesta')\">";
    	$infoAcademica = new InfoAcademica();
    	$infoLaboral = new InfoLaboral();
    	$curso = new Curso();
    	$idioma = new Idioma();
    	$reclutador = new Reclutador();
    	$cerificacion = new Certificacion();
    	$strTable = "<form id='frmCurriculum'> <table>".$alumno->toString($idAlumno).$infoAcademica->toString($idAlumno).$infoLaboral->toString($idAlumno).$idioma->toString($idAlumno).$curso->toString($idAlumno)
    					.$cerificacion->toString($idAlumno);
    	if ($esReclutador) {
			$strTable .= "<tr> <td id='Respuesta'>"; 
    		if ($reclutador->consultaFavorito($idReclutador, $idAlumno)) {
    			$strTable .= $btnEliminar;
    		} else {
    			$strTable .= $btnAgregar;
    		}
    	}
    	echo $strTable."<tr> <td> ".$this->btnRegresar." </tr> </td> </form>";
    }

	/**
	 * Agrega y Elimina de Favoritos a un Curriculum, además al agregar o eliminar regresa un mensaje y/o un 
	 * botón dependiendo de la acción realizada.
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id Del Alumno
	 * @param $idReclutador ID del Reclutador
	 * @param $agregar Booleano que indica: True si se va a agregar, false si se va a eliminar.
	 */    
    public function agregarEliminarFavorito($idAlumno, $idReclutador, $agregar) {
    	$btnAgregar = "<input type=\"button\" value=\"Agregar a Favoritos\" id=\"Agregar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarAFavoritos' , 'frmCurriculum', 'Respuesta')\">";
    	$btnEliminar = "<input type=\"button\" value=\"Eliminar de Favoritos\" id=\"Eliminar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EliminarDeFavoritos' , 'frmCurriculum', 'Respuesta')\">";
    	$btnImprimir = "<input type=\"button\" value=\"Imprimir\" id=\"Imprimir\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'ImprimirFavorito' , 'frmCurriculum', 'Respuesta')\">";    	
    	$reclutador = new Reclutador();
    	if ($agregar) {
	    	if ($reclutador->agregarFavorito($idReclutador, $idAlumno)) {
	    		echo "<b> <p>Agregado a Favoritos".$btnEliminar;
	    	} else {
	    		echo "<b><p> No se pudo agregar a Favoritos".$btnAgregar;
	    	}
    	} else {
    		if ($reclutador->eliminarFavorito($idReclutador, $idAlumno)) {
	    		echo "<b><p>".$btnAgregar;
	    	} else {
	    		echo "<b><p> No se pudo eliminar de Favoritos".$btnImprimir.$btnEliminar;
	    	}    				
    	}
    }
    
    
    /**
     * 
     * Consulta los favoritos de un reclutador y muestra el boton imprimir para imprimir toda la lista de alumnos en Favoritos
     * @author Benjamín Aguirre García
     * @param $idReclutador ID del reclutador.
     */
    public function consultarFavortios($idReclutador) {
    	$reclutador = new Reclutador();
    	$favoritos = $reclutador->obtenerFavoritos($idReclutador);
    	
		$strTable = "<table class='tablas_sort'> 
				<thead> 
			<tr> 
						<th> Nombre del Alumno
						<th> Nivel Educativo 
						<th> Carrera
						<th>
					</tr> 				</thead> <tbody>";
		if ($favoritos != null) {
			$infoAcademica1 =  new InfoAcademica();
			$alumno1 = new Alumno();
	    	foreach($favoritos as $fav) {
	    			$infoAcademica = $infoAcademica1->obtener($fav['al_id']);
	    			$infoAcademica = $infoAcademica[0];
	    			$infoAlumno = $alumno1->obtenerInfoPersonal($fav['al_id']);
	    			$infoAlumno = $infoAlumno[0];
					$strTable .= "
									<form id='$fav[al_id]'>
									<tr>
										<td> $infoAlumno[pe_nombre] $infoAlumno[pe_apellido_paterno] $infoAlumno[pe_apellido_materno] <input type='hidden' id='idAlumno' name='idAlumno' value='$fav[al_id]'>
										<td> $infoAcademica[nies_descripcion]
										<td> $infoAcademica[esfc_descripcion]
										<td> <input type='button' value='Ver' onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'CurriculumAlumno' , '$fav[al_id]', 'contenido')\">
									</form> ";    	
	    	}
	    	$strTable .= "
	    					<tr>
	    					 	<td> <input type=\"button\" value=\"Imprimir\" id=\"Imprimir\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'ImprimirFavorito' , 'vacio' , 'contenido'); \">";
		} else {
			$strTable = "<h1> No tienes Favoritos";
		} 
    	echo $strTable;
    }
    
    /**
     * 
     * Obtiene los favoritos y regresa los datos de todos los alumnos listados en favoritos del Reclutador con:
     * 	Nombre
     *  Carrera
     *  Correo
     *  Telefonos 
     * Y los manda a una pantalla lista para imprimir.
     * @param $idReclutador id del Reclutador
     */
    function imprimirFavoritos($idReclutador) {
    	$reclutador = new Reclutador();
    	$favoritos =  $reclutador->obtenerFavoritos($idReclutador);
    	$alumno = new Alumno();
    	$strFavoritos = "<table class='tablas_sort'> <thead><tr> 
 <th> Nombre <th> Correo Electrónico <th> Carrera / Posgrado <th> Telefonos</thead><tbody>";
		foreach ($favoritos as $favorito) {
			$strFavoritos .= $alumno->toStringContacto($favorito['al_id']);
		}
		echo $strFavoritos . "</tbody></table>";
    }
    
    /**
     * 
     * Enter description here ...
     * @author benjamin aguirre
     */
    
    function uploadbyIMG() {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            //ECHO $extension;
            if (($_FILES["file"]["size"] < 2000000000)  && in_array($extension, $allowedExts))
            {
            if ($_FILES["file"]["error"] > 0)
                {
              //  echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                }
            else
                {

                if (file_exists("./constancias/cursos/" . $_FILES["file"]["name"]))
                {
                //echo $_FILES["file"]["name"] . " already exists. ";
                }
                else
                {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "./constancias/cursos/" . $_FILES["file"]["name"]);
                //echo "Stored in: " . "./constancias/cursos/" . $_FILES["file"]["name"];
                }
                }
                $res = "../../constancias/cursos/".$_FILES["file"]["name"];
                            return $res; 
            } else
            {
            //echo "Invalid file";
            return null;

            }
    	} 	
}

//new CtlCurriculum($_GET);
new CtlCurriculum(( isset($_POST['opc']) ? $_POST : $_GET), $_FILES);
?>