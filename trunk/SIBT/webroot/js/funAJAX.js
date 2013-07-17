function ajax (url, opc, frm, div) {
    
    if (validar2(frm)) { //Si el formulario es vÃ¡lido
    
        //Se carga el contenido
         $("#" + div).load(url + "?opc=" + opc + "&" + getFormData(frm, 'silent', true), function(){
        
              tablasSort(); //Se activa el ordenamiento si existe la tabla
        });     
    }
}

function ajaxConId (url, opc, frm, div, id) {
    
    if (validar2(frm)) {
        $("#" + div).load(url + "?opc=" + opc + "&id=" + id + "&" + getFormData(frm, 'silent', true));
    }   
}

/*
 * Emmanuel Antonio García Carrillo
 * Función que permite evaluar si se cargó una imagen para subirla al servidor
 * de lo contrario solo inserta los datos normales.
 */
function ajaxConImagen(url, opc, frm , div, tipo){
	  var img = document.getElementById("archivo").value;
	  if(img.length != 0){	//Si se cargó una imagen
		  //alert("Se cargó una imagen");
		  var inputFileImage = document.getElementById("archivo");
		  var file = inputFileImage.files[0];
		  var data = new FormData();
		  data.append('archivo',file);
		  var urlLoader = "entities/upload.php";
		  //printObject(file);
		  var estado;
	
		  if (validar2(frm)) {
		        
			  $.ajax({
				  url:urlLoader,
				  type:'POST',
				  contentType:false,
				  data: data,
				  processData:false,
				  cache:false
			  }).done(function( msg ) {
			
				  if(msg != "false"){
					  //alert(msg);
					  $("#" + div).load(url + "?opc=" + opc + "&nombreImagen=" + msg + "&" + getFormData(frm, 'silent', true), function(){
        
                tablasSort(); //Se activa el ordenamiento si existe la tabla
            });     
				  }else{
					  $("#" + div).load(url + "?opc=" + opc + "&" + getFormData(frm, 'silent', true), function(){
        
              tablasSort(); //Se activa el ordenamiento si existe la tabla
              });     
				  }
			  });
		  }
	  }else{
		  //alert("No se cargó una imagen");
		  if (validar2(frm)) {
			  $("#" + div).load(url + "?opc=" + opc + "&" + getFormData(frm, 'silent', true),  function(){
        
              tablasSort(); //Se activa el ordenamiento si existe la tabla
        });     
		  }
	  }
}

function getFormData(objf, info, rval) {
    // La funciÃ³n getFormData recorre todos los elementos de un formulario
    // y va formando una cadena de formato "objeto=valor&objeto=valor&...".
    // Los campos del formulario para los que se haya especificado el
    // atributo TITLE, serÃ¡n considerados campos obligatorios.
    //
    // formato: getFormData(objetoFormulario, tipoAvisoError, returnValue);
    // objetoFormulario: tiene que ser el OBJETO, NO el nombre del formulario
    // tipoAvisoError: silent: no muestra errores, si no se obtuvieron datos del formulario
    // alert: muestra un mensaje de alerta y detiene la ejecuciÃ³n, si no se obtuvieron los datos
    // returnValue: si debe devolver o no el resultado, true o false
    // los campos con el title vaciÃ³ no son alertados
    //
    // ejemplo: var queryStrign = getFormData('formularioId', 'silent', true);
    var formComplete = true;
    var alertMsg = "Debe completar los siguientes campos:\r";
    var getstr = "";
    var formObj =document.getElementById(objf);
    for (var i = 0; i < formObj.elements.length; i++) {
        
        if (formObj.elements[i].type != undefined && formObj.elements[i].name != undefined){
            var elemValLength = formObj.elements[i].value;
            // si algÃºn campo para el envÃ­o de archivos cambia el enctype del form.
            if (formObj.elements[i].type == "file"){
                formObj.enctype = "multipart/form-data";
            }
            // chequea que todos los campos con atributo TITLE estÃ©n completos.
            if (formObj.elements[i].title != "" && elemValLength.length < 1) {
                alertMsg += " - " + formObj.elements[i].title + "\r";
                formComplete = false;
                continue;
            }
            // si es un checkbox, verifica que estÃ© chequeado
            if (formObj.elements[i].type == "checkbox"){
                if (formObj.elements[i].checked == true){
                    getstr += formObj.elements[i].name + "=" + encodeURIComponent(formObj.elements[i].value) + "&";
                }
                continue;
            }
            // si es un radio, verifica que estÃ© chequeado
            if (formObj.elements[i].type == "radio"){
                if (formObj.elements[i].checked == true){
                    getstr += formObj.elements[i].name + "=" + encodeURIComponent(formObj.elements[i].value) + "&";
                }
                continue;
            }
            if (elemValLength.length > 0) {
                getstr += formObj.elements[i].name + '=' + encodeURIComponent(formObj.elements[i].value) + '&';
            }
        }
    }
    if (!formComplete){
        if (info == 'alert'){
            alert(alertMsg);
        }
        return false;
    } else {
        if (rval){
            return getstr;
        } else {
            return true;
        }
    }
}

function validar2(formulario_id){
    $('etiqueta.error').remove();
    var valido = true;
    $('#'+formulario_id+' .required').each(function(index,element){

            if( $(this).val() == null || $(this).val() == "" || $(this).val() == "Seleccionar"){
                    valido = false;
                    $(this).after("<etiqueta class='error'>Campo Obligatorio</etiqueta>");
            }
    });

    $('#'+formulario_id+' .numeric').each(function(index,element){

            if( ($(this).val() != null || $(this).val() != "") 
                            && /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test($(this).val()) == false){
                    valido = false;
                    $(this).after("<etiqueta class='error'>Por favor introduzca un n&uacute;mero</etiqueta>");
            }
    });

    return valido;
}


//Ordenamiento, versiÃ³n para imprimir y pdf
function tablasSort(){
           $('.tablas_sort').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sSwfPath": "webroot/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
				{
					"sExtends": "print",
					"sButtonText": "Imprimir"
				},
				{
					"sExtends": "pdf",
					"sPdfMessage": "Ofertas de trabajo",
                                        "sFileName": "SIBT.pdf"
				}
			]
        },
        "oLanguage": {
         "sSearch": "Buscar:",
          "oPaginate": {
                "sFirst": "Primera",
                 "sLast": "Ãltima",
                 "sNext": "Siguiente",
                 "sPrevious": "Anterior"
            },
            "sLengthMenu": "Mostrar _MENU_ registros por pÃ¡gina",
	    "sZeroRecords": "Disculpe no se encontrarÃ³n datos",
	    "sInfo": "Mostrando de _START_ a _END_ de un total de _TOTAL_",
	    "sInfoEmpty": "Mostrando de 0 a 0 de un total de 0 ",
	    "sInfoFiltered": "(filtrados de _MAX_ registros totales)"
       },
       "sPaginationType": "full_numbers"
    } );
    
}