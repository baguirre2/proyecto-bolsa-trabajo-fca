<?php 

/*
 * Archivo: Class Certificacion
 * Autor:	Emmanuel García C.
 * Fecha:	Lunes 25/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

class Certificacion{

	function __construct() {
	}
	
	/*
	 * Método:	registrarCertificacion
	 * Autor:	Emmanuel García
	 * Descripción:
	 * Esta función recibe los datos del formulario de frmRegistroCertificacion.html
	 * y el id del alumno que se encuentra en sesión en ese momento.
	 * Se conecta a la interfaz de conexión e intenta insertar el registro, si es
	 * exitoso devuelve true, de lo contrario false.
	 */
	public function registrarCertificacion($GET, $alumno = NULL) {
		$conexion = new InterfazBD();
		$alumno = ($alumno != NULL)? $alumno : 1;
		$query = "INSERT INTO ingsw.certificacion (al_id, esau_id, ce_nombre, ce_descripcion, ce_empresa, ce_duracion, ce_anio)
    			 VALUES (".$alumno.", 2,'".$GET['ce_nombre']."','".$GET['ce_descripcion']."','".$GET['ce_empresa']."','".$GET['ce_duracion']."','".$GET['ce_anio']."')";
		if($conexion->insertar($query) != false){
			return true;
		}else{
			return false;
		}
		$conexion->cerrarConexion();
	}
	
	/*
	 * Método:	editarCertificacion
	 * Autor:	Emmanuel García
	 * Descripción:
	 * Esta función recibe los datos del formulario de frmRegistroCertificacion.html
	 * Se conecta a la interfaz de conexión e intenta actualizar los datos de un registro
	 * de certificación, si es exitoso devuelve true, de lo contrario false.
	*/
	public function editarCertificacion($GET) {
		$conexion = new InterfazBD();
		$query = "UPDATE ingsw.certificacion
    			  SET ce_nombre = '".$GET['ce_nombre']."', ce_descripcion = '".$GET['ce_descripcion']."', ce_empresa = '".$GET['ce_empresa']."',
    			  	  ce_duracion = '".$GET['ce_duracion']."', ce_anio = '".$GET['ce_anio']."'
    			  WHERE ce_id = '".$GET['ce_id']."';";
		if($conexion->insertar($query) != false){
			return true;
		}else{
			return false;
		}
		$conexion->cerrarConexion();
	}
	
	/*
	 * Método:	listarCertificaciones
	 * Autor:	Emmanuel García
	 * Descripción:
	 * Esta función recibe el id del alumno que esta en sesión
	 * Se conecta a la interfaz de conexión y busca los registros de las 
	 * certificaciones de ese Alumno, si existen registros devuelve todos en forma de tabla, 
	 * de lo contrario un mensaje indicando que se encontraron registros.
	*/
	public function listarCertificaciones($alumno = NULL){
		$conexion = new InterfazBD();
		$alumno = ($alumno != NULL)? $alumno : 1;
		$query = "SELECT * FROM ingsw.certificacion WHERE al_id = ".$alumno.";";
		$resultados = $conexion->consultar($query);
		if($resultados != false){
			//echo "Conexión hecha";
			$registros = "";
			for ($i=0; $i <= count($resultados)-1; $i++) {
				$registros .= "<tr><td>".$resultados[$i]['ce_nombre']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_descripcion']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_empresa']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_duracion']."</td>";
				$registros .= "<td>".$resultados[$i]['ce_anio']."</td>";
				$registros .= ($resultados[$i]['esau_id'] != 1)?
				"<td>
              						  <input type=\"button\" name=\"btnEditar\"  value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_editar', 'vacio', 'contCurr', '".$resultados[$i]['ce_id']."');\">
              						  </td></tr>" :"<td> </td></tr>";
			}
	
			$respuesta = "
                        <table>
                        <thead>
                        <tr>
                        <th>Nombre Certificación</th>
                    	<th>Descripción</th>
                        <th>Empresa/Institución</th>
                        <th>Duración</th>
                        <th>Año Certificación</th>
                        <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>".$registros."
                    	</tbody>
                        </table>
                    ";
			return $respuesta;
		}else{
			echo "<h2 class=respuesta>No existen registros</h2>";
			return false;
		}
		$conexion->cerrarConexion();
	}
	
	/*
	 * Método:	buscarCertificacion
	 * Autor:	Emmanuel García
	 * Descripción:
	 * Esta función recibe el id de la certificación que se puede editar
	 * Se conecta a la interfaz de conexión y busca el registro de la
	 * certificación a editar, si existe el registro devuelve el registro,
	 * de lo contrario un mensaje indicando que no se encontró el registro.
	*/
	public function buscarCertificacion($ce_id = NULL){
		$conexion = new InterfazBD();
		$query = "SELECT * FROM ingsw.certificacion
    			  WHERE ce_id = '".$ce_id."'; ";
		$registro = $conexion->consultar($query);
		if($registro != false){
			//echo "Registro encontrado";
			return $registro;
		}else{
			echo "<p class=respuesta>No se encontró el registro</p>";
			return false;
		}
		$conexion->cerrarConexion();
	}
}
?>