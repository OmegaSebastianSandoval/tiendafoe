<?php

class Page_compraController extends Page_mainController
{
  public function indexAction()
  {
    echo Session::getInstance()->get("user");
  }
  public function confirmarAction()
  {
    // Obtiene el contenido de la sección 2 para la vista
    $this->_view->contenido = $this->template->getContentseccion("2");

    // Instancia los modelos necesarios
    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productoModel = new Administracion_Model_DbTable_Productos();

    // Obtiene la información del usuario
    $usuarioInfo = $this->getUsuario();

    // Sanitiza y asigna los parámetros de la solicitud
    $cedula = $this->_getSanitizedParam('cedula');
    $cuotas = $this->_getSanitizedParam('cuotas');
    $cuota = $this->_getSanitizedParam('cuota');
    $valor = $this->_getSanitizedParam('valor');
    $nombre = Session::getInstance()->get("username");
    $nombreDestinatario = $this->_getSanitizedParam('destinatario');
    $direccion = $this->_getSanitizedParam('direccion');
    $ciudad = $this->_getSanitizedParam('ciudad-destino');
    $telefono = $this->_getSanitizedParam('telefono');
    $documento = $this->_getSanitizedParam('documento-destinatario');
    $barrio = $this->_getSanitizedParam('barrio');
    $celular = $this->_getSanitizedParam('celular');

    // Verifica que todos los datos necesarios estén presentes
    if ($barrio && $direccion && $ciudad && $telefono && $documento && $celular && $nombre) {
      // Actualiza los datos del carrito
      $itemsModel->updateCarrito($cedula, $nombre, $direccion, $ciudad, $telefono, $documento, $barrio, $celular, $cuotas);
    }

    // Recupera los productos en el carrito que no han sido validados aún
    $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$cedula'", "");

    // Asigna los datos a las variables de la vista
    $this->_view->cedula = $cedula;
    $this->_view->cuotas = $cuotas;
    $this->_view->cuota = $cuota;
    $this->_view->valor = $valor;
    $this->_view->nombre = $nombre;
    $this->_view->nombreDestinatario = $nombreDestinatario;
    $this->_view->direccion = $direccion;
    $this->_view->ciudad = $ciudad;
    $this->_view->telefono = $telefono;
    $this->_view->documento = $documento;
    $this->_view->barrio = $barrio;
    $this->_view->celular = $celular;
    $this->_view->usuarioInfo = $usuarioInfo;
    $this->_view->list_ciudades = $this->getCiudaddocumento();
  }


  public function confirmarcarritoAction()
  {
    // Establece el layout a "blanco"
    $this->setLayout("blanco");

    // Sanitiza y asigna los parámetros de la solicitud
    $cedula = $this->_getSanitizedParam('id');
    $cuotas = $this->_getSanitizedParam('cuotas');
    $cuota = $this->_getSanitizedParam('cuota');
    $valor = $this->_getSanitizedParam('valor');

    // Instancia los modelos necesarios
    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productoModel = new Administracion_Model_DbTable_Productos();

    // Obtiene la lista de productos en el carrito que aún no han sido enviados y no están validados
    $productosEnCarrito = $itemsModel->getList("cedula = '$cedula' AND enviado IS NULL AND validacion='0'", "");
    $ultimaCompra = $itemsModel->getList("validacion = '1'", "orden DESC")[0];
    $orden = $ultimaCompra->orden + 1;
    $fecha = date("Y-m-d H:i:s");

    // Confirma el carrito si hay productos en el carrito
    if ($cedula && count($productosEnCarrito) >= 1 && $productosEnCarrito[0]->nombre != '') {
      $itemsModel->updateCarritoConfirmacion($cedula, $orden, $fecha);
    }

    // Redirige si el carrito está vacío
    if (!$productosEnCarrito && $productosEnCarrito[0]->nombre == '') {
      header('Location: /page/informacioenvio');
      exit();  // Agregado exit para asegurar que se detenga la ejecución después del redireccionamiento
    }

    // Reinstancia los modelos necesarios (esto es redundante y se puede mejorar)
    $usuariosModel = new Administracion_Model_DbTable_Usuariostienda();
    $productosEnCarrito = $itemsModel->getList("cedula = '$cedula' AND validacion = '1' AND orden='$orden'", "id ASC");

    $enviado = $productosEnCarrito[0]->enviado;
    $mensajeProductos = '';

    // Construye el mensaje de productos en el carrito
    foreach ($productosEnCarrito as $itemCarrito) {
      $productoId = $itemCarrito->producto;
      $producto = $productoModel->getById($productoId);

      if ($producto->nombre != '') {
        $mensajeProductos .= "
            <tr>
                <td>{$producto->nombre}</td>
                <td><div align='right'>$ " . number_format($itemCarrito->valor, 0) . "</div></td>
                <td><div align='center'>{$itemCarrito->cantidad}</div></td>
                <td><div align='right'>$ " . number_format($itemCarrito->valor * $itemCarrito->cantidad, 0) . "</div></td>
            </tr>";
      }
    }

    // Obtiene información del usuario
    $usuarioInfo = $usuariosModel->getList("usuario = '$cedula'", "")[0];
    $cupo_actual = $usuarioInfo->cupo_actual - $valor;

    // Actualiza el cupo del usuario y el carrito si no ha sido enviado
    if ($enviado != 1) {
      $usuariosModel->editField($usuarioInfo->id, "cupo_actual", $cupo_actual);
      $itemsModel->updateByOrden($orden);
    }

    // Datos del usuario con fallback a la sesión
    $nombre = $usuarioInfo->nombre ?: Session::getInstance()->get("username");
    $correo = $usuarioInfo->correo ?: Session::getInstance()->get("email");
    $usuario = $usuarioInfo->usuario ?: Session::getInstance()->get("user");

    // Datos para enviar en la vista o por correo
    $datos = [
      'nombre' => $nombre,
      'correo' => $correo,
      'ciudad' => $usuario->ciudad_documento,
      'ciudad2' => $usuario->ciudad_residencia,
      'usuario' => $usuario,
      'valor' => $_GET['valor'],
      'cuotas' => $_GET['cuotas'],
      'id' => $usuario->id,
      'orden' => $orden,
      'cedula' => $cedula,
      'f' => microtime(),
      'hash' => md5("OMEGA_" . $orden)
    ];

    // Consulta y actualiza el pagare
    $pagare = $this->consultarPagare($cedula);
    if ($pagare != "") {
      $itemsModel->updateItemByPagare($pagare, $orden);
    }

    // Construye el mensaje de correo
    $mensaje = "<strong>Compra No. $orden V</strong><br />
    <table style=\"border:1px solid #000000;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
        <tr>
            <td><strong>Producto</strong></td>
            <td><strong>Precio</strong></td>
            <td><strong>Cantidad</strong></td>
            <td><strong>Subtotal</strong></td>
        </tr>";
    $mensaje .= $mensajeProductos;
    $mensaje .= "
        <tr>
            <td></td>
            <td></td>
            <td><strong>TOTAL</strong></td>
            <td><div align='right'><strong>$ " . number_format($valor, 0) . "</strong></div></td>
        </tr>
    </table>
    <br /><br />";

    $asunto = "COMPRA $orden V TIENDA VIRTUAL FOEBBVA";

    // Bono de autorización de descuento
    $bono = "<div style=\"border:1px solid #000000; padding:5px;\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
            <td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                    <td><img src=\"https://tienda.foebbva.com/corte/logo60.png\" height=\"77\" /></td>
                    <td class=\"textoNegro\"><div align=\"center\"><strong>DOCUMENTO AUTORIZACIÓN DE DESCUENTO No. $orden V</strong></div></td>
                </tr>
            </table></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td><p align=\"justify\" class=\"textoNegro\">Yo <span style=\"text-decoration:underline;\">$nombre</span> identificado (a) con cedula de ciudadan&iacute;a n&uacute;mero <span style=\"text-decoration:underline;\">$usuario</span> de <span style=\"text-decoration:underline;\">{$usuario->ciudad_documento}</span>, autorizo al pagador de la empresa donde laboro y que determina mi vinculo de asociaci&oacute;n con el Fondo de Empleados BBVA, a descontar por nómina o débito automático el valor de <span style=\"text-decoration:underline;\">$ " . number_format($valor, 0) . "</span> en (<span style=\"text-decoration:underline;\">$cuotas</span>) cuotas mensuales. En caso de mi desvinculación laboral, autorizo descontar de mi liquidación final de prestaciones sociales y demás beneficios que me liquiden a mi favor. Así mismo en caso de no presentarse el descuento en mi desprendible de nómina autorizo descontar el saldo de mi cuenta de nómina registrada en el FOE. En el caso de asociados independientes se cargará en su próxima cuenta de cobro.</p>
            </td>
        </tr>
    </table></div>";

    $mensaje .= $bono;

    $boton_azul = "background:#01508A; color:#FFF; font-size:12px; padding:5px 12px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;";
    $pagare = "<br /><br /><br />
    <a href=\"https://tienda.foebbva.com/pdf.php?orden=$orden\" style='$boton_azul'>IMPRIMIR PAGARÉ Y CARTA DE INSTRUCCIONES</a>";

    if ($pagare != '') {
      $mensaje .= "<br /><br />Tiene Pagaré Firmado?: <strong>Si. tiene firmado el pagaré No. $pagare</strong>";
    } else {
      $mensaje .= "<br /><br />Tiene Pagaré Firmado?: <strong>El asociado no tiene pagaré firmado.</strong>";
    }

    // Muestra el mensaje
    // echo $mensaje;
    $emailModel = new Core_Model_Mail();
    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($mensaje);
    $emailModel->getMail()->AltBody = $mensaje;

    if ($correo != "") {
     // $emailModel->getMail()->addAddress($correo, "Notificaciones FOE");
      // $data["mailTo"] = "" . $correo;
     $emailModel->getMail()->addAddress("desarrollo8@omegawebsystems.com", "Notificaciones FOE");
     $data["mailTo"] = "desarrollo8@omegawebsystems.com";

    }
    //$emailModel->getMail()->addBCC("tiendavirtualfoe@foebbva.com", "Notificaciones FOE");
   // $emailModel->getMail()->addBCC("solicitudcreditosfoe@foebbva.com", "Notificaciones FOE");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com", "Notificaciones FOE");
    // $emailModel->getMail()->addBCC("desarrollo8@omegawebsystems.com", "Notificaciones FOE");

    //ENVIO API
    $token = $this->conectar2();
    $data["mailCc"] = "tiendavirtualfoe@foebbva.com";
    $data["subject"] = "" . $asunto;
    $data["certimail"] = "CNC";
    $data["richContent"] = "" . $mensaje;
    //$data["mailTo"] = "solicitudcreditosfoe@foebbva.com";
    $data["bcc"] = "soporteomega@omegawebsystems.com,desarrollo8@omegawebsystems.com";
    //print_r($data);
    $result = $this->enviar($data, $token);
    if ($result == "-1" or $result == "" or $result == NULL) {

      if ($emailModel->sed()) {
        header("location: /page/informacioenvio/?res=1&orden=$orden");
        exit();  // Agregado exit para asegurar que se detenga la ejecución después del redireccionamiento

      } else {
        Session::getInstance()->set("error_guardar", "Lo sentimos, ocurrió un error al enviar la confirmación");
        header("location: /page/informacioenvio/?res=2&orden=$orden");
        exit();  // Agregado exit para asegurar que se detenga la ejecución después del redireccionamiento

      }
    }
    header("location: /page/informacioenvio/?res=1&orden=$orden");
  }





  /**
   * Genera los valores del campo ciudad_documento.
   *
   * @return array cadena con los valores del campo ciudad_documento.
   */
  private function getCiudaddocumento()
  {
    $modelData = new Administracion_Model_DbTable_Dependciudad();
    $data = $modelData->getList();
    $array = array();
    foreach ($data as $key => $value) {
      $array[$value->codigo] = $value->nombre;
    }
    return $array;
  }

  public function consultarPagare($cedula)
  {

    $hash = md5("OMEGA_" . date("Y-m-d"));
    $context = stream_context_create([
      "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
      ],
    ]);
    $res = file_get_contents("https://creditos.foebbva.com/page/login/consultarpagare/?hash=" . $hash . "&cedula=" . $cedula, false, $context);
    $res = json_decode($res);
    return ($res->numero_pagare);
  }

  function conectar2()
  {


    $url = "http://notify-it.com/notify/services/checkAccount?u=comercial@foebbva.notify-it.com&p=9864912c-77e8-4a0b-aed0-e009489aca2d";

    $data = array();

    $ch = curl_init($url);
    # Setup request to send json via POST.
    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);
    # Print response.
    //echo "<pre>$result</pre>";

    return $result;
  }



  function enviar($data, $token)
  {


    $url = "http://notify-it.com/notify/services/sendImmediateEmailNotification?login=comercial@foebbva.notify-it.com&password=9864912c-77e8-4a0b-aed0-e009489aca2d";

    $authorization = "Authorization: Bearer " . $token; // Prepare the authorisation token

    $ch = curl_init($url);
    # Setup request to send json via POST.
    $payload = json_encode($data);

    //echo $payload;

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    # Send request.
    $result = curl_exec($ch);
    //echo 'Curl error: ' . curl_error($ch).'<br>';
    curl_close($ch);
    # Print response.
    //echo "<pre>$result</pre>";

    return $result;
  }
}
