<section class="section-carrito">

    <div class="shadow">
        <div class="container d-flex align-items-center gap-3 py-3">
            <img src="/skins/page/corte/Carrito.png" alt="Imagen carrito">
            <h2 class="m-0">Carrito de compras</h2>
        </div>
    </div>
    <div class="container pb-5">
        <div id="content-carrito" class="content-carrito">

        </div>

        <?php if ($this->productosEnCarrito) { ?>
            <div id="content-formulario" class="content-formulario">

            </div>
        <?php } ?>
        <a id="btn-ver-mas" class="btn-azul mt-4 mx-auto" href="/page/tienda" style="display: none;">Ver más productos</a>

    </div>
</section>
<?php



?>
<script>
    ready(function() {


        // Función para mostrar el botón
        function mostrarBoton() {
            document.getElementById('btn-ver-mas').style.display = 'block';
        }

        getCarrito()
        getFormulario()
        getAlerta()

        function getCarrito() {

            $.post(
                '/page/carrito/carrito',
                function(res) {
                    $("#content-carrito").html(res);
                }
            );
        }

        function getFormulario() {

            $.post(
                '/page/carrito/formulario',
                function(res) {
                    $("#content-formulario").html(res);
                    mostrarBoton()
                }
            );
        }

        function getAlerta() {

            $.post(
                '/page/carrito/alerta',
                function(res) {
                    // console.log(res);
                    $("#alerta").html(res);
                }
            );
        }


        function cambiarTotal() {

            $.post(
                '/page/carrito/traerTotalCarrito',
                function(res) {
                    const response = JSON.parse(res);
                    const valor = document.getElementById('valor')
                    const total = document.getElementById('total')
                    valor.value = response.total
                    total.value = `$ ${formatoPesos(response.total)}`
                    generarCalculo()
                }
            );
        }

        function formatoPesos(x) {
            if (x === null || x === undefined) {
                return 0;
            }
            return x.toLocaleString('es-CO', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        /* *************************
        ELIMINAR CARRITO INICIO
        **************************** */
        const listContainer = document.querySelector("#content-carrito"); // Asegúrate de tener un contenedor para tu lista

        listContainer
            ?
            listContainer.addEventListener("click", async function(event) {
                if (event.target.classList.contains("btn-eliminar-item")) {
                    const recordId = event.target.getAttribute("data-id");
                    // console.log(recordId);
                    const data = {
                        itemId: recordId
                    };

                    try {
                        const response = await fetch("/page/carrito/deleteitemcarrito", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(data),
                        });

                        if (!response.ok) {
                            throw new Error("Error en la solicitud");
                        }

                        const res = await response.json(); // Parseamos la respuesta como JSON
                        // console.log(res);
                        $("#content-carrito").fadeOut();
                        getCarrito()
                        getItemsCarrito()
                        getAlerta()
                        cambiarTotal()


                        $("#content-carrito").fadeIn();
                        $("#item" + recordId).modal("hide");
                        Swal.fire({
                            icon: res.icon,
                            title: "¡Listo!",
                            text: res.msg,
                            showConfirmButton: true,
                            confirmButtonText: "Continuar",
                            confirmButtonColor: "#3a599b",
                        });
                    } catch (error) {
                        console.log("Error:", error); // Manejamos errores de red u otros errores
                    }
                }
            }) :
            null;
        /* *************************
        ELIMINAR CARRITO FIN
        **************************** */


    })
</script>