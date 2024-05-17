<h1 class="titulo-principal"><i class="fas fa-cogs"></i>
	<?php echo $this->titlesection; ?>
</h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-3 form-group  d-grid">
					<label class="control-label">Activo</label>
					<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">Categor&iacute;a</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="categoria" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_categoria as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "categoria") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">Subcategor&iacute;a</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="n1">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_n1 as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "n1") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="codigo" class="control-label">C&oacute;digo EAN</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->codigo; ?>" name="codigo" id="codigo"
							class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">Marca</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="marca" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_marca as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "marca") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre"
							class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 form-group">
					<label for="precio" class="control-label">Precio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->precio; ?>" name="precio" id="precio"
							class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="precio_antes" class="control-label">Precio anterior</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->precio_antes; ?>" name="precio_antes"
							id="precio_antes" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="disponibles" class="control-label">Disponibles</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->disponibles; ?>" name="disponibles"
							id="disponibles" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">Distribuidor</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="distribuidor">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_distribuidor as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "distribuidor") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="imagen">Imagen</label>
					<input type="file" name="imagen" id="imagen" class="form-control  file-image"
						data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png" <?php if (!$this->content->id) {
							echo 'required';
						} ?>>
					<div class="help-block with-errors"></div>
					<?php if ($this->content->imagen) { ?>
						<div id="imagen_imagen">
							<img src="/images/<?= $this->content->imagen; ?>"
								class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button"
									onclick="eliminarImagen('imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i
										class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-12 form-group">
					<label for="descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="descripcion" id="descripcion" class="form-control tinyeditor"
						rows="10"><?= $this->content->descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>