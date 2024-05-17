<form id="form1" name="form1" method="post" action="/administracion/ordenesdecompra/enviocarritofoe">
    <input name="nombre" type="hidden" value="<?php echo $this->nombre; ?>" />
    <input name="correo" type="hidden" value="<?php echo $this->correo; ?>" />
    <input name="ciudad" type="hidden" value="<?php echo $this->ciudad; ?>" />
    <input name="ciudad2" type="hidden" value="<?php echo $this->ciudad2; ?>" />
    <input name="usuario" type="hidden" value="<?php echo $this->usuario; ?>" />
    <input name="valor" type="hidden" value="<?php echo $this->valor; ?>" />
    <input name="cuotas" type="hidden" value="<?php echo $this->cuotas; ?>" />
    <input name="id" type="hidden" value="<?php echo $this->id; ?>" />
    <input name="nombres" type="hidden" value="<?php echo $this->nombres; ?>" />
    <input name="precios" type="hidden" value="<?php echo $this->precios; ?>" />
    <input name="cantidades" type="hidden" value="<?php echo $this->cantidades; ?>" />
    <input name="orden" type="hidden" value="<?php echo $this->orden; ?>" />
    <input name="f" type="hidden" value="<?php echo microtime(); ?>" />
    <input name="reenvio" type="hidden" value="<?php echo $this->reenvio; ?>" />
    <input name="hash" type="hidden" value="<?php echo md5("OMEGA_" . $this->orden); ?>" />
</form>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('form1').submit();
    })
</script>