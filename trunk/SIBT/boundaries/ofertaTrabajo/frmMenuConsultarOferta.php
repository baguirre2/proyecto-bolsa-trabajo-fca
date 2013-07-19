<?php 
class FrmMenuConsultarOferta{
	
	function __construct($id_oferta){
		
?>
	<input type="hidden" name="oftr_id" id="oftr_id" value="<?php echo $id_oferta; ?>"/>
	<table>
		<tr>
			<td>
			<input type="button" id="btn_modificar_generales" value="Modificar datos generales"/>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" id="btn_modificar_domicilio" value="Modificar domicilio" />
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" id="btn_modificar_perfil" value="Modificar perfil de aspirante"/>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" id="btn_modificar_idiomas" value="Modificar Idiomas" />
			</td>
		</tr>
            </tr>
                    <td>
                    <input type="button" value="Regresar al listado" onclick="ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 3, 'vacio', 'contenido')"/>
                    </td>
            </tr>
	</table>     
	
	<script>
	$("#btn_modificar_generales").bind('click',function(){
		var id_oferta = $("#oftr_id").val();
		$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":10,"id":id_oferta},function(data){
			/**Data es el string que nos manda de respuesta el metodo**/
				$('#formulario_oferta').empty();
				$('#formulario_oferta').append(data);
                                $('#oftr_horario_entrada').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true,'selectOnBlur':true });
		$('#oftr_horario_salida').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true, 'selectOnBlur':true});
			
			});
	});

	$("#btn_modificar_domicilio").bind('click',function(){
		var id_oferta = $("#oftr_id").val();
		$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":13,"id":id_oferta},function(data){
			/**Data es el string que nos manda de respuesta el metodo**/
				$('#formulario_oferta').empty();
				$('#formulario_oferta').append(data);
				
				console.log(id_oferta);
			});
	});

	$("#btn_modificar_idiomas").bind('click',function(){
		var id_oferta = $("#oftr_id").val();
		$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":12,"id":id_oferta},function(data){
			/**Data es el string que nos manda de respuesta el metodo**/
				$('#formulario_oferta').empty();
				$('#formulario_oferta').append(data);
				
				console.log(id_oferta);
			});
	});

	$("#btn_modificar_perfil").bind('click',function(){
		var id_oferta = $("#oftr_id").val();
		$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":14,"id":id_oferta},function(data){
			/**Data es el string que nos manda de respuesta el metodo**/
				$('#formulario_oferta').empty();
				$('#formulario_oferta').append(data);
				
				console.log(id_oferta);
			});
	});
	</script>
	<script type="text/javascript" src="webroot/js/frmOfertaTrabajo.js"></script> 
<?php 
	}
}
?>