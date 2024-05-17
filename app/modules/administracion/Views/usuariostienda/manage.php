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
				<div class="col-3 form-group d-grid">
					<label class="control-label">activo</label>
					<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="usuario" class="control-label">Documento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->usuario; ?>" name="usuario" id="usuario"
							class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">ciudad documento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="ciudad_documento">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_ciudad_documento as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "ciudad_documento") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="password" class="control-label">password</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->password; ?>" name="password" id="password"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="nombre" class="control-label">nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="correo" class="control-label">correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="email" value="<?= $this->content->correo; ?>" name="correo" id="correo"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="celular" class="control-label">celular</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="number" value="<?= $this->content->celular; ?>" name="celular" id="celular"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="telefono" class="control-label">telefono</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="number" value="<?= $this->content->telefono; ?>" name="telefono" id="telefono"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">nivel</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="nivel">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_nivel as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "nivel") == $key) {
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
					<label for="direccion" class="form-label">direccion</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->direccion; ?>" name="direccion" id="direccion"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="barrio" class="control-label">barrio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->barrio; ?>" name="barrio" id="barrio"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 form-group">
					<label class="control-label">ciudad de residencia</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i
									class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="ciudad_residencia">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_ciudad_residencia as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "ciudad_residencia") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="cuotas" class="control-label">cuotas</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->cuotas; ?>" name="cuotas" id="cuotas"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="paso" class="control-label">paso</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->paso; ?>" name="paso" id="paso"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="cupo_inicial" class="control-label">cupo_inicial</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->cupo_inicial; ?>" name="cupo_inicial"
							id="cupo_inicial" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="cupo_actual" class="control-label">cupo tienda</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->cupo_actual; ?>" name="cupo_actual"
							id="cupo_actual" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="fecha" class="control-label">fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="date" value="<?= $this->content->fecha; ?>" name="fecha" id="fecha"
							class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="fecha_nacimiento" class="control-label">fecha de nacimiento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i
									class="fas fa-calendar-alt"></i></span>
						</div>
						<input type="date" value="<?php if ($this->content->fecha_nacimiento) {
							echo $this->content->fecha_nacimiento;
						} else {
							echo date('Y-m-d');
						} ?>" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" data-provide="datepicker"
							data-date-format="yyyy-mm-dd" data-date-language="es">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group d-none">
					<label for="cupo_actual_soat" class="control-label">cupo_actual_soat</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i
									class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->cupo_actual_soat; ?>" name="cupo_actual_soat"
							id="cupo_actual_soat" class="form-control">
					</label>
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