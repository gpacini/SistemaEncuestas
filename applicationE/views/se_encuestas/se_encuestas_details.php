
<script src="<?php echo base_url(); ?>assets/javascript/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/javascript/html2canvas.js"></script>

<h2 style="margin-top:0px">Encuesta <?php echo $nombre; ?></h2>

<div class="col-md-12">
    <a href="<?php echo site_url('se_encuestas/read/' . $idEncuestas) ?>" class="btn btn-default">Atrás</a>
</div>

<a href="<?php echo site_url('se_encuestas/calificaciones/'.$idEncuestas) ?>" class="btn btn-primary">Ver Calificaciones</a>

<div id="stuff">
    
</div>

<h3>Calificaciones</h3>

<h4>Totales</h4>

<div class="col-md-12">
    <div class="col-md-12" id="divCulturas">
    <div class="col-md-4 col-md-offset-4">
        <canvas id="graphCulturas" width="300px" height="300px" ></canvas>
    </div>
    <div class="col-md-4">
        <div id="graphCulturasLegend" class="chart-legend"></div>
    </div>
    </div>
    <a class="btn btn-primary form-control" onclick="saveImg('divCulturas');" >Guardar Gráfico</a>
</div>

<div class="col-md-12"><h3>Por cultura</h3></div>
<div class="col-md-12">

    <?php foreach ($culturas as $cultura) {
        ?>

    <div class="col-md-4">
        <div class="col-md-12" id="div<?php echo $cultura->display; ?>">
            <h4><?php echo $cultura->nombre; ?></h4>

            <div class="col-md-12">
                <canvas id="graph-<?php echo $cultura->nombre; ?>" width="200px" height="200px" ></canvas>
            </div>
            <div class="col-md-12">
                <div id="graphLegend-<?php echo $cultura->nombre; ?>" class="chart-legend"></div>
            </div>
        </div>
        <a class="btn btn-primary form-control" onclick="saveImg('div<?php echo $cultura->display; ?>');" >Guardar Gráfico</a>
    </div>

        <?php
    }

    $counter = 0;
    ?>

</div>

<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;


<div class="col-md-12">
    <a href="<?php echo site_url('se_encuestas/calificaciones/'.$idEncuestas) ?>" class="btn btn-primary">Ver Calificaciones</a>
    <a href="<?php echo site_url('se_encuestas/read/' . $idEncuestas) ?>" class="btn btn-default">Atrás</a>
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
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label + ': ' + segments[i].value + '%' %><%}%></li><%}%></ul>",
    };
            var colores = ['#AEC6CF', '#77DD77', '#836953', '#ADD8E6', '#EC6778', '#CB99C9', '#FFD1DC', '#CFCFC4', '#FCD2AB', '#FFB347', '#FF6961', '#ADD9FE', '#529A86'];
            var culturasData = [
<?php
foreach ($culturas as $cultura) {
    $counter++;
    ?>
                {
                value: <?php echo number_format((100 * $cultura->promedio) / ($puntajeTotal > 0 ? $puntajeTotal : 1 ), 2); ?>,
                // 100 * <?php echo $cultura->promedio; ?> / <?php echo $puntajeTotal; ?>
        
                        label: "<?php echo $cultura->nombre; ?>",
                        color: colores[<?php echo $counter; ?>]
                },
<?php } ?>
            ];
            var context = document.getElementById('graphCulturas').getContext('2d');
            var culturasChart = new Chart(context).Pie(culturasData, options);
            document.getElementById('graphCulturasLegend').innerHTML = culturasChart.generateLegend();
<?php foreach ($culturas as $cultura) {
    ?>

        var categoriaData = [
    <?php
    $counter = 2;
    foreach ($cultura->categorias as $categoria) {
        $counter++;
        ?>
            {
                    value: <?php echo number_format(((100 * $categoria->promedio) / ($cultura->totalCultura > 0 ? $cultura->totalCultura : 1 )), 2); ?>,
                    // 100 * <?php echo $categoria->promedio; ?> / <?php echo $cultura->totalCultura; ?>
            
                    label: "<?php echo $categoria->nombre; ?>",
                    color: colores[<?php echo $counter; ?>]
            },
    <?php } ?>
        ];
                var context = document.getElementById('graph-<?php echo $cultura->nombre; ?>').getContext('2d');
                var categoriaChart = new Chart(context).Pie(categoriaData, options);
                document.getElementById('graphLegend-<?php echo $cultura->nombre; ?>').innerHTML = categoriaChart.generateLegend();
<?php } ?>
    
    
    var puntajeTotal = <?php echo $puntajeTotal; ?>;


    
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