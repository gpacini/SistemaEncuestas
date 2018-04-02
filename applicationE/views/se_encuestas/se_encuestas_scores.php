
<script src="<?php echo base_url(); ?>assets/javascript/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/javascript/html2canvas.js"></script>

<h2 style="margin-top:0px">Encuesta <?php echo $nombre; ?></h2>

<div class="col-md-12">
    <a href="<?php echo site_url('se_encuestas/read/' . $idEncuestas) ?>" class="btn btn-default">Atrás</a>
</div>

<h4>Calificación por datos demográficos</h4>

<div class="col-md-12">
    <div class="col-md-12">
        <select id="oneOptionChartSelect" class="form-control" onchange="renderOneOptionChart();">
            <option></option>
            <option value="LugarDeTrabajo">Lugares de Trabajo</option>
            <option value="Departamento">Departamentos</option>
            <option value="Sexo">Sexo</option>
            <option value="Jerarquia">Jerarquía</option>
            <option value="Edad">Edad</option>
            <option value="Antiguedad">Antigüedad</option>
        </select>
    </div>
</div>

<div class="col-md-12">
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
</div>


<div class="col-md-12" id="oneOptionChart">
</div>


<br />&nbsp;
<br />&nbsp;

<h4>Calificación por Culturas y datos demográficos</h4>

<div class="col-md-12">
    <div class="col-md-6">
        <select id="twoOptionChartSelectCultura" class="form-control" onchange="renderTwoOptionChart();">
            <option></option>
            <?php
            foreach ($culturas as $cultura) {
                echo "<option value='$cultura->nombre'>$cultura->nombre</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <select id="twoOptionChartSelect" class="form-control" onchange="renderTwoOptionChart();">
            <option></option>
            <option value="LugarDeTrabajo">Lugares de Trabajo</option>
            <option value="Departamento">Departamentos</option>
            <option value="Sexo">Sexo</option>
            <option value="Jerarquia">Jerarquía</option>
            <option value="Edad">Edad</option>
            <option value="Antiguedad">Antigüedad</option>
        </select>
    </div>
</div>

<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;


<div class="col-md-12" id="twoOptionChart">
</div>

<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;

<h4>Pie por dato demográfico</h4>
<div class="col-md-12" id="oneOptionPies">

</div>

<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;

<div class="col-md-12">
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

    var canvas;
    var data;
    var colors = ['#AEC6CF', '#77DD77', '#836953', '#ADD8E6', '#EC6778', '#CB99C9', '#FFD1DC', '#CFCFC4', '#FCD2AB', '#FFB347', '#FF6961', '#ADD9FE', '#529A86'];

    var pieOptions =
            {
                tooltipTemplate: "<%= label+': '+ value+'%' %>",
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label + ': ' + segments[i].value + '%' %><%}%></li><%}%></ul>",
            };

    function renderOneOptionChart() {
        var newChartOption = $("#oneOptionChartSelect").val();
        getChartData(newChartOption);
        $("#oneOptionChart").html("");
        for (var i = 0; i < currentCulturas.length; i++) {
            var promediosTemp = [];
            for (var j = 0; j < currentLabels[currentCulturas[i]].length; j++) {
                var promedio = currentPromedios[currentCulturas[i]][currentLabels[currentCulturas[i]][j]] / currentCounts[currentCulturas[i]][currentLabels[currentCulturas[i]][j]];
                promedio = +promedio.toFixed(2);
                promediosTemp.push(promedio);
            }
            data = {
                labels: currentLabels[currentCulturas[i]],
                datasets: [
                    {
                        label: "Calificacion",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: promediosTemp
                    }
                ]
            }

            var div = $("<div></div>");
            div.attr("class", "col-md-6");
            var label = $("<label></label>");
            label.attr("id", "div" + currentCulturas[i])
            label.append(currentCulturas[i] + "<br />");
            canvas = document.createElement("canvas");
            canvas.height = 400;
            var context = canvas.getContext('2d');
            var newChart = new Chart(context).Bar(data, barChartOptions);
            label.append(canvas);
            div.append(label);
            div.append("<a class='btn btn-primary form-control' onclick='saveImg(\"div" + currentCulturas[i] + "\");' >Guardar Gráfico</a>");
            $("#oneOptionChart").append(div);
        }
        var select = "<select class='form-control' onchange='renderOneOptionPieChart();' id='oneOptionPieChartSelect'><option></option>";
        for (var i = 0; i < currentLabels2.length; i++) {
            select += "<option value='" + currentLabels2[i] + "'>" + currentLabels2[i] + "</option>";
        }
        select += "</select>";
        $("#oneOptionPies").html("");
        $("#oneOptionPies").append(select);
    }
    function renderOneOptionPieChart() {
        var labelName = $("#oneOptionPieChartSelect").val();
        var pieData = [];
        var total = 0;
        for (var j = 0; j < currentCulturas.length; j++) {
            total += currentPromedios[currentCulturas[j]][labelName] / currentCounts[currentCulturas[j]][labelName];
        }
        for (var j = 0; j < currentCulturas.length; j++) {
            pieData.push({
                label: currentCulturas[j],
                value: ((100 * currentPromedios[currentCulturas[j]][labelName] / currentCounts[currentCulturas[j]][labelName]) / total).toFixed(2),
                color: colors[j]
            });
        }

        var div = $("<div></div>");
        div.attr("class", "col-md-6");
        var label = $("<label></label>");
        label.attr("id", "div" + labelName + "Pie");
        label.append(labelName + "<br />");
        canvas = document.createElement("canvas");
        canvas.height = 400;
        var context = canvas.getContext('2d');
        var newChart = new Chart(context).Pie(pieData, pieOptions);
        label.append(canvas);
        div.append(label);
        div.append("<a class='btn btn-primary form-control' onclick='saveImg(\"div" + labelName + "Pie\");' >Guardar Gráfico</a>");
        $("#oneOptionPies").append(div);
    }

    var newChartOptionCultura = "";

    function renderTwoOptionChart() {
        var newChartOption = $("#twoOptionChartSelect").val();
        newChartOptionCultura = $("#twoOptionChartSelectCultura").val();
        getChartDataCultura(newChartOption, newChartOptionCultura);
        $("#twoOptionChart").html("");
        for (var i = 0; i < currentCulturas.length; i++) {
            var promediosTemp = [];
            for (var j = 0; j < currentLabels[currentCulturas[i]].length; j++) {
                var promedio = currentPromedios[currentCulturas[i]][currentLabels[currentCulturas[i]][j]] / currentCounts[currentCulturas[i]][currentLabels[currentCulturas[i]][j]];
                promedio = +promedio.toFixed(2);
                promediosTemp.push(promedio);
            }
            data = {
                labels: currentLabels[currentCulturas[i]],
                datasets: [
                    {
                        label: "Calificacion",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: promediosTemp
                    }
                ]
            }

            var div = $("<div></div>");
            div.attr("class", "col-md-6");
            var label = $("<label></label>");
            label.attr("id", "div" + currentCulturas[i])
            label.append(newChartOption + " - " + currentCulturas[i] + "<br />");
            canvas = document.createElement("canvas");
            canvas.height = 400;
            var context = canvas.getContext('2d');
            var newChart = new Chart(context).Bar(data, barChartOptions);
            label.append(canvas);
            div.append(label);
            div.append("<a class='btn btn-primary form-control' onclick='saveImg(\"div" + currentCulturas[i] + "\");' >Guardar Gráfico</a>");
            $("#twoOptionChart").append(div);
        }

    }

    var barChartOptions =
            {
                tooltipTemplate: "<%= label+': '+ value %>",
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label %><%}%></li><%}%></ul>",
            };

    var respuestas = JSON.parse(<?php echo "'" . $respuestas . "'"; ?>);
    var currentPromedios = [];
    var currentLabels = [];
    var currentLabels2 = [];
    var currentCounts = [];
    var currentCulturas = [];

    function getChartData(newChartOption) {
        switch (newChartOption) {
            case 'LugarDeTrabajo':
                promedio = averageByLugarDeTrabajo();
                break;
            case 'Departamento':
                promedio = averageByDepartamento();
                break;
            case 'Sexo':
                promedio = averageBySexo();
                break;
            case 'Jerarquia':
                promedio = averageByJerarquia();
                break;
            case 'Antiguedad':
                promedio = averageByAntiguedad();
                break;
            case 'Edad':
                promedio = averageByEdad();
                break;
        }
    }


    function getChartDataCultura(newChartOption, newChartCultura) {
        switch (newChartOption) {
            case 'LugarDeTrabajo':
                promedio = averageCategoriaByLugarDeTrabajo(newChartCultura);
                break;
            case 'Departamento':
                promedio = averageCategoriaByDepartamento(newChartCultura);
                break;
            case 'Sexo':
                promedio = averageCategoriaBySexo(newChartCultura);
                break;
            case 'Jerarquia':
                promedio = averageCategoriaByJerarquia(newChartCultura);
                break;
            case 'Antiguedad':
                promedio = averageCategoriaByAntiguedad(newChartCultura);
                break;
            case 'Edad':
                promedio = averageCategoriaByEdad(newChartCultura);
                break;
        }
    }

    function averageByLugarDeTrabajo() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.lugarDeTrabajo] === 'undefined') {
                promedios[respuesta.cultura][respuesta.lugarDeTrabajo] = 0;
                nombres[respuesta.cultura].push(respuesta.lugarDeTrabajo);
                counts[respuesta.cultura][respuesta.lugarDeTrabajo] = 0;
            }
            promedios[respuesta.cultura][respuesta.lugarDeTrabajo] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.lugarDeTrabajo] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }

    function averageByDepartamento() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.departamento) === -1) {
                nombres2.push(respuesta.departamento);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.departamento] === 'undefined') {
                promedios[respuesta.cultura][respuesta.departamento] = 0;
                nombres[respuesta.cultura].push(respuesta.departamento);
                counts[respuesta.cultura][respuesta.departamento] = 0;
            }
            promedios[respuesta.cultura][respuesta.departamento] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.departamento] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }

    function averageBySexo() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.sexo) === -1) {
                nombres2.push(respuesta.sexo);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.sexo] === 'undefined') {
                promedios[respuesta.cultura][respuesta.sexo] = 0;
                nombres[respuesta.cultura].push(respuesta.sexo);
                counts[respuesta.cultura][respuesta.sexo] = 0;
            }
            promedios[respuesta.cultura][respuesta.sexo] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.sexo] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }

    function averageByJerarquia() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.jerarquia) === -1) {
                nombres2.push(respuesta.jerarquia);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.jerarquia] === 'undefined') {
                promedios[respuesta.cultura][respuesta.jerarquia] = 0;
                nombres[respuesta.cultura].push(respuesta.jerarquia);
                counts[respuesta.cultura][respuesta.jerarquia] = 0;
            }
            promedios[respuesta.cultura][respuesta.jerarquia] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.jerarquia] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }

    function averageByEdad() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.edad) === -1) {
                nombres2.push(respuesta.edad);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.edad] === 'undefined') {
                promedios[respuesta.cultura][respuesta.edad] = 0;
                nombres[respuesta.cultura].push(respuesta.edad);
                counts[respuesta.cultura][respuesta.edad] = 0;
            }
            promedios[respuesta.cultura][respuesta.edad] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.edad] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }

    function averageByAntiguedad() {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.antiguedad) === -1) {
                nombres2.push(respuesta.antiguedad);
            }
            if (typeof nombres[respuesta.cultura] === 'undefined') {
                nombres[respuesta.cultura] = [];
                culturas.push(respuesta.cultura);
                promedios[respuesta.cultura] = [];
                counts[respuesta.cultura] = [];
            }
            if (typeof promedios[respuesta.cultura][respuesta.antiguedad] === 'undefined') {
                promedios[respuesta.cultura][respuesta.antiguedad] = 0;
                nombres[respuesta.cultura].push(respuesta.antiguedad);
                counts[respuesta.cultura][respuesta.antiguedad] = 0;
            }
            promedios[respuesta.cultura][respuesta.antiguedad] += parseInt(respuesta.calificacion);
            counts[respuesta.cultura][respuesta.antiguedad] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
        currentLabels2 = nombres2;
    }


    //CATEGORIAS

    function averageCategoriaByLugarDeTrabajo(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.lugarDeTrabajo] === 'undefined') {
                promedios[respuesta.categoria][respuesta.lugarDeTrabajo] = 0;
                nombres[respuesta.categoria].push(respuesta.lugarDeTrabajo);
                counts[respuesta.categoria][respuesta.lugarDeTrabajo] = 0;
            }
            promedios[respuesta.categoria][respuesta.lugarDeTrabajo] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.lugarDeTrabajo] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }

    function averageCategoriaByDepartamento(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.departamento] === 'undefined') {
                promedios[respuesta.categoria][respuesta.departamento] = 0;
                nombres[respuesta.categoria].push(respuesta.departamento);
                counts[respuesta.categoria][respuesta.departamento] = 0;
            }
            promedios[respuesta.categoria][respuesta.departamento] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.departamento] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }

    function averageCategoriaBySexo(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.sexo] === 'undefined') {
                promedios[respuesta.categoria][respuesta.sexo] = 0;
                nombres[respuesta.categoria].push(respuesta.sexo);
                counts[respuesta.categoria][respuesta.sexo] = 0;
            }
            promedios[respuesta.categoria][respuesta.sexo] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.sexo] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }

    function averageCategoriaByEdad(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.edad] === 'undefined') {
                promedios[respuesta.categoria][respuesta.edad] = 0;
                nombres[respuesta.categoria].push(respuesta.edad);
                counts[respuesta.categoria][respuesta.edad] = 0;
            }
            promedios[respuesta.categoria][respuesta.edad] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.edad] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }

    function averageCategoriaByJerarquia(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.jerarquia] === 'undefined') {
                promedios[respuesta.categoria][respuesta.jerarquia] = 0;
                nombres[respuesta.categoria].push(respuesta.jerarquia);
                counts[respuesta.categoria][respuesta.jerarquia] = 0;
            }
            promedios[respuesta.categoria][respuesta.jerarquia] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.jerarquia] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }

    function averageCategoriaByAntiguedad(currentCultura) {
        var promedios = [];
        var nombres = [];
        var nombres2 = [];
        var counts = [];
        var culturas = [];
        for (var i = 0; i < respuestas.length; i++) {
            var respuesta = respuestas[i];

            if (nombres2.indexOf(respuesta.lugarDeTrabajo) === -1) {
                nombres2.push(respuesta.lugarDeTrabajo);
            }
            if (respuesta.cultura != currentCultura) {
                continue;
            }
            if (typeof nombres[respuesta.categoria] === 'undefined') {
                nombres[respuesta.categoria] = [];
                culturas.push(respuesta.categoria);
                promedios[respuesta.categoria] = [];
                counts[respuesta.categoria] = [];
            }
            if (typeof promedios[respuesta.categoria][respuesta.antiguedad] === 'undefined') {
                promedios[respuesta.categoria][respuesta.antiguedad] = 0;
                nombres[respuesta.categoria].push(respuesta.antiguedad);
                counts[respuesta.categoria][respuesta.antiguedad] = 0;
            }
            promedios[respuesta.categoria][respuesta.antiguedad] += parseInt(respuesta.calificacion);
            counts[respuesta.categoria][respuesta.antiguedad] += 1;
        }

        currentLabels = nombres;
        currentPromedios = promedios;
        currentCulturas = culturas;
        currentCounts = counts;
    }


//GUARDAR GRAFICOS 
    function saveImg(div) {
        html2canvas($("#" + div), {
            onrendered: function(canvas) {
                var myImage = canvas.toDataURL("image/png");
                window.open(myImage);
            }
        });
    }

</script>