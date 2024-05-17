<?php

class Page_perfilController extends Page_mainController
{

  public function indexAction()
  {
    $usuarioModel = new Administracion_Model_DbTable_Usuariostienda();

    $cedula = Session::getInstance()->get("user");

    $usuario = $usuarioModel->getList("usuario = '$cedula'")[0];
    $nombreUsuario = Session::getInstance()->get("username");
    $emailUsuario = Session::getInstance()->get("email");

    if ($usuario->nombre == "") {
      $usuario->nombre = $nombreUsuario;
    }
    if ($usuario->correo == "") {
      $usuario->correo = $emailUsuario;
    }
    $this->_view->usuario = $usuario;
    $this->_view->list_ciudad_documento = $this->getCiudaddocumento();
    $this->_view->list_ciudad_residencia = $this->getCiudadresidencia();
  }

  public function updateAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $usuarioModel = new Administracion_Model_DbTable_Usuariostienda();
    $content = $usuarioModel->getById($id);
    if ($content->id) {
      $data = $this->getData();
      $usuarioModel->update2($data, $id);
      //print_r($data); 
    }


    header('Location:/page/perfil'   . '');
  }
  private function getData()
  {
    $data = array();

    $data['usuario'] = $this->_getSanitizedParam("usuario");
    $data['nombre'] = $this->_getSanitizedParam("nombre");
    $data['correo'] = $this->_getSanitizedParam("correo");
    $data['celular'] = $this->_getSanitizedParam("celular");
    $data['telefono'] = $this->_getSanitizedParam("telefono");

    $data['direccion'] = $this->_getSanitizedParamHtml("direccion");
    $data['barrio'] = $this->_getSanitizedParam("barrio");
    $data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
    $data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");

    $data['fecha'] = $this->_getSanitizedParam("fecha");
    $data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
    $data['cupo_actual_soat'] = $this->_getSanitizedParam("cupo_actual_soat");
    return $data;
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


  /**
   * Genera los valores del campo ciudad_residencia.
   *
   * @return array cadena con los valores del campo ciudad_residencia.
   */
  private function getCiudadresidencia()
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
