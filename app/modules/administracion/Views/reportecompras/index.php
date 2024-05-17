<?php
$estilo1 = 'style="background:#DEEBF6;"';
$estilo2 = 'style="background:#C5E0B2;"';
?>

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
							<input type="date" required class="form-control" name="fecha1"
								value="<?php echo $this->getObjectVariable($this->filters, 'fecha1') ?>"></input>
						</label>
					</div>
					<div class="col-3">
						<label>fecha final</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro "><i
										class="fas fa-calendar"></i></span>
							</div>
							<input type="date" required class="form-control" name="fecha2"
								value="<?php echo $this->getObjectVariable($this->filters, 'fecha2') ?>"></input>
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


			<?php
			/* echo "<pre>";
					 print_r($this->lists);
					 echo "</pre>"; */
			?>

			<table class="table  table-bordered" width="100" border="1" cellpadding="0" cellspacing="0" style="border-color: gray;">
				<col width="255" />
				<col width="363" />
				<col width="262" />
				<tr height="22" <?php echo $estilo1; ?>>
					<td colspan="3" height="22" width="880">FORMATO DE PEDIDO CLIENTE INSTITUCIONAL POR INTERNET&nbsp;
					</td>
				</tr>
				<tr height="22" <?php echo $estilo1; ?>>
					<td rowspan="2" height="44">&nbsp;ASESOR INSTITUCIONAL&nbsp;</td>
					<td>&nbsp;NOMBRE&nbsp;</td>
					<td>
						<p align="left"><strong>HAROLD FELIPE MU&Ntilde;OZ&nbsp; FRANCO<u></u><u></u></strong></p>
					</td>
				</tr>
				<tr height="22" <?php echo $estilo1; ?>>
					<td height="22">CELULAR</td>
					<td>
						<p align="left"><strong>3185860598</strong></p>
					</td>
				</tr>
				<tr height="22" <?php echo $estilo1; ?>>
					<td height="22">&nbsp;</td>
					<td>&nbsp;</td>
					<td>
						<div align="left"></div>
					</td>
				</tr>
				<tr height="22" <?php echo $estilo1; ?>>
					<td rowspan="2" height="44">CARTERA&nbsp;</td>
					<td>&nbsp;NIT&nbsp;</td>
					<td>
						<div align="left"><strong>860.011.265-2</strong></div>
					</td>
				</tr>
				<tr height="22" <?php echo $estilo1; ?>>
					<td height="22">CLIENTE INSTITUCIONAL&nbsp;</td>
					<td>
						<p align="left"><strong>FONDO DE EMPLEADOS BBVA - FOE<u></u><u></u></strong></p>
					</td>
				</tr>
				<tr height="22">
					<td height="22">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<?php foreach ($this->lists as $content) { ?>
					<tr height="22" <?php echo $estilo2; ?>>
						<td rowspan="10" height="176" width="255">INFORMACI&Oacute;N DE FACTURA&nbsp;</td>
						<td>N&deg; ORDEN</td>
						<td>
							<?php echo $content->orden; ?>V
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td>FECHA</td>
						<td>
							<?php echo $content->fecha; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td>CC/NITCLIENTE&nbsp;</td>
						<td>
							<?php echo $content->cedula; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">NOMBRE CLIENTE&nbsp;</td>
						<td>
							<?php echo $content->nombre_usuario ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">DEPARTAMENTO&nbsp;</td>
						<td>
							<?php echo $content->departamentoFacturacion; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">CIUDAD&nbsp;</td>
						<td>
							<?php echo $content->ciudad1; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">DIRECCI&Oacute;N COMPLETA&nbsp;</td>
						<td>
							<?php echo $content->direccion_usuario; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">BARRIO&nbsp;</td>
						<td>
							<?php echo $content->barrio_usuario; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">CELULAR&nbsp;</td>
						<td>
							<?php echo $content->celular_usuario; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">TELEFONO&nbsp;</td>
						<td>
							<?php echo $content->telefono_usuario; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td width="255" rowspan="8">INFORMACI&Oacute;NDE DESPACHO&nbsp;</td>
						<td height="22">CC CLIENTE DESPACHO&nbsp;</td>
						<td>
							<?php echo $content->cedula; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">NOMBRE CLIENTE DESPACHO&nbsp;</td>
						<td>
							<?php echo $content->nombre; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">DEPARTAMENTO&nbsp;</td>
						<td>
							<?php echo $content->departamentoDespacho; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">CIUDAD&nbsp;</td>
						<td>
							<?php echo $content->ciudad; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">DIRECCI&Oacute;N COMPLETA DESPACHO&nbsp;</td>
						<td>
							<?php echo $content->direccion; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">BARRIO&nbsp;</td>
						<td>
							<?php echo $content->barrio; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">CELULAR&nbsp;</td>
						<td>
							<?php echo $content->celular; ?>
						</td>
					</tr>
					<tr height="22" <?php echo $estilo2; ?>>
						<td height="22">TELEFONO&nbsp;</td>
						<td>
							<?php echo $content->telefono; ?>
						</td>
					</tr>



					<?php
					foreach ($content->items as $key2 => $item) { ?>





						<tr height="22" <?php echo $estilo2; ?>>
							<td rowspan="5" height="110" width="255">PRODUCTO
								<?php echo $key2 + 1 ?>&nbsp;
							</td>
							<td>EAN&nbsp;</td>
							<td>
								<?php echo $item->codigo; ?>&nbsp;
							</td>
						</tr>
						<tr height="22" <?php echo $estilo2; ?>>
							<td height="22">DESCRIPCION&nbsp;</td>
							<td>
								<?php echo $item->nombre; ?>&nbsp;
							</td>
						</tr>
						<tr height="22" <?php echo $estilo2; ?>>
							<td height="22">CANTIDAD&nbsp;</td>
							<td>
								<?php echo $item->cantidad; ?>&nbsp;
							</td>
						</tr>
						<tr height="22" <?php echo $estilo2; ?>>
							<td height="22">PRECIO POR UNIDAD&nbsp;</td>
							<td>
								<?php echo $item->valor; ?>&nbsp;
							</td>
						</tr>
						<tr height="22" <?php echo $estilo2; ?>>
							<td height="22">BODEGA O TIENDA QUE DESPACHA&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					<?php } ?>

					<tr height="22">
						<td height="50">&nbsp;</td>
						<td height="22">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

				<?php } ?>
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