<h2>Editar</h2>

<?php
$oculto = array("id" => $user['id']);
echo form_open('usuarios/editarconfirmar', '', $oculto);
?>

<div class="form-horizontal">
    <h4>Usuario</h4>
    <hr />
    <div class="form-group col-md-6">
        <div class="col-md-12">
            <label for="username" class="control-label">Username</label>
            <?php echo form_input("username", $user['username'], "class='form-control'"); ?>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="col-md-12">
            <label for="username" class="control-label">Password</label>
            <?php echo form_input("password", '', "class='form-control'"); ?>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="col-md-12">
            <label for="username" class="control-label">Email</label>
            <?php echo form_input("Email", $user['email'], "class='form-control'"); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <input type="submit" value="Agregar" class="btn btn-primary" />
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<a href="<?php echo base_url(); ?>usuarios/index">Regresar</a>

<style>
    #contenido{
        max-width: 1400px;
        padding: 0 10%;
        margin: 0 auto;
    }
</style>
