
<div id="bloqueLogin" class="bloque">
    <?php
    $login = array(
        'name' => 'login',
        'id' => 'login',
        'value' => set_value('login'),
        'maxlength' => 80,
        'size' => 30,
    );
    $login_label = "Usuario";
    $password = array(
        'name' => 'password',
        'id' => 'password',
        'size' => 30,
    );
    $remember = array(
        'name' => 'remember',
        'id' => 'remember',
        'value' => 1,
        'checked' => set_value('remember'),
        'style' => 'margin:0;padding:0',
    );
    ?>
    <?php echo form_open($this->uri->uri_string()); ?>
    <table>
        <tr>
            <td><?php echo form_label($login_label, $login['id']); ?></td>
            <td><?php echo form_input($login); ?></td>
            <td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Contrase&ntilde;a', $password['id']); ?></td>
            <td><?php echo form_password($password); ?></td>
            <td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></td>
        </tr>
    </table>
    <?php
    echo form_submit(array(
        "name" => 'submit',
        "value" => "Ingresar",
        "class" => "boton",
        "id" => "btnLogin"
    ));
    ?>
<?php echo form_close(); ?>
</div>
<div id="fin"></div>