<?php

class FrmConsultarOfertaCompleta {

    function __construct($of = NULL) {
      
        ?>
       
        <form id="form_oferta" action="#">
            <input type="hidden" name="opc" value="10"/><!-- La opcion del controlador a la que se va a llamar -->
            <input type="hidden" name="oferta[re_id]" value="<?php echo $of['oferta']['re_id']; ?>"/>
            <fieldset>
                
                <table  class="tab_form">
                    <th>Datos generales.</th>
                    <tr>
                        <td>Nombre de la vacante</td>
                        <td><?php echo $of['oferta']['oftr_nombre']; ?></td>
                    </tr>
                    <tr>
                        <td>Puesto solicitado</td>
                        <td><?php echo $of['oferta']['oftr_puesto solicitado']; ?></td>
                    </tr>
                    <tr>
                        <td>Tipo de contrato</td>
                        <td><?php echo $of['oferta']['tico_nombre']; ?></td>
                    </tr>
                    <tr>
                        <td>Tiempo de contrato</td>
                                    <td><?php echo $of['oferta']['tieco_nombre']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Turno</td>
                                        <td><?php echo $of['oferta']['tu_nombre']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hora de entrada </td> 
                                        <td><?php echo $of['oferta']['oftr_horario_entrada']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hora de salida </td>
                                        <td><?php echo $of['oferta']['oftr_horario_salida']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Actividades a realizar </td>
                                        <td><?php echo $of['oferta']['oftr_actividades_realizar']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sueldo m&iacute;nimo</td>
                                        <td><?php echo $of['oferta']['oftr_sueldo_minimo']; ?></tr>
                                    </tr>
                                    <tr><td>Sueldo m&aacute;ximo</td>
                                        <td><?php echo $of['oferta']['oftr_sueldo_maximo']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Disponibilidad para viajar</td>
                                        <td><?php if($of['oferta']['oftr_disponibilidad_viajar'] == 't'){ echo 'Si.';}else{echo 'No.';} ?></td>
                                    </tr>
                                    <tr><td>N&uacute;mero de vacantes </td>
                                        <td><?php echo $of['oferta']['oftr_num_vacantes']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tel&eacute;fono de contacto</td>
                                        <td><?php echo $of['oferta']['oftr_telefono']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Correo el&eacute;ctronico de contacto</td>
                                        <td><?php echo $of['oferta']['oftr_correo']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Etiquetas</td>
                                        <td>
                                            <?php echo $of['oferta']['oftr_etiquetas']; ?>	
                                        </td>
                                    </tr>
                                    </table>
                                    <table class="tab_form">
                                        <th>Lugar de trabajo</th>
                                        <tr>
                                            <td>C.P</td>
                                            <td><?php echo $of['domicilio']['co_codigo_postal']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Calle<span>*</span></td>
                                            <td><?php echo $of['domicilio']['do_calle']; ?></td>
                                        </tr>
                                        <tr><td>N&uacute;mero exterior</td>
                                            <td><?php echo $of['domicilio']['do_num_exterior']; ?></td>
                                        </tr>
                                        <tr><td>N&uacute;mero interior</td>
                                            <td><?php echo $of['domicilio']['do_num_interior']; ?></td>
                                        </tr>
                                        <tr>
                                        <td>Estado<span>*</span></td>
                                        <td><?php echo $of['domicilio']['es_nombre']; ?></td>

                                        </tr>
                                        <tr><td>Delegaci&oacute;n/Municipio</td>
                                            <td><?php echo $of['domicilio']['demu_nombre']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Colonia</td>
                                            <td><?php echo $of['domicilio']['co_nombre']; ?></td>
                                        </tr>


                                    </table>



                                    <table class="tab_form">
                                        <th>Perfil requerido del aspirante.</th>

                                                <tr>
                                                        <td>Nivel de estudios.</td>
                                                        <td><?php echo $of['perfil']['nies_descripcion']; ?></td>
                                                        </tr>
                                        <tr>
                                                        <td>Estudios.</td>
                                                        <td><?php echo $of['perfil']['esfc_descripcion']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Semestre cursado</td>
                                                            <td><?php echo $of['perfil']['peas_semestre']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Edad m&iacute;nima</td> 
                                                            <td><?php echo $of['perfil']['peas_edad_minima']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Edad m&aacute;xima</td>
                                                            <td><?php echo $of['perfil']['peas_edad_maxima']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Experiencia requerida para el puesto</td>
                                                            <td><?php if(empty( $of['perfil']['experiencia_meses'])== false){ echo $of['perfil']['experiencia_meses'].' meses';} ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Habilidades requeridas para el puesto</td>
                                                            <td><?php echo $of['perfil']['peas_habilidades']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Conocimientos obligatorios</td>
                                                            <td><?php echo $of['perfil']['peas_conocimientos_obligatorios']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Conocimientos deseables</td>
                                                            <td><?php echo $of['perfil']['peas_conocimientos_deseables']; ?></td>

                                                        </tr>
                                                        </table>
                                                 
                                                        <?php if($of['idiomas'] != false){?>
                                                            <table class="tab_form">
                                                                
                                                                <thead>
                                                                
                                                                <th>Idioma </th>
                                                                <th>Nivel oral(%)</th>
                                                                <th>Nivel escrito(%)</th>
                                                                <th>Nivel lectura(%)</th>

                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        foreach($of['idiomas'] as $arr_idioma){
                                                                            echo '<tr><td>'.$arr_idioma['id_nombre'].'</td>';
                                                                             echo '<td>'.$arr_idioma['niid_nivel_oral'].'</td>';
                                                                             echo '<td>'.$arr_idioma['niid_nivel_escrito'].'</td>';
                                                                             echo '<td>'.$arr_idioma['niid_nivel_lectura'].'</td></tr>';
                                                                        }
                                                                    
                                                                    
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        
                                                        <?php } ?>



                                                        <table class="tab_form">
                                                            <tr>&nbsp;</tr>

                                                            <tr>
                                                                <td>
                                                                    <input type="button" value="Aceptar" onclick="aceptarOferta(<?php echo $of['oferta']['oftr_id'];?>)"/>
                                                                    <input type="button" value="Rechazar" onclick="rechazarOferta(<?php echo $of['oferta']['oftr_id'];?>)"/>
                                                                    <input type="button" value="Regresar al listado" onclick="mostrarListado();return false;"/>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        </fieldset>
                                                        <div id="mensajes"></div>




                                                        <script>

                                                            function aceptarOferta(id_oferta){
                                                                $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":24,"id":id_oferta},function(data){
                                                                    /**Data es el string que nos manda de respuesta el metodo**/
                                                                    $('#mensajes').empty();
                                                                    $('#mensajes').append(data);
                                                                    $('#mensajes').dialog('open');
						
                                                                });
                                                            }
                                                            
                                                            function rechazarOferta(id_oferta){
                                                                 $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":22,"id":id_oferta},function(data){
                                                                    /**Data es el string que nos manda de respuesta el metodo**/
                                                                    $('#mensajes').empty();
                                                                    $('#mensajes').append(data);
                                                                    $('#mensajes').dialog('open');
						
                                                                });
                                                            }
                                                            
                                                            function enviarRechazar(){
                                                                    $('#mensajes').dialog('close');
                                                                  $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',$('#frmRechazar').serialize(),function(data){
                                                                      $('#mensajes').empty();
                                                                      $('#mensajes').append(data);
                                                                      $('#mensajes').dialog('open');
						
                                                                });
                                                            }
                                                            
                                                            $(document).ready(function() {

                      

                                                                /*Pantalla para mostrar mensajes a la hora de agregar**/
                                                                $('#mensajes').dialog({
                                                                    autoOpen: false,
                                                                    modal: true});

                                                            });
                                                        </script>
                                                        <?php
                                                    }

                                                }
                                                ?>