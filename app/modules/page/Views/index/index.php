<section class="section-center">
    <div class="d-grid d-md-flex gap-md-10 align-items-center justify-content-center">

        <div class="image">
            <img src="/skins/page/corte/IconoSesion.png" alt="">
            <p><span>TIENDA </span> VIRTUAL</p>
        </div>
        <?php if ($this->cerrada == 0) { ?>
            <form class="form" action="/page/login/?debug=1" method="post" autocomplete="off">
                <img src="/skins/page/images/logo.png" alt="">

                <p class="message">INICIAR SESIÓN</p>
                <?php if ($this->error_login && $this->error_type) { ?>
                    <div class="alert alert-<?php echo $this->error_type ?> text-center" role="alert">
                        <?php echo $this->error_login ?>
                    </div>
                <?php } ?>
                <label>
                    <input name="user" required value="" type="text" class="input">
                    <span>Usuario</span>
                </label>

                <label>
                    <input required value="" name="password" type="password" class="input">
                    <span>Contraseña</span>
                </label>

                <a class="message" href="https://servicios3.selsacloud.com/linix/v6/860011265/recordar.php?nit=860011265" target="_blank">¿Olvideste tu contraseña?</a>
                <button class="submit">Ingresar</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                Apreciado asociado, la tienda se encuentra cerrada.
            </div>
        <?php } ?>

    </div>

</section>
<footer class="footer-login">
    <p class="text-center text-white">Todos los derechos reservados</p>
</footer>

<style>
    /* body {
        height: calc(100dvh - 50px);
    } */
    header {
        display: none;
    }
</style>