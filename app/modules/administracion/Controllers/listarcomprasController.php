<?php
/**
 * Controlador de Listarcompras que permite la  creacion, edicion  y eliminacion de los Listar compras del Sistema
 */
class Administracion_listarcomprasController extends Administracion_mainController
{
	public $botonpanel = 10;

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
		$this->route = "/administracion/listarcompras";
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
		$title = "Lista de compras";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "fecha DESC";
		$list = $this->mainModel->getList($filters, $order);
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
		$this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;

		$this->_view->list_productos = $this->getProductos();
	

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
			if (isset ($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset ($content)) {
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

	/**
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