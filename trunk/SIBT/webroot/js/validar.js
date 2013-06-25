function validar(formulario_id){
		$('label.error').remove();
		var valido = true;
		$('#'+formulario_id+' .required').each(function(index,element){
			
			if( $(this).val() == null || $(this).val() == ""){
				valido = false;
				$(this).after("<label class='error'>Campo Obligatorio</label>");
			}
		});

		$('#'+formulario_id+' .numeric').each(function(index,element){
			
			if( ($(this).val() != null || $(this).val() != "") 
					&& /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test($(this).val()) == false){
				valido = false;
				$(this).after("<label class='error'>Por favor introduzca un n&uacute;mero</label>");
			}
		});

		return valido;
	}
	
	$(document).ready(function(){
		$('#btn_enviar_formulario').click(function(){
			if(validar('form_oferta') == true){
				/*Serialize toma todos los datos del formulario**/
				$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',$('#form_oferta').serialize(),function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
						$('#mensajes').append(data);
						//$('#mensajes').dialog("open");
					});
			}
		});
	});