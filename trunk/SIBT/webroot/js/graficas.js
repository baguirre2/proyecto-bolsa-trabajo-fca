                function grafLoaded() {
                    
                      var data =  new google.visualization.DataTable();

                        var options = {
                            title: 'Ofertas de trabajo',
                            vAxis: {title: 'Ofertas',  titleTextStyle: {color: 'red'}}
                        };
        
                        
                        //Obtenemos los datos desde el controlador
                        var datos = $.ajax({
                        url: "controllers/generarReportes/CtlReportes.php?opc=3",
                        dataType:"json",
                        async: false
                        }).responseText;
          
                        var data =  new google.visualization.DataTable(datos);
            

                        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                }

                function loadGraf() {
                    //Cargamos el api de las gráficas
                   google.load("visualization", "1", { packages:["corechart"],"callback" : grafLoaded});
                }

                function initLoader() {
                   //Agregamos el script del api de google
                  var script = document.createElement("script");
                  script.src = "https://www.google.com/jsapi?callback=loadGraf";
                  script.type = "text/javascript";
                  document.getElementsByTagName("head")[0].appendChild(script);
                }