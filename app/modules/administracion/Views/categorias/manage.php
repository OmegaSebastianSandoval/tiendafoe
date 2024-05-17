<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-10 form-group">
					<label for="nombre"  class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-2 form-group d-grid">
			<label   class="control-label">Activa</label>
				<input type="checkbox" name="activa" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activa') == 1) { echo "checked";} ?>  required ></input>
				<div class="help-block with-errors"></div>
		</div>
				<input type="hidden" name="padre"  value="<?php if($this->content->padre){ echo $this->content->padre; } else { echo $this->padre; } ?>">
				<input type="hidden" name="nivel"  value="<?php if($this->content->nivel){ echo $this->content->nivel; } else { echo $this->nivel; } ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?padre=<?php if($this->content->padre){ echo $this->content->padre; } else { echo $this->padre; } ?>&nivel=<?php if($this->content->nivel){ echo $this->content->nivel; } else { echo $this->nivel; } ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>