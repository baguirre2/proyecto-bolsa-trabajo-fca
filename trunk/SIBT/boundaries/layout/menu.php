
<div id="header-inner" class="fixed-header-container">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="navbar">
                    <div class="navbar-inners">
                        <div class="container">
                            <div class="nav-container-outer">
                                <div class="nav-container-inner">
                                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>

                                    <div class="logo">
                                        <a class="brand pull-left" href="#" onclick="window.location.reload();"><img class="logo" src="webroot/img/logo.jpg" alt="SIBT" width="220" /></a>
                                    </div><!--/logo-->
                                    
                                    <div class="nav-collapse collapse">
        <ul class="nav pull-left">
          <?php
            switch( $usuario){
                case 'Admin': ?>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">ALUMNOS<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarAlumno/CtlAlumno.php', 'carAlumMenu', 'vacio', 'contenido')">Ingresar Archivo</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarAlumno/CtlAlumno.php', 'alumno_registrar', 'vacio', 'contenido')">Dar de alta un alumno</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">USUARIOS<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarUsuario/CtlUsuario.php', 'agregar_usuario', 'vacio', 'contenido')">Agregar usuario</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarUsuario/CtlUsuario.php', 'consUsuario', 'vacio', 'contenido')">Consultar usuario</a></li>
                        </ul>
                    </li>
          <?php break;
            
                case 'Responsable':?>
                    <li class="dropdown" ><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Ofertas de trabajo<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 20, 'vacio', 'contenido')">Pendientes de revisar</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">CURRICULUM<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                                <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'ConsultarCurriculum', 'vacio', 'contenido')">Consultar Curriculum</a></li>
                                <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')">Validar Constancias</a></li>
                    
                        </ul>
                    </li>
                    
                    
                    
                   <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Grupos<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                                <li><a href='#' onclick="ajax('controllers/gestionarGrupo/CtlGrupo.php', 1, 'vacio', 'contenido')">Agregar</a></li>
                                <li><a href='#' onclick="ajax('controllers/gestionarGrupo/CtlGrupo.php', 3, 'vacio', 'contenido')">Consultar</a></li>
                        </ul>
                   </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Reportes<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href='#' onclick="ajax('controllers/generarReportes/CtlReportes.php', 1, 'vacio', 'contenido')">Generar Reporte</a>
                            </li>
                            <li>
                                <a href='#' onclick="ajax('controllers/generarReportes/CtlReportes.php', 2, 'vacio', 'contenido')">Generar Gráficas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Gestionar ALUMNO<b class="caret"></b></a>
                         <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumnoResp', 'vacio', 'contenido')">Actualizar Datos Alumno</a></li>
                        </ul>
                    </li>
                    
          <?php  break;
            
                case 'Reclutador': ?>
                    <li class="dropdown" ><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Ofertas de trabajo<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 1, 'vacio', 'contenido')">Registrar</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 3, 'vacio', 'contenido')">Consultar</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Administrar CURRICULUM<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'ConsultarCurriculum', 'vacio', 'contenido')">Consultar Curriculum</a></li>
                        </ul>
                    </li>
          <?php break;
            
                case 'Alumno':?>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Administrar CURRICULUM<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaListar', 'vacio', 'contenido')">Informaci&oacute;n Acad&eacute;mica </a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'certi_listar', 'vacio', 'contenido')">Mis certificaciones</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabListar', 'vacio', 'contenido')">Mi Informaci&oacute;n Laboral</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'objProf', 'vacio', 'contenido')">Mi Objetivo Laboral</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'Cursos', 'vacio', 'contenido')">Mis Cursos</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'Idiomas', 'vacio', 'contenido')">Mis Idiomas</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'VerCurriculumCompleto', 'vacio', 'contenido')">Ver Curriculum</a></li>

                        </ul>
                    </li>

                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Gestionar ALUMNO<b class="caret"></b></a>
                         <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumnoAlu', 'vacio', 'contenido')">Actualizar Datos Alumno</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">Grupos<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href='#' onclick="ajax('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php', 1, 'vacio', 'contenido')">Inscribir</a></li>
                            <li><a href='#' onclick="ajax('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php', 2, 'vacio', 'contenido')">Consultar</a></li>
                        </ul>
                    </li>
          <?php break;
            }
          
          ?>
        </ul>
        </div><!--nav collapse-->

                                    
                                    
                                </div>
                            </div>
                        </div><!--/container-->
                    </div><!--/navbar inner-->
                </div><!--/navbar-->
              </div><!--/span12-->
        </div><!--/row-->
    </div><!--/container-->
</div><!--/header-->


