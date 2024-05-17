<span class=" d-flex gap-3 align-items-center pt-2"> <img src="/skins/page/corte/IconoProductos.png" alt="logo carrito"> Productos</span>
<hr class="mb-4">

<ul class="categoria">
    <?php
    /*  echo "<pre>";
    print_r($this->listcategorias[0]);*/
    // echo $this->idCategoria;
    ?>
    <?php foreach ($this->listcategorias as $categoria) { ?>
        <li class="<?php echo $this->idCategoria === $categoria->id ? 'active' : '' ?>">
            <div>
                <a href="/page/tienda?categoria=<?= $categoria->id ?>&page=1">
                    <?= $categoria->nombre ?>
                </a>
                <?php if (is_countable($categoria->subcategorias) && count($categoria->subcategorias) >= 1) { ?>
                    <span class="icono <?= $categoria->id ?>"><i class="fa-solid fa-chevron-right "></i></span>
                <?php } ?>

            </div>
            <?php if (is_countable($categoria->subcategorias) && count($categoria->subcategorias) >= 1) { ?>
                <ul class="subcategoria  ">
                    <?php foreach ($categoria->subcategorias as $subcategoria) { ?>
                        <li class="<?php echo $this->idSubCategoria === $subcategoria->id ? 'active' : '' ?>"><a href="/page/tienda?categoria=<?= $categoria->id ?>&sub=<?= $subcategoria->id ?>&page=1"> <?= $subcategoria->nombre ?> </a></li>
                    <?php } ?>

                </ul>
            <?php } ?>

        </li>
    <?php } ?>
</ul>


<select class="categoria-select form-select" id="categoriaSelect">
    <option value="">Selecciona una categoría</option>
    <?php foreach ($this->listcategorias as $categoria) { ?>
        <optgroup label="<?= $categoria->nombre ?>">
            <!-- Marcar la categoría principal como seleccionada si coincide con el ID de categoría activo -->
            <option value="/page/tienda?categoria=<?= $categoria->id ?>" <?= $this->idCategoria === $categoria->id ? 'selected' : '' ?>>
                <?= $categoria->nombre ?>
            </option>
            <?php if (is_countable($categoria->subcategorias) && count($categoria->subcategorias) >= 1) { ?>
                <?php foreach ($categoria->subcategorias as $subcategoria) { ?>
                    <!-- Marcar la subcategoría como seleccionada si coincide con el ID de subcategoría activo -->
                    <option value="/page/tienda?categoria=<?= $categoria->id ?>&sub=<?= $subcategoria->id ?>" <?= $this->idSubCategoria === $subcategoria->id ? 'selected' : '' ?>>
                        <?= $subcategoria->nombre ?>
                    </option>
                <?php } ?>
            <?php } ?>
        </optgroup>
     
    <?php } ?>
</select>
