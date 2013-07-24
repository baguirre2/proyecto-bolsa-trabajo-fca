<?php

include_once '../../entities/Alumno.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../boundaries/alumno/ResultadoCargaArchivo.php';
include_once 'ManejadorCSV.php';

class CtlAlumno {

    function __construct($GET, $FILES) {

        $opc = $GET['opc'];
        
        // 2 para coordinador y 5 para alumno
        
        $idUsuario = 12;

        switch ($opc) {

        	case 'alumno_registrar';
	        	$alumno = new Alumno();
	        	if (!isset($GET['btnAceptar'])) {
	        		$niveles_estudio = $alumno->listarNivelesEstudio();
	        		include('../../boundaries/alumno/frmRegistroAlumno.html');
	        	} else if ($GET['btnAceptar'] == 'Registrar') {
	        		$respuesta = $alumno->registrarAlumno($GET);
	        		echo "<h1 class=respuesta>".$respuesta."</h1><br/>";
	        	}
	        	break;
        	
        	case 'verificarCorreo';
	        	$alumno = new Alumno();
	        	$correo = $GET['id'];
	        	$existe = $alumno->checarCorreo($correo);
	        	 
	        	if(!$existe){
	        		echo '<script language="JavaScript"> validarCorreo(false); </script>';
	        	}else{
	        		echo '<script language="JavaScript"> validarCorreo(true); </script>';
	        	}
	        	break;

            case 'llenarListaEstudios';
                $alumno = new Alumno();
                $id_nivel = $GET['id'];
                $alumno->listarEstudiosFCA($id_nivel);
                break;

            case 'llenarListaEstadosAcademicos';
                $alumno = new Alumno();
                $id_nivel = $GET['id'];
                $alumno->listarEstadosAcademicos($id_nivel);
                break;
			
			case 'actualizar_alumno':
				$alumno = new Alumno();
               	if(!isset($GET['btnBuscar'])){
               		include('../../boundaries/alumno/frmBusquedaAlumno.html');
               	}else if($GET['btnBuscar']== 'Buscar'){
               		//Lista Busqueda de Alumno
               		include '../../boundaries/alumno/listaBusquedaAlumno.php';
               		$res_alumnos = $alumno->buscarAlumno($GET);
               		new frmResultadoAlumnos($res_alumnos);
               	}
               	break;
               	
            //*****************     AQUI EMPIEZAN LOS CASE PARA CARGA DE ARCHIVOS        *******************
            case 'carAlumMenu';

                //Incluimos el archivo que se cargara
                include_once '../../boundaries/alumno/cargarArchivo.php';
                break;

            case 'carAlumProceFile';

                $mensaje = $this->procesarArchivo($FILES['userfile']);

                new ResultadoCargaArchivo("El archivo " . $FILES['userfile']['name'] . " ya se ha cargado y procesado".
                        $mensaje);
                break;
            //*****************     AQUI TERMINAN LOS CASE PARA CARGA DE ARCHIVOS        *******************
            
                
                // ******* INICIO Actualizar alumno *****
                case 'casoInicia';
                break;
                	
                case 'actAlumnoAlu';
                	$tipoUsuario = 5;
                	$alumno = new Alumno();
                	if($datosAlumno = $alumno->recuperarDatosAlumno($idUsuario) ){
                		require '../../boundaries/alumno/frmAluActAlumno.html';
                	} else {
                		echo "ERROR al obtener la informacion";
                	}
                
                break;
				case 'actAlumnoResp';
	                $tipoUsuario = 2;
                	require '../../boundaries/alumno/frmAluBuscCoord.html';
                break;
                case 'buscAlumno';
                $alumno = new Alumno();
                if ($alumnos = $alumno->recuperarAlumnos($GET)){
                	require_once '../../boundaries/alumno/listarAlumnos.html';
                }
                break;
                case 'modAlumno';
                $id = isset($GET['id']) ? $GET['id'] : "no";
                $alumno = new Alumno;
                $carreras = $alumno->recuperarCarreras();
                if($datosAlumno = $alumno->recuperarDatosAlumno($id) ){
                	require_once '../../boundaries/alumno/frmAluActCoord.html';
                } else {
                	echo "ERROR al obtener la informaci�n";
                }
                
                
                break;
                case 'confActAlu';
                $this->confirmarActualizacion($GET, $tipoUsuario);
                break;
                case 'acepConfActAlu';
                $alumno = new Alumno();
                $alumno->actualizarAlumno($GET, $tipoUsuario);
                break;
                
                
                case 'llenarDir':		//Llena el formulario para modificar direccion.
                	include '../../boundaries/alumno/frmModDireccion.php';
                	$alum_id = $_GET['id'];
                	$alumno = new Alumno();
                	$cata_dir = $alumno->obtenerCatalogoDir();
                	$datos_dir = $alumno->obtenerMiDireccion($alumno_id);
                	$frm = new FrmMiDireccion($cata_dir ,$datos_dir);
                	
                	break;
                
                
                case 'obDeMu';			//Obtiene Delegación/Municipio de manera dinámica [a través de JS].
                	include '../../boundaries/alumno/divMiDireccion.php';
                	$dir = new Alumno();
                	$demu_arr = $dir->obtenerDeMu($_GET['es_id']);
                	$div = new DivMiDireccion();
                	$div->getDeMu($demu_arr);
                	break;
                
                case 'obColonia';		//Obtiene Colonia de manera dinámica [a través de JS].
                	include '../../boundaries/alumno/divMiDireccion.php';
                	$dir = new Alumno();
                	$col_arr = $dir->obtenerColonia($_GET['demu_id']);
                	$div = new DivMiDireccion();
                	$div->getColonia($col_arr);
                	
                	break;
                
                case 'actMiDireccion':		//Ejecuta QUERY
                	$mi_dir = new Alumno();
                	$mi_dir->actualizarDireccion($_GET['direccion']);
                	break;
                
                case 'direccionAlumno':		//Pinta el formulario de Mi Direccion-Alumno.
                	include '../../boundaries/alumno/frmModDireccion.php';
                	$alumno = new Alumno();
                	$catalogo = $alumno->obtenerCatalogoDir();
                	$mi_dir = $alumno->obtenerMiDireccion($_GET['id_alumno']);
                	$frmDir = new FrmMiDireccion($catalogo, $mi_dir);
                	break;
                // ********* FIN Actualizar alumno ******

               
                case 'telefonosAlumno';
                	$id_persona=$GET['pe_id'];
                	$this->mostrarTelefonos($id_persona);
                	break;
                	break;
                	
                case 'telefonoFormRegistrar';
                	require '../../boundaries/alumno/frmAluRegistrarTelefono.html';
                	break;
                	 
                case 'correoFormRegistrar';
                	require '../../boundaries/alumno/frmAluRegistrarCorreo.html';
                	break;
                	 
                case 'alumno_registrar_telefono';
                	$alumno = new Alumno();
                	if ($GET['btnAceptar'] == 'Registrar') {
                		if ($alumno->registrarTelefonoAlumno($GET, $idUsuario)) {
                			echo "<h1 class=respuesta>Registro realizado con &Eacute;xito</h1><br/>";
                		} else {
                			echo "<h1 class=respuesta>Error al registrar tel&eacute;fono</h1><br/>";
                		}
                	}
                	break;
                	 
                case 'alumno_registrar_correo';
                	$alumno = new Alumno();
                	if ($GET['btnAceptar'] == 'Registrar') {
                		if ($alumno->registrarCorreoAlumno($GET, $idUsuario)) {
                			echo "<h1 class=respuesta>Registro realizado con &Eacute;xito</h1><br/>";
                		} else {
                			echo "<h1 class=respuesta>Error al registrar el correo electr&oacute;nico</h1><br/>";
                		}
                	}
                	break;
                	
                	              	 
                case 'frmActContraseniaAlu';
                	require '../../boundaries/alumno/frmActContraseniaAlu.html';
                	break;
                	
                case 'correosAlumno';
                	$id_persona=$GET['pe_id'];
                	$this->mostrarCorreos($id_persona);
                	break;
               
                case 'confBorrarTelefonoAlu';
                	$id_tel=$_GET['id'];
                	$this->confirmarBorradoTelefono($GET, $tipoUsuario, $id_tel);
                	break;
                	
                case 'confBorrarCorreoAlu';
                	$coel_id=$_GET['id'];
                	$this->confirmarBorradoCorreo($GET, $tipoUsuario, $coel_id);
                	break;
                	 
                case 'confActContraseniaAlu';
                	$this->confirmarActualizacionContrasenia($GET, $tipoUsuario);
                	break;
                
                case 'acepConfActContraseniaAlu';
                	//echo "Adaptacion pendiente";
                	$alumno = new Alumno();
                	$alumno->actualizarContrasenia($GET, $idUsuario);
                	break;
                	
                case 'acepConfBorradoTelefonoAlu';
                	$id_tel=$_GET['id'];
                	$alumno = new Alumno();
                	$alumno->borrarTelefonoAlumno($GET, $tipoUsuario, $idUsuario, $id_tel);
                	break;
                	
                case 'acepConfBorradoCorreoAlu';
                	$id_correo=$_GET['id'];
                	//$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
                	//echo "pe_id en case de borrado: ".$pe_id ;
                	$alumno = new Alumno();
                	$alumno->borrarCorreoAlumno($GET, $tipoUsuario, $idUsuario, $id_correo);
                	break;
        }
    }

    //Autor: García Solis Eduardo
    //Descrip: Procesa el archivo con los registros de los alumnos y genera una cadena con los resultados obtenidos.
    //Param: Recibe el archivo a procesar
    public function procesarArchivo($file) {
        
        //Cadena que se enviara como resultado
        $res = "";
        //directorio donde se almacenaran los archivos 
        $directorio = '/opt/lampp/htdocs/SIBT/controllers/gestionarAlumno/files/';

        //extensiones permitidos a subir 
        $extPermit = Array("csv", "CSV", "txt");

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
            $res .= "<h4>El archivo es valido y fue cargado con exito.</h4>";
            $res .="<h4>Archivo: $nomFile</h4>";

            $manCSV = new ManejadorCSV();

            $CSV = $manCSV->abrirArchivo("/opt/lampp/htdocs/SIBT/controllers/gestionarAlumno/files/$nomFile"); //<---Aquí le das la dirección del archivo, una vez que se cargo al servidor
            
            //Número de alumno ingresados
            $eCont = 0;

            while (( $regis = $manCSV->extraerRegistro($CSV)) != FALSE) {
                
                //echo "<h1>CONTROL</h1>";

                $manCSV->procesarRegistro($regis);
                
                $eCont++;
            }
            $manCSV->cerrarArchivo($CSV);
            
            $res .= "El numero de alumno ingresados son $eCont";
        }
    }
    
    // Inicio Actualizar Alumno
    public function confirmarActualizacion($GET, $tipoUsuario){
    
    	if($tipoUsuario == 2){
    		$numCuenta = isset($GET['al_num_cuenta']) ? $GET['al_num_cuenta'] : "";
    		$nombre = isset($GET['pe_nombre']) ? $GET['pe_nombre'] : "";
    		$aPaterno = isset($GET['pe_apellido_paterno']) ? $GET['pe_apellido_paterno'] : "";
    		$aMaterno =  isset($GET['pe_apellido_materno']) ? $GET['pe_apellido_materno'] : "";
    		$carrera = isset($GET['esfc_descripcion']) ? $GET['esfc_descripcion'] : "";
    		$al_fecha_nacimiento =  isset($GET['al_fecha_nacimiento']) ? $GET['al_fecha_nacimiento'] : "";
    		$al_nacionalidad =  isset($GET['al_nacionalidad']) ? $GET['al_nacionalidad'] : "";
    		$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
    		echo"
    		<form id = 'frmConfActAlu'>
    		<input type='hidden' value='$numCuenta' name='al_num_cuenta' id = 'al_num_cuenta' >
    		<input type='hidden' value='$nombre' name='pe_nombre' id = 'pe_nombre' >
    		<input type='hidden' value='$aPaterno' name='pe_apellido_paterno' id = 'pe_apellido_paterno' >
    		<input type='hidden' value='$aMaterno' name='pe_apellido_materno' id = 'pe_apellido_materno' >
    		<input type='hidden' value='$carrera' name='esfc_descripcion' id = 'esfc_descripcion' >
    		<input type='hidden' value='$al_fecha_nacimiento' name='al_fecha_nacimiento' id = 'al_fecha_nacimiento' >	
			<input type='hidden' value='$al_nacionalidad' name='al_nacionalidad' id = 'al_nacionalidad' >
    		<input type='hidden' value='$pe_id' name='pe_id' id = 'pe_id' >
    		<table>
    		<tr>
    		<td colspan=\"2\">Esta seguro que desea modificar los datos del alumno?</td>
    		</tr>
    		<tr>
    		<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'acepConfActAlu', 'frmConfActAlu', 'contenido');\"/>
    		</td>
    		<td colspan=\"2\">
    		<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
    		</td>
    		</tr>
    		</table>
    		</form>
    		";
    
    	} else if ($tipoUsuario == 5){
    	$correo =  isset($GET['coel_correo']) ? $GET['coel_correo'] : "";
    	$us_contrasenia = isset($GET['us_contrasenia']) ? $GET['us_contrasenia'] : "";
    	$conf_us_contrasenia =  isset($GET['conf_us_contrasenia']) ? $GET['conf_us_contrasenia'] : "";
    	$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
		
    	//echo"Datos: $correo, $us_contrasenia, $conf_us_contrasenia, $us_id";
    		if ($us_contrasenia == $conf_us_contrasenia){
    		echo"
    		<form id = 'frmConfActAlu'>
    		<input type='hidden' value='$correo' name='coel_correo' id = 'coel_correo' >
    		<input type='hidden' value='$us_contrasenia' name='us_contrasenia' id = 'us_contrasenia' >
    		<input type='hidden' value='$conf_us_contrasenia' name='conf_us_contrasenia' id = 'conf_us_contrasenia' >
    		<input type='hidden' value='$pe_id' name='pe_id' id = 'pe_id' >
    		<table>
    		<tr>
    		<td colspan=\"2\"><center>Esta seguro que desea modificar sus datos?</center></td>
    		</tr>
    		<tr>
    		<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'acepConfActAlu', 'frmConfActAlu', 'contenido');\"/>
    		</td>
    		<td colspan=\"2\">
    		<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
    		</td>
    		</tr>
    		</table>
    		</form>
    		";
    		} else {
    		echo"
    		<table>
    		<tr>
    		<td><center><h4>Verifica que tu contrasenia y su confirmacion sean iguales</h4></center></td>
    		</tr>
    		</table>
    		<table>
    			<tr>
							<td><center><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></center>
							</td>
						</tr>
					</table>
    
				";
			}
		}
	}
	// Fin Actualizar Alumno
	
	
	/**
	 *Funcion para mostrar los tel�fonos del alumno
	 *@author Liliana Luna
	 *@param
	 **/
	public function mostrarTelefonos($id_persona){
		echo "&nbsp;";
		$resultados = $this->listarTelefonos(1,0, $id_persona);
		$registros = "";
		for ($i=0; $i <= count($resultados)-1; $i++) {
			$tel_id = $resultados[$i]['te_id'];
			$registros .= "<tr><td>".$resultados[$i]['te_telefono']."</td>";
			$registros .= "<td><form id=\"frmListar\"><input type=\"button\" value=\"Borrar\" onclick=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'confBorrarTelefonoAlu', 'frmListar', 'contenido', $tel_id)\"></form></td></tr>";
		}
		echo "<table>
    			<tr>
    				<td><input type=\"button\" value=\"Agregar tel&eacute;fono\" onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'telefonoFormRegistrar', 'vacio', 'contenido')\"></td>
    				<td><input type=\"button\" value=\"Regresar\" onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></td>
    			</tr></table>";
		 
		echo "<table class=\"tablas_sort\">
						<thead>
						<tr>
						<th>Tel&eacute;fono</th>";
		echo "<th>Opciones</th>";
		echo "</tr>
						</thead>
						<tbody>".$registros."
						</tbody></table>";
	}
	
	/**
	 *Funcion para listar los telefonos
	 *@author Liliana Luna
	 *@param opcion: determina si se listan todos los tel�fonos o uno en espec�fico.
	 **/
	public function listarTelefonos($opcion, $id_telefono, $id_persona){
	
		$conexion = new InterfazBD2();
		if($opcion==1){
			$query = "select T.te_telefono, T.te_id FROM ingsw.telefono AS T JOIN ingsw.persona AS P ON T.pe_id=P.pe_id
			AND T.pe_id=$id_persona";
		}
			//CHECAR ESTA OPCI�N
			elseif ($opcion==2){
			 
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
	*Funcion para mostrar los correos del alumno
	*@author Liliana Luna
	*@param
	**/
	public function mostrarCorreos($id_persona){
		echo "&nbsp;";
		$resultados = $this->listarCorreos(1,0, $id_persona);
		$registros = "";
		for ($i=0; $i <= count($resultados)-1; $i++) {
		$coel_id = $resultados[$i]['coel_id'];
		$registros .= "<tr><td>".$resultados[$i]['coel_correo']."</td>";
		$registros .= "<td><form id=\"frmListar\"><input type=\"button\" value=\"Borrar\" onclick=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'confBorrarCorreoAlu', 'frmListar', 'contenido', $coel_id)\"></form></td></tr>";
		}
		echo "<table class=\"tablas_sort\">
		<thead>
		<tr>
		<th>Correo electr&oacute;nico</th>";
		echo "<th>Opciones</th>";
		echo "</tr>
		</thead>
		<tbody>".$registros."
		</tbody></table>";
		echo "<table>
		<tr>
		<td><input type=\"button\" value=\"Agregar correo electr&oacute;nico\" onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'correoFormRegistrar', 'vacio', 'contenido')\"></td>
	    				<td><input type=\"button\" value=\"Regresar\" onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></td>
	    			</tr></table>";
    		}
	
    /**
    *Funcion para listar los correos del alumno
    *@author Liliana Luna
    *@param opcion: determina si se listan todos los tel�fonos o uno en espec�fico.
     **/
    public function listarCorreos($opcion, $id_telefono, $id_persona){
	
    		$conexion = new InterfazBD2();
    		if($opcion==1){
    		$query = "select C.coel_correo, C.coel_id FROM ingsw.correo_electronico AS C
    		JOIN ingsw.persona AS P ON C.pe_id=P.pe_id AND C.pe_id=$id_persona";
	}
	//CHECAR ESTA OPCI�N
	elseif ($opcion==2){
		
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
		
		
		public function confirmarActualizacionContrasenia($GET, $tipoUsuario){
		
			if ($tipoUsuario == 5){
		
				$us_contrasenia = isset($GET['us_contrasenia']) ? $GET['us_contrasenia'] : "";
				$conf_us_contrasenia =  isset($GET['conf_us_contrasenia']) ? $GET['conf_us_contrasenia'] : "";
				$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
		
				//echo"Datos: $correo, $us_contrasenia, $conf_us_contrasenia, $us_id";
				if ($us_contrasenia == $conf_us_contrasenia){
					echo"
					<form id = 'frmConfActAlu'>
					<input type='hidden' value='$us_contrasenia' name='us_contrasenia' id = 'us_contrasenia' >
					<input type='hidden' value='$conf_us_contrasenia' name='conf_us_contrasenia' id = 'conf_us_contrasenia' >
					<input type='hidden' value='$pe_id' name='pe_id' id = 'pe_id' >
					<table>
					<tr>
					<td colspan=\"2\"><center>Esta seguro que desea modificar su contrase&ntilde;a?</center></td>
					</tr>
					<tr>
					<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'acepConfActContraseniaAlu', 'frmConfActAlu', 'contenido');\"/>
					</td>
					<td colspan=\"2\">
					<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
					</td>
					</tr>
					</table>
					</form>";
				} else {
					echo"
			<table>
			<tr>
			<td><center><h4>Verifica que tu contrasenia y su confirmacion sean iguales</h4></center></td>
			</tr>
			</table>
			<table>
			<tr>
			<td><center><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></center>
							</td>
						</tr>
					</table>
		
				";
				}
			}
		}
		
		public function confirmarBorradoTelefono($GET, $tipoUsuario, $id_tel){
			 
			if ($tipoUsuario == 5){
		
				//CHECAR, �ES NECESARIO?
				$us_contrasenia = isset($GET['us_contrasenia']) ? $GET['us_contrasenia'] : "";
						$conf_us_contrasenia =  isset($GET['conf_us_contrasenia']) ? $GET['conf_us_contrasenia'] : "";
						$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
		
								//echo"Datos: $correo, $us_contrasenia, $conf_us_contrasenia, $us_id";
								if ($us_contrasenia == $conf_us_contrasenia){
								echo"
									<form id = 'frmConfBorradoAlu'>
									<input type='hidden' value='$us_contrasenia' name='us_contrasenia' id = 'us_contrasenia' >
									<input type='hidden' value='$conf_us_contrasenia' name='conf_us_contrasenia' id = 'conf_us_contrasenia' >
									<input type='hidden' value='$pe_id' name='pe_id' id = 'pe_id' >
									<table>
									<tr>
									<td colspan=\"2\"><center>�Est&aacute; seguro que desea borrar su tel&eacute;fono?</center></td>
									</tr>
									<tr>
									<td><input type='button' value='Aceptar' onclick=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'acepConfBorradoTelefonoAlu', 'frmConfBorradoAlu', 'contenido', $id_tel);\"/>
									</td>
									<td colspan=\"2\">
									<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
    		</td>
    		</tr>
    		</table>
    		</form>
    		";
								} else {
								echo"
    		<table>
    		<tr>
    		<td><center><h4>Verifica que tu contrasenia y su confirmacion sean iguales</h4></center></td>
    		</tr>
    		</table>
    		<table>
    			<tr>
							<td><center><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></center>
							</td>
						</tr>
					</table>
		
				";
								}
			}
		}
		
		public function confirmarBorradoCorreo($GET, $tipoUsuario, $coel_id){
			
		if ($tipoUsuario == 5){
			
		
			echo"
			<form id = 'frmConfBorradoAlu'>
			<input type='hidden' value='$correo' name='coel_correo' id = 'coel_correo' >
			<input type='hidden' value='$us_contrasenia' name='us_contrasenia' id = 'us_contrasenia' >
			<input type='hidden' value='$conf_us_contrasenia' name='conf_us_contrasenia' id = 'conf_us_contrasenia' >
			<input type='hidden' value='$pe_id' name='pe_id' id = 'pe_id' >
			<table>
			<tr>
			<td colspan=\"2\"><center>�Est&aacute; seguro que desea borrar su correo electr&oacute;nico?</center></td>
			</tr>
			<tr>
			<td>
			<input type='button' value='Aceptar' onclick=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'acepConfBorradoCorreoAlu', 'frmConfBorradoAlu', 'contenido', $coel_id);\"/>
			</td>
			<td colspan=\"2\">
			<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
			</td>
			</tr>
			</table>
			</form>
			";
			
		}
		}	
		

	
	

}

new CtlAlumno(( isset($_POST['opc']) ? $_POST : $_GET), $_FILES);
?>