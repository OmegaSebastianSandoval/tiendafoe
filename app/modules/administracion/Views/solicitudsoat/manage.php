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
					<label for="cedula" class="control-label">cédula asociado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" <?= $this->content->cedula ? 'disabled' : ''; ?> value="<?= $this->content->cedula; ?>" name="cedula" id="cedula" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="nombre" class="control-label">nombre asociado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="telefono" class="control-label">telefono asociado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->telefono; ?>" name="telefono" id="telefono" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="email" class="control-label">email</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->email; ?>" name="email" id="email" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="cedula2" class="control-label">cedula asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->cedula2; ?>" name="cedula2" id="cedula2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="nombre2" class="control-label">nombre asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre2; ?>" name="nombre2" id="nombre2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="telefono2" class="control-label">telefono asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->telefono2; ?>" name="telefono2" id="telefono2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="direccion2" class="control-label">direccion asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->direccion2; ?>" name="direccion2" id="direccion2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="ciudad2" class="control-label">ciudad asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->ciudad2; ?>" name="ciudad2" id="ciudad2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="email2" class="control-label">email asegurado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->email2; ?>" name="email2" id="email2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="placa" class="control-label">placa</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->placa; ?>" name="placa" id="placa" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="tipo" class="control-label">tipo de vehículo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->tipo; ?>" name="tipo" id="tipo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="cilindraje" class="control-label">cilindraje</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<?php if ($this->content->fecha < "2022-02-15 12:00:00") { ?>
							<input type="text" <?= $this->content->cilindraje ? 'readonly' : ''; ?> value="<?= $this->content->cilindraje; ?>" name="" id="" class="form-control">

						<?php   } else { ?>
							<input type="hidden" <?= $this->content->cilindraje ? 'readonly' : ''; ?> value="<?= $this->content->cilindraje; ?>" name="cilindraje" id="cilindraje" class="form-control">
							<input type="text"  value="<?= $this->content->costos->subtipo ." ". $this->content->costos->antiguedad ; ?>" name="" id="" class="form-control">
						<?php   } ?>

					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-4 form-group">
					<label for="modelo" class="control-label">modelo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->modelo; ?>" name="modelo" id="modelo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="fecha" class="control-label">fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="datetime-local" value="<?= $this->content->fecha; ?>" name="fecha" id="fecha" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>


				<div class="col-4 form-group d-none">
					<label for="pasajeros" class="control-label">pasajeros</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->pasajeros; ?>" name="pasajeros" id="pasajeros" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>


				<div class="col-4 form-group">
					<label for="valor_soat" class="control-label">valor soat</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->valor_soat; ?>" name="valor_soat" id="valor_soat" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label class="control-label">estado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="estado" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_estado as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "estado") == $key) {
											echo "selected";
										} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="valor_descuento" class="control-label">valor descuento</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->valor_descuento; ?>" name="valor_descuento" id="valor_descuento" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="valor" class="control-label">valor a pagar</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->valor; ?>" name="valor" id="valor" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="aseguradora" class="control-label">aseguradora</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->aseguradora; ?>" name="aseguradora" id="aseguradora" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="fecha_vencimiento_soat" class="control-label">fecha vencimiento SOAT</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="date" value="<?= $this->content->fecha_vencimiento_soat; ?>" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="archivo">PDF SOAT</label>
					<input type="file" name="archivo" id="archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->archivo) { ?>
						<div id="archivo_archivo">
							<div> <a href="/files/<?php echo $this->content->archivo; ?>" target="_blank" style="text-decoration:none; color:#3a599b; font-weight:600"><?php echo $this->content->archivo; ?></a></div>

						</div>
					<?php } ?>
				</div>
				<div class="col-12 form-group">
					<label for="observaciones" class="form-label">observaciones</label>
					<textarea name="observaciones" id="observaciones" class="form-control tinyeditor" rows="10"><?= $this->content->observaciones; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="metodo" class="control-label">metodo</label>
					<label class="input-group">
						<div class="input-group-prepend">

						</div>
						<input type="hidden" <?= $this->content->metodo ? 'readonly' : ''; ?> value="<?= $this->content->metodo; ?>" name="metodo" id="metodo" class="form-control">
						<input type="text" <?= $this->content->metodo ? 'readonly' : ''; ?> value="<?php if($this->content->metodo==1){echo "Cr&eacute;dito";}
						if($this->content->metodo==2){echo "PSE";} ?>" name="metodo" id="metodo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>



				<div class="col-4 form-group">
					<label for="cuotas" class="control-label">cuotas</label>
					<label class="input-group">
						<div class="input-group-prepend">

						</div>
						<input type="text" <?= $this->content->cuotas ? 'readonly' : ''; ?> value="<?= $this->content->cuotas; ?>" name="" id="cuotas" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="cuota" class="control-label">valor cuota</label>
					<label class="input-group">
						<div class="input-group-prepend">

						</div>
						<input type="text" <?= $this->content->cuota ? 'readonly' : ''; ?> value="<?= number_format($this->content->cuota); ?>" name="" id="cuota" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="cupo" class="control-label">cupo en el momento de la solicitud</label>
					<label class="input-group">
						<div class="input-group-prepend">

						</div>
						<input type="text" <?= $this->content->cupo ? 'readonly' : ''; ?> value="<?= number_format($this->content->cupo); ?>" name="" id="" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="cupo" class="control-label">cupo actual</label>
					<label class="input-group">
						<div class="input-group-prepend">

						</div>
						<input type="text" <?= $this->content->usuario->cupo ? 'readonly' : ''; ?> value="<?= number_format($this->content->usuario->cupo); ?>" name="" id="" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group d-none">
					<label for="radicado" class="control-label">radicado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->radicado; ?>" name="radicado" id="radicado" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group d-none">
					<label for="completo" class="control-label">completo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->completo; ?>" name="completo" id="completo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group d-none">
					<label for="quien_completo" class="control-label">quien_completo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->quien_completo; ?>" name="quien_completo" id="quien_completo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group d-none">
					<label for="fecha_completo" class="control-label">fecha_completo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->fecha_completo; ?>" name="fecha_completo" id="fecha_completo" class="form-control">
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