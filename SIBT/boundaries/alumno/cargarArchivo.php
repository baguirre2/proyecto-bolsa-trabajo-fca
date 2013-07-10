<h1>Registrar Alumno</h1>
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

