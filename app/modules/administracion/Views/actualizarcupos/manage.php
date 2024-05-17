<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-4 form-group">
					<?php if ($this->content->id == 1) { ?>
						<label for="contenido_archivo_prueba">Archivo de ejemplo</label>
						<a class="btn btn-success btn-block" href="/skins/page/files/base.xls" download>



							Descargar archivo de ejemplo
						</a>
						<div class="help-block with-errors"></div>
					<?php } ?>
					<?php if ($this->content->id == 2) { ?>
						<label for="contenido_archivo_prueba">Archivo de ejemplo</label>
						<a class="btn btn-success btn-block" href="/skins/page/files/baseproductos.xls" download>



							Descargar archivo de ejemplo
						</a>
						<div class="help-block with-errors"></div>
					<?php } ?>
				</div>
				<div class="col-12 form-group">
					<label for="archivo_productos">archivo</label>
					<input type="file" name="archivo_productos" id="archivo_productos" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo_productos');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, .xlsx" <?php if (!$this->content->id) {
																																																																																		echo 'required';
																																																																																	} ?>>
					<div class="help-block with-errors"></div>
					<?php if ($this->content->archivo_productos) { ?>
						<div id="archivo_archivo_productos">
							<div><?php echo $this->content->archivo_productos; ?></div>
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminararchivo('archivo_productos','<?php echo $this->route . "/deletearchivo"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Archivo</button></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Actualizar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>