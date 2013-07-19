<?php 
class FrmConsultarLugarTrabajo{
	
	function __construct($datos_formulario = NULL,$domicilio = NULL){
		
?>
<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="30"/><!-- La opcion del controlador a la que se va a llamar -->
        <input type="hidden" name="do_id" value="<?php echo $domicilio['id_id'];?>"/>
	<table>
			<th>Lugar de trabajo</th>
			<tr>
			<td>C.P<span>*</span></td>
			<td><input id="input_cp" type="text" name="codigo_postal" class="required"  value="<?php echo $domicilio['co_codigo_postal'];?>" onblur="obtenerDatosCp();return false;"/></td>
			</tr>
			<tr>
			<td>Calle<span>*</span></td>
			<td><input type="text" name="domicilio[do_calle]" class="required" value="<?php echo $domicilio['do_calle'];?>"/></td>
			</tr>
			<tr><td>N&uacute;mero exterior<span>*</span></td>
			<td><input type="text" name="domicilio[do_num_exterior]" class="required" value="<?php echo $domicilio['do_num_exterior'];?>"/></td>
			</tr>
			<tr><td>N&uacute;mero interior</td>
			<td><input type="text" name="domicilio[do_num_interior]" value="<?php echo $domicilio['do_num_interior'];?>" /></td>
			</tr>
                        
	</table>
        
        <table id="datos_cp"></table>
        <table>
            <tr>
                            <td><input type="button" value="Guardar" onclick="frmModLugarEnviar();return false;"/></td>
                            <td><input type="button" value="Cancelar" id="cancelar_guardar" onclick="vaciarFrmOferta();return false;"/></td>
                        </tr>
            
        </table>
</fieldset>
<?php 
	}
}
?>
</form>