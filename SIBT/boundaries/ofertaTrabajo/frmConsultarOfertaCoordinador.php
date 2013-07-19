<?php 

class FrmConsultarOfertaCoordinador{
	
	
	function __construct($campos = NULL,$datos_tabla = NULL){
	
		
?>


<div id="div_consultar">
	<?php 
		include('frmConsultarPendientesRevisar.php');
		$of = new FrmConsultarPendientesRevisar($campos,$datos_tabla);
	?>
</div><!--div consultar -->
 
 <div id="formulario_oferta">
 
 </div>  

<script type="text/javascript">
    
    
         function mostrarListado(){
             $('#mensajes').dialog('close');
             ajax('controllers/gestionarOfertaTrabajo/CtlOferta.php', 20, 'vacio', 'contenido');
             
         }
         
         function verOftrCompleta(id_oferta){
        	 $.get('controllers/gestionarOfertaTrabajo/CtlOferta.php',{"opc":21,"id":id_oferta},function(data){
					/**Data es el string que nos manda de respuesta el metodo**/
        		 $('#div_consultar').empty();
			 $('#div_consultar').append(data);
						
                 });		
				

         }

        
         

         $(document).ready(function(){
             
			
          });
         
    </script>

<?php 
	}/*Fin del constructor*/
}
?>
        