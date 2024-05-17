<table cellpadding="3" cellspacing="0" border="1" width="100%">
    <thead>
        <tr>
            <td>Id</td>
            <td>Categor&iacute;a</td>
            <td>Subcategor&iacute;a</td>
            <td>Marca</td>
            <td>C&oacute;digo EAN</td>
            <td>Nombre</td>
            <td>Descripcion</td>
            <td>Precio</td>
            <td>Precio antes</td>
            <td>Disponibles</td>
            <td>Activo</td>
            <td>Distibuidor</td>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->lists as $content) { ?>
            <?php $id = $content->id; ?>
            <tr>
                <td>
                    <?= $id; ?>
                </td>

                <td>
                    <?= $content->categoria ?>
                </td>


                <td>
                    <?= $content->n1; ?>
                </td>

                <td>
                    <?= $content->marca; ?>
                </td>
                <td>
                    <?= $content->codigo; ?>

                </td>

                <td>
                    <?= $content->nombre; ?>

                </td>

                <td>
                    <?= strip_tags($content->descripcion); ?>

                </td>
                <td>
                    <?= $content->precio; ?>

                </td>
                <td>
                    <?= $content->precio_antes; ?>

                </td>
                <td>
                    <?= $content->disponibles; ?>

                </td>
                <td>
                    <?= $content->activo; ?>

                </td>
                <td>
                    <?= $content->nombre; ?>

                </td>


                <td>
                    <?= $content->distribuidor; ?>

                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>