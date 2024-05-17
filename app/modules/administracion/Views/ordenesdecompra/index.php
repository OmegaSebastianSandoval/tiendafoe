<h1 class="titulo-principal"><i class="fas fa-cogs"></i>
	<?php echo $this->titlesection; ?>
</h1>
<div class="container-fluid">

	<div align="center">
		<ul class="pagination justify-content-center mt-2">
			<?php
			$url = $this->route;
			$min = $this->page - 10;
			if ($min < 0) {
				$min = 1;
			}
			$max = $this->page + 10;
			if ($this->totalpages > 1) {
				if ($this->page != 1)
					echo '<li class="page-item" ><a class="page-link"  href="' . $url . '?page=' . ($this->page - 1) . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else {
						if ($i <= $max and $i >= $min) {
							echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>  ';
						}
					}
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
			}
			?>
		</ul>
	</div>

	<div class="content-dashboard">
		<div class="franja-paginas">
			<div class="row">
				<div class="col-5">
					<div class="titulo-registro">Se encontraron
						<?php echo $this->register_number; ?> Registros
					</div>
				</div>
				<div class="col-3 text-right">
					<div class="texto-paginas">Registros por pagina:</div>
				</div>
				<div class="col-1">
					<select class="form-control form-control-sm selectpagination">
						<option value="20" <?php if ($this->pages == 20) {
												echo 'selected';
											} ?>>20</option>
						<option value="30" <?php if ($this->pages == 30) {
												echo 'selected';
											} ?>>30</option>
						<option value="50" <?php if ($this->pages == 50) {
												echo 'selected';
											} ?>>50</option>
						<option value="100" <?php if ($this->pages == 100) {
												echo 'selected';
											} ?>>100</option>
					</select>
				</div>
				<div class="col-3">
					<div class="text-right d-none"><a class="btn btn-sm btn-success" href="<?php echo $this->route . "\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear
							Nuevo</a></div>
				</div>
			</div>
		</div>

		<?php if ($this->msg_enviar && $this->res) : ?>
			<div class="alert alert-<?php echo $this->res ?> mt-3" role="alert">
				<?php echo $this->msg_enviar ?>
			</div>
		<?php endif ?>

		<div class="content-table">


			<table class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>Orden</td>
						<td>fecha</td>
						<td>cedula</td>
						<td>nombre</td>
						<td width="150"></td>


					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->lists as $content) { ?>
						<?php $id = $content->id;
						?>
						<tr>
							<td>
								<?= $content->orden . "V"; ?>
							</td>
							<td>
								<?= $content->fecha; ?>
							</td>
							<td>
								<?= $content->cedula; ?>
							</td>
							<td>
								<?= $content->nombre; ?>
							</td>


							<td>
								<a class="btn btn-verde btn-sm" href="<?php echo $this->route; ?>/generarenvio?cedula=<?php echo $content->cedula; ?>&orden=<?php echo $content->orden; ?>&reenvio=1" data-bs-toggle="tooltip" data-placement="top" title="Reenviar Pagaré"><i class="fa-solid fa-comment-dollar"></i></a>
								<!-- <a class="btn btn-rojo btn-sm" href="<?php echo $this->route; ?>/anular?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Anular Orden"><i class="fa-solid fa-xmark"></i></a> -->

								<span data-bs-toggle="tooltip" data-placement="top" title="Anular Orden"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#anular<?= $id ?>"><i class="fa-solid fa-xmark"></i></a></span>
								<div class="modal fade text-left" id="anular<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										  <div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Anular orden</h4>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								  
											</div>
									  <div class="modal-body">
										<div class="">¿Esta seguro de anular esta orden?</div>
									  </div>
									  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
											<a class="btn btn-danger" href="<?php echo $this->route; ?>/anular?id=<?= $id ?>&csrf=<?= $this->csrf; ?><?php echo ''; ?>" >Anular</a>
									  </div>
									</div>
								  </div>
							</div>
							</td>
							<!-- <td>
							<input type="hidden" id="<?= $id; ?>" value="<?= $content->orden; ?>"></input>
							<button class="up_table btn btn-primary btn-sm"><i class="fas fa-angle-up"></i></button>
							<button class="down_table btn btn-primary btn-sm"><i class="fas fa-angle-down"></i></button>
						</td> -->
							<!-- <td class="text-right">
							<div>
								<a class="btn btn-azul btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>"  data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
								<span  data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm"  data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
							</div>
							
							<div class="modal fade text-left" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
										  <div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								  
											</div>
									  <div class="modal-body">
										<div class="">¿Esta seguro de eliminar este registro?</div>
									  </div>
									  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
											<a class="btn btn-danger" href="<?php echo $this->route; ?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf; ?><?php echo ''; ?>" >Eliminar</a>
									  </div>
									</div>
								  </div>
							</div>
						</td> -->
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>


		<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="order-route" value="<?php echo $this->route; ?>/order"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
	</div>
	<div align="center">
		<ul class="pagination justify-content-center">
			<?php
			$url = $this->route;
			$min = $this->page - 10;
			if ($min < 0) {
				$min = 1;
			}
			$max = $this->page + 10;
			if ($this->totalpages > 1) {
				if ($this->page != 1)
					echo '<li class="page-item" ><a class="page-link"  href="' . $url . '?page=' . ($this->page - 1) . '"> &laquo; Anterior </a></li>';
				for ($i = 1; $i <= $this->totalpages; $i++) {
					if ($this->page == $i)
						echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
					else {
						if ($i <= $max and $i >= $min) {
							echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>  ';
						}
					}
				}
				if ($this->page != $this->totalpages)
					echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
			}
			?>
		</ul>
	</div>
</div>