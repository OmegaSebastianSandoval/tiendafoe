<?php

class Page_comprasController extends Page_mainController
{

  public function indexAction()
  {
    $this->_view->contenido = $this->template->getContentseccion(3);

    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productosModel = new Administracion_Model_DbTable_Productos();

    $cedula = Session::getInstance()->get("user");

    $comprasPorUsuario = $itemsModel->getList(" validacion = 1 AND  cedula='$cedula' ");



    foreach ($comprasPorUsuario as $key => $compra) {
      $compra->productoInfo = $productosModel->getById($compra->producto);
    }

    $this->_view->compras = $comprasPorUsuario;

  }
}
