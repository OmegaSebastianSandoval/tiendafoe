<?php

/**
 *
 */

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{
		$this->setLayout('page_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();

		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;



		if (!Session::getInstance()->get("user")) {
			header("Location: /");
		}

		if (Session::getInstance()->get("user")) {


			$cerrada = $this->getTiendaAbierta();
			if ($cerrada == 1) {
				header("Location:/page/login/logout");
			}
			
			// Inicializar modelos
			$usuarioModel = new Administracion_Model_DbTable_Usuariostienda();
			$itemsModel = new Administracion_Model_DbTable_Listarcompras();
			$contenidosModel = new Page_Model_DbTable_Contenido();

			// Obtener información del usuario
			$cedula = Session::getInstance()->get("user");
			$this->_view->cedula = $cedula;
			$usuario = $usuarioModel->getList("usuario = '$cedula'")[0];


			$nombreUsuario = Session::getInstance()->get("username");

			// Establecer cupo actual dependiendo de la consulta
			if (strpos($_SERVER['QUERY_STRING'], "soat") !== FALSE) {
				$this->_view->cupoActual = $usuario->cupo_actual_soat;
			}

			// Establecer cupos formateados
			$this->_view->cupoActualTienda = ($usuario->cupo_actual);
			// $this->_view->cupoActualSoat = $this->formato_pesos($usuario->cupo_actual_soat);
			$this->_view->usuario = $usuario;
			$this->_view->nombreUsuario = $nombreUsuario;

			//esto estaba asignado así, para solo manejar el cupo de la tienda
			$this->_view->cupoActualSoat = $this->_view->cupoActualTienda;

			// Establecer productos en el carrito
			$productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula = '$cedula'");
			$this->_view->productosEnCarrito = $productosEnCarrito;

			// Obtener contenido sin cupo
			$contenidoSinCupo = $contenidosModel->getList("contenido_estado = '1' AND contenido_id='2'")[0];
			$this->_view->contenidoSinCupo = $contenidoSinCupo;

			$contenidoSinCupo->contenido_introduccion = str_replace('[ENLACE]', '<a href="https://creditos.foebbva.com/page/sistema/?tienda=1" target="_blank" >modulo de solicitud de cr&eacute;ditos.</a>', $contenidoSinCupo->contenido_introduccion);
		}






		$this->getLayout()->setData("meta_description", "$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords", "$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts", "$informacion->info_pagina_scripts");
		$botonesModel = new Page_Model_DbTable_Publicidad();
		$this->_view->botones = $botonesModel->getList("publicidad_seccion='3' AND publicidad_estado='1'", "orden ASC");

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);

		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("", "orden ASC");
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);
		$adicionales = $this->_view->getRoutPHP('modules/page/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales", $adicionales);
		$this->usuario();
	}

	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
	}

	public function getUsuario()
	{
		$usuarioModel = new Administracion_Model_DbTable_Usuariostienda();
		$cedula = Session::getInstance()->get("user");
		$usuario = $usuarioModel->getList("usuario = '$cedula'")[0];
		return $usuario;
	}
	public function getTasa()
	{
		$hash = md5("OMEGA_" . date("Y-m-d"));
		$context = stream_context_create([
			"ssl" => [
				"verify_peer" => false,
				"verify_peer_name" => false,
			],
		]);
		$res = file_get_contents("https://creditos.foebbva.com/page/login/getTasa/?hash=" . $hash . "&linea=18A", false, $context);
		$array_tasa = json_decode($res);
		return $array_tasa;
	}

	public function formato_pesos($x)
	{
		$res = number_format($x, 0, ',', '.') ?? 0;
		return $res;
	}
	public function traeritems()
	{
		// Configura el layout para esta acción como 'blanco'
		$this->setLayout("blanco");
		// Instancia de modelos para operaciones de base de datos
		$itemsModel = new Administracion_Model_DbTable_Listarcompras();


		// Obtiene la sesión del usuario actual
		$usuario = Session::getInstance()->get("user");

		// Recupera los productos en el carrito que no han sido validados aún
		$productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");
		$cantidadProductosEnCarrito = 0;

		// Procesa cada producto en el carrito
		foreach ($productosEnCarrito as $item) {
			// Obtiene la descripción completa del producto
			$cantidadProductosEnCarrito += $item->cantidad;
		}

		$res = ["cantidad" => $cantidadProductosEnCarrito ?? 0];
		// Asigna los datos procesados a la vista para su uso en la plantilla
		echo json_encode($res);
	}


	public function traerTotalCarrito()
	{
		$itemsModel = new Administracion_Model_DbTable_Listarcompras();
		$productoModel = new Administracion_Model_DbTable_Productos();

		// Obtiene la sesión del usuario actual
		$usuario = Session::getInstance()->get("user");


		// Recupera los productos en el carrito que no han sido validados aún
		$productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$usuario'", "");


		$total = 0;

		// Procesa cada producto en el carrito
		foreach ($productosEnCarrito as $item) {



			// Calcula el subtotal para cada producto en el carrito
			$item->subtotal = (int)$item->valor * (int)$item->cantidad;
			$total += $item->subtotal;
		}


		return $total;
	}
}
