<?php

/**
 *
 */

class Page_indexController extends Controllers_Abstract
{
  public function init()
  {
    $this->setLayout('page_page');
    if (Session::getInstance()->get("user")) {
      header("Location: /page/tienda");
    }
    parent::init();
  }

  public function indexAction()
  {
    $this->getLayout()->setData("mostrarbackground", 1);

    $this->_view->error_login = Session::getInstance()->get("error_login");
    Session::getInstance()->set("error_login", "");
    $this->_view->error_type = Session::getInstance()->get("error_type");
    Session::getInstance()->set("error_type", "");



    $this->_view->cerrada = $this->getTiendaAbierta();
  }
 
}
