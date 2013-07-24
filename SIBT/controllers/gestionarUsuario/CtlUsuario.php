<?php
/*
 * Archivo: Class CtlUsuario
 * Autor:	Victor M. Morales Reyes
 * Fecha:	Martes 27/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

include_once '../../entities/Usuario.php';
include_once '../../entities/InterfazBD2.php';

class CtlUsuario {

    function __construct($GET) {

        $opc = $GET['opc'];

        
        switch ($opc) {
        	//inicia agregar usuario
			case 'agregar_usuario';  
            	$usuario = new Usuario();
            	$consultaTipo = $usuario->obtenerTipoUsuario();
				if (!$consultaTipo) {
					echo"Error en la conexiÃ³n con la base de datos.";
				}
				include '../../boundaries/usuario/frmRegistroUsuario.html';
            	break;
            case 'registrar_usuario';
				$usuario = new Usuario();
            	$registrado = $usuario->registrarUsuario($GET);
				if ($registrado){
					
					echo"
			<table>
			  <tr>
				<td colspan=\"2\"><h1>El usuario ha sido agregado.</h1></td>
			  </tr>
			  <tr>
				<td colspan=\"2\">
				<input type= 'button' value='Aceptar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'agregar_usuario', 'vacio', 'contenido'); \" />
				</td>
			  </tr>
			</table>
		";
				}
				
            	break;
			case 'regresar';
				echo "<h1>Gestionar Usuario<h1>";
				
            	break;
            // fin agregar usuario
            
            // Inicia Consultar Usuario
            	case 'consUsuario';
            	$usuario = new Usuario();
            	$consultaUsuarios = $usuario->obtenerUsuariosCoordDirAsis();
            	if (!$consultaUsuarios) {
            		echo"Error en la conexión con la base de datos.";
            	} else {
            		include '../../boundaries/usuario/listarUsuarios.html';
            	}
            	break;
            	case 'modifUsuario';
            	$id = $GET['id'];
            	if ($id){
            		$usuario = new Usuario();
            		$consultaTipo = $usuario->obtenerTipoUsuario();
            		$datosUsuarios = $usuario->obtenerDatosUsuario($id);
            		if (!$datosUsuarios && !$consultaTipo) {
            			echo"Error en la conexión con la base de datos.";
            		} else {
            			include '../../boundaries/usuario/frmModifUsuarios.html';
            		}
            	}
            	break;
            	case 'confModifUsiario';
            	$this->confirmarModificacion($GET);
            	break;
            	case 'acepModifUsuario';
            	$usuario = new Usuario();
            	$usuario->modificarUsuario($GET);
            	break;
            	case 'confBajaUsuario';
            	$this->confirmarBaja($GET);
            	break;
            	case 'acepBajaUsuario';
            	$usuario = new Usuario();
            	$usuario->bajaUsuario($GET);
            	break;
            	 
            	//Fin consultar usuario
            	
    
		}
    }
    // inicia consultar usuario
    public function confirmarModificacion($GET){
    	$usuario = $GET['usuario'];
    	$tipoUsuario = $GET['tipoUsuario'];
    	$eMail = $GET['eMail'];
    	$pe_id = $GET['pe_id'];
    	$us_id = $GET['us_id'];
		$pe_nombre = $GET['pe_nombre'];
		$pe_apellido_paterno = $GET['pe_apellido_paterno'];
		$pe_apellido_materno = $GET['pe_apellido_materno'];
    
    	// Datos: $usuario, $tipoUsuario, $eMail, $pe_id, $us_id
    	echo"
    	<form id = 'frmConfModifUsu'>
    	<input type='hidden' value='$usuario' name='usuario' >
    	<input type='hidden' value='$tipoUsuario' name='tipoUsuario' >
    	<input type='hidden' value='$eMail' name='eMail' >
    	<input type='hidden' value='$pe_id' name='pe_id' >
    	<input type='hidden' value='$us_id' name='us_id' >
		<input type='hidden' value='$pe_nombre' name='pe_nombre' >
		<input type='hidden' value='$pe_apellido_paterno' name='pe_apellido_paterno' >
		<input type='hidden' value='$pe_apellido_materno' name='pe_apellido_materno' >
    	<table>
    	<tr>
    	<td colspan=\"2\">&iquest;Esta seguro que desea modificar la informaci&oacute;n del usuario?</td>
    	</tr>
    	<tr>
    	<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'acepModifUsuario', 'frmConfModifUsu', 'contenido');\"/>
    	</td>
    	<td colspan=\"2\">
    	<input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'consUsuario', 'vacio', 'contenido'); \" />
    	</td>
    	</tr>
    	</table>
    	</form>
    	";
    
    
    
    }
    
    public function confirmarBaja($GET){
    $us_id = $GET['id'];
    $usuario = new Usuario();
    $datosUsuarios = $usuario->obtenerDatosUsuario($us_id);
    $pe_id = $datosUsuarios['pe_id'];
    
    //echo "Datos: $us_id, $pe_id";
    echo"
    <form id = 'frmConfModifUsu'>
    <input type='hidden' value='$us_id' name='us_id' >
    <input type='hidden' value='$pe_id' name='pe_id' >
    <table>
    <tr>
    <td colspan=\"2\">&iquest;Esta seguro que desea dar de baja al usuario?</td>
    </tr>
    <tr>
    <td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'acepBajaUsuario', 'frmConfModifUsu', 'contenido');\"/>
    </td>
    <td colspan=\"2\">
    <input type= 'button' value='Cancelar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'consUsuario', 'vacio', 'contenido'); \" />
    </td>
    </tr>
    </table>
    </form>
    ";
    
    }
    
    //fin consultar usuario
    
    
}

new CtlUsuario($_GET);
?>