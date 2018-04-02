
        <h2 style="margin-top:0px">Se_usuariosencuestas <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="varchar">sexo <?php echo form_error('sexo') ?></label>
                <input type="text" class="form-control" name="sexo" id="sexo" placeholder="sexo" value="<?php echo $sexo; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">edad <?php echo form_error('edad') ?></label>
                <input type="text" class="form-control" name="edad" id="edad" placeholder="edad" value="<?php echo $edad; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">antiguedad <?php echo form_error('antiguedad') ?></label>
                <input type="text" class="form-control" name="antiguedad" id="antiguedad" placeholder="antiguedad" value="<?php echo $antiguedad; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">jerarquia <?php echo form_error('jerarquia') ?></label>
                <input type="text" class="form-control" name="jerarquia" id="jerarquia" placeholder="jerarquia" value="<?php echo $jerarquia; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">idLugarTrabajo <?php echo form_error('idLugarTrabajo') ?></label>
                <input type="text" class="form-control" name="idLugarTrabajo" id="idLugarTrabajo" placeholder="idLugarTrabajo" value="<?php echo $idLugarTrabajo; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">idDepartamento <?php echo form_error('idDepartamento') ?></label>
                <input type="text" class="form-control" name="idDepartamento" id="idDepartamento" placeholder="idDepartamento" value="<?php echo $idDepartamento; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">idEncuesta <?php echo form_error('idEncuesta') ?></label>
                <input type="text" class="form-control" name="idEncuesta" id="idEncuesta" placeholder="idEncuesta" value="<?php echo $idEncuesta; ?>" />
            </div>
	    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('se_usuariosencuestas') ?>" class="btn btn-default">Cancelar</a>
	</form>