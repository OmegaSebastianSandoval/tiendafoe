<?php
/**
 * Controlador de Usuariostienda que permite la  creacion, edicion  y eliminacion de los usuario del Sistema
 */
class Administracion_usuariostiendaController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos usuario
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
	protected $_csrf_section = "administracion_usuariostienda";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador usuariostienda .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Usuariostienda();
		$this->namefilter = "parametersfilterusuariostienda";
		$this->route = "/administracion/usuariostienda";
		$this->namepages = "pages_usuariostienda";
		$this->namepageactual = "page_actual_usuariostienda";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  usuario con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de usuario";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
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
		$this->_view->list_nivel = $this->getNivel();
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  usuario  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_usuariostienda_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_nivel = $this->getNivel();
		$this->_view->list_ciudad_documento = $this->getCiudaddocumento();
		$this->_view->list_ciudad_residencia = $this->getCiudadresidencia();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar usuario";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear usuario";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear usuario";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un usuario  y redirecciona al listado de usuario.
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

			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR USUARIO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un usuario  y redirecciona al listado de usuario.
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
			$data['log_tipo'] = 'EDITAR USUARIO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un usuario  y redirecciona al listado de usuario.
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
					$data['log_tipo'] = 'BORRAR USUARIO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Usuariostienda.
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
		$data['usuario'] = $this->_getSanitizedParam("usuario");
		$data['password'] = $this->_getSanitizedParam("password");
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['correo'] = $this->_getSanitizedParam("correo");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		if ($this->_getSanitizedParam("nivel") == '') {
			$data['nivel'] = '0';
		} else {
			$data['nivel'] = $this->_getSanitizedParam("nivel");
		}
		$data['direccion'] = $this->_getSanitizedParamHtml("direccion");
		$data['barrio'] = $this->_getSanitizedParam("barrio");
		$data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
		$data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");
		if ($this->_getSanitizedParam("cuotas") == '') {
			$data['cuotas'] = '0';
		} else {
			$data['cuotas'] = $this->_getSanitizedParam("cuotas");
		}
		if ($this->_getSanitizedParam("paso") == '') {
			$data['paso'] = '0';
		} else {
			$data['paso'] = $this->_getSanitizedParam("paso");
		}
		if ($this->_getSanitizedParam("cupo_inicial") == '') {
			$data['cupo_inicial'] = '0';
		} else {
			$data['cupo_inicial'] = $this->_getSanitizedParam("cupo_inicial");
		}
		if ($this->_getSanitizedParam("cupo_actual") == '') {
			$data['cupo_actual'] = '0';
		} else {
			$data['cupo_actual'] = $this->_getSanitizedParam("cupo_actual");
		}
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		$data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
		$data['cupo_actual_soat'] = $this->_getSanitizedParam("cupo_actual_soat");
		return $data;
	}

	/**
	 * Genera los valores del campo nivel.
	 *
	 * @return array cadena con los valores del campo nivel.
	 */
	private function getNivel()
	{
		$array = array();
		$array['1'] = 'Administrador';
		$array['2'] = 'Usuario';

		return $array;
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
			if ($filters->usuario != '') {
				$filtros = $filtros . " AND usuario LIKE '%" . $filters->usuario . "%'";
			}
			if ($filters->nombre != '') {
				$filtros = $filtros . " AND nombre LIKE '%" . $filters->nombre . "%'";
			}
			if ($filters->correo != '') {
				$filtros = $filtros . " AND correo LIKE '%" . $filters->correo . "%'";
			}
			if ($filters->nivel != '') {
				$filtros = $filtros . " AND nivel ='" . $filters->nivel . "'";
			}
			if ($filters->cupo_inicial != '') {
				$filtros = $filtros . " AND cupo_inicial LIKE '%" . $filters->cupo_inicial . "%'";
			}
			if ($filters->cupo_actual != '') {
				$filtros = $filtros . " AND cupo_actual LIKE '%" . $filters->cupo_actual . "%'";
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
			$parramsfilter['usuario'] = $this->_getSanitizedParam("usuario");
			$parramsfilter['nombre'] = $this->_getSanitizedParam("nombre");
			$parramsfilter['correo'] = $this->_getSanitizedParam("correo");
			$parramsfilter['nivel'] = $this->_getSanitizedParam("nivel");
			$parramsfilter['cupo_inicial'] = $this->_getSanitizedParam("cupo_inicial");
			$parramsfilter['cupo_actual'] = $this->_getSanitizedParam("cupo_actual");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}