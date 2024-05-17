<?php

/**
 * Controlador de Actualizarcupos que permite la  creacion, edicion  y eliminacion de los actualizar cupos del Sistema
 */
class Administracion_actualizarcuposController extends Administracion_mainController
{
	public $botonpanel;

	/**
	 * $mainModel  instancia del modelo de  base de datos actualizar cupos
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
	protected $_csrf_section = "administracion_actualizarcupos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador actualizarcupos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Actualizarcupos();
		$this->namefilter = "parametersfilteractualizarcupos";
		$this->route = "/administracion/actualizarcupos";
		$this->namepages = "pages_actualizarcupos";
		$this->namepageactual = "page_actual_actualizarcupos";
		$this->_view->route = $this->route;

		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}

		$id = $this->_getSanitizedParam("id");
		if ($id == 1) {
			$this->botonpanel = 11;
		}
		if ($id == 2) {
			$this->botonpanel = 9;
		}



		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  actualizar cupos con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de actualizar cupos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
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
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  actualizar cupos  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{


		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_actualizarcupos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");

		if ($id > 0) {

			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar actualizar cupos";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear actualizar cupos";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear actualizar cupos";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}



	/**
	 * Recibe un identificador  y Actualiza la informacion de un actualizar cupos  y redirecciona al listado de actualizar cupos.
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
				$uploadDocument =  new Core_Model_Upload_Document();
				if ($_FILES['archivo_productos']['name'] != '') {
					if ($content->archivo_productos) {
						$uploadDocument->delete($content->archivo_productos);
					}
					$data['archivo_productos'] = $uploadDocument->upload("archivo_productos");
				} else {
					$data['archivo_productos'] = $content->archivo_productos;
				}
				$this->mainModel->update($data, $id);
			}
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR ACTUALIZAR CUPOS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		// header('Location: '.$this->route.''.'');
		if ($id == 1) {
			header('Location: ' . $this->route . '/actcupos' . '');
		}
		if ($id == 2) {
			header('Location: ' . $this->route . '/actproductos' . '');
		}
	}
	public function actproductosAction()
	{
		// Establecer el diseño de la página
		$this->setLayout('blanco');
		// Obtener el nombre del archivo de la base de datos
		$archivoCupos = $this->mainModel->getById(2);
		$archivo = $archivoCupos->archivo_productos;
		$inputFileName = FILE_PATH . $archivo;

		// Cargar el archivo de Excel
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		$infoExcel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		// Inicializar modelos
		$productosModel = new Administracion_Model_DbTable_Productos();
		$categoriasModel = new Administracion_Model_DbTable_Categorias();
		$marcasModel = new Administracion_Model_DbTable_Marcas();
		$distribuidoresModel = new Administracion_Model_DbTable_Distribuidores();
		for ($i = 2; $i <= count($infoExcel); $i++) {
			$fila = $infoExcel[$i];
			$data = [
				'id' => $fila['A'],
				'codigo' => $fila['E'],
				'nombre' => $fila['F'],
				'descripcion' => $fila['G'],
				'precio' => $fila['H'],
				'precio_antes' => $fila['I'],
				'disponibles' => $fila['J'],
				'activo' => $fila['K'],
				'imagen' => $fila['M']
			];
			$categoriaNombre = $fila['B'];
			$subcategoriaNombre = $fila['C'];
			$marcaNombre = $fila['D'];
			$distribuidorNombre = $fila['L'];

			if ($data['codigo'] != '') {
				$producto = $productosModel->getList("codigo='" . $data['codigo'] . "'", "")[0];
				if (!$producto) {

					if ($categoriaNombre) {
						$data["categoria"] = $categoriasModel->getList(" nombre LIKE '%$categoriaNombre' AND nivel='0'", "")[0]->id;
					} else {
						$data["categoria"] = "";
					}

					if ($subcategoriaNombre) {
						$data["n1"] = $categoriasModel->getList(" nombre LIKE '%$subcategoriaNombre' AND nivel='1'", "")[0]->id;
					} else {
						$data["n1"] = "";
					}
					if ($marcaNombre) {
						$data["marca"] = $marcasModel->getList(" nombre LIKE '%$marcaNombre'", "")[0]->id;
					} else {
						$data["marca"] = "";
					}

					if ($distribuidorNombre) {
						$data["distribuidor"] = $distribuidoresModel->getList(" nombre LIKE '%$distribuidorNombre'", "")[0]->id;
					} else {
						$data["distribuidor"] = "";
					}

					$productosModel->insert($data);

				} else {
					if ($data['disponibles'] != "" and $data['disponibles'] != $producto->disponibles) {
						$productosModel->editField($producto->id, "disponibles", $data['disponibles']);
					}
					if ($data['precio'] != "" and $data['precio'] != $producto->disponibles) {
						$productosModel->editField($producto->id, "precio", $data['precio']);
					}
					if ($data['precio_antes'] != "" and $data['precio_antes'] != $producto->precio_antes) {
						$productosModel->editField($producto->id, "precio_antes", $data['precio_antes']);
					}
					if ($data['marca'] != "" and $data['marca'] != $producto->marca) {
						$productosModel->editField($producto->id, "marca", $data['marca']);
					}
					if ($data['imagen'] != "" and $data['imagen'] != $producto->disponibles) {
						$productosModel->editField($producto->id, "imagen", $data['imagen']);
					}
				}
			}
		}
		// Redireccionar después de procesar todas las filas
		header('Location: ' . $this->route . '/manage?id=2' . '');
	}


	public function actcuposAction()
	{


		// Establecer el diseño de la página
		$this->setLayout('blanco');

		// Obtener el nombre del archivo de la base de datos
		$archivoCupos = $this->mainModel->getById(1);
		$archivo = $archivoCupos->archivo_productos;
		$inputFileName = FILE_PATH . $archivo;

		// Cargar el archivo de Excel
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		$infoExcel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		// Inicializar modelos
		$cedulasModel = new Administracion_Model_DbTable_Cedulas();
		$usuariosModel = new Administracion_Model_DbTable_Usuariostienda();

		// Obtener los usuarios de la tabla de cedulas
		$usuariosCedulas = $cedulasModel->getList("", "");
		$usuariosCedulasMap = [];
		foreach ($usuariosCedulas as $usuarioCedula) {
			$usuariosCedulasMap[$usuarioCedula->cedula] = $usuarioCedula;
		}

		// Obtener los usuarios de la tabla de usuarios de tienda
		$usuariosTienda = $usuariosModel->getList("", "");
		$usuariosTiendaMap = [];
		foreach ($usuariosTienda as $usuarioTienda) {
			$usuariosTiendaMap[$usuarioTienda->usuario] = $usuarioTienda;
		}

		// Iterar sobre cada fila del archivo Excel
		for ($i = 2; $i <= count($infoExcel); $i++) {
			$fila = $infoExcel[$i];
			$data = [
				'cedula' => $fila['A'],
				'nombre' => $fila['B'],
				'cupo' => $fila['C'],
				'cupo_soat' => $fila['D']
			];

			// Verificar y procesar usuario en tabla de cedulas
			if (!isset($usuariosCedulasMap[$data['cedula']])) {
				// Si el usuario no existe, insertarlo
				$cedulasModel->insert($data);
			} else {
				// Si el usuario existe, actualizar campos según condiciones
				// Actualizar campo cupo si es diferente de vacío o cero
				if ($data['cupo'] != "" || $data['cupo'] == "0" && ($usuariosCedulasMap[$data['cedula']]->cupo != $data['cupo'])) {
					$cupo = (int)$data['cupo'];
					$cedulasModel->editField($data['cedula'], "cupo", $cupo);
				}
				// Actualizar campo cupo_soat si es diferente de vacío o cero
				if ($data['cupo_soat'] != "" || $data['cupo'] == 0 && ($usuariosCedulasMap[$data['cedula']]->cupo_soat != $data['cupo_soat'])) {
					$cupo_soat = (int)$data['cupo_soat'];
					$cedulasModel->editField($data['cedula'], "cupo_soat", $cupo_soat);
				}
			}

			// Verificar y procesar usuario en tabla de usuarios de tienda
			if (isset($usuariosTiendaMap[$data['cedula']])) {
				// Si el usuario existe, actualizar campos según condiciones
				// Actualizar campos cupo_inicial y cupo_actual si son diferentes de vacío o cero
				if ($data['cupo'] != "" || $data['cupo'] == "0" && ($usuariosTiendaMap[$data['cedula']]->cupo_inicial != $data['cupo'] && $usuariosTiendaMap[$data['cedula']]->cupo_actual != $data['cupo'])) {
					$cupo = (int)$data['cupo'];
					$usuariosModel->editField($usuariosTiendaMap[$data['cedula']]->id, "cupo_inicial", $cupo);
					$usuariosModel->editField($usuariosTiendaMap[$data['cedula']]->id, "cupo_actual", $cupo);
				}
				// Actualizar campo cupo_actual_soat si es diferente de vacío o cero
				if ($data['cupo_soat'] != "" || $data['cupo_soat'] == 0 && ($usuariosTiendaMap[$data['cedula']]->cupo_actual_soat != $data['cupo_soat'])) {
					$cupo_soat = (int)$data['cupo_soat'];
					$usuariosModel->editField($usuariosTiendaMap[$data['cedula']]->id, "cupo_actual_soat", $cupo_soat);
				}

				// Actualizar campo nombre si está vacío
				if ($usuariosTiendaMap[$data['cedula']]->nombre == "") {
					$usuariosModel->editField($usuariosTiendaMap[$data['cedula']]->id, "nombre", $data['nombre']);
				}
			}
		}

		// Redireccionar después de procesar todas las filas
		header('Location: ' . $this->route . '/manage?id=1' . '');
	}


	/**
	 * Recibe un identificador  y elimina un actualizar cupos  y redirecciona al listado de actualizar cupos.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->archivo_productos) && $content->archivo_productos != '') {
						$uploadDocument->delete($content->archivo_productos);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR ACTUALIZAR CUPOS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Actualizarcupos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['archivo'] = $this->_getSanitizedParam("archivo");
		$data['archivo_productos'] = "";
		return $data;
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
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->archivo != '') {
				$filtros = $filtros . " AND archivo LIKE '%" . $filters->archivo . "%'";
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
			$parramsfilter['archivo'] =  $this->_getSanitizedParam("archivo");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
