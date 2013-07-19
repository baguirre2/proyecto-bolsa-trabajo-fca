$.extend($.validator.messages, {
    required: "Campo obligatorio.",
    remote: "Por favor arregle este campo.",
    email: "Por favor introduzca un email v�lido.",
    url: "Por favor introduzca una URL v�lida.",
    date: "Por favor introduzca una fecha v�lida",
    dateISO: "Por favor introduzca una fecha v�lida (ISO).",
    number: "Por favor introduzca un n�mero.",
    digits: "Por favor introduzca solo d�gitos.",
    creditcard: "Por favor introduzca un número válido de tarjeta de crédito.",
    equalTo: "Por favor introduzca el mismo valor otra vez.",
    accept: "Por favor introduzca un valor con una extensi�n v�lida.",
    maxlength: $.validator.format("Por favor no introduzca m�s de {0} caracteres."),
    minlength: $.validator.format("Por favor introduzca por lo menos {0} caracteres."),
    rangelength: $.validator.format(" {0} y {1} de longitud."),
    range: $.validator.format("Por favor introduzca un valor entre {0} y {1}."),
    max: $.validator.format("Por favor introduzca un valor menor o igual a {0}."),
    min: $.validator.format("Por favor introduzca un valor igual o mayor a {0}.")
});

$.validator.addMethod("letras_acentos", function(value, element) {
				return this.optional(element) || /^[a-zA-Záéíóúñ]+$/.test(value);
			},'S&oacute;lo se permiten letras en este campo');

$.validator.addMethod("letras_acentos_espacios", function(value, element) {
				return this.optional(element) || /^[a-zA-Záéíóúñ\s]+$/.test(value);
			},'S&oacute;lo se permiten letras en este campo');

$.validator.addMethod("letras_acentos_espacios_numeros", function(value, element) {
				return this.optional(element) || /^[a-zA-Z0-9áéíóúñ\s]+$/.test(value);
			},'S&oacute;lo se permiten letras y números en este campo');

$.validator.addMethod("letras_acentos_espacios_numeros_signos", function(value, element) {
	return this.optional(element) || /^[a-zA-Z0-9������\s]+$/.test(value);
			},'S&oacute;lo se permiten letras, números, puntos y comas en este campo');

			
$.validator.addMethod("letras_numeros", function(value, element) {
				return this.optional(element) || /^[0-9A-Z]+$/.test(value);
			},'S&oacute;lo se permiten números y letras en este campo');
			
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

