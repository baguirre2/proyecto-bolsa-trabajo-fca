        function obtenerDeMu(){
        	var demu_id = $('#demu_id').val();
        	if(demu_id != ''){
        		$.get('controllers/gestionarAlumno/CtlAlumno.php',{'opc': OPCION,'demu_id':demu_id},function(data){
        			$('#td_demu_id').empty();
        			$('#td_demu_id').append(data);
        			console.log(data);
        		});
        	}
        }
        
        function obtenerColonia(){
        	var co_id = $('#co_id').val();
        	if(co_id != ''){
        		$.get('controllers/gestionarAlumno/CtlAlumno.php',{'opc': OPCION,'co_id':co_id},function(data){
        			$('#td_co_id').empty();
        			$('#td_co_id').append(data);
        			console.log(data);
        		});
        	}
        }