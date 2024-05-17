<head>
    <title>Exportar</title>
</head>

<body>
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <thead>

        <tr>
            <th><strong>id</strong></th>
            <th><strong>usuario</strong></th>
            <th><strong>nombre</strong></th>
            <th><strong>correo</strong></th>
            <th><strong>celular</strong></th>
            <th><strong>telefono</strong></th>
            <th><strong>direccion</strong></th>
            <th><strong>activo</strong></th>
            <th><strong>ciudad documento</strong></th>
            <th><strong>ciudad residencia</strong></th>
            <th><strong>fecha nacimiento</strong></th>
            <th><strong>cupo tienda</strong></th>
            <th><strong>cupo soat</strong></th>
        </tr>

        </thead>

        <tbody>
            <?php foreach ($this->usuarios as $key => $usuario) { ?>
                <tr>
                    <td>
                        <?php echo $usuario->id; ?>
                    </td>
                    <td>
                        <?php echo $usuario->usuario; ?>
                    </td>
                    <td>
                        <?php echo $usuario->nombre; ?>
                    </td>
                    <td>
                        <?php echo $usuario->correo; ?>
                    </td>
                    <td>
                        <?php echo $usuario->celular; ?>
                    </td>
                    <td>
                        <?php echo $usuario->telefono; ?>
                    </td>
                    <td>
                        <?php echo $usuario->direccion; ?>
                    </td>
                    <td>
                        <?php echo $usuario->activo; ?>
                    </td>
                    <td>
                        <?php echo $usuario->ciudad_documento; ?>
                    </td>
                    <td>
                        <?php echo $usuario->ciudad_residencia; ?>
                    </td>
                    <td>
                        <?php echo $usuario->fecha_nacimiento; ?>
                    </td>
                    <td>
                        <?php echo $usuario->cupo_actual; ?>
                    </td>
                    <td>
                        <?php echo $usuario->cupo_actual_soat; ?>
                    </td>
                </tr>

            <?php } ?>
        </tbody>


    </table>
</body>