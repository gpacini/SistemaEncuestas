
<h2 style="margin-top:0px">Encuesta</h2><div id="successMessage"></div>
<div class="tab-titulo"> <h2 class="form-control btn btn-info" onclick="openTab('datosEncuesta');" >Datos Encuesta</h2>
    <div class="tab-contenido" id="tab-datosEncuesta">
        <div id="datosEncuestaErrores"></div>
        <h3>Datos Encuesta</h3>
        <div class="col-md-12">
            <form method="post" id="form-encuesta">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Nombre Encuesta </label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre Encuesta" value="<?php echo $nombre; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Titulo Encuesta </label>
                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo Encuesta" value="<?php echo $titulo; ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Empresa </label>
                        <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Empresa" value="<?php echo $empresa; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Total Encuestados </label>
                        <input type="text" class="form-control" name="totalEncuestados" id="totalEncuestados" placeholder="Total Encuestados" value="<?php echo $totalEncuestados; ?>" />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="varchar">Mensaje Preliminar </label>
                    <textarea style='height: 500px;' class="form-control" name="mensaje" id="mensaje" placeholder="Mensaje Preliminar" value="" ><?php echo $mensaje; ?></textarea>
                </div>
                <input type="hidden" name="idEncuestas" class="idEncuesta"  value="<?php echo $idEncuestas; ?>" />
            </form>
        </div>
        <div  class="col-md-12">
            <button type="submit" class="btn btn-primary" onclick="guardarDatosEncuesta();">Guardar Avance</button> 
        </div>
    </div>
</div>
<div class="tab-titulo"> <h2 class="form-control btn btn-info" onclick="openTab('datosCulturasCategorias');" >Culturas y Categorias</h2>
    <div class="tab-contenido" id="tab-datosCulturasCategorias">
        <div id="datosCulturasCategoriasErrores"></div>
        <div class="contenidoCulturas">
        <h3>Culturas</h3>
            <?php if ($countCulturas == 0) { ?>
            <form method="post" class="form-cultura">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="varchar">Cultura </label>
                        <input type="text" class="form-control nombre_cultura" name="nombre" placeholder="Nombre de Cultura" value="" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="create" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idCultura" class="idCultura" value="" />
            </form>
        <?php
            } else {
                foreach ($culturas as $cultura) {
                    ?>
            <form method="post" class="form-cultura">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="varchar">Cultura </label>
                        <input type="text" class="form-control nombre_cultura" name="nombre" placeholder="Nombre de Cultura" value="<?php echo $cultura->nombre; ?>" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="update" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idCultura" class="idCultura" value="<?php echo $cultura->idCultura; ?>" />
            </form>
            <?php } } ?>
        </div>
        <div class="col-md-12" >
            <button type="submit" class="btn btn-primary ultimoItemForm" onclick="agregarCultura();">Agregar Cultura</button> <br />
        </div>
        <div  class="col-md-12">
            <button type="submit" class="btn btn-primary" onclick="guardarCulturasCategorias();">Guardar Avance</button> 
        </div>
        <div class="contenidoCategorias">
        <h3>Categorias</h3>
            <?php if ($countCategorias == 0) { ?>
            <form method="post" class="form-categoria">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="varchar">Categoria </label>
                        <input type="text" class="form-control nombre_categoria" name="nombre" placeholder="Nombre de Categoria" value="" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="create" />
                <input type="hidden" name="idEncuesta" class="idEncuesta"  value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idCategoria" class="idCategoria" value="" />
            </form>
        <?php
            } else {
                foreach ($categorias as $categoria) {
                    ?>
            <form method="post" class="form-categoria">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="varchar">Categoria </label>
                        <input type="text" class="form-control nombre_categoria" name="nombre" placeholder="Nombre de Categoria" value="<?php echo $categoria->nombre; ?>" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="update" />
                <input type="hidden" name="idEncuesta" class="idEncuesta"  value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idCategoria" class="idCategoria" value="<?php echo $categoria->idCategoria; ?>" />
            </form>
            <?php } } ?>
        </div>
        <div class="col-md-12" >
            <button type="submit" class="btn btn-primary ultimoItemForm" onclick="agregarCategoria();">Agregar Categoria</button> <br />
        </div>
        <div  class="col-md-12">
            <button type="submit" class="btn btn-primary" onclick="guardarCulturasCategorias();">Guardar Avance</button> 
        </div>
    </div>
</div>
<div class="tab-titulo"> <h2 class="form-control btn btn-info" onclick="openTab('datosDemograficos');" >Datos Demograficos</h2>
    <div class="tab-contenido" id="tab-datosDemograficos">
        <div id="datosDemograficosErrores"></div>
        <div class="contenidoLugaresDeTrabajo">
        <h3>Lugares de Trabajo</h3>
            <?php if ($countLugaresDeTrabajo == 0) { ?>
        <form method="post" class="form-lugarDeTrabajo">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Lugar de Trabajo </label>
                        <input type="text" class="form-control lugarDeTrabajo" name="nombre" placeholder="Lugar de Trabajo" value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int">Encuestados </label>
                        <input type="text" class="form-control totalPersonas" name="totalPersonas" placeholder="Total Encuestados" value="" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="create" />
                <input type="hidden" name="idEncuesta" class="idEncuesta"  value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idLugarTrabajo" value="" /> 
            </form>
        <?php
            } else {
                foreach ($lugaresDeTrabajo as $lugarDeTrabajo) {
                    ?>
        <form method="post" class="form-lugarDeTrabajo">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Lugar de Trabajo </label>
                        <input type="text" class="form-control lugarDeTrabajo" name="nombre" placeholder="Lugar de Trabajo" value="<?php echo $lugarDeTrabajo->nombre; ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int">Encuestados </label>
                        <input type="text" class="form-control totalPersonas" name="totalPersonas" placeholder="Total Encuestados" value="<?php echo $lugarDeTrabajo->totalPersonas; ?>" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="update" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idLugarTrabajo" class="idLugarDeTrabajo" value="<?php echo $lugarDeTrabajo->idLugarTrabajo; ?>" /> 
            </form>
            <?php }}?>
        </div>
        <div class="col-md-12" >
            <button type="submit" class="btn btn-primary ultimoItemForm" onclick="agregarLugarDeTrabajo();">Agregar Otro Lugar de Trabajo</button> <br />
        </div>
        <div  class="col-md-12">
            <button type="submit" class="btn btn-primary" onclick="guardarDatosDemograficos();">Guardar Avance</button> 
        </div>
        <div class="contenidoDepartamentos">
        <h3>Departamentos</h3>
            <?php if ($countDepartamentos == 0) { ?>
        <form method="post" class="form-departamento">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Departamento </label>
                        <input type="text" class="form-control departamento" name="nombre" placeholder="Departamento" value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int">Encuestados </label>
                        <input type="text" class="form-control totalPersonas" name="totalPersonas" placeholder="Total Encuestados" value="" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="create" />
                <input type="hidden" name="idEncuesta" class="idEncuesta"  value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idDepartamento" value="" /> 
            </form>
        <?php
            } else {
                foreach ($departamentos as $departamento) {
                    ?>
        <form method="post" class="form-departamento">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Departamento </label>
                        <input type="text" class="form-control lugarDeTrabajo" name="nombre" placeholder="Lugar de Trabajo" value="<?php echo $departamento->nombre; ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int">Encuestados </label>
                        <input type="text" class="form-control totalPersonas" name="totalPersonas" placeholder="Total Encuestados" value="<?php echo $departamento->totalPersonas; ?>" />
                    </div>
                </div>
                <input type="hidden" class="accion" value="update" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idLugarTrabajo" value="<?php echo $departamento->idDepartamento; ?>" /> 
            </form>
            <?php }}?>
        </div>
        <div class="col-md-12" >
            <button type="submit" class="btn btn-primary ultimoItemForm" onclick="agregarDepartamento();">Agregar Otro Departamento</button> <br />
        </div>
        <div  class="col-md-12">
            <button type="submit" class="btn btn-primary" onclick="guardarDatosDemograficos();">Guardar Avance</button> 
        </div>
    </div>
</div>

<div class="tab-titulo"> <h2 class="form-control btn btn-info" onclick="openPreguntasTab();" >Preguntas</h2>
    <div class="tab-contenido" id="tab-datosPreguntas">
        <div id="datosPreguntasErrores"></div>
        <div class="contenidoPreguntas">
        <h3>Preguntas</h3>
            <?php if ($countPreguntas == 0) { ?>
            <form method="post" class="form-pregunta">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="varchar">Pregunta </label>
                        <input type="text" class="form-control pregunta" name="pregunta" placeholder="Pregunta" value="" />
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="varchar">Cultura </label>
                        <div class="pregunta_cultura_placeholder"></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="varchar">Categoria </label>
                        <div class="pregunta_categoria_placeholder"></div>
                    </div>
                </div>
                <input type="hidden" class="accion" value="create" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idPregunta" class="idPregunta" value="" />
            </form>
        <?php
            } else {
                foreach ($preguntas as $pregunta) {
                    ?>
            <form method="post" class="form-pregunta">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="varchar">Pregunta </label>
                        <input type="text" class="form-control pregunta" name="pregunta" placeholder="Pregunta" value="<?php echo $pregunta->pregunta; ?>" />
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="varchar">Cultura </label>
                        <div class="pregunta_cultura_placeholder"></div>
                        <div style="display: none;" class='cultura_value' ><?php echo $pregunta->idCultura; ?></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="varchar">Categoria </label>
                        <div class="pregunta_categoria_placeholder"></div>
                        <div style="display: none;" class='categoria_value' ><?php echo $pregunta->idCategoria; ?></div>
                    </div>
                </div>
                <input type="hidden" class="accion" value="update" />
                <input type="hidden" name="idEncuesta" class="idEncuesta" value="<?php echo $idEncuestas; ?>" />
                <input type="hidden" name="idPregunta" class="idPregunta" value="<?php echo $pregunta->idPregunta; ?>" />
            </form>
            <?php } } ?>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" >
            <button type="submit" class="btn btn-primary ultimoItemForm" onclick="agregarPregunta();">Agregar Pregunta</button> <br />
        </div>
        <div  class="col-md-12 col-sm-12 col-xs-12">
            <button type="submit" class="btn btn-primary" onclick="guardarDatosPreguntas();">Guardar Avance</button> 
        </div>
    </div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12">
    <br />
<a href="<?php echo site_url('se_encuestas') ?>" class="btn btn-default">Cancelar</a>
</div>

<script>
<?php
echo "var urlDatosEncuesta = '" . site_url('se_encuestas/create_action') . "';";
echo "var urlDatosEncuestaUpdate = '" . site_url('se_encuestas/update_action') . "';";
echo "var urlCulturas = '" . site_url('se_culturas/create_action') . "';";
echo "var urlCulturasUpdate = '" . site_url('se_culturas/update_action') . "';";
echo "var urlCategorias = '" . site_url('se_categorias/create_action') . "';";
echo "var urlCategoriasUpdate = '" . site_url('se_categorias/update_action') . "';";
echo "var urlDepartamentos = '" . site_url('se_departamentos/create_action') . "';";
echo "var urlDepartamentosUpdate = '" . site_url('se_departamentos/update_action') . "';";
echo "var urlLugaresDeTrabajo = '" . site_url('se_lugaresdetrabajo/create_action') . "';";
echo "var urlLugaresDeTrabajoUpdate = '" . site_url('se_lugaresdetrabajo/update_action') . "';";
echo "var urlPreguntas = '" . site_url('se_preguntas/create_action') . "';";
echo "var urlPreguntasUpdate = '" . site_url('se_preguntas/update_action') . "';";
echo "var action='" . $action . "';";
?>
</script>