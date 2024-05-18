<?php

class Page_loginController extends Page_mainController
{
 
  /* usuario
1069472501
Ryf.8588

admin
Foe_tienda0210

 */
  public function indexAction()
  {
    //error_reporting(E_ALL);

    // Establecer layout de la página
    $this->setLayout("blanco");

    // Obtener parámetros sanitizados de usuario y contraseña
    $user = $this->_getSanitizedParam("user");
    $password = $this->_getSanitizedParam("password");

    // Intentar iniciar sesión
    $response = $this->login($user, $password);
    $res = $response["res"];
    $array = $response["array"];

    // Manejar errores de inicio de sesión
    if ($res === "error1") {
      Session::getInstance()->set("error_login", "Si olvido su contraseña, favor ingrese en Recordar Contraseña");
      Session::getInstance()->set("error_type", "danger");
    } elseif ($res === "error2") {
      Session::getInstance()->set("error_login", "Usuario inactivo");
      Session::getInstance()->set("error_type", "danger");
    } elseif ($array->success == "1") {
      Session::getInstance()->set("error_login", "Sesión iniciada correctamente");
      Session::getInstance()->set("error_type", "success");

      // Establecer datos de sesión
      Session::getInstance()->set("user", $user);
      Session::getInstance()->set("level", 2);
      Session::getInstance()->set("username", $array->data[0]->NOMBRES_APELLIDOS);
      Session::getInstance()->set("email", $array->data[0]->CORREO);
      Session::getInstance()->set("password", $array->data[0]->CLAVE);

      // Verificar si el usuario existe en la tabla de usuarios de la tienda
      $usuariosTienda = new Administracion_Model_DbTable_Usuariostienda();
      $usuario = $usuariosTienda->getList("usuario = '$user'", "")[0];
      if (!$usuario) {

        $cedulasModel = new Administracion_Model_DbTable_Cedulas();
        $usuarioCedulas = $cedulasModel->getList("cedula = '$user'", "")[0];

        // Crear nuevo usuario en la tienda si no existe
        $data = [
          'usuario' => $user,
          'activo' => 1,
          'nombre' => $array->data[0]->NOMBRES_APELLIDOS,
          'nivel' => 2,
          'paso' => 1,
          'cupo_inicial' => (int)$usuarioCedulas->cupo ?? 0,
          'cupo_actual' => (int)$usuarioCedulas->cupo ?? 0,
          'cupo_actual_soat' => (int)$usuarioCedulas->cupo_soat ?? 0,
        ];
        $usuariosTienda->insertInicio($data);
      }

      // Redireccionar al panel de usuario
      header("Location: /page/tienda");
      return;
    } else {
      // Error genérico de inicio de sesión
      Session::getInstance()->set("error_login", "Ocurrió un error al iniciar sesión.");
      Session::getInstance()->set("error_type", "danger");
    }

    // Redireccionar a la página de inicio en caso de error
    header("Location: /");
  }



  function login($usuario, $clave)
  {

    $clave = str_replace("#", "Numeral", $clave);

    $hash = md5("OMEGA_" . date("Y-m-d"));


    $context = stream_context_create([
      "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
      ],
    ]);
    $hash = md5("OMEGA_" . date("Y-m-d"));

    $context = stream_context_create([
      "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
      ],
    ]);
    $hash = md5("OMEGA_" . date("Y-m-d"));
    $res = file_get_contents("https://creditos.foebbva.com/page/login/loginlinix2/?hash=" . $hash . "&usuario=" . $usuario . "&clave=" . $clave, false, $context);

    $array = json_decode($res);


    return array("array" => $array, "res" => $res);
  }

  public function logoutAction()
  {

    Session::getInstance()->set("user", null);
    Session::getInstance()->set("level", null);
    Session::getInstance()->set("username", null);
    Session::getInstance()->set("email", null);
    Session::getInstance()->set("password", null);
    header("Location: /");
  }
}
