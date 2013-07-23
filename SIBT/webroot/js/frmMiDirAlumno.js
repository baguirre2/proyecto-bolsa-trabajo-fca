        function obtenerDeMu(){
        	var es_id = $('#es_id').val();
        	if(es_id != ''){
        		$.get('controllers/gestionarAlumno/CtlAlumno.php',{'opc': 'obDeMu','es_id':es_id},function(data){
        			$('#td_demu_id').empty();
        			$('#td_demu_id').append(data);
        			console.log(data);
        		});
        	}
        }
        
        function obtenerColonia(){
        	var demu_id = $('#demu_id').val();
        	if(demu_id != ''){
        		$.get('controllers/gestionarAlumno/CtlAlumno.php',{'opc': 'obColonia' ,'demu_id':demu_id},function(data){
        			$('#td_co_id').empty();
        			$('#td_co_id').append(data);
        			console.log(data);
        		});
        	}
        }
        
        function obtenerDatosCp(){
            var cp = $('#co_codigo_postal').val();
            if(cp != ''){
                if(cp.length  == 5){
                    $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{'opc':55,'cp':cp},function(data){
                        $('#datos_cp').empty();
                        $('#datos_cp').append(data);
                        
                    });
                }else{
                   
                    $('#co_codigo_postal').after("<etiqueta class='error'>El c.p debe contener 5 d&iacutegitos.</etiqueta>");
                }    
                
            }
    }