<?php

class Page_compraController extends Page_mainController
{
  public function indexAction()
  {
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
}
