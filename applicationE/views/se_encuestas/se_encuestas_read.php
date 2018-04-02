<h2 style="margin-top:0px">Encuesta <?php echo $nombre; ?></h2>
<table class="table">
    <tr><td>Nombre</td><td><?php echo $nombre; ?></td></tr>
    <tr><td>Link de la Encuesta</td><td><?php echo site_url("encuesta/".$idEncuestas); ?></td></tr>
    <tr><td>Título</td><td><?php echo $titulo; ?></td></tr>
    <tr><td>Mensaje</td><td><?php echo nl2br($mensaje); ?></td></tr>
    <tr><td>Empresa</td><td><?php echo $empresa; ?></td></tr>
    <tr><td>Total A Encuestar</td><td><?php echo $totalEncuestados; ?></td></tr>
    <tr><td>Total Encuestados</td><td><?php echo $encuestados; ?></td></tr>
</table>

<a href="<?php echo site_url('se_encuestas/resultados/'.$idEncuestas) ?>" class="btn btn-primary">Ver Resultados</a>
<a href="<?php echo site_url('se_encuestas/calificaciones/'.$idEncuestas) ?>" class="btn btn-primary">Ver Calificaciones</a>
<a href="<?php echo site_url('se_encuestas/estadisticas/'.$idEncuestas) ?>" class="btn btn-primary">Ver Estadisticas</a>

<h3>Estadísticas</h3>

<table class="table">
    <tr><th>Por Lugar de Trabajo</th><td></td><td></td><td></td><td></td></tr>
    <tr>
        <th>Lugar</th>
        <th>A encuestar</th>
        <th>Encuestados</th>
        <th>% del Lugar</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($lugaresDeTrabajo as $lugarDeTrabajo){
        ?>
    <tr>
        <td><?php echo $lugarDeTrabajo->nombre; ?></td>
        <td><?php echo $lugarDeTrabajo->totalPersonas; ?></td>
        <td><?php echo $lugarDeTrabajo->encuestados; ?></td>
        <td><?php echo number_format(((100 * $lugarDeTrabajo->encuestados)/$lugarDeTrabajo->totalPersonas), 2, '.', ''); ?></td>
        <td><?php echo number_format(((100 * $lugarDeTrabajo->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
    <tr><th>Por Departamento</th><td></td><td></td><td></td><td></td></tr>
    <tr>
        <th>Departamento</th>
        <th>A encuestar</th>
        <th>Encuestados</th>
        <th>% del Departamento</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($departamentos as $departamento){
        ?>
    <tr>
        <td><?php echo $departamento->nombre; ?></td>
        <td><?php echo $departamento->totalPersonas; ?></td>
        <td><?php echo $departamento->encuestados; ?></td>
        <td><?php echo number_format(((100 * $departamento->encuestados)/$departamento->totalPersonas), 2, '.', ''); ?></td>
        <td><?php echo number_format(((100 * $departamento->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
</table>

<table class="table">
    <tr><th>Por Sexo</th><td></td><td></td></tr>
    <tr>
        <th>Sexo</th>
        <th>Encuestados</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($sexos as $sexo){
        ?>
    <tr>
        <td><?php echo $sexo->display; ?></td>
        <td><?php echo $sexo->encuestados; ?></td>
        <td><?php echo number_format(((100 * $sexo->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
    <tr><th>Por Edad</th><td></td><td></td></tr>
    <tr>
        <th>Edad</th>
        <th>Encuestados</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($edades as $edad){
        ?>
    <tr>
        <td><?php echo $edad->display; ?></td>
        <td><?php echo $edad->encuestados; ?></td>
        <td><?php echo number_format(((100 * $edad->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
    <tr><th>Por Antigüedad</th><td></td><td></td></tr>
    <tr>
        <th>Antigüedad</th>
        <th>Encuestados</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($antiguedades as $antiguedad){
        ?>
    <tr>
        <td><?php echo $antiguedad->display; ?></td>
        <td><?php echo $antiguedad->encuestados; ?></td>
        <td><?php echo number_format(((100 * $antiguedad->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
    <tr><th>Por Jerarquía</th><td></td><td></td></tr>
    <tr>
        <th>Jerarquía</th>
        <th>Encuestados</th>
        <th>% del Total</th>
    </tr>
    <?php foreach($jerarquias as $jerarquia){
        ?>
    <tr>
        <td><?php echo $jerarquia->display; ?></td>
        <td><?php echo $jerarquia->encuestados; ?></td>
        <td><?php echo number_format(((100 * $jerarquia->encuestados)/($encuestados>0?$encuestados : 1)), 2, '.', ''); ?></td>
    </tr>
    <?php } ?>
</table>

<a href="<?php echo site_url('se_encuestas/resultados/'.$idEncuestas) ?>" class="btn btn-primary">Ver Resultados</a>
<a href="<?php echo site_url('se_encuestas/calificaciones/'.$idEncuestas) ?>" class="btn btn-primary">Ver Calificaciones</a>
<a href="<?php echo site_url('se_encuestas/estadisticas/'.$idEncuestas) ?>" class="btn btn-primary">Ver Estadisticas</a>
<a href="<?php echo site_url('se_encuestas') ?>" class="btn btn-default">Atrás</a>