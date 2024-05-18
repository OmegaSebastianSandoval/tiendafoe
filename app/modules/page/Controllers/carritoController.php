<?php

class Page_carritoController extends Page_mainController
{


    public function indexAction()
    {
    }
    public function formularioAction()
    {
        //   error_reporting(E_ALL);


        // Configura el layout para esta acción como 'blanco'
        $this->setLayout("blanco");
        // print_r($productosEnCarrito);
        // Instancia de modelos para operaciones de base de datos
        $itemsModel = new Administracion_Model_DbTable_Listarcompras();
        $productoModel = new Administracion_Model_DbTable_Productos();

        // Obtiene la sesión del usuario actual
        $usuario = Session::getInstance()->get("user");
        $this->_view->usuario = $usuario;

        // Recupera los productos en el carrito que no han sido validados aún
        $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");

        $banderaNoDisponibles = false;
        $total = 0;

        // Procesa cada producto en el carrito
        foreach ($productosEnCarrito as $item) {
            // Obtiene la descripción completa del producto
            $item->productoDescripcion = $productoModel->getById($item->producto);

            // Calcula la cantidad en validación para cada producto
            $productoCantidadEnValidacion = $itemsModel->getList("producto = '$item->producto' AND validacion = '1'");
            $cantidadEnValidacion = array_sum(array_map(function ($producto) {
                return (int)$producto->cantidad;
            }, $productoCantidadEnValidacion));

            // Calcula la cantidad disponible de cada producto teniendo en cuenta los que están en validación y en el carrito
            $item->productoCantidadDisponible = $item->productoDescripcion->disponibles - $cantidadEnValidacion - $item->cantidad;

            // Verifica si hay productos no disponibles
            if ($item->productoCantidadDisponible <= 0) {
                $banderaNoDisponibles = true;
            }

            // Calcula el subtotal para cada producto en el carrito
            $item->subtotal = (int)$item->valor * (int)$item->cantidad;
            $total += $item->subtotal;
        }



        // Traer datos del comprador
        $ciudadesModel = new Administracion_Model_DbTable_Dependciudad();
        $ciudades = $ciudadesModel->getList("", " nombre ASC ");
        $usuarioInfo = $this->getUsuario();

        // Traer la compra anterior
        $ultimaCompra = $itemsModel->getList("validacion = '1' AND cedula='$usuario'", "id DESC")[0];

        // Obtener y establecer nombre del usuario en la vista
        $this->_view->nombre = $ultimaCompra->nombre ?? Session::getInstance()->get("username");

        // Obtener y establecer dirección del usuario en la vista
        $this->_view->direccion = $ultimaCompra->direccion ?? $usuarioInfo->direccion;

        // Obtener y establecer teléfono del usuario en la vista
        $this->_view->telefono = $ultimaCompra->telefono ?? $usuarioInfo->telefono;

        // Obtener y establecer celular del usuario en la vista
        $this->_view->celular = $ultimaCompra->celular ?? $usuarioInfo->celular;

        // Obtener y establecer barrio del usuario en la vista
        $this->_view->barrio = $ultimaCompra->barrio ?? $usuarioInfo->barrio;

        // Obtener y establecer documento del usuario en la vista
        $this->_view->documento = $ultimaCompra->documento ?? $usuarioInfo->usuario;



        $this->_view->ciudades = $ciudades;







        $tasa = $this->getTasa();
        //numero de cuotas
        $numeroCuotas = 36;
        if ($_GET['cuotas'] != "") {
            $numeroCuotas = $_GET['cuotas']; //cuotas
        }

        //interes mensual
        $interesMensual = $tasa->tasa / 100;
        //Seguro
        $seguro = 0.02 / 100;
        //Asignacion del total del carrito
        $valorTotalCarrito = $total;

        //Se calcula el valor de la cuota mensual
        $interesSimple = $valorTotalCarrito * $interesMensual;
        $denominadorAmortizacion = 1 - pow((1 + $interesMensual), (-1 * $numeroCuotas));
        $interesSimple = $interesSimple / $denominadorAmortizacion; //cuota

        $numeros = range(1, 36);



        $this->_view->cuotas = $numeros;
        $this->_view->numeroCuotas = $numeroCuotas;
        $this->_view->tasa = $tasa->tasa;
        $this->_view->interesMensual = $interesMensual;
        $this->_view->seguro = $seguro;
        $this->_view->interesSimple = $interesSimple;


        // Asigna los datos procesados a la vista para su uso en la plantilla
        $this->_view->productosEnCarrito = $productosEnCarrito;
        $this->_view->total = $total;
        $this->_view->totalCuota = $valorTotalCarrito;

        $this->_view->banderaNoDisponibles = $banderaNoDisponibles;
    }

    public function alertaAction()
    {

        // Configura el layout para esta acción como 'blanco'
        $this->setLayout("blanco");
        // print_r($productosEnCarrito);
        // Instancia de modelos para operaciones de base de datos
        $itemsModel = new Administracion_Model_DbTable_Listarcompras();
        $productoModel = new Administracion_Model_DbTable_Productos();

        // Obtiene la sesión del usuario actual
        $usuario = Session::getInstance()->get("user");

        // Recupera los productos en el carrito que no han sido validados aún
        $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");

        $banderaNoDisponibles = false;
        $total = 0;

        // Procesa cada producto en el carrito
        foreach ($productosEnCarrito as $item) {
            // Obtiene la descripción completa del producto
            $item->productoDescripcion = $productoModel->getById($item->producto);

            // Calcula la cantidad en validación para cada producto
            $productoCantidadEnValidacion = $itemsModel->getList("producto = '$item->producto' AND validacion = '1'");
            $cantidadEnValidacion = array_sum(array_map(function ($producto) {
                return (int)$producto->cantidad;
            }, $productoCantidadEnValidacion));

            // Calcula la cantidad disponible de cada producto teniendo en cuenta los que están en validación y en el carrito
            $item->productoCantidadDisponible = $item->productoDescripcion->disponibles - $cantidadEnValidacion - $item->cantidad;

            // Verifica si hay productos no disponibles
            if ($item->productoCantidadDisponible <= 0) {
                $banderaNoDisponibles = true;
            }

            // Calcula el subtotal para cada producto en el carrito
            $item->subtotal = (int)$item->valor * (int)$item->cantidad;
            $total += $item->subtotal;
        }

        // Asigna los datos procesados a la vista para su uso en la plantilla
        $this->_view->productosEnCarrito = $productosEnCarrito;
        $this->_view->total = $total;
        $this->_view->banderaNoDisponibles = $banderaNoDisponibles;
    }


    public function addcarritoAction()
    {
        // Configura el layout para esta acción como 'blanco'
        $this->setLayout("blanco");

        // Obtiene el cuerpo de la solicitud POST en formato JSON
        $json_data = file_get_contents('php://input');

        // Decodifica el JSON a un array asociativo
        $data = json_decode($json_data, true);

        // Verifica si la decodificación fue exitosa
        if ($data === null) {
            http_response_code(400); // Envía un código de estado HTTP 400
            echo json_encode([
                'success' => false,
                'msg' => "Lo sentimos, ocurrió un error al procesar los datos."
            ]);
            exit;
        }

        // Extrae el ID del producto y la cantidad desde los datos
        $productoId = $data["producto"] ?? null;
        $cantidad = $data['cantidad'] ?? 0;

        // Verifica si el producto y la cantidad son válidos
        if (empty($productoId) || $cantidad <= 0) {
            echo json_encode([
                'success' => false,
                'msg' => "Datos del producto inválidos."
            ]);
            exit;
        }





        // Instancia los modelos necesarios
        $productoModel = new Administracion_Model_DbTable_Productos();
        $itemsModel = new Administracion_Model_DbTable_Listarcompras();
        // Obtiene la sesión del usuario actual
        $usuario = Session::getInstance()->get("user");
        // Obtiene el producto por ID
        $producto = $productoModel->getById($productoId);

        // Prepara los datos adicionales del carrito
        $data["valor"] = $producto->precio;
        $data["fecha"] = date("Y-m-d H:i:s");
        $data["validacion"] = 0;
        $data["cedula"] = $usuario;


        error_reporting(E_ALL);

        //validar que el producto no se pueda agregar por el cupo
        $totalActualCarrito = $this->traerTotalCarrito();
        $usuarioInfo = $this->getUsuario();
        $cupo =  $usuarioInfo->cupo_actual;
        $nuevoTotal =  $totalActualCarrito + $producto->precio;
        if ($nuevoTotal >  $cupo) {
            echo json_encode([
                'success' => false,
                'msg' => "Cupo insuficiente",
                'icon' => "error",
                'footer' => 1

            ]);
            exit;
        }

        //buscar si el producto existe en el carrito

        // Recupera los productos en el carrito que no han sido validados aún
        $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");


        foreach ($productosEnCarrito as $productoCarrito) {
            if ($productoCarrito->producto == $productoId) {
                $nuevaCantidadCarrito = $productoCarrito->cantidad + $cantidad;
                $itemsModel->editField($productoCarrito->id, "cantidad", $nuevaCantidadCarrito);

                // Verifica si el usuario está logueado y si la actualizacion fue exitosa
                if (Session::getInstance()->get("user") && $nuevaCantidadCarrito >= 2) {
                    echo json_encode([
                        'success' => true,
                        'msg' => "Producto agregado al carrito exitosamente",
                        'icon' => "success",
                        'footer' => 1

                    ]);
                    exit;
                }
            }
        }
        // Inserta los datos en el carrito
        $insertId = $itemsModel->insertCarrito($data);

        // Verifica si el usuario está logueado y si la inserción fue exitosa
        if (Session::getInstance()->get("user") && $insertId) {
            echo json_encode([
                'success' => true,
                'msg' => "Producto agregado al carrito exitosamente",
                'icon' => "success",
                'footer' => 1

            ]);
            exit;
        }

        // Responde con un error si no se pudo agregar al carrito
        echo json_encode([
            'success' => false,
            'msg' => "No se pudo agregar el producto al carrito."
        ]);
    }

    public function carritoAction()
    {
        $this->setLayout("blanco");

        // Instancia de modelos para operaciones de base de datos
        $itemsModel = new Administracion_Model_DbTable_Listarcompras();
        $productoModel = new Administracion_Model_DbTable_Productos();
        $contenidoModel = new Administracion_Model_DbTable_Contenido();
        $textoCarrito = $contenidoModel->getList("contenido_estado = '1' AND contenido_id='4'")[0];
        $this->_view->textoCarrito = $textoCarrito;
        // Obtiene la sesión del usuario actual
        $usuario = Session::getInstance()->get("user");

        // Recupera los productos en el carrito que no han sido validados aún
        $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");

        $banderaNoDisponibles = false;
        $total = 0;

        // Procesa cada producto en el carrito
        foreach ($productosEnCarrito as $item) {
            // Obtiene la descripción completa del producto
            $item->productoDescripcion = $productoModel->getById($item->producto);

            // Calcula la cantidad en validación para cada producto
            $productoCantidadEnValidacion = $itemsModel->getList("producto = '$item->producto' AND validacion = '1'");
            $cantidadEnValidacion = array_sum(array_map(function ($producto) {
                return (int)$producto->cantidad;
            }, $productoCantidadEnValidacion));

            // Calcula la cantidad disponible de cada producto teniendo en cuenta los que están en validación y en el carrito
            $item->productoCantidadDisponible = $item->productoDescripcion->disponibles - $cantidadEnValidacion - $item->cantidad;

            // Verifica si hay productos no disponibles
            if ($item->productoCantidadDisponible <= 0) {
                $banderaNoDisponibles = true;
            }

            // Calcula el subtotal para cada producto en el carrito
            $item->subtotal = (int)$item->valor * (int)$item->cantidad;
            $total += $item->subtotal;
        }

        // Asigna los datos procesados a la vista para su uso en la plantilla
        $this->_view->productosEnCarrito = $productosEnCarrito;
        $this->_view->total = $total;
        $this->_view->banderaNoDisponibles = $banderaNoDisponibles;
    }

    public function deleteitemcarritoAction()
    {
        // Configura el layout para esta acción como 'blanco'
        $this->setLayout("blanco");

        // Obtiene el cuerpo de la solicitud POST en formato JSON
        $json_data = file_get_contents('php://input');

        // Decodifica el JSON a un array asociativo
        $data = json_decode($json_data, true);

        // Verifica si la decodificación fue exitosa
        if ($data === null) {
            http_response_code(400); // Envía un código de estado HTTP 400
            echo json_encode([
                'success' => false,
                'msg' => "Lo sentimos, ocurrió un error al procesar los datos."
            ]);
            exit;
        }

        // Extrae el ID del producto y la cantidad desde los datos
        $itemId = $data["itemId"] ?? null;

        // Verifica si el producto y la cantidad son válidos
        if (empty($itemId)) {
            echo json_encode([
                'success' => false,
                'msg' => "Datos del producto inválidos."
            ]);
            exit;
        }

        $cedula = Session::getInstance()->get("user");

        $itemsModel = new Administracion_Model_DbTable_Listarcompras();

        $registroCarrito = $itemsModel->getById($itemId);

        if ($registroCarrito && $registroCarrito->cantidad == 1) {
            // ELimina los datos en el carrito
            $itemsModel->deleteRegister($itemId);

            echo json_encode([
                'success' => true,
                'msg' => "Producto eliminado del carrito exitosamente",
                'icon' => "success",
                'footer' => 0
            ]);
            exit;
        } else if ($registroCarrito && $registroCarrito->cantidad >= 2) {
            $nuevaCantidadCarrito = $registroCarrito->cantidad - 1;
            $itemsModel->editField($itemId, "cantidad", $nuevaCantidadCarrito);
            echo json_encode([
                'success' => true,
                'msg' => "Cantidad actualizada exitosamente",
                'icon' => "success",
                'footer' => 0
            ]);
            exit;
        }
    }
    public function traeritemsAction()
    {
        // Configura el layout para esta acción como 'blanco'
        $this->setLayout("blanco");
        // Instancia de modelos para operaciones de base de datos
        $itemsModel = new Administracion_Model_DbTable_Listarcompras();


        // Obtiene la sesión del usuario actual
        $usuario = Session::getInstance()->get("user");

        // Recupera los productos en el carrito que no han sido validados aún
        $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");

        // Procesa cada producto en el carrito para sumar las cantidades
        $cantidadProductosEnCarrito = array_reduce($productosEnCarrito, function ($carry, $item) {
            return $carry + $item->cantidad;
        }, 0);

        $res = ["cantidad" => $cantidadProductosEnCarrito];

        // Asigna los datos procesados a la vista para su uso en la plantilla
        echo json_encode($res);
    }
}
