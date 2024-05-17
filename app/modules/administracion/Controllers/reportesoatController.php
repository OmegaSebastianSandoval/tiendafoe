<?php
/**
 * Controlador de Solicitudsoat que permite la  creacion, edicion  y eliminacion de los solicitudsoat del Sistema
 */
class Administracion_reportesoatController extends Administracion_mainController
{
	public $botonpanel = 14;

	/**
	 * $mainModel  instancia del modelo de  base de datos solicitudsoat
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
	protected $_csrf_section = "administracion_solicitudsoat";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador solicitudsoat .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Solicitudsoat();
		$this->namefilter = "parametersfiltersolicitudsoat";
		$this->route = "/administracion/reportesoat";
		$this->namepages = "pages_solicitudsoat";
		$this->namepageactual = "page_actual_solicitudsoat";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  solicitudsoat con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de solicitudsoat";
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
		$this->_view->list_estados = $this->getEstados();

		$hoy = date("YmdHis");
		$excel = $this->_getSanitizedParam("excel");

		if ($excel == 1) {
			$lists = $this->mainModel->getList($filters, $order);
			
			
			$this->_view->lists = $lists;
			$this->setLayout('blanco');
			$this->_view->excel = $excel;
			$this->setLayout('blanco');
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=reporte_soat_$hoy.xls");

		}

	}

	private function getEstados()
	{
		$array = array();
		$array['1'] = 'Solicitudes completas';
		$array['2'] = 'Solicitudes incompletas';
		$array['3'] = 'Todas las solicitudes';

		return $array;
	}

	protected function getFilter()
	{
		$filtros = "1 = 1 AND ( (cupo>0 AND cuotas IS NOT NULL) OR (cupo IS NULL AND cuotas IS NOT NULL) OR (cupo='0' AND radicado IS NOT NULL) OR fecha<'2022-04-12 00:00:00' OR completo='1' )";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);
			if ($filters->fecha1rs != '' && $filters->fecha2rs != '') {
				$filtros = $filtros . " AND solicitud_soat.fecha >= '$filters->fecha1rs 00:00:00' AND solicitud_soat.fecha <= '$filters->fecha2rs 23:59:59'";
			}
			if ($filters->completas == "3") {
				$filtros = " 1 = 1 ";
			}
			if ($filters->completas == "2") {
				$filtros = " 1 = 1  AND fecha>='2022-04-12 00:00:00' AND ( (cupo='0' AND radicado IS NULL) OR (cupo>0 AND cuotas IS NULL) OR (cupo IS NULL AND cuotas IS NULL) ) AND completo IS NULL ";
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
			$parramsfilter['fecha1rs'] = $this->_getSanitizedParam("fecha1rs");
			$parramsfilter['fecha2rs'] = $this->_getSanitizedParam("fecha2rs");
			$parramsfilter['completas'] = $this->_getSanitizedParam("completas");
			$parramsfilter['email'] = $this->_getSanitizedParam("email");
			$parramsfilter['cedula2'] = $this->_getSanitizedParam("cedula2");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}