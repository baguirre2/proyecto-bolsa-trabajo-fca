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
    	$query = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id)
					JOIN ingsw.estado_academico AS esac ON (inac.esac_id = esac.esac_id)
					WHERE inac.al_id = $idAlumno;";
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res; 
    }
    
    //Métovo para cambiar el campo esau_id al ID de autoriazo
    public function cambiarEstado ($idInfoAcade, $idEstado) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.informacion_academica SET esau_id=$idEstado WHERE inac_id=$idInfoAcade");
        
        $conn->cerrarConexion();
        
        return $res;        
    }
    
    public function obtenerOtrosEstudios () {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.estudio_fca AS esfc JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id);";
    	$res = $conn->consultar($quey);
    	$conn->cerrarConexion();
    	return $res;
    }
    
    public function obtenerEstudiosFCAPorNivel ($nivelEstudio) {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivelEstudio;";
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res;
    }
    
    public function buscarPorGrado($idEstudiosFCA) {
    	
    	$conn = new InterfazBD2();
    	
    	$query = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esfc.nies_id = nies.nies_id)
					JOIN ingsw.estado_academico AS esac ON (inac.esac_id = esac.esac_id)
					JOIN ingsw.alumno AS al ON (al.al_id = inac.al_id)
					JOIN ingsw.persona AS pe ON (al.pe_id = pe.pe_id)
					WHERE inac.esfc_id = $idEstudiosFCA;";
//    	echo $query; 
    	$res = $conn->consultar($query);
    	$conn->cerrarConexion();
    	return $res;
    }
    
    public function toString($idAlumno) {
    	$conn = new InterfazBD2();
		$res = $this->obtener($idAlumno);
		$strInfoAcademica = "
				<tr> <th colspan='4'>  Informacion Académica </th> </tr> ";
		foreach ($res as $datos) {
			$strInfoAcademica .= "
				<tr> <th colspan='2'> $datos[nies_descripcion] - $datos[esfc_descripcion] ($datos[esac_tipo]: $datos[inac_fecha_inicio] ";
			
			if ($datos[inac_fecha_termino] != null) {
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
    
}
?>