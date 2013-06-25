<?php

include_once '../../entities/InfoLaboral.php';
include './../../entities/Certificacion.php';
include_once '../../entities/InterfazBD2.php';

class CtlCurriculum {

    function __construct($GET) {

        $opc = $GET['opc'];

        //En esta l铆nea se obtendra el ID del alumno, por un objeto SESSION
        $idAlum = 1;

        switch ($opc) {

            //Mostrar Formulario para registro
            case 1;
                include '../../boundaries/curriculum/menuCurr.html';
                break;

            //Mostrar Formularo de Registro
            case 2;
                include '../../boundaries/curriculum/frmCurrRegis.html';
                break;

            //Modificar
            case 3;
                echo "<h1>Modificar</h1>";
                break;

            //Listar
            case 4;
                echo "<h1>Listar</h1>";
                break;

            //Registrar
            case 'registrar';
                echo "<h1>He registrado tus datos $GET[nomAlum].
                            Tu Direcci贸n es: $GET[dirAlum]</h1>";
                break;

            //Lista todas las Informaci贸n Laboral del alumno
            case 'inLabListar';
                //Se invoca el metodo que se encarga de generar la lista
                $this->listarInfoLaboral($idAlum, NULL);
                break;

            //Obtiene los datos de la informaci贸n laboral y los muestra para su edici贸n
            case 'inLabFrmEditar';
                //Obtenemos el ID de la infoLaboral que sera modificada
                $idInfoLab = $GET['id'];
                $this->mostrarFrmModificar($idInfoLab);
                break;

            //Actualiza en la BD los datos de la informaci贸n laboral
            case 'inLabModificar';
                if ($this->modificarInfoLaboral($GET['id'], $GET)) {

                    $this->listarInfoLaboral($idAlum, "La informaci贸n laboral ha sido registrada");
                } else {
                    $this->listarInfoLaboral($idAlum, "Ha ocurrido un error al registrar la informaci贸n laboral");
                }
                break;

            //Obtiene los datos de la informaci贸n laboral y los muestra para su edici贸n
            case 'inLabFrmRegistrar';
                //Incluimos la boundary formulario de infoAcademica y luego creamos un objeto de ella
                include_once '../../boundaries/curriculum/FormularioInfoAcademica.php';
                new FormularioInfoAcademica();
                break;

            case 'inLabRegistrar';

                if ($this->agregarInfoLaboral($idAlum, $GET)) {

                    $this->listarInfoLaboral($idAlum, "La informaci贸n laboral ha sido registrada");
                } else {
                    $this->listarInfoLaboral($idAlum, "Ha ocurrido un error al registrar la informaci贸n laboral");
                }

                break;
                
            case 'certi_listar';
                echo "<h1>Mis certificaciones</h1>";
                $certificacion = new Certificacion();
                echo $certificacion->listarCertificaciones();
                echo "<input type=\"button\" name=\"Agregar\" value=\"Agregar Certificaci髇\" onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_registrar', 'vacio', 'contenido');\">";
                echo "<input type='button' value='Regresar' onclick='ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_listar', 'vacio', 'contenido');'>";
                break;
                
            case 'certi_registrar';
                if(!isset($GET['ce_id']) && !isset($GET['btnAceptar']) ) {	//Si no se ha cargado el formulario se incluye
                	include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                } else if($GET['btnAceptar'] == 'Registrar' ) {
                	$certificacion = new Certificacion();
                	if($certificacion->registrarCertificacion($GET, 1)){
                		echo "<h1 class=respuesta>Registro realizado con 閤ito</h1><br/>";
                	}else{
                		echo "<h1 class=respuesta>Error al registrar</h1><br/>";
                	}
                }
                break;
                
            case 'certi_editar';
                $certificacion = new Certificacion();
                if(!isset($registro) && !isset($GET['ce_id'])){
                	$registro = $certificacion->buscarCertificacion($GET['id']);
                	include('../../boundaries/curriculum/frmCurrRegistroCertificacion.html');
                }else if($GET['btnAceptar'] == 'Editar' && isset($GET['ce_id'])){
                	if($certificacion->editarCertificacion($GET)){
                		echo "<h1 class=respuesta>Registro actualizado con 閤ito</h1><br/>";
                	}else{
                		echo "<h1 class=respuesta>Error al actualizar</h1><br/>";
                	}
                }
                break;
        }
    }

    //Recibe el ID de la info laboral que se quiere modificar, muestra los valores para su futura edici贸n
    //Autor: Garc铆a Solis Eduardo
    function mostrarFrmModificar($idInfoLab) {
        include_once '../../boundaries/curriculum/FormularioInfoAcademica.php';

        //Creamos un objeto para obtener los datos de la infoLaboral
        $infoLab = new InfoLaboral();
        $infoLab = $infoLab->obtener($idInfoLab);

        new FormularioInfoAcademica($infoLab[0]);
    }

    //Recibe en un array todos lo datos necesarios para regitrar una nueva entrada de informaci贸n laboral
    //Autor: Garc铆a Solis Eduardo
    function agregarInfoLaboral($idAlum, $GET) {
        
        //Declaramos los datos NO obligatorios, para que no sean variables indefinidas
        $GET['jefe'] = ( isset($GET['jefe']) ? $GET['jefe'] : "" );
        $GET['logros'] = ( isset($GET['logros']) ? $GET['logros'] : "" );

        //Creamos un objeto para porder regitrar los datos de la infoLaboral
        $infoLab = new InfoLaboral();

        return ($infoLab->guardar($idAlum, $GET['nomEmp'], $GET['puesto'], $GET['jefe'], $GET['descAct'], $GET['logros'], $GET['anios']));
    }
    
    //Recibe en un array todos lo datos necesarios para regitrar una nueva entrada de informaci贸n laboral
    //Autor: Garc铆a Solis Eduardo
    function modificarInfoLaboral($idInfoLab, $GET) {
        
        //Declaramos los datos NO obligatorios, para que no sean variables indefinidas
        $GET['jefe'] = ( isset($GET['jefe']) ? $GET['jefe'] : "" );
        $GET['logros'] = ( isset($GET['logros']) ? $GET['logros'] : "" );

        //Creamos un objeto para porder regitrar los datos de la infoLaboral
        $infoLab = new InfoLaboral();

        return ($infoLab->modificar($idInfoLab, $GET['nomEmp'], $GET['puesto'], $GET['jefe'], $GET['descAct'], $GET['logros'], $GET['anios']));
    }

    //Este M茅todo se encarga de generar la lista de la informaci贸n laboral del alumno
    //Autor: Garc铆a Solis Eduardo
    function listarInfoLaboral($idAlum, $mensaje) {

        //Importo la boundary que genera la lista a partir de un array
        include_once '../../boundaries/curriculum/ListaInfoLaboral.php';

        //Creo un objeto inforlaboral
        $lista = new InfoLaboral();

        //Obtengo de la BD la consulta que se pasa a array
        $lista = $lista->listar($idAlum);

        //Objeto que arma la lista apartir de un array
        new ListaInfoLaboral($lista, $mensaje);
    }
}

new CtlCurriculum($_GET);
?>