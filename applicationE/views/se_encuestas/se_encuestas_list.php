
        <h2 style="margin-top:0px">Encuestas</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('se_encuestas/create'),'Crear', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('se_encuestas/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('se_encuestas'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nombre</th>
		<th>Titulo</th>
		<th>Empresa</th>
		<th>Total A Encuestar</th>
		<th>Total Encuestados</th>
		<th>Action</th>
            </tr><?php
            foreach ($se_encuestas_data as $se_encuestas)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
			<td><?php echo $se_encuestas->nombre ?></td>
			<td><?php echo $se_encuestas->titulo ?></td>
			<td><?php echo $se_encuestas->empresa ?></td>
			<td><?php echo $se_encuestas->totalEncuestados ?></td>
			<td><?php echo $se_encuestas->encuestados ?></td>
			<td style="text-align:center">
				<?php 
				echo anchor(site_url('se_encuestas/read/'.$se_encuestas->idEncuestas),'Ver'); 
				echo ' | '; 
				echo anchor(site_url('se_encuestas/update/'.$se_encuestas->idEncuestas),'Actualizar'); 
				echo ' | '; 
				echo anchor(site_url('se_encuestas/delete/'.$se_encuestas->idEncuestas),'Eliminar','onclick="javasciprt: return confirm(\'Esta seguro de eliminar ?\')"'); 
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