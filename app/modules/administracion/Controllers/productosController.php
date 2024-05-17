<?php
/**
 * Controlador de Productos que permite la  creacion, edicion  y eliminacion de los producto del Sistema
 */
class Administracion_productosController extends Administracion_mainController
{
	public $botonpanel = 8;

	/**
	 * $mainModel  instancia del modelo de  base de datos producto
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
	protected $_csrf_section = "administracion_productos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador productos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Productos();
		$this->namefilter = "parametersfilterproductos";
		$this->route = "/administracion/productos";
		$this->namepages = "pages_productos";
		$this->namepageactual = "page_actual_productos";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  producto con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Administración de producto";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "id DESC";
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
		$this->_view->list_categoria = $this->getCategoria();
		$this->_view->list_n1 = $this->getN1();
		$this->_view->list_marca = $this->getMarca();
		$this->_view->list_distribuidor = $this->getDistribuidor();

	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  producto  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_productos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_categoria = $this->getCategoria();
		$this->_view->list_n1 = $this->getN1();
		$this->_view->list_marca = $this->getMarca();
		$this->_view->list_distribuidor = $this->getDistribuidor();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear producto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un producto  y redirecciona al listado de producto.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadImage = new Core_Model_Upload_Image();
			if ($_FILES['imagen']['name'] != '') {
				$data['imagen'] = $uploadImage->upload("imagen");
			}
			$id = $this->mainModel->insert($data);

			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un producto  y redirecciona al listado de producto.
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
				$uploadImage = new Core_Model_Upload_Image();
				if ($_FILES['imagen']['name'] != '') {
					if ($content->imagen) {
						$uploadImage->delete($content->imagen);
					}
					$data['imagen'] = $uploadImage->upload("imagen");
				} else {
					$data['imagen'] = $content->imagen;
				}
				$this->mainModel->update($data, $id);
			}
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un producto  y redirecciona al listado de producto.
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
					$uploadImage = new Core_Model_Upload_Image();
					if (isset ($content->imagen) && $content->imagen != '') {
						$uploadImage->delete($content->imagen);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR PRODUCTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}


	public function exportarAction()
	{
		$this->setLayout('blanco');


		$list = $this->mainModel->getListReporte();

		$this->_view->lists = $list;


		$hoy = date("YmdHis");
		$excel = $this->_getSanitizedParam("excel");
		$this->_view->excel = $excel;


		if ($excel == 1) {
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-type:   application/x-msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=productos_" . $hoy . ".xls");
		}

	}


	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Productos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		if ($this->_getSanitizedParam("activo") == '') {
			$data['activo'] = '0';
		} else {
			$data['activo'] = $this->_getSanitizedParam("activo");
		}
		if ($this->_getSanitizedParam("categoria") == '') {
			$data['categoria'] = '0';
		} else {
			$data['categoria'] = $this->_getSanitizedParam("categoria");
		}
		$data['n1'] = $this->_getSanitizedParam("n1");
		$data['codigo'] = $this->_getSanitizedParam("codigo");
		if ($this->_getSanitizedParam("marca") == '') {
			$data['marca'] = '0';
		} else {
			$data['marca'] = $this->_getSanitizedParam("marca");
		}
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['imagen'] = "";
		if ($this->_getSanitizedParam("precio") == '') {
			$data['precio'] = '0';
		} else {
			$data['precio'] = $this->_getSanitizedParam("precio");
		}
		if ($this->_getSanitizedParam("precio_antes") == '') {
			$data['precio_antes'] = '0';
		} else {
			$data['precio_antes'] = $this->_getSanitizedParam("precio_antes");
		}
		if ($this->_getSanitizedParam("disponibles") == '') {
			$data['disponibles'] = '0';
		} else {
			$data['disponibles'] = $this->_getSanitizedParam("disponibles");
		}
		if ($this->_getSanitizedParam("distribuidor") == '') {
			$data['distribuidor'] = '0';
		} else {
			$data['distribuidor'] = $this->_getSanitizedParam("distribuidor");
		}
		$data['descripcion'] = $this->_getSanitizedParamHtml("descripcion");
		return $data;
	}

	/**
	 * Genera los valores del campo Categor&iacute;a.
	 *
	 * @return array cadena con los valores del campo Categor&iacute;a.
	 */
	private function getCategoria()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategoria();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo Subcategor&iacute;a.
	 *
	 * @return array cadena con los valores del campo Subcategor&iacute;a.
	 */
	private function getN1()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategoria();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo Marca.
	 *
	 * @return array cadena con los valores del campo Marca.
	 */
	private function getMarca()
	{
		$modelData = new Administracion_Model_DbTable_Dependmarca();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo Distribuidor.
	 *
	 * @return array cadena con los valores del campo Distribuidor.
	 */
	private function getDistribuidor()
	{
		$modelData = new Administracion_Model_DbTable_Dependdistribuidor();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}

	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);
			if ($filters->activo != '') {
				$filtros = $filtros . " AND activo LIKE '%" . $filters->activo . "%'";
			}
			if ($filters->categoria != '') {
				$filtros = $filtros . " AND categoria LIKE '%" . $filters->categoria . "%'";
			}
			if ($filters->n1 != '') {
				$filtros = $filtros . " AND n1 LIKE '%" . $filters->n1 . "%'";
			}
			if ($filters->codigo != '') {
				$filtros = $filtros . " AND codigo LIKE '%" . $filters->codigo . "%'";
			}
			if ($filters->marca != '') {
				$filtros = $filtros . " AND marca LIKE '%" . $filters->marca . "%'";
			}
			if ($filters->nombre != '') {
				$filtros = $filtros . " AND nombre LIKE '%" . $filters->nombre . "%'";
			}
			if ($filters->imagen != '') {
				$filtros = $filtros . " AND imagen LIKE '%" . $filters->imagen . "%'";
			}
			if ($filters->precio != '') {
				$filtros = $filtros . " AND precio LIKE '%" . $filters->precio . "%'";
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
			$parramsfilter['activo'] = $this->_getSanitizedParam("activo");
			$parramsfilter['categoria'] = $this->_getSanitizedParam("categoria");
			$parramsfilter['n1'] = $this->_getSanitizedParam("n1");
			$parramsfilter['codigo'] = $this->_getSanitizedParam("codigo");
			$parramsfilter['marca'] = $this->_getSanitizedParam("marca");
			$parramsfilter['nombre'] = $this->_getSanitizedParam("nombre");
			$parramsfilter['imagen'] = $this->_getSanitizedParam("imagen");
			$parramsfilter['precio'] = $this->_getSanitizedParam("precio");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}