<?php
/* echo "<pre>";
print_r($this->productosEnCarrito) ;
echo "</pre>";
 */

?>
<div id="content-carrito">
    <?php if (count($this->productosEnCarrito) >= 1) { ?>


        <table>

            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->productosEnCarrito as $item) { ?>
                    <tr>
                        <td data-label="Producto">
                            <?php echo $item->productoDescripcion->nombre;

                            if ($item->productoCantidadDisponible <= 0) {


                                echo '<div class="alert alert-danger p-1" role="alert">
                           (Producto no disponible)
                          </div>';
                            }

                            ?></td>
                        <td data-label="Precio">$ <?= formato_pesos($item->valor) ?></td>
                        <td data-label="Cantidad"><?= $item->cantidad ?></td>
                        <td data-label="Subtotal">$
                            <?php echo formato_pesos($item->subtotal);  ?></td>
                        <td data-label="Eliminar"> <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#item<?= $item->id ?>"><i class="fa-solid fa-x"></i></button> </td>
                        <!-- Modal -->
                        <div class="modal fade" id="item<?= $item->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar registro</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que desea eliminar este registro?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-danger btn-eliminar-item" data-id="<?= $item->id ?>">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="border-0">
                    </td>

                    <td class="border-0">
                    </td>

                    <td class="border-0">
                        <strong>TOTAL</strong>
                    </td>
                    <td class="border-0">
                        <strong> $ <?php echo formato_pesos($this->total) ?></strong>
                    </td>
                    <td class="border-0">
                    </td>

                </tr>

            </tbody>
        </table>
        <?php echo $this->contenido ?>



    <?php } else { ?>
        <div class="alert alert-warning" role="alert">
            El carrito esta vacio
        </div>

    <?php } ?>

</div>


<style>
    table {
        border: 0;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
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
        padding: .625em;
        text-align: center;
        border-right: 1px solid var(--grisC);
        font-size: 15px;

    }

    table th:last-of-type,
    table td:last-of-type {
        border-right: 0;
    }

    .btn-outline-danger {
        border: none;
        display: grid;
        place-items: center;
        margin: auto;
        transition: all 300ms ease-in-out !important;
    }

    .btn-outline-danger i {
        font-size: 22px;
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
    .btn-outline-danger {
        display: inline;

    }
    }
</style>