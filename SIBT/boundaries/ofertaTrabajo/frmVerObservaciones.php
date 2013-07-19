<?php 
class FromConsultarPerfil{
	
	function __construct($datos_formulario = NULL,$id_reclutador = NULL){
		
?>
<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="2"/><!-- La opcion del controlador a la que se va a llamar -->
	<input type="hidden" name="oferta[re_id]" value="<?php echo $id_reclutador; ?>"/>
	<fieldset>
	

<?php 
	}
}
?>