<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
		<div class="content-dashboard">
			<div class="row">
				<div class="col-3">
					<label>cedula</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="cedula" value="<?php echo $this->getObjectVariable($this->filters, 'cedula') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>email</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="email" value="<?php echo $this->getObjectVariable($this->filters, 'email') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>placa</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="placa" value="<?php echo $this->getObjectVariable($this->filters, 'placa') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="fecha" value="<?php echo $this->getObjectVariable($this->filters, 'fecha') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>valor</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-morado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" class="form-control" name="valor" value="<?php echo $this->getObjectVariable($this->filters, 'valor') ?>"></input>
					</label>
				</div>
				<div class="col-3">
					<label>estado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-azul "><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="estado">
							<?php foreach ($this->list_estado as $key => $value) : ?>
								<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado') ==  $key) {
																	echo "selected";
																} ?>><?= $value; ?></option>
							<?php endforeach ?>
						</select>
					</label>
				</div>
				<div class="col-3">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
				</div>
				<div class="col-3">
					<label>&nbsp;</label>
					<a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1"> <i class="fas fa-eraser"></i> Limpiar Filtro</a>
				</div>
			</div>
		</div>
	</form>


	<div align="center">
		<ul class="pagination justify-content-center mt-5">
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
					<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
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
					<div class="text-right"><a class="btn btn-sm btn-success" href="<?php echo $this->route . "\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
				</div>
			</div>
		</div>
		<?php if($this->msg_enviar && $this->res):?>
		<div class="alert alert-<?php echo $this->res?> mt-3" role="alert">
		<?php echo $this->msg_enviar?>
		</div>
		<?php endif ?>
		<div class="large-table-fake-top-scroll-container-3">
			<div>&nbsp;</div>
		</div>
		<div class="content-table">
			<table class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>id</td>
						<td>cedula</td>
						<td>nombre</td>
						<td>email</td>
						<td>placa</td>
						<td>fecha</td>
						<td>valor</td>
						<td>estado</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->lists as $content) { ?>
						<?php $id =  $content->id; ?>
						<tr>
							<td><?= $content->id; ?></td>
							<td><?= $content->cedula; ?></td>
							<td><?= $content->nombre; ?></td>
							<td><?= $content->email; ?></td>
							<td><?= $content->placa; ?></td>
							<td><?= $content->fecha; ?></td>
							<td><?= $content->valor; ?></td>
							<td><?= $this->list_estado[$content->estado]; ?>
							<td class="text-right">
								<div>
									<a class="btn btn-morado btn-sm" href="<?php echo $this->route; ?>/enviarpdf?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Enviar PDF"><i class="fa-solid fa-file-pdf"></i></a>
									<a class="btn btn-verde btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>

									<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt"></i></a></span>
								</div>
								<!-- Modal -->
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
												<a class="btn btn-danger" href="<?php echo $this->route; ?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf; ?><?php echo ''; ?>">Eliminar</a>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
	</div>
	<div align="center">
		<ul class="pagination justify-content-center mt-5">
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
<style>
	.large-table-fake-top-scroll-container-3 {
		max-width: 90%;
		overflow-x: scroll;
		overflow-y: auto;
	}

	.large-table-fake-top-scroll-container-3 div {
		background-color: red;
		font-size: 1px;
		line-height: 1px;
	}
</style>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var tableContainer = $(".content-table");
		var table = $(".content-table table");
		var fakeContainer = $(".large-table-fake-top-scroll-container-3");
		var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

		var tableWidth = table.width();
		fakeDiv.width(tableWidth);

		fakeContainer.scroll(function() {
			tableContainer.scrollLeft(fakeContainer.scrollLeft());
		});
		tableContainer.scroll(function() {
			fakeContainer.scrollLeft(tableContainer.scrollLeft());
		});
	})
</script>