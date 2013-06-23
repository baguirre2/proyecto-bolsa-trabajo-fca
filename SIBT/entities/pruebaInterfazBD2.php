<?php 
	include 'InterfazBD2.php';
	
	$db = new InterfazBD2();
		
  /**En el caso de las tablas de este proyecto
  recuerden que: como las tablas estan en un
esquema deben acceder a ellas con
  esquema.nombre de la tabla*/
  
	/*Regresan false si hay un error*/
	$db->ejecutarQuery("INSERT INTO ofertatrabajo(nombre,reclutador) VALUES('nueva oferta','reclutador 1')");
	$db->ejecutarQuery("UPDATE ofertatrabajo SET nombre='otro nombre' WHERE nombre='nueva oferta'");
 	$db->ejecutarQuery("DELETE FROM ofertatrabajo WHERE nombre='otro nombre'");
	
	
 	$resultado = $db->consultar('SELECT * FROM ofertatrabajo');
 	if($resultado != false){ //regresa falso si no encontro nada
 		foreach($resultado as $fila){
 			foreach($fila as $campo=>$valor){
 				//Ha algo con eso
 				echo $campo."=>".$valor."</br>";
 			}
 		}	
 	}
	
 	$resultado = $db->insertar("INSERT INTO ofertatrabajo(nombre,reclutador) VALUES('super oferta','reclutador 1151')",'id');
 	if($resultado != false){//regresa falso si no inserto
 		//usar el id del ultimo registro insertado
 		$id_registro = $resultado;
 		//Ejemplo 
 		//INSERT INTO otratabla(llaveforanea_ofertatrabajo) VALUES($id_registro);
 		echo "Este es el id del ultimo registro insertado $id_registro</br>";
 	}
	
 	$campos_valores = array();
 	$campos_valores['nombre'] = 'Oferta 45454';
 	$campos_valores['reclutador'] = 'Reclutador 4545';
	
	
 	$resultado = $db->ejecutarInsert('ofertatrabajo',$campos_valores,'id');
 	if($resultado != false){//regresa falso si no inserto
 		//usar el id del ultimo registro insertado
		$id_registro = $resultado;
		echo "Este es el id del ultimo registro insertado $id_registro</br>";
 	}
	
 	$campos_valores = array();
 	$campos_valores['reclutador'] = 'Reclutador 888';

 	/*Regresa false si hay un error*/
 	/*En este ejemplo solo actualiza el reclutador*/
 	$db->ejecutarUpdate('ofertatrabajo',$campos_valores,'WHERE id='.$id_registro);
	
 	/*Recibe nombre de la tabla*/
	$array_res = $db->toCatalogo('catalogo');
 	if(empty($array_res) != true){//Regresa un arreglo vacio si hubo un error de lo contrario es un arreglo de [int] => valor
 		foreach($array_res as $clave=>$valor){
 			//ejemplo
 			//echo "<option value='$clave'>$valor</option>";
 			echo $clave."=".$valor;
 		}
 	}
	
	/******IMPORTANTE CERRAR CONEXION!!!!!!!!!!!**********/
	$db->cerrarConexion();
	
	

?>