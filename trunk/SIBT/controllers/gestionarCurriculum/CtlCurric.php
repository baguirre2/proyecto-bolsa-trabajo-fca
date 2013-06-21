<?php

include '../../entities/InterfazBD.php';

class CtlCurric {
    function __construct($_GET) {
        
        $opc = $_GET['opc'];
        
        switch ($opc) {
            
            //Mostrar menÃº
            case 1; include '../../boundaries/curriculum/menuCurr.html';
                break;
            
            //Mostrar Formularo de Registro
            case 'infoAcademica'; 
				           
            echo "<h1>&nbsp;</h1>";
            //Llamar al modelo para listar la información académica que tiene el alumno
            //Mostrar en cada una la opción de editar si está confirmado
            $resultados = $this->listarGradosAcademicos();
            //var_dump($resultados);
            
            $registros = "";
            for ($i=0; $i <= count($resultados)-1; $i++) {
            	$registros .= "<tr><td>".$resultados[$i]['inac_escuela']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_promedio']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_fecha_inicio']."</td>";
            	$registros .= "<td>".$resultados[$i]['inac_fecha_termino ']."</td>";
            	$registros .= ($resultados[$i]['esau_id'] == 1)? "<td>EDITAR</td></tr>" : "<td>NO EDITAR</td></tr>";
            }
            
            echo "
                        <table>
                        <thead>
                        <tr>
                        <th>Escuela</th>
                        <th>Promedio</th>
                        <th>Fecha inicio</th>
                        <th>Fecha término</th>
                        <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>".$registros."
                    	</tbody>
                        
                    ";
            print "<tr>
					<td><input type='button' value='Registrar' onclick='ajax('controllers/gestionarCurriculum/CtlCurric.php', 'registrar', 'frmRegis', 'resFrmRegis')'/></td>
					<td><input name='btnCancelar' type='submit' id='btnCancelar' value='Cancelar' /></td>
				    </tr></table>";     
            
            break;
            
            
            
            //Modificar
            case 3; echo "<h1>Modificar</h1>";
                break;
            
            //Listar
            case 4; echo "<h1>Listar</h1>";
                break;
            
            //Registrar
            case 'registrar'; 
                            
                
                    echo "<h1>He registrado tus datos $_GET[nomAlum].
                            Tu DirecciÃ³n es: $_GET[dirAlum]</h1>";
                break;
        }
    }
    
    //function registrarAlumno ($_GET) {
    //Recibe los datos de la peticiÃ³n y crea una Entity, que los almacena en la BD
    function registrarAlumno ($nom, $dir, $tel) {
        
    }
    
    public function listarGradosAcademicos($alumno = NULL){
    	$conexion = new InterfazBD();
    	$query = "SELECT * FROM ingsw.informacion_academica WHERE al_id=1 ";
    	$resultados = $conexion->consultar($query);
    	if($resultados != false){
    		//echo "Conexión hecha";
    		return $resultados;
    	}else{
    		echo "<p class=respuesta>No existen registros</p>";
    		return false;
    	}
    	$conexion->cerrarConexion();
    }
}

new CtlCurric ($_GET);
?>