function ajax (url, opc, frm, div) {
    
    $("#" + div).load(url + "?opc=" + opc + "&" + getFormData(frm, 'silent', true));
}

function getFormData(objf, info, rval) {
    // La función getFormData recorre todos los elementos de un formulario
    // y va formando una cadena de formato "objeto=valor&objeto=valor&...".
    // Los campos del formulario para los que se haya especificado el
    // atributo TITLE, serán considerados campos obligatorios.
    //
    // formato: getFormData(objetoFormulario, tipoAvisoError, returnValue);
    // objetoFormulario: tiene que ser el OBJETO, NO el nombre del formulario
    // tipoAvisoError: silent: no muestra errores, si no se obtuvieron datos del formulario
    // alert: muestra un mensaje de alerta y detiene la ejecución, si no se obtuvieron los datos
    // returnValue: si debe devolver o no el resultado, true o false
    // los campos con el title vació no son alertados
    //
    // ejemplo: var queryStrign = getFormData('formularioId', 'silent', true);
    var formComplete = true;
    var alertMsg = "Debe completar los siguientes campos:\r";
    var getstr = "";
    var formObj =document.getElementById(objf);
    for (var i = 0; i < formObj.elements.length; i++) {
        
        if (formObj.elements[i].type != undefined && formObj.elements[i].name != undefined){
            var elemValLength = formObj.elements[i].value;
            // si algún campo para el envío de archivos cambia el enctype del form.
            if (formObj.elements[i].type == "file"){
                formObj.enctype = "multipart/form-data";
            }
            // chequea que todos los campos con atributo TITLE estén completos.
            if (formObj.elements[i].title != "" && elemValLength.length < 1) {
                alertMsg += " - " + formObj.elements[i].title + "\r";
                formComplete = false;
                continue;
            }
            // si es un checkbox, verifica que esté chequeado
            if (formObj.elements[i].type == "checkbox"){
                if (formObj.elements[i].checked == true){
                    getstr += formObj.elements[i].name + "=" + formObj.elements[i].value + "&";
                }
                continue;
            }
            // si es un radio, verifica que esté chequeado
            if (formObj.elements[i].type == "radio"){
                if (formObj.elements[i].checked == true){
                    getstr += formObj.elements[i].name + "=" + formObj.elements[i].value + "&";
                }
                continue;
            }
            if (elemValLength.length > 0) {
                getstr += formObj.elements[i].name + '=' + formObj.elements[i].value + '&';
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