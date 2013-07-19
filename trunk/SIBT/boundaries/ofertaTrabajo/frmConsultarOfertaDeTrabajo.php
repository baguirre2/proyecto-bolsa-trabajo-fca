<?php 
class FrmConsultarOfertaDeTrabajo{
	
	
	function __construct($select= NULL,$campos = NULL,$datos_tabla = NULL,$id_reclutador = NULL){
?>
<!--<table border="1" class="table_consultar">
	<form id="frmConsu">
		<input type="hidden" name="id_reclutador" value='<?php echo $id_reclutador;?>' />
		<input type="hidden" name="opc" value="6"/>
        <tbody>   
            <tr>                
                <td>Palabra de b&uacute;squeda:</td>
                <td>
                    <input type="text" name="" value="" placeholder="busqueda" style="width:200px" />         
                </td>
                <td>Estatus Oferta:</td>
                <td><select name="">
  						< ?php foreach($select['estado']as $clave=>$valor){
  							
	                               			echo "<option value='".$clave."'>".$valor."</option>";
	                               		}
	                               	?>  
                    </select>
                </td>
                </tr>
            	<tr>
	                <td>Carrera:</td>
	                <td><select name="Estado Oferta">
	                               < ?php foreach($select['carrera'] as $clave=>$valor){
	                               			echo "<option value='$clave'>$valor</option>";
	                               		}
	                               	?>  
	                    </select>
	                </td>
	
	               <td>Campo Fecha</td>
	            	<td><input type="text" id="cal" name="calendario" value="" /></td>
					
               </tr>
               <tr>
               		<td class="button_agregar" colspan="4"><input  type="button" value="Buscar" id="button_buscar"/></td>
               </tr>          
        </tbody>
     
	</form>
    </table>-->
    </br>
    </br>
    </br>
<table  class="tablas_sort">
        <thead>
            <tr>
            	<th>Nombre</th>
                <th>Puesto</th>
                <th>Fecha de registro</th>
                <th>Estudios</th>
                <th>Estado de autorizaci&oacute;n</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
        		echo self::crearFilasTabla($campos, $datos_tabla);
        	?>
        </tbody>
    </table>


<?php 
	}/*Fin del constructor*/
	
	/**
	 * Regresa las filas de una tabla
	 * @param array[] $campos nombre de los campos a mostrar
	 * @param array[][] $datos_tabla datos a mostrar en esos campos
	 * @return string $cadenaFilas
	 */
	static function crearFilasTabla($campos = NULL, $datos_tabla = NULL){
	
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
				//$cadenaFilas .= "<a href='#' name='btn_modificar_registro'onclick='modificarOferta(".$fila['oftr_id'].");return false;'><img src='webroot/images/icono_modificar.gif'/></a>";
                            $cadenaFilas .= "<a href='#' name='btn_modificar_registro'onclick='modificarOferta(".$fila['oftr_id'].");return false;'><i class='fontawesome-icon button circle-button green icon-edit'></i></a>";
			}
			if($fila['esau_nombre'] == 'Rechazado'){
				//$cadenaFilas .= "<a href='#' title='Ver observaciones' name='btn_ver_observaciones'onclick='verObservaciones(".$fila['oftr_id'].");return false;'><img src='webroot/images/observaciones.jpeg'/></a>";
                            $cadenaFilas .= "<a href='#' title='Ver observaciones' name='btn_ver_observaciones'onclick='verObservaciones(".$fila['oftr_id'].");return false;'><img src='webroot/images/observaciones.jpeg'/></a>";
			}
			if($fila['esau_nombre'] == 'Aprobado'){
				//$cadenaFilas .= "<a href='#' name='btn_disminuir_vacantes' title='Disminuir vacantes' onclick='disminuirVacantes(".$fila['oftr_id'].");return false;' ><img src='webroot/images/disminuir.jpg'/></a>";
                            $cadenaFilas .= "<a href='#' name='btn_disminuir_vacantes' title='Disminuir vacantes' onclick='disminuirVacantes(".$fila['oftr_id'].");return false;' > <i class='fontawesome-icon button circle-button green icon-minus'></i></a>";
			}
			$cadenaFilas .= '</td>';
	
			$cadenaFilas .= '</tr>';
	 		
        }	
        
        return $cadenaFilas;

	}
}
?>
		