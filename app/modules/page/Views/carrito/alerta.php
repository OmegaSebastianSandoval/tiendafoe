<?php

if ($this->banderaNoDisponibles) {
    echo '<div class="alert alert-danger text-center" role="alert">
            Uno de los productos seleccionados ya no se encuentra disponible, por favor eliminelo para continuar
            </div>';
}
if ($this->total > $this->cupoActualTienda) {

    echo '<div class="alert alert-danger text-center" role="alert">
                Su cupo actual no es suficiente
            </div>';
}


if (!$this->banderaNoDisponibles &&  $this->cupoActualTienda >= $this->total) { ?>
    <div class='button'>
        <button class="mx-auto">
            <span>
                <p>Confirmar</p>
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
        </button>
    </div>
<?php } ?>
