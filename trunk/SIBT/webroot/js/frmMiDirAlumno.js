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