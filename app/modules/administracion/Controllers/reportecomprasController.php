<?php
/**
 * Controlador de Listarcompras que permite la  creacion, edicion  y eliminacion de los Listar compras del Sistema
 */
class Administracion_reportecomprasController extends Administracion_mainController
{
	public $botonpanel = 14;

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
		$this->route = "/administracion/reportecompras";
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

		$excel = $this->_getSanitizedParam("excel");
		$title = "Lista de compras";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " items.orden ASC, items.cedula ASC, items.fecha ASC";
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
		$lists = $this->mainModel->getListPagesAlkosto($filters, $order, $start, $amount);
		$ciudadModel = new Administracion_Model_DbTable_Dependciudad();
		foreach ($lists as $key => $value) {
			$value->items = $this->mainModel->getListOrdenesYProductos("orden = '$value->orden' ");
			$value->departamentoFacturacion = $ciudadModel->getList("nombre = '$value->ciudad1' ")[0]->departamento;
			$value->departamentoDespacho = $ciudadModel->getList("nombre = '$value->ciudad' ")[0]->departamento;

		}

		$this->_view->lists = $lists;
		$this->_view->csrf_section = $this->_csrf_section;

		$this->_view->list_productos = $this->getProductos();

		$hoy = date("YmdHis");
		if ($excel == 1) {
			$lists = $this->mainModel->getListAlkosto($filters, $order);
			foreach ($lists as $key => $value) {
				$value->items = $this->mainModel->getListOrdenesYProductos("orden = '$value->orden' ");
				$value->departamentoFacturacion = $ciudadModel->getList("nombre = '$value->ciudad1' ")[0]->departamento;
				$value->departamentoDespacho = $ciudadModel->getList("nombre = '$value->ciudad' ")[0]->departamento;
			}
			
			$this->_view->lists = $lists;
			$this->setLayout('blanco');
			$this->_view->excel = $excel;
			$this->setLayout('blanco');
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=reporte_analista_$hoy.xls");

		}


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

	protected function getFilter()
	{
		$filtros = "items.validacion = '1' AND items.cedula > 0 ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);

			if ($filters->fecha1 != '' && $filters->fecha2 != '') {
				$filtros = $filtros . " AND items.fecha >= '$filters->fecha1 00:00:00' AND items.fecha <= '$filters->fecha2 23:59:59'";
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

			$parramsfilter['fecha1'] = $this->_getSanitizedParam("fecha1");
			$parramsfilter['fecha2'] = $this->_getSanitizedParam("fecha2");


			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}