<h2>Asignar Roles</h2>

<?php echo form_open('usuarios/asignarRolConfirmar'); ?>
    
    <div class="form-horizontal">
        <h4>Usuario <?php echo $user['username']; ?></h4>
        <hr />

	    <div class="form-group">
                <label for="varchar">Rol</label>
                <select class="form-control" name="role_id" id="role_id">
                    <?php 
                    foreach ($roles as $rol)
                    {
                        echo "<option value='$rol->id'>$rol->role - $rol->Descripcion</option>";
                    }
                    ?>
                </select>
            </div>
	    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" /> 

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Crear" class="btn btn-default" />
            </div>
        </div>
    </div>
<?php echo form_close(); ?>

    <a href="<?php echo base_url(); ?>usuarios/index">Regresar</a>
</div>
