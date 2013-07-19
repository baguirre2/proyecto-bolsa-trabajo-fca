<?php

include_once '../../entities/Alumno.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../boundaries/alumno/ResultadoCargaArchivo.php';
include_once 'ManejadorCSV.php';

class CtlAlumno {

    function __construct($GET, $FILES) {

        $opc = $GET['opc'];
        
        // 2 para coordinador y 5 para alumno
        $tipoUsuario = 2;
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
                	
                case 'actAlumno';
                if($tipoUsuario == 2){
                	require '../../boundaries/alumno/frmAluBuscCoord.html';
                } else if ($tipoUsuario == 5){
                	$alumno = new Alumno();
                	if($datosAlumno = $alumno->recuperarDatosAlumno($idUsuario) ){
                		require '../../boundaries/alumno/frmAluActAlumno.html';
                	} else {
                		echo "ERROR al obtener la informaci�n";
                	}
                }
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
                	
                	
                // ********* FIN Actualizar alumno ******
                         
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

}

new CtlAlumno(( isset($_POST['opc']) ? $_POST : $_GET), $_FILES);
?>