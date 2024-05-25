<form action="/page/compra/confirmar" class="form-tienda shadow mt-5">
    <div class="header-form">
        DATOS PARA LA COMPRA
    </div>
    <div class="row">

        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="total">Valor a pagar</label>
                <input type="text" class="form-control" value="$ <?= formato_pesos($this->total) ?>" id="total" name="total" readonly>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="destinatario">Nombre destinatario</label>
                <input type="text" class="form-control" value="<?= $this->nombre ?>" id="destinatario" name="destinatario" required>
            </div>
        </div>


        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="tasa">Tasa nominal mes vencido</label>
                <input type="text" class="form-control" value="<?php echo round($this->tasa, 4); ?>%" id="tasa" name="tasa" readonly>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="direccion">Dirección envío</label>
                <input type="text" class="form-control" value="<?= $this->direccion ?>" id="direccion" name="direccion" required>
            </div>
        </div>



        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="cuotas-numero">Número de cuotas</label>

                <select name="-numero-numero" id="cuotas-numero" class="form-control" required>

                    <?php foreach ($this->cuotas as $key => $cuota) { ?>
                        <option <?php echo $this->numeroCuotas == $key + 1 ? 'selected' : '' ?> value="<?= $key + 1 ?>"><?= $cuota ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="barrio">Barrio</label>
                <input type="text" class="form-control" value="<?= $this->barrio ?>" id="barrio" name="barrio" required>
            </div>
        </div>





        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="valor-cuota">Valor cuota ordinaria</label>
                <input type="text" class="form-control" value="$ <?= formato_pesos($this->interesSimple) ?>" id="valor-cuota" name="valor-cuota" readonly>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="ciudad-destino">Ciudad destino</label>


                <select name="ciudad-destino" id="ciudad-destino" class="form-control" required>
                    <option value="" selected disabled></option>
                    <?php foreach ($this->ciudades as $key => $ciudad) { ?>
                        <option value="<?php echo mb_convert_encoding($ciudad->nombre, 'UTF-8', 'ISO-8859-1'); ?>" <?php if (strpos($ciudad->nombre, "BOGOT") !== FALSE) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo mb_convert_encoding($ciudad->nombre, 'UTF-8', 'ISO-8859-1'); ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>





        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="cuota-fondo-m">Valor cuota Fondo Mutual</label>
                <input type="text" class="form-control" value="$ <?= formato_pesos(($this->total * 2.5 / 100) / 6) ?>" id="cuota-fondo-m" name="cuota-fondo-m" readonly>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="telefono">Teléfono destinatario</label>
                <input type="text" class="form-control" value="<?= $this->telefono ?>" id="telefono" name="telefono">
            </div>
        </div>




        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="documento-destinatario">Documento destinatario</label>
                <input type="text" class="form-control" value="<?= $this->documento ?>" id="documento-destinatario" name="documento-destinatario" required>
            </div>
        </div>
        <div class="content-input col-12 col-md-6">
            <div class="form-group">
                <label for="celular">Célular destinatario</label>
                <input type="text" class="form-control" value="<?= $this->celular ?>" id="celular" name="celular" required>


            </div>
        </div>

        <input type="hidden" name="cedula" id="cedula" value="<?= $this->usuario ?>">
        <input type="hidden" name="valor" id="valor" value="<?= $this->total ?>">
        <input type="hidden" name="cuotas" id="cuotas" value="<?= $this->numeroCuotas ?>">
        <input type="hidden" name="cuota" id="cuota" value="<?= $this->interesSimple ?>">
        <input type="hidden" name="tasa-valor" id="tasa-valor" value="<?= $this->tasa ?>">



        <?php echo $this->contenido2 ?>

        <div class="mt-4">
            <div id="alerta">

            </div>


        </div>
    </div>



</form>



<script>
    // Element references
    const numeroCuotasElement = document.getElementById("cuotas-numero");
    const tasaElement = document.getElementById("tasa-valor");
    const totalElement = document.getElementById("valor");

    const valorCuotaElement = document.getElementById("valor-cuota");
    const cuotasElement = document.getElementById("cuotas");
    const cuotaElement = document.getElementById("cuota");

    // Function to format numbers as currency
    function formatoPesos(x) {
        if (x === null || x === undefined) {
            return '0';
        }
        return new Intl.NumberFormat('es-CO', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(x);
    }

    // Function to calculate monthly payment
    function calcularCuotaMensual(tasa, total, numeroCuotas) {
        const interesMensual = tasa / 100;
        const seguro = 0.02 / 100;
        const valorTotalCarrito = total;

        let interesSimple = valorTotalCarrito * interesMensual;
        const denominadorAmortizacion = 1 - Math.pow((1 + interesMensual), -numeroCuotas);
        interesSimple = interesSimple / denominadorAmortizacion;

        return interesSimple;
    }

    // Event listener for change event on numeroCuotasElement
    numeroCuotasElement.addEventListener("change", generarCalculo);

    function generarCalculo() {
        const numeroCuotas = parseInt(numeroCuotasElement.value, 10);
        const tasa = parseFloat(tasaElement.value);
        const total = parseFloat(totalElement.value);

        const interesSimple = calcularCuotaMensual(tasa, total, numeroCuotas);

        valorCuotaElement.value = "$ " + formatoPesos(interesSimple);
        cuotasElement.value = numeroCuotas;
        cuotaElement.value = interesSimple;
    }
 
</script>