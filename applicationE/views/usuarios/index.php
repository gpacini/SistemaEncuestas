<h2>Usuarios</h2>

<p>
    <a class="btn btn-primary" href="<?php echo base_url(); ?>usuarios/crear">Agregar Usuario<a/>
</p>

<table class="table table-bordered">
    <thead>
        <th>
            Nombre de Usuario
        </th>
        <th>            
            Correo Electr&oacute;nico
        </th>
        <th></th>
    </thead>
<?php 
foreach ($usuarios as $user) 
    {
    echo "<tr>";
    echo    "<td>";
    echo        $user['username'];
    echo    "</td>";
    echo    "<td>";
    echo        $user['email'];
    echo    "</td>";
    echo    "<td>";
    echo        "<a href='".base_url()."usuarios/editar/".$user['id']."' >Editar</a>";
    echo "</tr>";
}

?>
</table>

<?php echo $paginacion; ?>

<style>
    #contenido{
        max-width: 1400px;
        padding: 0 10%;
        margin: 0 auto;
    }
</style>