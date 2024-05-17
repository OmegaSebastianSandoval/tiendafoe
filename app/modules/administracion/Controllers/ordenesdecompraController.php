<?php

/**
 * Controlador de Listarcompras que permite la  creacion, edicion  y eliminacion de los Listar compras del Sistema
 */
class Administracion_ordenesdecompraController extends Administracion_mainController
{
	public $botonpanel = 12;

	/**
	 * $mainModel  instancia del modelo de  base de datos Listar compras
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_listarcompras";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador listarcompras .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Listarcompras();
		$this->namefilter = "parametersfilterlistarcompras";
		$this->route = "/administracion/ordenesdecompra";
		$this->namepages = "pages_listarcompras";
		$this->namepageactual = "page_actual_listarcompras";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  Listar compras con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Lista de ordenes de compra";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "orden DESC";
		$list = $this->mainModel->getListOrdenes($filters, $order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
			$page = Session::getInstance()->get($this->namepageactual);
			$start = ($page - 1) * $amount;
		} else if (!$page) {
			$start = 0;
			$page = 1;
			Session::getInstance()->set($this->namepageactual, $page);
		} else {
			Session::getInstance()->set($this->namepageactual, $page);
			$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list) / $amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPagesOrdenes($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;

		$this->_view->list_productos = $this->getProductos();
		$this->_view->res = $this->_getSanitizedParam("res");

		$this->_view->msg_enviar = Session::getInstance()->get("msg_enviar");
		Session::getInstance()->set("msg_enviar", "");
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  Listar compras  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_listarcompras_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar Listar compras";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear Listar compras";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear Listar compras";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un Listar compras  y redirecciona al listado de Listar compras.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id, $id);
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR LISTAR COMPRAS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un Listar compras  y redirecciona al listado de Listar compras.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
				$this->mainModel->update($data, $id);
			}
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR LISTAR COMPRAS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un Listar compras  y redirecciona al listado de Listar compras.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);
					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR LISTAR COMPRAS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	public function anularAction()
	{
		$this->setLayout('blanco');

		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id = $this->_getSanitizedParam("id");

			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->editField($id, 'validacion', 0);
					Session::getInstance()->set("msg_enviar", "Orden anulada correctamente");

					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'ANULAR COMPRAS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				} else {
					Session::getInstance()->set("msg_enviar", "La orden no pudo ser anulada correctamente");
					header('Location: ' . $this->route . '?res=danger' . '');
				}
			}
		} else {
			Session::getInstance()->set("msg_enviar", "La orden no pudo ser anulada correctamente");
			header('Location: ' . $this->route . '?res=danger' . '');
		}

		header('Location: ' . $this->route . '?res=success' . '');
	}

	public function generarenvioAction()
	{
		$this->setLayout('blanco');


		$this->_view->orden = $orden = $this->_getSanitizedParam("orden");
		$cedula = $this->_getSanitizedParam("cedula");
		$this->_view->reenviar = $reenviar = $this->_getSanitizedParam("reenviar");

		$productosModel = new Administracion_Model_DbTable_Dependproductos();
		$usuariosModel = new Administracion_Model_DbTable_Usuariostienda();

		if (isset($orden) && $orden > 0 && isset($cedula) && $cedula > 0) {
			$items = $this->mainModel->getList("validacion = 1 AND cedula='$cedula' AND orden='$orden'", " id ASC");
			$usuarioTienda = $usuariosModel->getList("usuario = '$cedula'", "")[0];

			if (isset($items)) {
				$nombres = "";
				$precios = 0;
				$cantidades = 0;
				$valor = 0;
				foreach ($items as $item) {
					$producto = $productosModel->getById($item->producto);
					$nombre1 = str_replace("|", "I", $producto->nombre);
					$nombre1 = str_replace('"', '', $nombre1);
					$nombre1 = str_replace("'", "", $nombre1);

					$nombres .= $nombre1 . "|";
					$precios .= $item->valor . "|";
					$cantidades .= $item->cantidad . "|";

					if ($item->valor > 0) {
						$valor += $item->valor * $item->cantidad;
					}
				}
				$this->_view->nombres = $nombres;
				$this->_view->precios = $precios;
				$this->_view->cantidades = $cantidades;
				$this->_view->valor = $valor;
				$this->_view->nombre = $usuarioTienda->nombre;
				$this->_view->usuario = $usuarioTienda->usuario;
				$this->_view->correo = $usuarioTienda->correo;
				$this->_view->ciudad = $usuarioTienda->ciudad_documento;
				$this->_view->ciudad2 = $usuarioTienda->ciudad_residencia;
				$this->_view->id = $usuarioTienda->id;

				$this->_view->cuotas = 36;
			} else {
				Session::getInstance()->set("msg_enviar", "La orden no pudo ser anulada correctamente");
				header('Location: ' . $this->route . '?res=danger' . '');
			}
		}
	}

	public function enviocarritofoeAction()
	{

		$this->setLayout('blanco');
		$existe_pagare = 0;
		$numero_pagare = 0;
		$nombre = $this->_getSanitizedParam('nombre');
		$correo = $this->_getSanitizedParam('correo');
		$ciudad = $this->_getSanitizedParam('ciudad');
		$ciudad2 = $this->_getSanitizedParam('ciudad2');
		$usuario = $this->_getSanitizedParam('usuario');
		$password = $this->_getSanitizedParam('password');
		$cuotas = $this->_getSanitizedParam('cuotas');
		//$id = $this->_getSanitizedParam('id')
		$orden = $this->_getSanitizedParam('orden');

		$precios = explode("|", str_replace("'", "", $this->_getSanitizedParam('precios')));
		$nombres = explode("|", str_replace("'", "", $this->_getSanitizedParam('nombres')));
		$cantidades = explode("|", str_replace("'", "", $this->_getSanitizedParam('cantidades')));
		$total_items = count($precios);




		$valor = $this->_getSanitizedParam('valor');


		$mensaje = "<strong>Compra No. " . $orden . "V</strong><br />
<table style=\"border:1px solid #000000;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\" >
	<tr>
		<td><strong>Producto</strong></td>
		<td><strong>Precio</strong></td>
		<td><strong>Cantidad</strong></td>
		<td><strong>Subtotal</strong></td>
	</tr>";

		for ($i = 0; $i <= $total_items; $i++) {
			if ($nombres[$i] != '') {
				$mensaje .= "
			<tr>
				<td>" . $nombres[$i] . "</td>
				<td><div align='right'>$ " . (number_format($precios[$i], 0)) . "</div></td>
				<td><div align='center'>" . $cantidades[$i] . "</div></td>
				<td><div align='right'>$ " . (number_format($precios[$i] * $cantidades[$i], 0)) . "</div></td>
			</tr>";
			} //if
		} //for

		$mensaje .= "	
	<tr>
		<td></td>
		<td></td>
		<td><strong>TOTAL</strong></td>
		<td><div align='right'><strong>$ " . ($valor ? number_format($valor, 0) : '0') . "</strong></div></td>
	</tr>

</table>
<br /><br />";


		$asunto = " COMPRA " . $orden . "V TIENDA VIRTUAL FOEBBVA";

		$bono = "<div style=\"border:1px solid #000000; padding:5px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td><img src=\"https://tienda.foebbva.com/corte/logo60.png\" height=\"77\" /></td>
        <td class=\"textoNegro\"><div align=\"center\"><strong>DOCUMENTO AUTORIZACIÓN DE DESCUENTO No. " . $orden . "V</strong></div></td>
      </tr>
    </table></td>
  </tr>\r\n
  <tr>
    <td></td>
  </tr>\r\n
  <tr>
    <td><p align=\"justify\" class=\"textoNegro\">Yo <span style=\"text-decoration:underline;\">" . $nombre . "</span> identificado (a) con cedula de ciudadan&iacute;a n&uacute;mero <span style=\"text-decoration:underline;\">" . $usuario . "</span> de <span style=\"text-decoration:underline;\">" . $ciudad . "</span>, autorizo al pagador de la empresa donde laboro y que determina mi vinculo de asociaci&oacute;n con el Fondo de Empleados BBVA, a descontar por nómina o débito automático el valor de <span style=\"text-decoration:underline;\">$ " . ($valor ? number_format($valor, 0) : '0')  . "</span> en ( <span style=\"text-decoration:underline;\">" . $cuotas . "</span> ) cuotas mensuales. En caso de m&iacute; desvinculaci&oacute;n laboral, autorizo descontar de mi liquidaci&oacute;n final de prestaciones sociales y dem&aacute;s beneficios que me liquiden a mi favor.\r\n As&iacute; mismo en caso de no presentarse el descuento en mi desprendible de n&oacute;mina autorizo descontar el saldo de mi cuenta de n&oacute;mina registrada en el FOE. En el caso de asociados independientes se cargara en su pr&oacute;xima cuenta de cobro.</p>
    </td>
  </tr>
</table></div>";

		$mensaje .= $bono;

		$boton_azul = "background:#01508A; color:#FFF; font-size:12px; padding:5px 12px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;";

		$pagare = "<br /><br /><br />
<a href=\"https://tienda.foebbva.com/pdf.php?orden=" . $orden . "\" style='" . $boton_azul . "'>IMPRIMIR PAGARÉ Y CARTA DE INSTRUCCIONES</a>
";
		if ($existe_pagare == 0) {
			//$mensaje.= $pagare;
		}

		if ($existe_pagare == 1) {
			$mensaje = $mensaje . "<br /><br />Tiene Pagare Firmado?: <strong>Si. tiene firmado el pagare No. " . $numero_pagare . "</strong>";
		} else {
			$mensaje = $mensaje . "<br /><br />Tiene Pagare Firmado?: <strong>El asociado no tiene pagare firmado.</strong>";
		}

		if ($correo != "") {
			//$data["mailTo"] = "".$correo;
		}
		//$data["mailCc"] = "tiendavirtualfoe@foebbva.com";
		$data["mailTo"] = "desarrollo8@omegawebsystems.com";




		$hash = md5("OMEGA_" . $orden);
		$hash2 = $this->_getSanitizedParam('hash');
		// echo $hash; 
		// echo "<br>";
		// echo $hash2;
		if ($hash == $hash2) {
			//ENVIO API
			$token = $this->conectar2();
			$data["subject"] = "" . $asunto;
			$data["certimail"] = "CNC";
			$data["richContent"] = "" . $mensaje;
			//  $data["bcc"] = "soporteomega@omegawebsystems.com";
			$data["bcc"] = "desarrollo8@omegawebsystems.com";

			//print_r($data);
			$result = $this->enviar($data, $token);
			// echo $result;
			//ENVIO API
			if ($result == "-1" or $result == "" or $result == NULL) {
				Session::getInstance()->set("msg_enviar", "Lo sentimos, ocurrió un error al enviar el pagaré");
				header('Location: ' . $this->route . '?res=danger' . '');
			} else {
				Session::getInstance()->set("msg_enviar", "Pagaré enviado correctamente");
				header('Location: ' . $this->route . '?res=success' . '');
			}
		} else {
			Session::getInstance()->set("msg_enviar", "Lo sentimos, ocurrió un error al enviar el pagaré");
			

			header('Location: ' . $this->route . '?res=danger' . '');
		}
	}


	/**
	 * 
	 * Genera los valores del campo Productos.
	 *
	 * @return array cadena con los valores del campo Productos.
	 */
	public function getProductos()
	{
		$modelData = new Administracion_Model_DbTable_Dependproductos();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Listarcompras.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		if ($this->_getSanitizedParam("cedula") == '') {
			$data['cedula'] = '0';
		} else {
			$data['cedula'] = $this->_getSanitizedParam("cedula");
		}
		if ($this->_getSanitizedParam("producto") == '') {
			$data['producto'] = '0';
		} else {
			$data['producto'] = $this->_getSanitizedParam("producto");
		}
		if ($this->_getSanitizedParam("valor") == '') {
			$data['valor'] = '0';
		} else {
			$data['valor'] = $this->_getSanitizedParam("valor");
		}
		if ($this->_getSanitizedParam("cantidad") == '') {
			$data['cantidad'] = '0';
		} else {
			$data['cantidad'] = $this->_getSanitizedParam("cantidad");
		}
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		if ($this->_getSanitizedParam("validacion") == '') {
			$data['validacion'] = '0';
		} else {
			$data['validacion'] = $this->_getSanitizedParam("validacion");
		}
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['direccion'] = $this->_getSanitizedParam("direccion");
		$data['ciudad'] = $this->_getSanitizedParam("ciudad");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['barrio'] = $this->_getSanitizedParam("barrio");
		if ($this->_getSanitizedParam("cuotas") == '') {
			$data['cuotas'] = '0';
		} else {
			$data['cuotas'] = $this->_getSanitizedParam("cuotas");
		}
		if ($this->_getSanitizedParam("enviado") == '') {
			$data['enviado'] = '0';
		} else {
			$data['enviado'] = $this->_getSanitizedParam("enviado");
		}
		$data['pagare'] = $this->_getSanitizedParam("pagare");
		return $data;
	}
	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1  AND validacion='1' ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);
			if ($filters->cedula != '') {
				$filtros = $filtros . " AND cedula LIKE '%" . $filters->cedula . "%'";
			}
			if ($filters->producto != '') {
				$filtros = $filtros . " AND producto LIKE '%" . $filters->producto . "%'";
			}
			if ($filters->valor != '') {
				$filtros = $filtros . " AND valor LIKE '%" . $filters->valor . "%'";
			}
			if ($filters->cantidad != '') {
				$filtros = $filtros . " AND cantidad LIKE '%" . $filters->cantidad . "%'";
			}
			if ($filters->fecha != '') {
				$filtros = $filtros . " AND fecha LIKE '%" . $filters->fecha . "%'";
			}
			if ($filters->validacion != '') {
				$filtros = $filtros . " AND validacion LIKE '%" . $filters->validacion . "%'";
			}
			if ($filters->nombre != '') {
				$filtros = $filtros . " AND nombre LIKE '%" . $filters->nombre . "%'";
			}
			if ($filters->direccion != '') {
				$filtros = $filtros . " AND direccion LIKE '%" . $filters->direccion . "%'";
			}
			if ($filters->ciudad != '') {
				$filtros = $filtros . " AND ciudad LIKE '%" . $filters->ciudad . "%'";
			}
			if ($filters->telefono != '') {
				$filtros = $filtros . " AND telefono LIKE '%" . $filters->telefono . "%'";
			}
			if ($filters->documento != '') {
				$filtros = $filtros . " AND documento LIKE '%" . $filters->documento . "%'";
			}
			if ($filters->celular != '') {
				$filtros = $filtros . " AND celular LIKE '%" . $filters->celular . "%'";
			}
			if ($filters->barrio != '') {
				$filtros = $filtros . " AND barrio LIKE '%" . $filters->barrio . "%'";
			}
			if ($filters->cuotas != '') {
				$filtros = $filtros . " AND cuotas LIKE '%" . $filters->cuotas . "%'";
			}
			if ($filters->enviado != '') {
				$filtros = $filtros . " AND enviado LIKE '%" . $filters->enviado . "%'";
			}
			if ($filters->pagare != '') {
				$filtros = $filtros . " AND pagare LIKE '%" . $filters->pagare . "%'";
			}
		}
		return $filtros;
	}

	/**
	 * Recibe y asigna los filtros de este controlador
	 *
	 * @return void
	 */
	protected function filters()
	{
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			$parramsfilter['cedula'] = $this->_getSanitizedParam("cedula");
			$parramsfilter['producto'] = $this->_getSanitizedParam("producto");
			$parramsfilter['valor'] = $this->_getSanitizedParam("valor");
			$parramsfilter['cantidad'] = $this->_getSanitizedParam("cantidad");
			$parramsfilter['fecha'] = $this->_getSanitizedParam("fecha");
			$parramsfilter['validacion'] = $this->_getSanitizedParam("validacion");
			$parramsfilter['nombre'] = $this->_getSanitizedParam("nombre");
			$parramsfilter['direccion'] = $this->_getSanitizedParam("direccion");
			$parramsfilter['ciudad'] = $this->_getSanitizedParam("ciudad");
			$parramsfilter['telefono'] = $this->_getSanitizedParam("telefono");
			$parramsfilter['documento'] = $this->_getSanitizedParam("documento");
			$parramsfilter['celular'] = $this->_getSanitizedParam("celular");
			$parramsfilter['barrio'] = $this->_getSanitizedParam("barrio");
			$parramsfilter['cuotas'] = $this->_getSanitizedParam("cuotas");
			$parramsfilter['enviado'] = $this->_getSanitizedParam("enviado");
			$parramsfilter['pagare'] = $this->_getSanitizedParam("pagare");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
