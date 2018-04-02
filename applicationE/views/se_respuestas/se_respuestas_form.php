
        <h2 style="margin-top:0px">Se_respuestas <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="int">calificacion <?php echo form_error('calificacion') ?></label>
                <input type="text" class="form-control" name="calificacion" id="calificacion" placeholder="calificacion" value="<?php echo $calificacion; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">idPregunta <?php echo form_error('idPregunta') ?></label>
                <input type="text" class="form-control" name="idPregunta" id="idPregunta" placeholder="idPregunta" value="<?php echo $idPregunta; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">idUsuario <?php echo form_error('idUsuario') ?></label>
                <input type="text" class="form-control" name="idUsuario" id="idUsuario" placeholder="idUsuario" value="<?php echo $idUsuario; ?>" />
            </div>
	    <input type="hidden" name="idRespuesta" value="<?php echo $idRespuesta; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('se_respuestas') ?>" class="btn btn-default">Cancelar</a>
	</form>