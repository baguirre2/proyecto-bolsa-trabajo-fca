<?php
/*
 * Autor: García Solis Eduardo 
 */
include_once 'InterfazBD2.php';

class InfoAcademica {
    
    private $universidad;
    private $escuela;
    private $promedio;
    private $fechaIni;
    private $fechaTerm;
    private $rutaConsta;
    
    public function __construct() {
        ;
    }

        //Autor: Eduardo García Solis
    //Obtienes toda la información de acuerdo a su estado de validación
    public function listarPorEstado($idEstado) {

        $conn = new InterfazBD();

        $res = $conn->consultar("SELECT 
                                    inac_id, 
                                    inac_universidad, 
                                    inac_escuela, 
                                    persona.pe_nombre, 
                                    persona.pe_apellido_paterno,
                                    persona.pe_apellido_materno 
                                FROM 
                                    ingsw.informacion_academica AS infoAca 
                                    JOIN ingsw.alumno ON (infoAca.al_id=alumno.al_id) 
                                    JOIN ingsw.persona ON (persona.pe_id=alumno.pe_id) 
                                WHERE 
                                    esau_id=$idEstado");

        $conn->cerrarConexion();

        return $res;
    }
    
    /**
     * 
     * Extrae toda la información academica relacionada con el alumno.
     * @author Benjamín Aguirre García 
     * @param $idAlumno Id del Alumno
     */
    public function obtener ($idAlumno) {
    	$conn = new InterfazBD2();
    	$select = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id)
					JOIN ingsw.estado_academico AS esac ON (inac.esac_id = esac.esac_id)
					WHERE inac.al_id = $idAlumno;";
    	$res = $conn->consultar($select);
    	$conn->cerrarConexion();
    	return $res; 
    }
    
    //Métovo para cambiar el campo esau_id al ID de autoriazo
    public function cambiarEstado ($idInfoAcade, $idEstado) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.informacion_academica SET esau_id=$idEstado WHERE inac_id=$idInfoAcade");
        
        $alum = $conn->consultar("SELECT coel_correo, inac_universidad, inac_escuela, pe_nombre, pe_apellido_paterno, pe_apellido_materno FROM ingsw.informacion_academica AS ia 
                JOIN ingsw.alumno AS al ON (ia.inac_id=al.al_id) JOIN ingsw.persona AS pe ON (al.pe_id=pe.pe_id) 
                JOIN ingsw.correo_electronico AS co ON (pe.pe_id=co.pe_id) 
		WHERE ia.inac_id=$idInfoAcade");
        
        $alum = $alum[0];
        
        mail($alum['coel_correo'], "Constancia ". ($idEstado == 1? "Aceptada" : "Rechazada" ), "Buen día $alum[pe_nombre] $alum[pe_apellido_paterno] $alum[pe_apellido_materno]:<br>
                    Se te informa que tu constancia de la Información Académica $alum[inac_universidad] - $alum[inac_escuela] ha sido ". ($idEstado == 1? "Aceptada" : "Rechazada" ));
        
        $conn->cerrarConexion();
        
        return $res;        
    }
    
	/**
	 * Obtiene otros estudios
	 * @author Benjamín Aguirre García
	 */        
    public function obtenerOtrosEstudios () {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.estudio_fca AS esfc JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id);";
    	$res = $conn->consultar($quey);
    	$conn->cerrarConexion();
    	return $res;
    }

	/**
	 * Obtiene los estudios de la FCA por Nivel recibido.
	 * @author Benjamín Aguirre García
	 * @param $nivelEstudio id del nivel de estudios
	 */        
    public function obtenerEstudiosFCAPorNivel ($nivelEstudio) {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivelEstudio;";
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res;
    }
    
	/**
	 * Busca y regresa los alumnos que tengan cierto grado escolar en la FCA.
	 * @author Benjamín Aguirre García
	 * @param $idEstudiosFCA Id del Alumno
	 */        
    public function buscarPorGrado($idEstudiosFCA) {
    	
    	$conn = new InterfazBD2();
    	
    	$query = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id)
					JOIN ingsw.estado_academico AS esac ON (inac.esac_id = esac.esac_id)
					JOIN ingsw.alumno AS al ON (al.al_id = inac.al_id)
					JOIN ingsw.persona AS pe ON (al.pe_id = pe.pe_id)
					WHERE inac.esfc_id = $idEstudiosFCA;";
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res;
    }
    
    	/**
	 * Busca y regresa los alumnos que tengan cierto grado escolar en la FCA.
	 * @author Eduardo García
	 * @param $idInfoAcademica
	 */        
    public function obtenerByID($idInfoLab) {
    	
    	$conn = new InterfazBD2();
    	
    	$query = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id)
					JOIN ingsw.estado_academico AS esac ON (inac.esac_id = esac.esac_id)
					JOIN ingsw.alumno AS al ON (al.al_id = inac.al_id)
					JOIN ingsw.persona AS pe ON (al.pe_id = pe.pe_id)
					WHERE inac.inac_id = $idInfoLab";
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res;
    }

	/**
	 * Hace un reporte completo de la Información Academica del un alumno, esto se añade a un <table> $InfoAcademica->toString </table>
	 * para un armado de toda la información mas completo. 
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del Alumno
	 */    
    public function toString($idAlumno) {
    	$conn = new InterfazBD2();
		$res = $this->obtener($idAlumno);
		$strInfoAcademica = "
				<tr> <th colspan='4'>  Informacion Académica </th> </tr> ";
		foreach ($res as $datos) {
			$strInfoAcademica .= "
				<tr> <td colspan='2'> <b> $datos[nies_descripcion] - $datos[esfc_descripcion] ($datos[esac_tipo]: $datos[inac_fecha_inicio] ";
			
			if ($datos['inac_fecha_termino'] != null) {
				$strInfoAcademica .= "-  $datos[inac_fecha_termino])";
			} else {
				$strInfoAcademica .= ")";
			}
			$strInfoAcademica .= "
				<tr> <td> Universidad: $datos[inac_universidad]
				<tr> <td> Escuela: $datos[inac_escuela]
				<tr> <td> Promedio: $datos[inac_promedio] 
			";
		}
		return $strInfoAcademica;
    }
    
    
     /**
     *Funcion para registrar un grado academico
     *@author Liliana Luna
     *@param
     **/
    public function registrarGradoAcademico($idAlum, $nomFile){   	
    	
    	$conexion = new InterfazBD2();
    
    	$nombreGrado = $_POST['lstNombre'];
    	$universidad = $_POST['txtUniversidad'];
    	$escuela = $_POST['txtEscuela'];
    	$nivel = $_POST['btnNivel'];
    	$esfc_id = $_POST['lstNombre'];
    	$esac_id = $_POST['lstEstado'];
    	$fechaInicio = $_POST['txtFechaInicio'];
    	$fechaTermino = $_POST['txtFechaTermino'];
    	$promedio = $_POST['txtPromedio'];
    	$otro = $_POST['txtOtro'];
    
    
    	//si ha escrito algo en otro, hay que registrarlo antes
    	if($otro != ""){
    		$query = "insert into ingsw.estudio_otro(nies_id, esot_descripcion) values ($nivel, '$otro')";
    		$resultado = $conexion->insertar($query, esot_id);   		 
    		
    		$query_select = "select max(esot_id) from ingsw.estudio_otro";
    		$resultados = $conexion->consultar($query_select);
    		if($resultados != false){
    			$esot_id = $resultados[0]['max'];
    		}else{
    			$esot_id = 0;
    		}
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
    
    	//Si el grado es ajeno a la FCA
    	if($otro != ""){
    		//Si no hay fecha de t�rmino
    		if($fechaTermino == ""){
    			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_ruta_constancia)
    			VALUES ( $inac_id_insertar, $idAlum, $esac_id, null, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$nomFile') ";
    		}else{
    			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_fecha_termino, inac_ruta_constancia)
    			VALUES ( $inac_id_insertar, $idAlum, $esac_id, null, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$fechaTermino', '$nomFile') ";
    		}
    		 
    	}else{    		 
    		//Si no hay fecha de t�rmino
    		if($fechaTermino == ""){
    			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_ruta_constancia)
    			VALUES ( $inac_id_insertar, $idAlum, $esac_id, $esfc_id, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$nomFile') ";
    		}else{
    			$query = "INSERT INTO ingsw.informacion_academica (inac_id, al_id, esac_id, esfc_id, esau_id, esot_id, inac_universidad, inac_escuela, inac_promedio, inac_fecha_inicio, inac_fecha_termino, inac_ruta_constancia)
    			VALUES ( $inac_id_insertar, $idAlum, $esac_id, $esfc_id, 2, $esot_id, '$universidad', '$escuela', $promedio, '$fechaInicio', '$fechaTermino', '$nomFile') ";
    		}
    	}
    
    	$resultado = $conexion->insertar($query, inac_id);
    
    	if(($resultado == false) || ($resultado ==0)){
    		echo "<h1>No registrado. Error</h1>";
    	}else{
    		$res="El grado acad�mico ha sido registrado.";    		
    	}
    	$conexion->cerrarConexion();
    	return $res;
    }
    
    
    /**
     *Funcion para actualizar un grado academico
     *@author Liliana Luna
     *@param
     **/
    public function actualizarGradoAcademico($idAlum, $nomFile){
    	$conexion = new InterfazBD2();    	
    	$universidad = $_POST['txtUniversidad'];	
    	$escuela = $_POST['txtEscuela'];			
    	$esfc_id = $_POST['esfc_id'];
    
    	$esac_id = $_POST['lstEstado'];
    
    	$fechaInicio = $_POST['txtFechaInicio'];
    	$fechaTermino = $_POST['txtFechaTermino'];
    	$promedio = $_POST['txtPromedio'];
    
    	$infoAc_id = $_POST['infoAc_id'];
    
    	$campos_valores = array('inac_universidad'=>$universidad,'inac_escuela'=>$escuela,'inac_fecha_inicio'=>$fechaInicio, 'inac_fecha_termino'=>$fechaTermino, 'esac_id'=>$esac_id, 'inac_promedio'=>$promedio, 'inac_ruta_constancia'=>$nomFile);
    
    	$resultado = $conexion->ejecutarUpdate('ingsw.informacion_academica', $campos_valores, " WHERE inac_id = $infoAc_id");
    
    	if($resultado == false){
    		echo "<h1>No actualizado. Error</h1>";
    	}else{    		
    		$res="El grado acad�mico ha sido actualizado.";
    	}
    	$conexion->cerrarConexion();
    	return $res;
    }
    
}
?>