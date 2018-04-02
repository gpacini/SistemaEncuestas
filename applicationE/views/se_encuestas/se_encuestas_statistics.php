
<script src="<?php echo base_url(); ?>assets/javascript/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/javascript/html2canvas.js"></script>

<h2 style="margin-top:0px">Encuesta <?php echo $nombre; ?></h2>


<div class="col-md-12">
<a href="<?php echo site_url('se_encuestas/read/'.$idEncuestas) ?>" class="btn btn-default">Atrás</a>
</div>

<h3>Estadisticas</h3>

<div class="col-md-6">
    <div class="col-md-12" id="divLugaresDeTrabajo">
    <div class="col-md-12"><h4>Lugares de Trabajo</h4></div>
    <div class="col-md-8">
        <canvas id="graph-LugarDeTrabajo" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-LugarDeTrabajo" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divLugaresDeTrabajo');" >Guardar Gráfico</a>
</div>
<div class="col-md-6">
    <div class="col-md-12" id="divDepartamentos">
    <div class="col-md-12"><h4>Departamentos</h4></div>
    <div class="col-md-8">
        <canvas id="graph-Departamento" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-Departamento" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divDepartamentos');" >Guardar Gráfico</a>
</div>
<div class="col-md-6">
    <div class="col-md-12" id="divSexo">
    <div class="col-md-12"><h4>Sexo</h4></div>
    <div class="col-md-8">
        <canvas id="graph-Sexo" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-Sexo" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divSexo');" >Guardar Gráfico</a>
</div>
<div class="col-md-6">
    <div class="col-md-12" id="divJerarquia">
    <div class="col-md-12"><h4>Jerarquia</h4></div>
    <div class="col-md-8">
        <canvas id="graph-Jerarquia" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-Jerarquia" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divJerarquia');" >Guardar Gráfico</a>
</div>
<div class="col-md-6">
    <div class="col-md-12" id="divEdad">
    <div class="col-md-12"><h4>Edad</h4></div>
    <div class="col-md-8">
        <canvas id="graph-Edad" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-Edad" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divEdad');" >Guardar Gráfico</a>
</div>
<div class="col-md-6">
    <div class="col-md-12" id="divAntiguedad">
    <div class="col-md-12"><h4>Antigüedad</h4></div>
    <div class="col-md-8">
        <canvas id="graph-Antiguedad" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphLegend-Antiguedad" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divAntiguedad');" >Guardar Gráfico</a>
</div>

<div class="col-md-12">
<a href="<?php echo site_url('se_encuestas/read/'.$idEncuestas) ?>" class="btn btn-default">Atrás</a>
</div>

<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;

<style>
    .chart-legend li span{
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
}
.chart-legend ul{
    list-style-type: none;
}
</style>

<script>
    
    var options = 
    {
        tooltipTemplate: "<%= label+': '+ value+'%' %>",
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label %><%}%></li><%}%></ul>",
    };
    
    //Por Lugar de Trabajo
    
var data = {
    labels: [<?php
        foreach( $lugaresDeTrabajo as $lugarDeTrabajo ){
            echo "'".$lugarDeTrabajo->nombre."',";
        }
    ?>],
    datasets: [
        {
            label: "Lugar",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [<?php
            foreach( $lugaresDeTrabajo as $lugarDeTrabajo ){
                echo number_format(((100 * $lugarDeTrabajo->encuestados)/$lugarDeTrabajo->totalPersonas), 2, '.', '').",";
            }
            ?>]
        },
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $lugaresDeTrabajo as $lugarDeTrabajo ){
                echo number_format(((100 * $lugarDeTrabajo->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
             
    ]
};

            var context = document.getElementById('graph-LugarDeTrabajo').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-LugarDeTrabajo').innerHTML = chart.generateLegend();

    
    //Por Departamento
    
data = {
    labels: [<?php
        foreach( $departamentos as $departamento ){
            echo "'".$departamento->nombre."',";
        }
    ?>],
    datasets: [
        {
            label: "Departamento",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [<?php
            foreach( $departamentos as $departamento ){
                echo number_format(((100 * $departamento->encuestados)/$departamento->totalPersonas), 2, '.', '').",";
            }
            ?>]
        },
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $departamentos as $departamento ){
                echo number_format(((100 * $departamento->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
    ]
};

            context = document.getElementById('graph-Departamento').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-Departamento').innerHTML = chart.generateLegend();
            
                //Por Sexo
    
data = {
    labels: [<?php
        foreach( $sexos as $sexo ){
            echo "'".$sexo->display."',";
        }
    ?>],
    datasets: [
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $sexos as $sexo ){
                echo number_format(((100 * $sexo->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
    ]
};

            context = document.getElementById('graph-Sexo').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-Sexo').innerHTML = chart.generateLegend();
            
            //Por Edad
    
data = {
    labels: [<?php
        foreach( $edades as $edad ){
            echo "'".$edad->display."',";
        }
    ?>],
    datasets: [
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $edades as $edad ){
                echo number_format(((100 * $edad->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
    ]
};

            context = document.getElementById('graph-Edad').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-Edad').innerHTML = chart.generateLegend();

            //Por Jerarquia
    
data = {
    labels: [<?php
        foreach( $jerarquias as $jerarquia ){
            echo "'".$jerarquia->display."',";
        }
    ?>],
    datasets: [
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $jerarquias as $jerarquia ){
                echo number_format(((100 * $jerarquia->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
    ]
};

            context = document.getElementById('graph-Jerarquia').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-Jerarquia').innerHTML = chart.generateLegend();


            //Por Antiguedad
    
data = {
    labels: [<?php
        foreach( $antiguedades as $antiguedad ){
            echo "'".$antiguedad->display."',";
        }
    ?>],
    datasets: [
        {
            label: "Total",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [<?php
            foreach( $antiguedades as $antiguedad ){
                echo number_format(((100 * $antiguedad->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', '').",";
            }
            ?>]
        }
    ]
};

            context = document.getElementById('graph-Antiguedad').getContext('2d');
            var chart = new Chart(context).Bar(data, options);
            document.getElementById('graphLegend-Antiguedad').innerHTML = chart.generateLegend();




//GUARDAR GRAFICOS 
function saveImg(div){
    html2canvas($("#"+div), {
        onrendered: function(canvas) {
            var myImage = canvas.toDataURL("image/png");
            window.open(myImage);
        }
    });
}
</script>