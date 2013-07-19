			
	function validar(formulario_id){
		$('label.error').remove();
		var valido = true;
		$('#'+formulario_id).children().find('.required').each(function(index,element){
				
			if( $(this).val() == null || $(this).val() == ""){
				valido = false;
				$(this).after("<label class='error'>Campo Obligatorio</label>");
			}
		});

		$('#'+formulario_id+' .numeric').each(function(index,element){
			
			if( ($(this).val() != null || $(this).val() != "") 
					&& /^([1-9][0-9]*)|0$/.test($(this).val()) == false){
				valido = false;
				$(this).after("<label class='error'>Por favor introduzca un n&uacute;mero</label>");
			}
		});

		return valido;
	}
        
       

	function validarEtiquetas(){
		var valido = true;
		var str_etiquetas = $.trim($('#oftr_etiquetas').val());
		$('#etiqueta_error').remove();
                
		if(str_etiquetas != null && str_etiquetas != ''){
			var arr_etiquetas = str_etiquetas.split(',');
			$.each(arr_etiquetas,function(index,elemento){
				arr_etiquetas[index] = $.trim(elemento).toLowerCase();
			});
			
			if(arr_etiquetas.length > 0){
				$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{'opc':7,'palabras': arr_etiquetas},function(data){
					
					if(data == 1){
						valido = false;
						$('#oftr_etiquetas').after("<label class='error' id='etiqueta_error' >Una o varias de las etiquetas no son permitidas</label>");
					}
				});

			}
		}

		return valido;
	}

	function validarExistenciaIdioma(id_idioma){
        
            var valido = true;
            $.each($('.val_idiomas'), function(index, elemento){
                if($(this).val() == id_idioma){
                 valido = false;   
                }
            });
            return valido;
        }

	
	/**
	*Retira la fila de la tabla idiomas
	**/
	function eliminarIdioma(id_tr_idioma){
		
		$('#tr_idioma_'+id_tr_idioma+'').remove();
		$('#div_idioma_'+id_tr_idioma+'').remove();
	}
	
        function agregarIdioma(){
        
			$('#tmp_id_nivel_oral').addClass('required numeric');
			$('#tmp_id_nivel_escrito').addClass('required numeric');
			$('#tmp_id_nivel_lectura').addClass('required numeric');
			
			if(validar('frm_agregar_idioma') == true){
				$('#error_idiomas').empty();
				$('#tmp_id_nivel_oral').removeClass('required numeric');
				$('#tmp_id_nivel_escrito').removeClass('required numeric');
				$('#tmp_id_nivel_lectura').removeClass('required numeric');
				
                                num_idioma = $('#num_idioma').val();
					
					
				/**Obtenemos los valores del formulario*/
				var idioma = $('#tmp_idioma').val();
				var idioma_text = $("#tmp_idioma option[value='"+idioma+"']").text();
                                
                                if(validarExistenciaIdioma(idioma) == true){
				var oral = $('#tmp_id_nivel_oral').val();
				var escrito = $('#tmp_id_nivel_escrito').val();
				var lectura = $('#tmp_id_nivel_lectura').val();

				/***
				*Ponemos esos valores en la tabla de idiomas
				*y agregamos campos ocultos a nuestro formulario
				**/
				$("<div id='div_idioma_"+num_idioma+"'><input type='hidden' name='idioma["+num_idioma+"][id_id]' class='val_idiomas' value='"+idioma+"'><input type='hidden' name='idioma["+num_idioma+"][niid_nivel_oral]' value='"
						+oral+"'><input type='hidden' name='idioma["+num_idioma+"][niid_nivel_escrito]' value='"+escrito+"'>"+
					"<input type='hidden' name='idioma["+num_idioma+"][niid_nivel_lectura]' value='"+lectura+"'></div>").appendTo('#idiomas');

				$("<tr id='tr_idioma_"+num_idioma+"'><td>"+idioma_text+"</td><td>"+oral+"</td><td>"+escrito+"</td><td>"
						+lectura+"</td><td><input type='button' value='Eliminar' onclick='eliminarIdioma("+num_idioma+");return false;'/></td></tr>").appendTo('#tab_idiomas');
				num_idioma++;
                                $('#num_idioma').val(num_idioma);

				/**limpiamos los input*/
				$('#tmp_id_nivel_oral').val('');
				$('#tmp_id_nivel_escrito').val('');
				$('#tmp_id_nivel_lectura').val('');
				/*Cerramos la ventana**/
                                    }else{
                                        $('#error_idiomas').append("<etiqueta class>Ya ha agregado ese idioma.</etiqueta>");
                                    }
				} 
		   
        }
        
        function enviarFormulario(){
				var res_validar_etiquetas = validarEtiquetas();
				console.log(res_validar_etiquetas);
				if(validar('form_oferta') == true && res_validar_etiquetas == true && $('#select_col').length > 0 ){
				/*Serialize toma todos los datos del formulario**/
				//if(1 == 1){
				$.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',$('#form_oferta').serialize(),function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
						$('#mensajes').empty();
                                                
						$('#mensajes').append('<pre>'+data+'</pre>');
						$('#mensajes').dialog("open");
					});
			}
		}
                
         function recargarFormulario(){
             cerrarDialog();
             ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 1, 'vacio', 'contenido');
            
         }
         
         function cerrarDialog(){
             $('#mensajes').dialog("close");   
         }
	$(document).ready(function(){

		
		
		 
		/*Pantalla para mostrar mensajes a la hora de agregar**/
		$('#mensajes').dialog({
			autoOpen: false,
			modal: true});
                 $(".ui-dialog-titlebar-close").hide();      
		/**
		*Funcionalidad de selector de horas
		**/
		$('#oftr_horario_entrada').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true,'selectOnBlur':true });
		$('#oftr_horario_salida').timepicker({ 'timeFormat': 'H:i:s','step':60, 'disableTextInput':true, 'selectOnBlur':true});
	});
        
        function obtenerDatosCp(){
                var cp = $('#input_cp').val();
                if(cp != ''){
                    if(cp.length  == 5){
                        $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{'opc':55,'cp':cp},function(data){
                            $('#datos_cp').empty();
                            $('#datos_cp').append(data);
                            
                        });
                    }else{
                       
                        $('#input_cp').after("<etiqueta class='error'>El c.p debe contener 5 dígitos.</etiqueta>");
                    }    
                    
                }
        }
        
        function obtenerDatosEstudios(){
                var nies_id = $('#nies_id').val();
                if(nies_id != ''){
                   
                        $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{'opc':56,'id_nivel_estudio':nies_id},function(data){
                            $('#td_esfc_id').empty();
                            $('#td_esfc_id').append(data);
                          
                            console.log(data);
                        });
                    
                    
                }
        }
        
        function obtenerSemestre(){
                var esfc_id = $('#esfc_id').val();
                if(esfc_id != ''){
                   
                        $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{'opc':57,'esfc_id':esfc_id},function(data){
                            $('#td_peas_semestre').empty();
                            $('#td_peas_semestre').append(data);
                          
                            console.log(data);
                        });
                    
                    
                }
        }