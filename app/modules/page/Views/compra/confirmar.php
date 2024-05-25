<section class="section-carrito">

    <div class="shadow">
        <div class="container d-flex align-items-center gap-3 py-3">
            <img src="/skins/page/corte/Carrito.png" alt="Imagen carrito">
            <h2 class="m-0">Documento de autorización de descuento</h2>
        </div>
    </div>

    <div class="container py-5 ">
        <form action="/page/compra/confirmarcarrito" class="form-confirmar">

            <table width="99%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%"><img src="/skins/page/images/logo.png" width="100%" style="max-width:230px;" /></td>
                                <td class="textoNegro">
                                    <div align="center"><strong>DOCUMENTO AUTORIZACI&Oacute;N DE DESCUENTO</strong></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div align="center"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p align="justify" class="textoNegro mt-3">Yo <span style="text-decoration:underline;"><?php echo $this->nombre; ?></span> identificado (a) con cedula de ciudadan&iacute;a n&uacute;mero <span style="text-decoration:underline;"><?php echo $this->usuarioInfo->usuario ?></span> de <span style="text-decoration:underline;"><?php echo $this->list_ciudades[$this->usuarioInfo->ciudad_documento]; ?></span>, autorizo al pagador de la empresa donde laboro y que determina mi vinculo de asociaci&oacute;n con el Fondo de Empleados BBVA, a descontar por n&oacute;mina o d&eacute;bito autom&aacute;tico el valor de <span style="text-decoration:underline;">$<?php echo formato_pesos($this->valor); ?></span> en ( <span style="text-decoration:underline;"><?php echo $this->cuotas; ?></span> ) cuotas mensuales. En caso de m&iacute; desvinculaci&oacute;n laboral, autorizo descontar de mi liquidaci&oacute;n final de prestaciones sociales y dem&aacute;s beneficios que me liquiden a mi favor. As&iacute; mismo en caso de no presentarse el descuento en mi desprendible de n&oacute;mina autorizo descontar el saldo de mi cuenta de n&oacute;mina registrada en el FOE. En el caso de asociados independientes se cargara en su pr&oacute;xima cuenta de cobro.</p>
                    </td>
                </tr>
            </table>

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" required>
                <label class="form-check-label" for="flexCheckChecked" data-bs-toggle="modal" data-bs-target="#modalTerminos">
                    Términos y condiciones de la compra
                </label>
            </div>

            <!-- Modal Términos -->
            <div class="modal fade" id="modalTerminos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Términos de compra</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            .<?php echo $this->contenido ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>


            <div class='button mt-3'>
                <button class="mx-auto">
                    <span>
                        <p>Confirmar</p>
                       
                    </span>
                </button>
            </div>
            <input type="hidden" name="id" value="<?= $this->cedula?>">
            <input type="hidden" name="valor" value="<?= $this->valor?>">
            <input type="hidden" name="cuotas" value="<?= $this->cuotas?>">
            <input type="hidden" name="cuota" value="<?= $this->cuota?>">
        </form>
    </div>
</section>