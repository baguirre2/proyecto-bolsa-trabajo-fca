<?php 

/*
 * Archivo: Archivo upload.php
 * Autor:	Emmanuel García C.
 * Fecha:	Martes 25/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

$tipo = 'certs';

$upload_folder ='./../constancias/'.$tipo;
//var_dump($_FILES);

//$return = Array('ok'=>TRUE, 'msg' => "Imagen subida exitosamente");
//$return = "Imagen subida exitosamente";

$nombre_archivo = $_FILES['archivo']['name'];
$nombre_archivo = str_replace(" ","_",$nombre_archivo);
$tipo_archivo = $_FILES['archivo']['type'];
$tamano_archivo = $_FILES['archivo']['size'];
$tmp_archivo = $_FILES['archivo']['tmp_name'];
$archivador = $upload_folder . '/' . $nombre_archivo;
 
if (!move_uploaded_file($tmp_archivo, $archivador)) {
	//$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir la imagen.", 'status' => 'error');
	$return = false;
	echo json_encode($return);
	return json_encode(false);
}else{
	$return = $nombre_archivo;
	echo $return;
	return $nombre_archivo;
}

?>
