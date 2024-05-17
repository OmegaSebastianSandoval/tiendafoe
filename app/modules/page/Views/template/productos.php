<?php
// print_r($this->listPages[0]);

foreach ($this->listPages as $producto) { ?>
    <div class="card">
        <a href="/page/tienda/detalle?p=<?= $producto->id ?>&c=<?= $this->idCategoria ?>&s=<?= $this->idSubCategoria?>">
            <div class="card-image">
                <?php if ($producto->imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->imagen)) { ?>
                    <img src="/images/<?= $producto->imagen ?>" alt="Imagen del producto <?= $producto->nombre ?>">

                <?php  } else { ?>
                    <img src="/skins/page/images/stock.jpg" alt="Imagen no disponible del producto <?= $producto->nombre ?>">
                <?php  } ?>


            </div>
            <div class="card-image-marca">
                <?php if ($producto->marca_imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $producto->marca_imagen)) { ?>
                    <img src="/images/<?= $producto->marca_imagen ?>" alt="Imagen de la marca <?= $producto->marca_nombre ?>">
                <?php  } ?>

            </div>
            <div class="card-body">
                <h3 class="card-title"><?= $producto->nombre ?></h3>

                <h4>EAN <?= $producto->codigo ?></h4>
                <?php if ($producto->precio_antes >  $producto->precio) { ?>
                    <h5 class="precio-antes"> Precio antes: <span> <?= "$ " . formato_pesos($producto->precio_antes) ?></span> </h5>
                <?php  } ?>
                <span class="precio-text">PRECIO AHORA</span>

                <h5> <span class="asociado-text">Asociado FOE:</span> <span> <?= "$ " . formato_pesos($producto->precio) ?></span> </h5>

                <?php $disponibles = (int)$producto->disponibles - (int)$producto->total_cantidad_envalidacion ?>

                <?php if ($disponibles >= 1) { ?>
                    <h6>Disponibles: <span><?= $disponibles ?></span></h6>
                <?php  } ?>

                <?php if ($disponibles <= 0) { ?>
                    <h6>Sin unidades disponibles</h6>
                <?php  } ?>


            </div>
        </a>
        <div class="card-footer">
            <div class="footer-left">
                <button onclick="decrement(<?= $producto->id ?>)">-</button>
                <span id="itemCount<?= $producto->id ?>">1</span>
                <button onclick="increment(<?= $producto->id ?>, <?= $disponibles ?>)">+</button>
            </div>
            <div class="footer-right">
                <button class="btn" onclick="comprar(<?= $producto->id ?>)">Comprar</button>
            </div>



        </div>
    </div>



<?php } ?>