<?php

include_once '../../entities/Alumno.php';
include_once '../../entities/InterfazBD2.php';
include_once '../../boundaries/alumno/ResultadoCargaArchivo.php';
include_once 'ManejadorCSV.php';

class CtlAlumno {

    function __construct($GET, $FILES) {

        $opc = $GET['opc'];

        switch ($opc) {

            case 'alumno_registrar';
                $alumno = new Alumno();
                if (!isset($GET['btnAceptar'])) {
                    $niveles_estudio = $alumno->listarNivelesEstudio();
                    include('../../boundaries/alumno/frmRegistroAlumno.html');
                } else if ($GET['btnAceptar'] == 'Registrar') {
                    if ($alumno->registrarAlumno($GET)) {
                        echo "<h1 class=respuesta>Registro realizado con éxito</h1><br/>";
                    } else {
                        echo "<h1 class=respuesta>Error al registrar</h1><br/>";
                    }
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

            //*****************     AQUÍ EMPIEZAN LOS CASE PARA CARGA DE ARCHIVOS        *******************
            case 'carAlumMenu';

                //Incluimos el archivo que se cargara
                include_once '../../boundaries/alumno/cargarArchivo.php';
                break;

            case 'carAlumProceFile';

                $mensaje = $this->procesarArchivo($FILES['userfile']);

                new ResultadoCargaArchivo("El archivo " . $FILES['userfile']['name'] . " ya se ha cargado y procesado".
                        $mensaje);
                break;
            //*****************     AQUÍ TERMINAN LOS CASE PARA CARGA DE ARCHIVOS        *******************
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

}

new CtlAlumno(( isset($_POST['opc']) ? $_POST : $_GET), $_FILES);
?>