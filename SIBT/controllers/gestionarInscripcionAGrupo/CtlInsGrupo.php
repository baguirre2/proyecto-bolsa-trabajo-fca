<?php
	/*
	 * @author: Alejandro Vargas
	 * @date: 25/06/2013
    */
    include "../../entities/Grupo.php";
    class CtlInsGrupo{
        function __construct($GET) {
            $opc = $GET['opc'];

            switch ($opc) {
                case 1:
                    //Mostrar formulario de inscripci�n a grupo
                    include '../../boundaries/grupo/frmInscribirGrupo.php';
                    $gr = new Grupo();
                    $datos = $gr->obtenerDatosGrupo2();
                    $campos = array();
                    $campos[] = 'gr_nombre';
                    $campos[] = 'ta_nombre';
                    $campos[] = 'pe_nombre';
                    $campos[] = 'pe_apellido_materno';
                    $campos[] = 'pe_apellido_paterno';
                    $campos[] = 'gr_fecha_inicio';
                    $campos[] = 'ho_hora_inicio';
                    $campos[] = 'ho_hora_fin';
                    $frmInscribirGrupo = new FrmInscribirGrupo($datos,$campos);
                break;
                case 2:
                    include '../../boundaries/grupo/frmConsultarGrupoAlumno.php';
                    $gr = new Grupo();
                    $datos = $gr->obtenerGruposAlumno();
                    $campos = array();
                    $campos[] = 'gr_nombre';
                    $campos[] = 'ta_nombre';
                    $campos[] = 'pe_nombre';
                    $campos[] = 'pe_apellido_materno';
                    $campos[] = 'pe_apellido_paterno';
                    $campos[] = 'gr_fecha_inicio';
                    $campos[] = 'ho_hora_inicio';
                    $campos[] = 'ho_hora_fin';
                    
                    
                    $frmConsultarGrupo = new FrmConsultarGrupoAlumno($datos,$campos);
                    
                break;
            
                case 3:
                    //inscripación al grupo
                    include '../../boundaries/grupo/frmInscribirGrupo.php';
                    
                    $db = new InterfazBD2();
                    $grupo_id = $_GET['gr_id'];
                    $alumno_id = $_GET['al_id'];
                    $str_insert = "INSERT INTO ingsw.inscripcion(al_id,gr_id,in_ausencia) VALUES($alumno_id,$grupo_id,'f')";
                    $insert = $db->insertar($str_insert,'in_id');
    		        $db->cerrarConexion();
              	    return $insert;
                    
                    break;
            
            case 4:
            //Dar de baja el grupo al que se inscribió el alumno
                include '../../boundaries/grupo/frmInscribirGrupo.php';
                
                $db = new InterfazBD2();
                $grupo_id = $_GET['gr_id'];
                $alumno_id = $_GET['al_id'];
                $str_insert = " DELETE FROM ingsw.inscripcion WHERE al_id=$alumno_id AND gr_id=$grupo_id";
                $insert = $db->ejecutarQuery($str_insert);
                $db->cerrarConexion();
              	return $insert;
                
                break;
                
                
            }
        }
    }
   new CtlInsGrupo($_GET);
?>