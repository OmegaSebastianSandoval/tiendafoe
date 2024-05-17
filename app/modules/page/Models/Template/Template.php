<?php

/**
 * 
 */
class Page_Model_Template_Template
{

	protected $_view;

	function __construct($view)
	{
		$this->_view = $view;
	}


	public function getContentseccion($seccion)
	{
		$contenidoModel = new Page_Model_DbTable_Contenido();
		$contenidos = [];
		$rescontenidos = $contenidoModel->getList("contenido_estado='1' AND contenido_seccion = '$seccion' AND contenido_padre = '0' ", "orden ASC");
		foreach ($rescontenidos as $key => $contenido) {
			$contenidos[$key] = [];
			$contenidos[$key]['detalle'] = $contenido;
			$padre = $contenido->contenido_id;
			$hijos = $contenidoModel->getList("contenido_estado='1' AND contenido_padre = '$padre' ", "orden ASC");
			foreach ($hijos as $key2 => $hijo) {
				$padre = $hijo->contenido_id;
				$contenidos[$key]['hijos'][$key2] = [];
				$contenidos[$key]['hijos'][$key2]['detalle'] = $hijo;
				$nietos = $contenidoModel->getList("contenido_padre = '$padre' ", "orden ASC");
				if ($nietos) {
					$contenidos[$key]['hijos'][$key2]['hijos'] = $nietos;
					foreach ($nietos as $key3 => $subnietos) {
						$padre = $subnietos->contenido_id;

						/* if ($_GET['prueba_ambiental'] == "1") {
						  echo $padre . " titulo:" . $subnietos->contenido_titulo . "<br>";
						} */

						//En Nuestros procedimientos > 7. Gestión sostenibilidad > plan ambiental 2020 – 2022 (id 2826) cambiar la información por la del plan ambiental (id 434)
						/* if ($padre == "2826") {
						  $padre = 434;
						} */

						$contenidos[$key]['hijos'][$key2]['hijos'][$key3] = [];
						$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['nietos'] = $subnietos;
						$subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

						//se agrego esta condición porque estaba ordenando las carpetas de plan ambiental en nuestros procedicimientos al reves
						/* if ($subnietos->contenido_id == "2826") {
						  $subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden DESC");
						} */

						if ($subnietos2) {
							$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'] = $subnietos2;
							//documentos y carpetas nivel3
							foreach ($subnietos2 as $key4 => $subsubnietos) {

								$padre = $subsubnietos->contenido_id;
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4] = [];
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['detalle'][$key4]['subsubnietos'] = $subsubnietos;
								$subsubnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

								$contenidos['hijos_' . $padre] = $subsubnietos2;

								if ($subsubnietos2) {
									$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4]['subsubnietos'] = $subsubnietos2;
									//documentos y carpetas nivel4
									foreach ($subsubnietos2 as $key5 => $bisnietos) {
										$padre = $bisnietos->contenido_id;
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5] = [];
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['detalle'][$key5]['bisnietos'] = $bisnietos;
										$bisnietos = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

										$contenidos['hijos_' . $padre] = $bisnietos;

										if ($bisnietos) {
											//documentos y carpetas nivel5
											$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'] = $bisnietos;


											foreach ($bisnietos as $key6 => $bisnietos2) {
												$padre = $bisnietos2->contenido_id;
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6] = [];
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos']['detalle'][$key6]['bisnietos2'] = $bisnietos2;
												$bisnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

												$contenidos['hijos_' . $padre] = $bisnietos2;

												if ($bisnietos2) {
													//documentos y carpetas nivel6
													$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6]['bisnietos2'] = $bisnietos2;


													foreach ($bisnietos2 as $key7 => $bisnietos3) {
														$padre = $bisnietos3->contenido_id;
														$bisnietos3 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");
														$contenidos['hijos_' . $padre] = $bisnietos3;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$this->_view->contenidos = $contenidos;
		return $this->_view->getRoutPHP("modules/page/Views/template/contenedor.php");
	}


	public function productosPanel()
	{
		// error_reporting(E_ALL);
		$this->_view->productos = $this->productos();
		$this->_view->paginacion = $this->paginacion();
		$this->_view->categorias = $this->categorias();
		return $this->_view->getRoutPHP("modules/page/Views/template/panel.php");
	}
	public function productoById($idProducto)
	{
		// error_reporting(E_ALL);
		$this->_view->productos = $this->productoInd($idProducto);
		$this->_view->categorias = $this->categorias();
		return $this->_view->getRoutPHP("modules/page/Views/template/panel.php");
	}

	public function productos()
	{
		// Instanciación del modelo de productos.
		$productosModel = new Page_Model_DbTable_Productos();

		// Creación del filtro SQL basado en los parámetros de entrada.
		$filtro = $this->crearFiltro([
			'categoria' => $_GET['categoria'] ?? '',
			'sub' => $_GET['sub'] ?? '',
			'buscar' => $_POST['buscar'] ?? ''
		]);
		// echo $filtro;
		//enviar parametros de cateogira y subcategoria  a la vista
		$_GET['categoria'] ? $this->_view->idCategoria = $_GET['categoria'] : null;
		$_GET['sub'] ? $this->_view->idSubCategoria = $_GET['sub'] : null;
		$_POST['buscar'] ? $this->_view->buscar = $_POST['buscar'] : null;
		// print_r($filtro);	
		// Determinación del orden de los resultados de la consulta.
		$orden = $this->determinarOrden($_GET['categoria'] ?? '');

		// Obtención de productos filtrados y ordenados.
		$productos = $productosModel->getProductos("activo = '1' $filtro", $orden);

		// Determinación de la página actual.
		$page = $this->determinarPagina();

		// Cálculo de la paginación para obtener el inicio y la cantidad de productos por página.
		list($start, $amount) = $this->calcularPaginacion($productos);

		// Asignación de los productos y las páginas para la vista.
		$this->_view->list = $productos;
		$this->_view->page = $page;
		$this->_view->pages = $this->pages;
		$this->_view->register_number = count($productos);
		$this->_view->totalpages = ceil(count($productos) / $amount);

		$this->_view->listPages = $productosModel->getProductosPages("productos.activo = '1' $filtro", $orden, $start, $amount);
		
		// Devolución de la vista con los productos listados.
		return $this->_view->getRoutPHP("modules/page/Views/template/productos.php");
	}

	private function crearFiltro($params)
	{
		// Inicialización del filtro SQL.
		$filtro = "";
		// Añade filtro de categoría si está presente.
		if ($params['categoria']) {
			$filtro .= " AND categoria='{$params['categoria']}' ";
		}
		// Añade filtro de subcategoría si está presente.
		if ($params['sub']) {
			$filtro .= " AND n1='{$params['sub']}' ";
		}
		// Añade filtro de búsqueda si está presente.
		if ($params['buscar']) {
			$buscar = '%' . $params['buscar'] . '%';
			$filtro .= " AND productos.nombre LIKE '$buscar'";
		}
		return $filtro;
	}

	private function determinarOrden($categoria)
	{
		// Retorna el orden de los productos basado en la presencia o ausencia de categoría.
		return $categoria ? "productos.precio ASC" : "productos.id DESC";
	}

	private function determinarPagina()
	{
		// Gestión de la sesión para recordar la página actual.
		$session = Session::getInstance();
		// Determinación de la página actual, recurriendo a la sesión si es necesario.
		$page = $_GET['page'] ?? $session->get($this->namepageactual) ?? 1;
		// Actualización de la página actual en la sesión.
		$session->set($this->namepageactual, $page);
		return $page;
	}

	private function calcularPaginacion($productos)
	{
		// Cantidad fija de productos por página.
		$amount = 21;
		// Cálculo del total de productos.
		$total = count($productos);
		// Determinación de la página actual.
		$page = $this->determinarPagina();
		// Cálculo del inicio de la paginación.
		$start = ($page - 1) * $amount;
		return [$start, $amount];
	}


	public function categorias($categoria = '')
	{
		$categoriasModel = new Administracion_Model_DbTable_Categorias();
		$categorias = $categoriasModel->getList("activa = '1' AND padre = '0'", "nombre ASC");
		foreach ($categorias as $categoria) {
			$categoria->subcategorias = $categoriasModel->getList("activa = '1' AND padre = '$categoria->id'", "nombre ASC");
		}
		$this->_view->listcategorias = $categorias;





		return $this->_view->getRoutPHP("modules/page/Views/template/categorias.php");
	}

	public function paginacion()
	{
		return $this->_view->getRoutPHP("modules/page/Views/template/paginacion.php");
	}


	public function productoInd($id)
	{
		// Instanciación del modelo de productos.
		$productosModel = new Page_Model_DbTable_Productos();
		$marcaModel = new Administracion_Model_DbTable_Marcas();
		$itemsModel = new Administracion_Model_DbTable_Listarcompras();

		$producto = $productosModel->getById($id);
		$marca = $marcaModel->getById($producto->marca);
		$productosEnValidacion = $itemsModel->getList("producto = '$id' AND validacion = '1'");
		$cantidadEnValidacion  = 0;

		foreach ($productosEnValidacion as $productoEnValidacion) {
			$cantidadEnValidacion += (int)$productoEnValidacion->cantidad;
		}

		$cat =  $_GET['c'];
		$subCat = $_GET['s'];
		$enlace = "/page/tienda";
		// Inicializa el enlace base
		if ($cat) {
			$enlace .= "?categoria=$cat";
		}

		// Agrega subcategoría al enlace si existe
		if ($subCat) {
			// Verifica si ya hay un parámetro de categoría para decidir si agregar '&' o '?'
			$enlace .= $cat ? "&sub=$subCat" : "?sub=$subCat";
		}
		$this->_view->enlace = $enlace;
		

		$this->_view->producto = $producto;
		$this->_view->marca = $marca;
		$this->_view->cantidadEnValidacion = $cantidadEnValidacion;


		// Devolución de la vista con los productos listados.
		return $this->_view->getRoutPHP("modules/page/Views/template/detalle.php");
	}


	public function banner($seccion)
	{
		$this->_view->seccionbanner = $seccion;
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		$this->_view->banners = $publicidadModel->getList("publicidad_seccion = '$seccion' AND publicidad_estado = '1'", "orden ASC");

		return $this->_view->getRoutPHP("modules/page/Views/template/bannerprincipal.php");
	}
	public function bannerPrincipal($seccion)
	{
		$this->_view->seccionbanner = $seccion;
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		$this->_view->banners = $publicidadModel->getList("publicidad_seccion = '$seccion' AND publicidad_estado = '1'", "orden ASC");

		return $this->_view->getRoutPHP("modules/page/Views/template/bannerprincipal.php");
	}
}
