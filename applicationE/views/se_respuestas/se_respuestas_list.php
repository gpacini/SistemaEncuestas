
        <h2 style="margin-top:0px">Se_respuestas List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('se_respuestas/create'),'Crear', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('se_respuestas/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('se_respuestas'); ?>" class="btn btn-default">Reset</a>
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
		<th>calificacion</th>
		<th>idPregunta</th>
		<th>idUsuario</th>
		<th>Action</th>
            </tr><?php
            foreach ($se_respuestas_data as $se_respuestas)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
			<td><?php echo $se_respuestas->calificacion ?></td>
			<td><?php echo $se_respuestas->idPregunta ?></td>
			<td><?php echo $se_respuestas->idUsuario ?></td>
			<td style="text-align:center">
				<?php 
				echo anchor(site_url('se_respuestas/read/'.$se_respuestas->idRespuesta),'Ver'); 
				echo ' | '; 
				echo anchor(site_url('se_respuestas/update/'.$se_respuestas->idRespuesta),'Actualizar'); 
				echo ' | '; 
				echo anchor(site_url('se_respuestas/delete/'.$se_respuestas->idRespuesta),'Eliminar','onclick="javasciprt: return confirm(\'Esta seguro de eliminar ?\')"'); 
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