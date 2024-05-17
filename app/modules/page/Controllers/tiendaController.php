<?php

class Page_tiendaController extends Page_mainController
{

  public function indexAction()
  {
    $this->getLayout()->setData("ocultarbackground", 1);
    $this->_view->banner = $this->template->bannerPrincipal(1);
    $this->_view->productos = $this->template->productosPanel();
    $modalModel = new Page_Model_DbTable_Publicidad();
    $this->_view->popup = $modalModel->getList("publicidad_seccion=101 AND publicidad_estado=1", "")[0];
  }
  public function detalleAction()
  {
    $this->getLayout()->setData("ocultarbackground", 1);

    $idProducto = $this->_getSanitizedParam("p");
    $this->_view->producto = $this->template->productoById($idProducto);
  }
}
