<section class="section-carrito">

    <div class="shadow">
        <div class="container d-flex align-items-center gap-3 py-3">
            <img src="/skins/page/corte/IconoCompras.png" alt="Imagen compras">
            <h2 class="m-0">Mis compras</h2>
        </div>
    </div>
    <div class="container pt-5 contenedor-compras">
        <?php echo $this->contenido ?>

        <div class="compras">
            <?php if (count($this->compras) >= 1) { ?>
                <?php foreach ($this->compras as $compra) { ?>
                    <?php
                    /* echo '<pre>';
                    print_r($compra);
                    echo '</pre>'; */
                    ?>
                    <div class="contenedor-tabla-compras">

                        <table>

                            <thead>
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Subtotal</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td data-label="Producto"><?= $compra->productoInfo->nombre ?></td>
                                    <td data-label="Precio">$ <?= formato_pesos($compra->productoInfo->precio) ?></td>
                                    <td data-label="Cantidad"><?= $compra->cantidad ?></td>
                                    <td data-label="Subtotal">$ <?= formato_pesos($compra->cantidad * $compra->productoInfo->precio) ?></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } else { ?>

                <div class="alert alert-warning w-100 w-md-50 mx-auto text-center" role="alert">
                    No existen compras
                </div>
            <?php } ?>



            <a  class="btn-azul mt-4 mx-auto" href="/page/tienda" >Ver más productos</a>
        </div>


    </div>
</section>


<style>
    table {
        border: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 20px 0;
        width: 100%;
        table-layout: fixed;
    }



    table tr {

        border: 0;
        padding: .35em;
    }

    table th {
        color: var(--blueC);
        font-weight: 600;


    }

    table th,
    table td {
        padding: 5px 7px;
        text-align: center;
        border-right: 1px solid var(--gris);
        font-size: 15px;


    }

    table td {

        color: var(--gris);
        font-weight: 500;

    }

    table th:last-of-type,
    table td:last-of-type {
        border-right: 0;
    }

    .contenedor-tabla-compras {
        background-color: var(--grisC);
        padding: 10px 0;
        margin-bottom: 10px;

    }


    @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }

    }
</style>