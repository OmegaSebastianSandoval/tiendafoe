<?php

class Page_soatController extends Page_mainController
{

  public function indexAction()
  {
    $this->_view->idCategoria = 'SOAT';
    $this->_view->productos = $this->template->productosPanel();
    //$this->getLayout()->setData("ocultarbackground", 1);
  }
  public function detalleAction()
  {
  }
}
