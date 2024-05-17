<section class="section-carrito">

    <div class="shadow">
        <div class="container d-flex align-items-center gap-3 py-3">
            <img src="/skins/page/corte/IconoPerfil.png" alt="Imagen perfil">
            <h2 class="m-0">Mi perfil</h2>
        </div>
    </div>
    <div class="container pt-5">
        <form action="/page/perfil/update" class="form-tienda shadow" >
            <div class="header-form">
                MIS DATOS
            </div>
            <div class="row">
                <input type="hidden" name="id" value="<?= $this->usuario->id?>">
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Documento</label>
                        <input type="text" class="form-control" value="<?=Session::getInstance()->get("user")?>" name="usuario" readonly>
                    </div>

                </div> 
                 <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control" value="<?= $this->usuario->telefono?>" name="telefono" required>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Ciudad del documento</label>
                        <select class="form-control" name="ciudad_documento" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_ciudad_documento as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->usuario, "ciudad_documento") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Dirección</label>
                        <input type="text" class="form-control"name="direccion"  value="<?= $this->usuario->direccion?>" required>
                    </div>

                </div>
                
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="nombre"  value="<?= $this->usuario->nombre?>" required>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Ciudad de residencia</label>
                        <select class="form-control" name="ciudad_residencia" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_ciudad_residencia as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->usuario, "ciudad_residencia") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" />
								<?= $value; ?>
								</option>
							<?php } ?>
						</select>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Correo</label>
                        <input type="text" class="form-control" name="correo"  value="<?= $this->usuario->correo?>" required>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Fecha de nacimiento</label>
                        <input type="date" class="form-control"name="fecha_nacimiento" value="<?= $this->usuario->fecha_nacimiento?>" required>
                    </div>

                </div>
                <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Celular</label>
                        <input type="text" class="form-control" name="celular" value="<?= $this->usuario->celular?>" required>
                    </div>

                </div>
               <!--  <div class="content-input col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>

                </div> -->
                
            </div>
            
            <button class="btn-azul mx-auto mb-3">ACTUALIZAR</button>
        </form>

    </div>
</section>