var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  $(function () {
    $(".doc-item-theme").on("click", function () {
      let id = $(this).attr("data-id");
      console.log(id);
      $("#" + id).slideToggle();
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  /* *************************
  HEADER
  **************************** */
  document.querySelector(".mobile_nav").addEventListener("click", function () {
    var mm = document.querySelector(".mobile_menu"),
      mn = document.querySelector(".mobile_nav"),
      a = "active";

    if (mm.classList.contains(a) && mn.classList.contains(a)) {
      mm.classList.remove(a);
      mm.style.display = "none";
      mn.classList.remove(a);
      document.querySelectorAll(".mobile_menu li").forEach(function (li) {
        li.classList.remove("slide");
      });
    } else {
      mm.classList.add(a);
      mm.style.display = "block";
      mn.classList.add(a);
      document.querySelectorAll(".mobile_menu li").forEach(function (li, i) {
        setTimeout(function () {
          li.classList.add("slide");
        }, (i + 1) * 100);
      });
    }
  });

  /* *************************
  HEADER
  **************************** */
});

document.addEventListener("DOMContentLoaded", function () {
  //#region Categoria
  /* *************************
  CATEOGRIA INICIO
  **************************** */
  const iconos = document.querySelectorAll(".categoria .icono"); // Seleccionar solo los iconos

  iconos.forEach(function (icono) {
    icono.addEventListener("click", function (event) {
      event.stopPropagation(); // Evitar que el evento se propague a elementos superiores
      const categoria = icono.closest("li"); // Encontrar el elemento li de la categoría
      const subcategoria = categoria.querySelector(".subcategoria");

      // Cerrar todas las subcategorías excepto la actual
      document
        .querySelectorAll(".categoria > li")
        .forEach(function (otraCategoria) {
          const otraSubcategoria = otraCategoria.querySelector(".subcategoria");
          if (otraSubcategoria && otraSubcategoria !== subcategoria) {
            otraSubcategoria.style.maxHeight = "0px";
            // Resetear iconos solo si no son el actual
            if (otraCategoria.querySelector(".icono") !== icono) {
              otraCategoria
                .querySelector(".icono")
                .classList.remove("rotate-icon");
            }
          }
        });

      // Alternar la subcategoría actual
      if (subcategoria.style.maxHeight === "500px") {
        subcategoria.style.maxHeight = "0px";
      } else {
        subcategoria.style.maxHeight = "500px";
      }

      // Rotar el icono (si es necesario)
      icono.classList.toggle("rotate-icon");
    });
  });

  // Agregar controlador de eventos a la categoría para prevenir el despliegue
  document
    .querySelectorAll(".categoria > li > div > a")
    .forEach(function (link) {
      link.addEventListener("click", function (event) {
        event.stopPropagation(); // Esto asegura que el clic en el enlace no cause la expansión de las subcategorías
      });
    });

  /* CATEGORIAS RESPONSIVE */

  const categoriaSelect = document.getElementById("categoriaSelect");
  categoriaSelect
    ? categoriaSelect.addEventListener("change", function () {
        const url = this.value;
        if (url) {
          window.location = url; // Redirigir al usuario a la URL
        }
      })
    : null;
});

/* *************************
  CATEOGRIA FIN
  **************************** */

//#region BOTONES COMPRA
/* *************************
  BOTONES COMPRA INICIO
  **************************** */
function increment(id, disp) {
  const itemCount = document.getElementById("itemCount" + id);
  const max = disp >= 6 ? 5 : disp;
  if (parseInt(itemCount.innerText) >= max) {
    return;
  }
  itemCount.innerText = parseInt(itemCount.innerText) + 1;
}

function decrement(id) {
  const itemCount = document.getElementById("itemCount" + id);
  let currentCount = parseInt(itemCount.innerText);
  if (currentCount > 1) {
    // Evita que la cantidad sea menor a 1
    itemCount.innerText = currentCount - 1;
  }
}

async function comprar(id) {
  const count = document.getElementById("itemCount" + id).innerText;

  await addCarrito(id, count);
}

async function addCarrito(id, count) {
  const data = {
    producto: id,
    cantidad: count,
  };
  console.log(data);
  await fetch("/page/carrito/addcarrito", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Parseamos la respuesta como JSON
    })
    .then((res) => {
      console.log(res);
      alertaSwal(res);

      //listar el numero de items que hay en el carrito, funcion definida en el header
      getItemsCarrito();
    })
    .catch((error) => {
      console.log("Error:", error); // Manejamos errores de red u otros errores
    });
}



//#region ALERTA COMPRA
function alertaSwal(res) {
  if (res.success) {
    Swal.fire({
      icon: res.icon,
      title: "¡Listo!",
      text: res.msg,

      showConfirmButton: false,

      footer:
        '<div class="d-flex gap-2 justify-content-center align-items-center">' +
        '<button onclick="accion1()" class="btn btn-azul">Continuar comprando</button>' +
        '<button onclick="accion2()" class="btn btn-verde">Ir al carrito <i class="fa-solid fa-cart-shopping"></i> </button>' +
        "</div>",

      showClass: {
        popup: `
          animate__animated
          animate__fadeInUp
          animate__faster
          `,
      },
      hideClass: {
        popup: `
          animate__animated
          animate__fadeOutDown
          animate__faster
          `,
      },
    });
  } else {
    Swal.fire({
      icon: res.icon,
      title: "Error",
      confirmButtonColor: "#3a599b",
      text: res.msg,

      confirmButtonText: "Continuar",

      showClass: {
        popup: `
animate__animated
animate__fadeInUp
animate__faster
`,
      },
      hideClass: {
        popup: `
animate__animated
animate__fadeOutDown
animate__faster
`,
      },
    });
  }
}

function accion1() {
  console.log("Acción 1 ejecutada");
  Swal.close(); // Cierra la alerta de SweetAlert2
}

function accion2() {
  console.log("Acción 2 ejecutada");
  window.location.href = "/page/carrito"; // Modifica con la URL deseada
}

/* *************************
  BOTONES COMPRA FIN
  **************************** */

function ready(fn) {
  if (document.readyState !== "loading") {
    fn();
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}
