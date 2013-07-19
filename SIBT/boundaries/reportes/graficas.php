<?php
class FrmGraficas{
    function __construct() {
        ?> 
        <div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Ofertas de trabajo</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                 <p class="animated fadeInDown delay2">Vacantes ocupadas y número de consultas.</p>
	            </div>
	        </div>
	    </div>
	</div>
           
     <div id="chart_div" style="width:95%; height:1500px;"></div>
     <!--Se puede modificar el tamaño del div para darle mayor presentación-->
     
<script>
/*Mandar a llamar a funcion del script que carga las graficas*/
initLoader();
 </script>     
 

            <?php
    }
    
}
?>
