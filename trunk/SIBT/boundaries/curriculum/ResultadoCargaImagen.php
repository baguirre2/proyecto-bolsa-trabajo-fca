<?php

//Dentro del constructor hay una copia indetica el index, solo cambian (bueno se adecuan) las direcciones de los CSS y del JS

class ResultadoCargaImagen {

    public function __construct($mensaje) {

        //error_reporting (E_ALL & ~E_NOTICE);

        /**
        * En este caso se usarÃ¡ esta parte para las pruebas hasta que se tenga desarrollado el modulo de Usuarios.
        * @author BenjamÃ­n Aguirre GarcÃ­a
        * 
        */
        /*//Se inicia la sesiÃ³n en PHP. 
        session_start();
        // Se debe de poder almacenar el tipo de usuario, seleccionen con el que van a probar. 
        // Alumno, Coordinador, Profesor, Reclutador
        $_SESSION['TipoUsuario'] = 'Alumno'; 
        // Aqui pongan el id del Usuario con el que estÃ¡n haciendo pruebas, 
        $_SESSION['idUsuario'] = 1;*/

        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Sistema de Reservaciones de Laboratorio</title>
                <link href="../../webroot/css/estilo.css" rel="stylesheet" type="text/css" />
                <link href="../../webroot/css/menu.css" rel="stylesheet" type="text/css" />
            </head>

            <body>
                <script type="text/javascript" src="../../webroot/js/jquery-1.10.1.js"></script>	
                <script type="text/javascript" src="../../webroot/js/funAJAX.js"></script>	
                <script type="text/javascript" src="../..webroot/js/validar.js"></script>
                <?php include_once 'menu2.html'; 
                	$this->mostrarInfoAcademica($idAlum);
                ?>

                <div id="contenido">
                    
                </div>
                
                <div id="pie"></div>
                <form id="vacio"></form>
            </body>
            <!-- Solo agregue este Script, el cual muestra un mensaje (que recibe el contructor como parametro), 
                    y una vez que se muestra, se redirecciona al index del sistema  -->
            <script type="text/javascript">
                //Esto hace que se lance al mensaje una vez que la pagina este cargada al 100%
                document.addEventListener('DOMContentLoaded', function () {
                    
                    //Una vez de que se cargo la pagina, autoejecuto inmediatamente el mensaje, al dar Aceptar el usuario, se redirecciona
                     setTimeout(function(){
                         alert ('<? echo $mensaje ?>');
                         window.location.href="../../";
                     },0);
                }, false);
                </script>	
        </html>
        <?
    }
    
    
    /**
     *Funcion para mostrar la información academica del alumno
     *@author Liliana Luna
     *@param
     **/
    public function mostrarInfoAcademica($idAlum){
    	echo "&nbsp;";
    	$resultados = $this->listarGradosAcademicos(1,0, $idAlum);
    	$registros = "";
    	for ($i=0; $i <= count($resultados)-1; $i++) {
    		$infoAc_id = $resultados[$i]['inac_id'];
    		$registros .= "<tr><td>".$resultados[$i]['esfc_descripcion']."</td>";
    		$registros .= "<td>".$resultados[$i]['inac_fecha_inicio']."</td>";
    		$registros .= "<td>".$resultados[$i]['esac_tipo']."</td>";
    		$registros .= ($resultados[$i]['esau_id'] != 1)? "<td><form id=\"frmListar\"><input type=\"button\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormEditar', 'frmListar', 'contenido', $infoAc_id)\"></form></td></tr>" : "<td></td></tr>";
    	}
    	echo "
				<table class=\"tablas_sort\">
						<thead>
						<tr>
						<th>Nombre de estudio</th>
						<th>Fecha de inicio</th>
						<th>Estado</th>";
    	echo ($resultados[$i-1]['esau_id'] != 1)? "<th>Edici&oacute;n</th>" : "";
    	echo "</tr>
						</thead>
						<tbody>".$registros."
						</tbody>";
    	echo "<tr>
						<td><input type=\"button\" value=\"Agregar grado academico\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaFormRegistrar', 'vacio', 'contenido')\"></td>
    
						</tr></table>";
    }
    
    /**
     *Funcion para listar los grados académicos
     *@author Liliana Luna
     *@param opcion: determina si se listan todos los grados académicos o uno en específico (de la FCA u otro).
     **/
    public function listarGradosAcademicos($opcion, $id_infoAca, $idAlum){
    
    	$conexion = new InterfazBD2();
    	if($opcion==1){
    		$query = "select a.inac_id, a.esau_id, b.esfc_descripcion, a.inac_fecha_inicio, c.esac_tipo FROM ingsw.informacion_academica AS a
					JOIN ingsw.estudio_fca AS b ON a.esfc_id=b.esfc_id
					JOIN ingsw.estado_academico AS c ON a.esac_id=c.esac_id AND a.al_id=2
					UNION ALL
					select a.inac_id, a.esau_id, b.esot_descripcion, a.inac_fecha_inicio, c.esac_tipo FROM ingsw.informacion_academica AS a
					JOIN ingsw.estudio_otro AS b ON a.esot_id=b.esot_id
					JOIN ingsw.estado_academico AS c ON a.esac_id=c.esac_id AND a.al_id=2";
    	}elseif ($opcion==2){
    			
    		$query_otro = "SELECT esot_id FROM ingsw.informacion_academica where inac_id=$id_infoAca";
    		$resultados_otro = $conexion->consultar($query_otro);
    			
    		$id_otro = $resultados_otro[0]['esot_id'];
    
    		if($id_otro != ""){
    			$query = "SELECT * FROM ingsw.informacion_academica AS a JOIN ingsw.estudio_otro AS b
    			ON a.esot_id = b.esot_id AND al_id=$idAlum and inac_id=$id_infoAca";
    		}else{
    			$query = "SELECT * FROM ingsw.informacion_academica AS a JOIN ingsw.estudio_fca AS b
    			ON a.esfc_id = b.esfc_id AND al_id=$idAlum and inac_id=$id_infoAca";
    		}
    
    	}
    	$resultados = $conexion->consultar($query);
    	if($resultados != false){
    		return $resultados;
    	}else{
    		return $resultados;
    	}
    	$conexion->cerrarConexion();
    }
    

}
?>