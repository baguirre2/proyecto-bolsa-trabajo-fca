<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Registrar Alumno</h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
<div>
    <form enctype="multipart/form-data" action="controllers/gestionarAlumno/CtlAlumno.php" name="form" method="POST" >
        <input type="hidden" name="opc" value="carAlumProceFile" />
        <table>	
            <tr>
                <td colspan="2">Ingresa el archivo .cvs: <input name="userfile" type="file"></td>
            </tr>    
            <tr>
                <td></td>
                <td> <input type = "submit" value= "Reservar"></td>
            </tr>
        </table>
    </form>
</div>