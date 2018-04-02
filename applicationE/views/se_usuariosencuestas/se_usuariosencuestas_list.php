
        <h2 style="margin-top:0px">Se_usuariosencuestas List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('se_usuariosencuestas/create'),'Crear', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('se_usuariosencuestas/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('se_usuariosencuestas'); ?>" class="btn btn-default">Reset</a>
                        <?php
                    }
                    ?>
                    <input type="submit" value="Buscar" class="btn btn-primary" />
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>sexo</th>
		<th>edad</th>
		<th>antiguedad</th>
		<th>jerarquia</th>
		<th>idLugarTrabajo</th>
		<th>idDepartamento</th>
		<th>idEncuesta</th>
		<th>Action</th>
            </tr><?php
            foreach ($se_usuariosencuestas_data as $se_usuariosencuestas)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
			<td><?php echo $se_usuariosencuestas->sexo ?></td>
			<td><?php echo $se_usuariosencuestas->edad ?></td>
			<td><?php echo $se_usuariosencuestas->antiguedad ?></td>
			<td><?php echo $se_usuariosencuestas->jerarquia ?></td>
			<td><?php echo $se_usuariosencuestas->idLugarTrabajo ?></td>
			<td><?php echo $se_usuariosencuestas->idDepartamento ?></td>
			<td><?php echo $se_usuariosencuestas->idEncuesta ?></td>
			<td style="text-align:center">
				<?php 
				echo anchor(site_url('se_usuariosencuestas/read/'.$se_usuariosencuestas->idUsuario),'Ver'); 
				echo ' | '; 
				echo anchor(site_url('se_usuariosencuestas/update/'.$se_usuariosencuestas->idUsuario),'Actualizar'); 
				echo ' | '; 
				echo anchor(site_url('se_usuariosencuestas/delete/'.$se_usuariosencuestas->idUsuario),'Eliminar','onclick="javasciprt: return confirm(\'Esta seguro de eliminar ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>