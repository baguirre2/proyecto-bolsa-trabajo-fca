function validarFecha(fechaIngresada) {
    if (/[0-9][0-9]\/[0-9][0-9]\/([0-9]{1,4})$/.test(fechaIngresada)){
        return (true)
    } else {
        return (false);
    }
}


function validar(){

//Fecha.
    varFecha = document.formulario.fecha.value
    if(varFecha.length == 0){
       alert("Tiene que indicar su fecha.")
       document.formulario.fecha.focus();
       return 0;
    }else if(!validarFecha(varFecha)){ // Se ingresó un formato incorrecto
      alert("Ingresa un formato de fecha valido.");
      document.formulario.fecha.focus();
      return 0;
  }

    //envio del formulario
    alert("Generando Reporte...");
    document.formulario.submit();
}