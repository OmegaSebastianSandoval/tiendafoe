<div class="content-panel">

    <nav class="content-searchbar">
        <form action="/page/tienda" method="post">
            <div class="search">
                <input name="buscar" value="<?= $this->buscar ?>" placeholder="Producto" type="text" required>
                <button type="submit">Buscar</button>
            </div>
        </form>

        <a class="all-products" href="/page/tienda?p=all"> Ver todos los productos</a>
    </nav>
    <aside class="content-categorias">
        <?php echo $this->categorias ?>

    </aside>
    <section class="content-products">

        <?php echo $this->paginacion ?>
        <div class="products-grid">
            <?php echo $this->productos ?>
        </div>
        <?php echo $this->paginacion ?>


    </section>

</div>