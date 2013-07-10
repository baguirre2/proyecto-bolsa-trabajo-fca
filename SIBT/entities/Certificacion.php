<?php 

/*
 * Archivo: Class Certificacion
 * Autor: Emmanuel Garc�a C.
 * Fecha: Lunes 24/Junio/2013
 */

class Certificacion{

	function __construct() {
	}
	
	/*
	 * M�todo:	registrarCertificacion
	* Autor:	Emmanuel Garc�a
	* Descripci�n:
	* Esta funci�n recibe los datos del formulario de frmRegistroCertificacion.html
	* y el id del alumno que se encuentra en sesi�n en ese momento.
	* Se conecta a la interfaz de conexi�n e intenta insertar el registro, si es
	* exitoso devuelve true, de lo contrario false.
	*/
	public function registrarCertificacion($GET, $alumno = NULL) {
		$conexion = new InterfazBD();
	
		$imagen = isset($GET['nombreImagen']) ? $GET['nombreImagen'] : null;
	
		$alumno = ($alumno != NULL)? $alumno : 1;
		$query = "INSERT INTO ingsw.certificacion (al_id, esau_id, ce_nombre, ce_descripcion, ce_empresa, ce_duracion, ce_anio, ce_ruta_constancia)
    			 VALUES (".$alumno.", 2,'".$GET['ce_nombre']."','".$GET['ce_descripcion']."','".$GET['ce_empresa']."','".$GET['ce_duracion']."','".$GET['ce_anio']."','".$imagen."')";
	
		//echo $query;
		if($conexion->insertar($query) != false){
			$conexion->cerrarConexion();
			return true;
		}else{
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	/*
	 * M�todo:	editarCertificacion
	* Autor:	Emmanuel Garc�a
	* Descripci�n:
	* Esta funci�n recibe los datos del formulario de frmRegistroCertificacion.html
	* Se conecta a la interfaz de conexi�n e intenta actualizar los datos de un registro
	* de certificaci�n, si es exitoso devuelve true, de lo contrario false.
	*/
	public function editarCertificacion($GET) {
		$conexion = new InterfazBD();
	
		$imagen = isset($GET['nombreImagen']) ? $GET['nombreImagen'] : null;
	
		$query = "UPDATE ingsw.certificacion
    			  SET ce_nombre = '".$GET['ce_nombre']."', ce_descripcion = '".$GET['ce_descripcion']."', ce_empresa = '".$GET['ce_empresa']."',
    			  	  ce_duracion = '".$GET['ce_duracion']."', ce_anio = '".$GET['ce_anio']."', ce_ruta_constancia = '".$imagen."'
    			  WHERE ce_id = '".$GET['ce_id']."';";
		if($conexion->insertar($query) != false){
			$conexion->cerrarConexion();
			return true;
		}else{
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	/*
	 * M�todo:	listarCertificaciones
	* Autor:	Emmanuel Garc�a
	* Descripci�n:
	* Esta funci�n recibe el id del alumno que esta en sesi�n
	* Se conecta a la interfaz de conexi�n y busca los registros de las
	* certificaciones de ese Alumno, si existen registros devuelve todos en forma de tabla,
	* de lo contrario un mensaje indicando que se encontraron registros.
	*/
	public function listarCertificaciones($alumno = NULL, $orden = null, $msg = null){
		$conexion = new InterfazBD();
		$alumno = ($alumno != NULL)? $alumno : 1;
		$orden = ($orden != NULL)? $orden : "ce_nombre";
		$query = "SELECT * FROM ingsw.certificacion WHERE al_id = ".$alumno." ORDER BY ".$orden.";";
		$resultados = $conexion->consultar($query);
		if($resultados != false){
			//echo "Conexi�n hecha";
			$registros = "";
			for ($i=0; $i <= count($resultados)-1; $i++) {
				$registros .= "<tr><td>".$resultados[$i]['ce_nombre']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_descripcion']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_empresa']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_duracion']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_anio']."</td>";
	
				$registros .= ($resultados[$i]['esau_id'] != 1)?
				"<td>
              	<input type=\"button\" name=\"btnEditar\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_editar', 'vacio', 'contenido', '".$resultados[$i]['ce_id']."');\">
              	</td></tr>" :"<td> </td></tr>";
				 
			}
				
			if(!isset($msg)){
				$msg = "";
			}else if($msg == 1){
				$msg = "<h1 class=respuesta>Registro realizado con �xito</h1><br/>";
			}else if($msg == 2){
				$msg = "<h1 class=respuesta>Registro actualizado con �xito</h1><br/>";
			}
				
			$respuesta = $msg;
			$respuesta.="<h1>Mis certificaciones</h1><br/>
                        <table class=\"tablas_sort\">
	                        <thead>
		                        <tr>
			                        <th>Certificaci�n</th>
			                    	<th>Descripci�n</th>
			                        <th>Instituci�n</th>
			                        <th>Duraci�n</th>
			                        <th>A�o</th>
			                        <th>Acciones</th>
		                        </tr>
	                        </thead>
	                        <tbody>".$registros."
	                    	</tbody>
                        </table>
                    ";
			$respuesta.="<input type=\"button\" name=\"Agregar\" value=\"Agregar Certificaci�n\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_registrar', 'vacio', 'contenido');\">";
			$conexion->cerrarConexion();
			return $respuesta;
		}else{
			include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
			echo "<h2 class=respuesta>No existen registros actualmente</h2>";
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	/*
	 * M�todo:	buscarCertificacion
	 * Autor:	Emmanuel Garc�a
	 * Descripci�n:
	 * Esta funci�n recibe el id de la certificaci�n que se puede editar
	 * Se conecta a la interfaz de conexi�n y busca el registro de la
	 * certificaci�n a editar, si existe el registro devuelve el registro,
	 * de lo contrario un mensaje indicando que no se encontr� el registro.
	*/
	public function buscarCertificacion($ce_id = NULL){
		$conexion = new InterfazBD();
		$query = "SELECT * FROM ingsw.certificacion
    			  WHERE ce_id = '".$ce_id."'";
		$registro = $conexion->consultar($query);
		if($registro != false){
			//echo "Registro encontrado";
			return $registro;
		}else{
			echo "<p class=respuesta>No se encontr� el registro</p>";
			return false;
		}
		$conexion->cerrarConexion();
	}

                //Autor: Eduardo Garc�a Solis
	//Obtienes todas las certificaciones de acuerdo a su estado de validaci�n
	public function listarPorEstado($idEstado) {
	
		$conn = new InterfazBD();
	
		$res = $conn->consultar("SELECT
				certificacion.ce_id,
				persona.pe_nombre,
				persona.pe_apellido_paterno,
				persona.pe_apellido_materno,
				certificacion.ce_nombre,
				certificacion.ce_empresa
				FROM
				ingsw.certificacion JOIN
				ingsw.alumno ON (alumno.al_id = certificacion.al_id)
				JOIN ingsw.persona ON (alumno.pe_id = persona.pe_id)
				JOIN ingsw.estado_autorizacion ON (certificacion.esau_id = estado_autorizacion.esau_id)
				WHERE
				certificacion.esau_id=$idEstado");
	
				$conn->cerrarConexion();
	
				return $res;
	}
        
        //Métovo para cambiar el campo esau_id al ID de autoriazo
    public function cambiarEstado ($idInfoAcade, $idEstado) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.certificacion SET esau_id=$idEstado WHERE ce_id=$idInfoAcade");
        
        $conn->cerrarConexion();
        
        return $res;        
    }

	/**
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del Alumno
	 */        
    public function toString($idAlumno) {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.certificacion WHERE al_id = $idAlumno AND esau_id=1";
    	$certificacion = $conn->consultar($query);
    	if ($certificacion == null) {
    		return "";
    	}
    	$strCertificacion = "<tr> <th> Certificaciones ";
    	foreach ($certificacion AS $datos) {
    		$strCertificacion .= "<tr> <td> <b>Certificacion: $datos[ce_nombre]
    						     <tr> <td> Empresa: $datos[ce_empresa]
    						     <tr> <td> Duracion: $datos[ce_duracion]	
    						     <tr> <td> Año: $datos[ce_anio]
    						     <tr> <td> Descripcion: $datos[ce_descripcion]
    						     <tr> <td> ";
    	}
    	return $strCertificacion;
    	
    }
}
?>