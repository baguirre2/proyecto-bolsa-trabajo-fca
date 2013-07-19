<?php

include '../../entities/OfertaTrabajo.php';

class CtlOferta {
    function __construct($_GET) {
        
        $opc = $_GET['opc'];
        
        switch ($opc) {
            
            //Mostrar Formulario para registro
            case 1: 
            include '../../boundaries/ofertaTrabajo/frmAgregarOferta.php';
            $of = new OfertaTrabajo();
            $datos_formulario = $of->obtenerCatalogosRelacionados();
            $frmAgregarOferta = new FrmAgregarOferta($datos_formulario,1);
            break;
        
            /**Obtener CP**/
            case 55:
            include '../../boundaries/ofertaTrabajo/divEstadoColonia.php';  
            $of = new OfertaTrabajo();
            $arr_datos = $of->obtenerEstadoDelegacionColonia($_GET['cp']);
           
            new DivEstadoColonia($arr_datos);
            break;
            
            /**Obtener Estudios**/
            case 56:
            include '../../boundaries/ofertaTrabajo/divEstudio.php';  
            $of = new OfertaTrabajo();
            $arr_datos = $of->obtenerEstudio($_GET['id_nivel_estudio']);
            $div = new DivEstudio($arr_datos);    
            $div->getEstudio($arr_datos);
            break;
        
            
        
            /**Obtener Semestres**/
            case 57:
            include '../../boundaries/ofertaTrabajo/divEstudio.php';  
            $of = new OfertaTrabajo();
            $arr_datos = $of->obtenerSemestre($_GET['esfc_id']);
            $div = new DivEstudio(); 
            
            $div->getSemestres($arr_datos[0]['esfc_num_semestres']);
            break;
        
        
            //Procesar fromulario registro
            case 2: 
            $of = new OfertaTrabajo();
            $domicilio = $_GET['domicilio'];
            $tmp_dom = $of->insert('domicilio',$domicilio,'do_id');
            $perfil_aspirante = $_GET['perfil'];
            $tmp_asp = $of->insert('perfil_aspirante',$perfil_aspirante,'peas_id');
            $per_idioma = array();
            $per_idioma['peas_id'] = $tmp_asp;
            $oferta = $_GET['oferta'];
            $oferta['peas_id'] = $tmp_asp;
            $oferta['do_id'] = $tmp_dom;
            $oferta['oftr_estado_vacante'] = true;
            $oferta['esau_id'] = 2;
            $oferta['oftr_fecha_aprobacion'] = $of->obtenerFecha();
            $oferta['oftr_fecha_registro'] = $of->obtenerFecha();
            $oferta['oftr_fecha_termino_vigencia'] = '1970-01-01';
            $oferta['oftr_num_vacantes_disponibles'] = $oferta['oftr_num_vacantes'];
            if($oferta['oftr_disponibilidad_viajar'] === 0){
            	$oferta['oftr_disponibilidad_viajar'] = false;
            }else{
            	$oferta['oftr_disponibilidad_viajar'] = true;
            }
            $tmp_oferta = $of->insert('oferta_trabajo',$oferta,'oftr_id');
            if(empty($_GET['idioma']) == false){
            	$idiomas = $_GET['idioma'];
            	foreach($idiomas as $idioma){
            		$tmp_idioma = $of->insert('nivel_idioma',$idioma,'id_id');
            		
            		$per_idioma['niid_id'] = $tmp_idioma;
            		$of->insert('perfil_aspirante_idioma',$per_idioma,'peasid_id');
            	}
        	  }
         		if($tmp_oferta != false){
         			echo "<p>Su oferta se ha registrado correctamente.Espere respuesta.</p></br><input type='button' value='Aceptar' onclick='recargarFormulario();return false;'/>";
         		}else{
         			echo "<p>Ha ocurrido un error y su oferta no pudo ser procesada</p></br><input type='button' value='Aceptar' onclick='cerrarDialog();return false;'/>";
         		}
            break;
            
            //Consultar Reclutador
            case 3: 
	            include '../../boundaries/ofertaTrabajo/frmConsultarOfertaReclutador.php';
	            $of = new OfertaTrabajo();
	            $datos_tabla = $of->obtenerDatosTabla();
	            $select = $of->obtenerCatBuscarReclutador();
	            $campos_rec = array();
	            $campos_rec[] = 'oftr_nombre';
	            $campos_rec[] ='oftr_puesto_solicitado';
	            $campos_rec[] = 'oftr_fecha_registro';
	            $campos_rec[] = 'esfc_descripcion';
	            $campos_rec[] = 'esau_nombre';
	            $frmConsultar = new FrmConsultarOfertaReclutador($select,$campos_rec, $datos_tabla,1);
            break;
            
            //Consultar Coordinador
            case 4:
           
            break;
            
            
            
            //Regresar registros
            case 5:
            	$of = new OfertaTrabajo();
            	if(isset($_GET['campo_order_by'])){
            		$nombre_campo = $_GET['campo_order_by'];
            		$datos_tabla = $of->obtenerDatosTabla(' ORDER BY '.$nombre_campo);
            		$campos_rec = array();
            		$campos_rec[] = 'oftr_nombre';
            		$campos_rec[] ='oftr_puesto_solicitado';
            		$campos_rec[] = 'oftr_fecha_registro';
            		$campos_rec[] ='oftr_sueldo_maximo';
            		$campos_rec[] = 'esfc_descripcion';
            		$campos_rec[] = 'esau_nombre';
            		echo $this->crearFilasTablaReclutador($campos_rec, $datos_tabla);
            	}
            break;
            
            case 6:
            		$of = new OfertaTrabajo();
            		echo $of->obtenerOferta($GET['id']);
            break;
            
            
            case 7:
            	$arreglo_palabras = $_GET['palabras'];
            	$of = new OfertaTrabajo();
            	echo $of->validarPalabras($arreglo_palabras);
            break;
            
            //Mostrar menu
            case 9:
            	include '../../boundaries/ofertaTrabajo/frmMenuConsultarOferta.php';
            	$oftr_id = $_GET['id'];
            	$of = new FrmMenuConsultarOferta($oftr_id);
            break;
            
            //Mostrar datos generales de la empresa
            case 10:
            	include '../../boundaries/ofertaTrabajo/frmConsultarDatosGenerales.php';
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	$oferta = $of->obtenerOfertaGenerales($oftr_id);
            	$datos_formulario = $of->obtenerCatalogosRelacionados();
            	$frm = new FrmConsultarDatosGenerales($datos_formulario,$oferta);
            break;
            
            //Actualizar datos generales
            case 11:
            	$of = new OfertaTrabajo();
            	$oferta = $_GET['oferta'];
            	if($oferta['oftr_disponibilidad_viajar'] == 1){
            		$oferta['oftr_disponibilidad_viajar'] = true;
            	}else{
            		$oferta['oftr_disponibilidad_viajar'] = false;
            	}
            	foreach($oferta as $clave=>$valor){
            		if($valor == ''){
            			$oferta[$clave] = NULL;
            		}
            	}
            	
            	$of->update('oferta_trabajo',$oferta,'oftr_id',$_GET['oftr_id']);
            	echo 'La actualización se ha realizado exitosamente';
            break;
            
            /***Formulario consultar idiomas**/
            case 12:
            	include '../../boundaries/ofertaTrabajo/frmConsultarIdiomas.php';
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	$idiomas = $of->obtenerOfertaIdiomas($oftr_id);
            	$datos_formulario = $of->obtenerCatalogosRelacionados();
            	$frm = new FrmConsultarIdiomas($datos_formulario,$idiomas);
            break;
            
            /**Formulario modificar domicilio*/
            case 13:
            	include '../../boundaries/ofertaTrabajo/frmConsultarLugarTrabajo.php';
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	$domicilio = $of->obtenerDomicilio($oftr_id);
            	$datos_formulario = $of->obtenerCatalogosRelacionados();
            	$frm = new FrmConsultarLugarTrabajo($datos_formulario, $domicilio);
            break;
            
            /**Formulario modificar perfil**/
            case 14:
            	include '../../boundaries/ofertaTrabajo/frmConsultarPerfil.php';
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	$perfil = $of->obtenerPerfil($oftr_id);
            	$datos_formulario = $of->obtenerCatalogosRelacionados();
            	$frm = new FrmConsultarPerfil($datos_formulario,$perfil);
            break;
            
            /**Obtener observaciones**/
            case 15:
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	echo $of->obtenerObservaciones($oftr_id);
            break;
            
            /**Obtener vacantes disponibles**/
            case 16:
            	$oftr_id = $_GET['id'];
            	$of = new OfertaTrabajo();
            	$num_vacantes = $of->obtenerNumVacantes($oftr_id);
            	if($num_vacantes != 0){
            		$str_vacantes = "<p>Vacantes disponibles actualmente:$num_vacantes</p></br>";
            		$str_vacantes .= "<input type='hidden' id='oftr_id_vaca' value='$oftr_id'/>";
	            	$str_vacantes .= '<p>Seleccione para disminuir el n&uacute;mero de vacantes</p></br>';
	            	$str_vacantes .= "<select id='select_num_vaca_disp'>";
	            		for($i = 0; $i < $num_vacantes;$i++){
	            			$str_vacantes .= "<option value='$i'>$i</option>";
	            		}
	            	$str_vacantes .= '</select>';
            	}else{
            		$str_vacantes = '<p>El n&uacute;mero de vacantes es cero</p></br>';
            	}
            	
            	echo $str_vacantes;
            	
            break;
            
            //Disminuir el numero de vacantes
            case 17:
            	$oftr_id = $_GET['id'];
            	$num_disponibles = $_GET['num_disponibles'];
            	$of = new OfertaTrabajo();
            	$of->setNumVacantesDisponibles($oftr_id,$num_disponibles);
            break;
            
            case 20:
            	include '../../boundaries/ofertaTrabajo/frmConsultarOfertaCoordinador.php';
            	$of = new OfertaTrabajo();
            	$datos_tabla = $of->obtenerPendientes();
            	$campos_rec = array();
            	$campos_rec[] = 'oftr_nombre';
            	$campos_rec[] ='oftr_puesto_solicitado';
            	$campos_rec[] = 'oftr_fecha_registro';
            	$campos_rec[] = 'em_nombre';
            	$campos_rec[] = 'esau_nombre';
            	$frmConsultar = new FrmConsultarOfertaCoordinador($campos_rec, $datos_tabla);
            break;
        
            /**Mostrar oferta completa**/
            case 21:
                include '../../boundaries/ofertaTrabajo/frmConsultarOfertaCompleta.php';
                $of = new OfertaTrabajo();
            	$oferta = $of->obtenerOferta($_GET['id']);
                
                new FrmConsultarOfertaCompleta($oferta);
            break;
        
            /**Actualizar rechazar**/
            case 22:
                echo '<label>Observaciones:</label></br>';
                echo "<form id='frmRechazar'>";
                echo "<input type='hidden' name='opc' value='23'/>";
                echo "<input type='hidden' name='id' value='".$_GET['id']."'/>";
                echo '<textarea name="observaciones"></textarea>';
                echo "<input type='button' value='Rechazar' onclick='enviarRechazar();return false;'/>";
                echo '</form>';
            break;
        
            /**Procesar rechazar**/
            case 23:
                $of = new OfertaTrabajo();
                $datos['oftr_observaciones'] = $_GET['observaciones'];
                $datos['esau_id'] = 3;
            	$oferta = $of->update('oferta_trabajo',$datos,'oftr_id',$_GET['id']);
                echo "<p>La información se ha actualizado exitosamente.</p><input type='button' value='Aceptar' onclick='mostrarListado();return false;' />";
            break;
        
            /**Procesar aceptar**/
            case 24:
                $of = new OfertaTrabajo();
                $datos['esau_id'] = 1;
            	$oferta = $of->update('oferta_trabajo',$datos,'oftr_id',$_GET['id']);
                echo "<p>La información se ha actualizado exitosamente.</p><input type='button' value='Aceptar' onclick='mostrarListado();return false;' />";
            break;
            
            /***Procesar modificar domicilio**/
            case 30:
            	$of = new OfertaTrabajo();
            	$oferta = $_GET['domicilio'];
            	
            	foreach($oferta as $clave=>$valor){
            		if($valor == ''){
            			$oferta[$clave] = NULL;
            		}
            	}
            	
            	$of->update('domicilio',$oferta,'do_id',$_GET['do_id']);
            	echo 'La actualización se ha realizado exitosamente';
            break;
         
            /**Procesar modificar perfil**/
            case 31:
            break;
        
             /**Procesar modificar idiomas**/
            case 31:
            break;
        
            case 40:
            	
            break;
            
        }
    }
    

    function crearFilasTablaReclutador($campos = NULL, $datos_tabla = NULL){
    
    	$cadenaFilas = "";
    	foreach($datos_tabla as $fila){
    		$cadenaFilas .= '<tr>';
    		foreach($campos as $clave ){
    			$cadenaFilas .= '<td>';
    			$cadenaFilas .= $fila[$clave];
    			$cadenaFilas .= '</td>';
    		}
    		$cadenaFilas .= '<td>';
    		if($fila['esau_nombre'] == 'Rechazado'|| $fila['esau_nombre'] == 'Pendiente'){
    			$cadenaFilas .= "<a href='#' name='btn_modificar_registro'onclick='modificarOferta(".$fila['oftr_id'].");return false;'><img src='webroot/images/icono_modificar.gif'/></a>";
    		}
    		if($fila['esau_nombre'] == 'Rechazado'){
    			$cadenaFilas .= "<a href='#' title='Ver observaciones' name='btn_ver_observaciones'onclick='verObservaciones(".$fila['oftr_id'].");return false;'><img src='webroot/images/observaciones.jpeg'/></a>";
    		}
    		if($fila['esau_nombre'] == 'Aprobado'){
    			$cadenaFilas .= "<a href='#' name='btn_disminuir_vacantes' title='Disminuir vacantes' onclick='disminuirVacantes(".$fila['oftr_id'].");return false;' ><img src='webroot/images/disminuir.jpg'/></a>";
    		}
    		$cadenaFilas .= '</td>';
    
    		$cadenaFilas .= '</tr>';
    
    	}
    
    	return $cadenaFilas;
    
    }
    
    
    function crearFilasTablaCooordinador($campos = NULL, $datos_tabla = NULL){
    
    	$cadenaFilas = "";
    	foreach($datos_tabla as $fila){
    		$cadenaFilas .= '<tr>';
    		foreach($campos as $clave ){
    			$cadenaFilas .= '<td>';
    			$cadenaFilas .= $fila[$clave];
    			$cadenaFilas .= '</td>';
    		}
    		$cadenaFilas .= '<td>';
    	
    		if($fila['esau_nombre'] == 'Pendiente'){
    			$cadenaFilas .= "<a href='#' title='Ver oferta completa' class='accion_link' onclick='verOftrAceptarRechazar(".$fila['oftr_id'].");return false;'><img src='webroot/images/ver_completa.png'/></a>";
    		}else{
    			$cadenaFilas .= "<a href='#' title='Ver observaciones' class='accion_link' onclick='verOftrCompleta(".$fila['oftr_id'].");return false;'><img src='webroot/images/ver_completa.png'/></a>";
    		}
    		
    		$cadenaFilas .= '</td>';
    
    		$cadenaFilas .= '</tr>';
    
    	}
    
    	return $cadenaFilas;
    
    }
    
}

new CtlOferta($_GET);
?>