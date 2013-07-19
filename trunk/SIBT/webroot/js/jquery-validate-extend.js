$.extend($.validator.messages, {
    required: "Campo obligatorio.",
    remote: "Por favor arregle este campo.",
    email: "Por favor introduzca un email v·lido.",
    url: "Por favor introduzca una URL v·lida.",
    date: "Por favor introduzca una fecha v·lida",
    dateISO: "Por favor introduzca una fecha v·lida (ISO).",
    number: "Por favor introduzca un n˙mero.",
    digits: "Por favor introduzca solo dÌgitos.",
    creditcard: "Por favor introduzca un n√∫mero v√°lido de tarjeta de cr√©dito.",
    equalTo: "Por favor introduzca el mismo valor otra vez.",
    accept: "Por favor introduzca un valor con una extensiÛn v·lida.",
    maxlength: $.validator.format("Por favor no introduzca m·s de {0} caracteres."),
    minlength: $.validator.format("Por favor introduzca por lo menos {0} caracteres."),
    rangelength: $.validator.format(" {0} y {1} de longitud."),
    range: $.validator.format("Por favor introduzca un valor entre {0} y {1}."),
    max: $.validator.format("Por favor introduzca un valor menor o igual a {0}."),
    min: $.validator.format("Por favor introduzca un valor igual o mayor a {0}.")
});

$.validator.addMethod("letras_acentos", function(value, element) {
				return this.optional(element) || /^[a-zA-Z√°√©√≠√≥√∫√±]+$/.test(value);
			},'S&oacute;lo se permiten letras en este campo');

$.validator.addMethod("letras_acentos_espacios", function(value, element) {
				return this.optional(element) || /^[a-zA-Z√°√©√≠√≥√∫√±\s]+$/.test(value);
			},'S&oacute;lo se permiten letras en este campo');

$.validator.addMethod("letras_acentos_espacios_numeros", function(value, element) {
				return this.optional(element) || /^[a-zA-Z0-9√°√©√≠√≥√∫√±\s]+$/.test(value);
			},'S&oacute;lo se permiten letras y n√∫meros en este campo');

$.validator.addMethod("letras_acentos_espacios_numeros_signos", function(value, element) {
	return this.optional(element) || /^[a-zA-Z0-9·ÈÌÛ˙Ò\s]+$/.test(value);
			},'S&oacute;lo se permiten letras, n√∫meros, puntos y comas en este campo');

			
$.validator.addMethod("letras_numeros", function(value, element) {
				return this.optional(element) || /^[0-9A-Z]+$/.test(value);
			},'S&oacute;lo se permiten n√∫meros y letras en este campo');
			
$.validator.addMethod("exactlength", function(value, element, param) {
 return this.optional(element) || value.length == param;
}, $.format("Por favor introduzca exactamente {0} caracteres."));

$.validator.addMethod("selectzero", function(value, element) {
var resultado = true;
if(value == 0){
	resultado = false;
}
 return this.optional(element) || resultado;
}, $.format("Por favor seleccione una opci&oacute;n"));

