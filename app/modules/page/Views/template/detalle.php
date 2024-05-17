<?php
// print_r($this->producto);
?>

<div class="row content-detalle">
    <div class="col-12">
        <a class="btn btn-outline-secondary d-flex gap-2 align-items-center mb-4" href="<?= $this->enlace ?>" style="width: fit-content;">
        <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>
    <div class="col-12 col-lg-5 content-img">
        <?php if ($this->producto->imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $this->producto->imagen)) { ?>
            <a href="/images/<?= $this->producto->imagen ?>" data-fancybox data-caption="<?= $this->producto->nombre ?>">
                <img src="/images/<?= $this->producto->imagen ?>" alt="Imagen del producto <?= $this->producto->nombre ?>">
            </a>


        <?php  } else { ?>
            <img src="/skins/page/images/stock.jpg" alt="Imagen no disponible del producto <?= $this->producto->nombre ?>">
        <?php  } ?>
    </div>
    <div class="col-12 col-lg-7">


        <?php if ($this->marca->imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . "/images/" . $this->marca->imagen)) { ?>
            <div class="image-marca">
                <img src="/images/<?= $this->marca->imagen ?>" alt="Imagen de la marca <?= $this->marca->nombre ?>">
            </div>
        <?php  } ?>

        <?php if ($this->producto->descripcion) { ?>
            <h2 class="title-detalle"><?= $this->producto->nombre ?></h2>

            <h4>EAN <?= $this->producto->codigo ?></h4>


            <div class="accordion mt-4" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Descripción
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?= sin_p($this->producto->descripcion) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php  } ?>

        <div class="card-body card">

            <?php if ($this->producto->precio_antes >  $this->producto->precio) { ?>
                <h5 class="precio-antes"> Precio antes: <span> <?= "$ " . formato_pesos($this->producto->precio_antes) ?></span> </h5>
            <?php  } ?>
            <span class="precio-text">PRECIO AHORA</span>

            <h5> <span class="asociado-text">Asociado FOE:</span> <span> <?= "$ " . formato_pesos($this->producto->precio) ?></span> </h5>

            <?php $disponibles = (int)$this->producto->disponibles - (int)$this->cantidadEnValidacion ?>

            <?php if ($disponibles >= 1) { ?>
                <h6>Disponibles: <span><?= $disponibles ?></span></h6>
            <?php  } ?>

            <?php if ($disponibles <= 0) { ?>
                <h6>Sin unidades disponibles</h6>
            <?php  } ?>


        </div>
        <div class="card-footer">
            <div class="footer-left">
                <button onclick="decrement(<?= $this->producto->id ?>)">-</button>
                <span id="itemCount<?= $this->producto->id ?>">1</span>
                <button onclick="increment(<?= $this->producto->id ?>, <?= $disponibles ?>)">+</button>
            </div>
            <div class="footer-right">
                <button class="button" onclick="comprar(<?= $this->producto->id ?>)">Comprar</button>
            </div>



        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        Fancybox.bind("[data-fancybox]", {
            showClass: "f-scaleIn",
            hideClass: "f-scaleOut",
        });
    })
</script>
<?php
/* 
foreach ($this->listPages as $producto) { ?>
    <div class="card">
        <a href="/page/tienda/detalle?p=<?= $producto->id ?>">
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



<?php } ?> */