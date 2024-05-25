<section class="top-line bg-azul-o">

</section>
<div class='container'>
    <div class='mobile_nav'>
        <button class='burger' title='Open and close menu'>
            <span class='mobile_nav__label'>Open and close menu</span>
            <div class='top stripe'></div>
            <div class='middle stripe'></div>
            <div class='bottom stripe'></div>
        </button>
    </div>
    <div class='mobile_menu'>
        <nav>
            <ul>
                <li class='visited'>
                    <a href='#'>
                        <span class="title">
                            Bienvenido(a):
                        </span>
                        <br>
                        <span class="text">
                            <?php echo $this->nombreUsuario ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <span class="title">
                            Cupo:
                        </span>
                        <br>

                        <span class="text">
                            $ <?php echo $this->cupoActualTienda ?>

                        </span>
                    </a>
                </li>
                <li>
                    <a href='/page/compras'>Mis compras</a>
                </li>
                <li>
                    <a href='/page/perfil'>Mi perfil</a>
                </li>
                <li>
                    <a href='/page/login/logout/'>Salir</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class='logo'>
        <a href="/">
            <img src="/skins/page/images/logo.png" alt="Logo FOE">
        </a>
        <div class="vr bg-azul-o"></div>
        <p><span>TIENDA </span> <br>
            VIRTUAL</p>

    </div>
    <nav class='head_nav'>
        <div class="info-1">
            <div>
                <span class="title">
                    Bienvenido(a):
                </span>
                <span class="text">
                    <?php echo $this->nombreUsuario ?>
                </span>

            </div>
            <div>
                <span class="title">
                    Cupo: $
                </span>
                <span class="text">
                   
                    <?php echo formato_pesos($this->cupoActualTienda) ?>

                </span>

            </div>
        </div>
        <div class="vr"></div>

        <div class="content-carrito">
            <a href="/page/carrito">

                <img src="/skins/page/corte/Carrito.png" alt="Imagen carrito">
                <span class="contador-carrito"></span>
            </a>
        </div>
        <div class="info-2">
            <a href="/page/compras">Mis compras</a>
            <span class="text">
                <a href="/page/perfil">Mi perfil</a>

            </span>

        </div>
        <div class='button'>
            <a href="/page/login/logout">
                <span>
                    <p>Salir</p>
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>
            </a>
        </div>
    </nav>

</div>
<?php if ($this->cupoActualTienda <= 0) { ?>
    <section class=" alerta-sincupo">
        <!-- <div class="container"> -->
        <div class="">

            <div class="alerta bg-azul-o">
                <?php echo $this->contenidoSinCupo->contenido_introduccion ?>
            </div>
        </div>
    </section>
<?php } ?>

<script>
    getItemsCarrito()

    function getItemsCarrito() {

        $.post(
            '/page/carrito/traeritems',
            function(res) {
                 res = JSON.parse(res);
                //console.log(res.cantidad);
                $(".contador-carrito").html(res.cantidad);
            }
        );
    }
</script>

<?php
function formato_pesos($x)
{
    $res = number_format($x, 0, ',', '.') ?? 0;
    return $res;
}



?>