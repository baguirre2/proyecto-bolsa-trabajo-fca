<?php 

class FrmConsultarOfertaReclutador{
	
	
	function __construct($select= NULL,$campos = NULL,$datos_tabla = NULL,$id_reclutador = NULL){
	
		
?>


<div id="div_consultar">
	<?php 
		include('frmConsultarOfertaDeTrabajo.php');
		$of = new FrmConsultarOfertaDeTrabajo($select, $campos,$datos_tabla,$id_reclutador);
	?>
</div><!--div consultar -->
 
   

 <div id="dialog_observaciones" title="Observaciones"></div>
 <div id="dialog_num_vacantes" ></div>
 <div id="formulario_oferta"></div>
 <div id="mensajes_frm"></div>
<script type="text/javascript">
         


         function modificarOferta(id_oferta){
        	 $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":9,"id":id_oferta},function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
						$('#div_consultar').empty();
						$('#div_consultar').append(data);
						
						
					});
					
          }

         function verObservaciones(id_oferta){
        	 $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":15,"id":id_oferta},function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
						$('#dialog_observaciones').empty();
						$('#dialog_observaciones').append(data);
						$('#dialog_observaciones').dialog("open");
						
					});
				

         }

         function disminuirVacantes(id_oferta){
        	 $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":16,"id":id_oferta},function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
						$('#dialog_num_vacantes').empty();
						$('#dialog_num_vacantes').append(data);
						$('#dialog_num_vacantes').dialog("open");
						
					});
         }

         function vaciarFrmOferta(){
             $('#formulario_oferta').empty();
         }

         function frmModLugarEnviar(id_oferta){
             
         }
         
          function frmModDatosGeneralesEnviar(){
                $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',$('#form_oferta').serialize(),function(data){
						/**Data es el string que nos manda de respuesta el metodo**/
							$('#mensajes_frm').empty();
							$('#mensajes_frm').append(data);
							$('#mensajes_frm').dialog("open");
						
						});
            }
            
			
         $(document).ready(function(){
             
                                $('#oftr_horario_entrada').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true,'selectOnBlur':true });
				$('#oftr_horario_salida').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true, 'selectOnBlur':true});
             
				$('#button_buscar').click(function(){
					$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',$('#frmConsu').serialize(),function(data){
						/**Data es el string que nos manda de respuesta el metodo**/
							$('#registros_consultar').empty();
							$('#registros_consultar').append(data);
							
						});

				});

				/*Pantalla para mostrar las observaciones**/
				$('#dialog_observaciones').dialog({
					autoOpen: false,
					modal: true,
					buttons: {
						"Salir": function(){
							$(this).dialog('close');
						}
					}
				});
				
				/*Pantalla para mostrar las observaciones**/
				$('#dialog_num_vacantes').dialog({
					autoOpen: false,
					modal: true,
					buttons: {
						"Aceptar":function(){
							if($('#select_num_vaca_disp').length){
								console.log('ddddd');
								var num_vacantes = $('#select_num_vaca_disp').val();
								var oferta_id = $('#oftr_id_vaca').val();
								$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":17,"id":oferta_id,"num_disponibles":num_vacantes},function(data){console.log(data)});
							}

							$(this).dialog('close');
							$('#dialog_num_vacantes').empty();
						},
						"Salir": function(){
							$(this).dialog('close');
						}
					}
				});
                                
                                /*Pantalla para mostrar los mensajes**/
				$('#mensajes_frm').dialog({
					autoOpen: false,
					modal: true,
					close: vaciarFrmOferta
				});
				


			
          });
         
    </script>

<script type="text/javascript" src="webroot/js/function_calendario.js"></script>
<?php 
	}/*Fin del constructor*/
}
?>
        