<?php if ($this->excel != 1) { ?>
	<h1 class="titulo-principal"><i class="fas fa-cogs"></i>
		<?php echo $this->titlesection; ?>
	</h1>
	<div class="container-fluid">
		<form action="<?php echo $this->route; ?>" method="post">
			<div class="content-dashboard">
				<div class="row">

					<div class="col-3">
						<label>fecha inicio</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro "><i
										class="fas fa-calendar"></i></span>
							</div>
							<input type="date" class="form-control" name="fecha1ra"
								value="<?php echo $this->getObjectVariable($this->filters, 'fecha1ra') ?>" required></input>
						</label>
					</div>
					<div class="col-3">
						<label>fecha final</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro "><i
										class="fas fa-calendar"></i></span>
							</div>
							<input type="date" class="form-control" name="fecha2ra"
								value="<?php echo $this->getObjectVariable($this->filters, 'fecha2ra') ?>" required></input>
						</label>
					</div>


					<div class="col-3">
						<label>&nbsp;</label>
						<button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
					</div>
					<div class="col-3">
						<label>&nbsp;</label>
						<a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1"> <i
								class="fas fa-eraser"></i> Limpiar Filtro</a>
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
					<div class="col-3">
						<div class="titulo-registro">Se encontraron
							<?php echo $this->register_number; ?> Registros
						</div>
					</div>
					<div class="col-3 text-end">
						<div class="texto-paginas">Registros por pagina:</div>
					</div>
					<div class="col-1 text-start">

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
					<div class="col-5 text-end">
						<div class="text-right"><a class="btn btn-sm btn-success"
								href="<?php echo $this->route . "?excel=1"; ?>" target="_blank"> <i
									class="fa-regular fa-file-excel"></i>
								Exportar</a></div>
					</div>
				</div>
			</div>


			<div class="large-table-fake-top-scroll-container-3">
				<div>&nbsp;</div>
			</div>
			<div class="content-table">
			<?php } ?>



			<table border="1" cellpadding="2" cellspacing="0"
				class=" table table-striped  table-hover table-administrator text-left">
				<thead>
					<tr>
						<td>Orden</td>
						<td>Cedula</td>
						<td>Asociado</td>
						<td>Valor total</td>
						<td>cuotas</td>
						<td>fecha</td>

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
								<?= $content->cedula; ?>
							</td>
							<td>
								<?= ($content->nombre_usuario) ? $content->nombre_usuario : $content->nombre; ?>
							</td>
							<td>
								<?php if ($this->excel != 1) { ?>
									<?= number_format($content->total, 0, ".", "."); ?>
								<?php } else { ?>
									<?= $content->total; ?>
								<?php } ?>


							</td>
							<td>
								<?= $content->cuotas; ?>
							</td>

							<td>
								<?= $content->fecha; ?>
							</td>



						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php if ($this->excel != 1) { ?>

			</div>


			<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="order-route"
				value="<?php echo $this->route; ?>/order"><input type="hidden" id="page-route"
				value="<?php echo $this->route; ?>/changepage">
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


	<style>
		.large-table-fake-top-scroll-container-3 {
			max-width: 100%;
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
		document.addEventListener("DOMContentLoaded", function () {
			var tableContainer = $(".content-table");
			var table = $(".content-table table");
			var fakeContainer = $(".large-table-fake-top-scroll-container-3");
			var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

			var tableWidth = table.width();
			fakeDiv.width(tableWidth);

			fakeContainer.scroll(function () {
				tableContainer.scrollLeft(fakeContainer.scrollLeft());
			});
			tableContainer.scroll(function () {
				fakeContainer.scrollLeft(tableContainer.scrollLeft());
			});
		})
	</script>
<?php } ?>