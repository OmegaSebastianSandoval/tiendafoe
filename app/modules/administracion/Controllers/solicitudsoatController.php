<?php

/**
 * Controlador de Solicitudsoat que permite la  creacion, edicion  y eliminacion de los solicitudsoat del Sistema
 */
class Administracion_solicitudsoatController extends Administracion_mainController
{
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
		$this->route = "/administracion/solicitudsoat";
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
		$cedulasModel = new Administracion_Model_DbTable_Cedulas();
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "solicitud_soat.id DESC ";
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
		$lists = $this->mainModel->getListPages($filters, $order, $start, $amount);

		foreach ($lists as $value) {
			$value->usuario = $cedulasModel->getList("cedula = '$value->cedula' ")[0];
		}

		$this->_view->lists = $lists;

		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->list_estado = $this->getEstado();
		$this->_view->res = $this->_getSanitizedParam("res");

		$this->_view->msg_enviar = Session::getInstance()->get("msg_enviar");
		Session::getInstance()->set("msg_enviar", "");
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  solicitudsoat  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudsoat_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_estado = $this->getEstado();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			$cedulasModel = new Administracion_Model_DbTable_Cedulas();
			$costosModel = new Administracion_Model_DbTable_Costossoat();

			$content->usuario = $cedulasModel->getList("cedula = '$content->cedula' ")[0];
			$content->costos = $costosModel->getList("codigo = '$content->cilindraje' ")[0];

			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar solicitudsoat";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear solicitudsoat";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear solicitudsoat";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un solicitudsoat  y redirecciona al listado de solicitudsoat.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if ($_FILES['archivo']['name'] != '') {
				$data['archivo'] = $uploadDocument->upload("archivo");
			}
			$id = $this->mainModel->insert($data);

			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR SOLICITUDSOAT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un solicitudsoat  y redirecciona al listado de solicitudsoat.
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
				if ($_FILES['archivo']['name'] != '') {
					if ($content->archivo) {
						$uploadDocument->delete($content->archivo);
					}
					$data['archivo'] = $uploadDocument->upload("archivo");
				} else {
					$data['archivo'] = $content->archivo;
				}
				$this->mainModel->update($data, $id);
			}
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR SOLICITUDSOAT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un solicitudsoat  y redirecciona al listado de solicitudsoat.
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
					if (isset($content->archivo) && $content->archivo != '') {
						$uploadDocument->delete($content->archivo);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR SOLICITUDSOAT';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	public function enviarpdfAction()
	{
		$this->setLayout('blanco');

		error_reporting(E_ALL);
		$headers = "Content-Type: text/html; charset=UTF-8";

		$id =  $this->_getSanitizedParam("id");
		$content = $this->mainModel->getById($id);
		$cedula = $content->cedula;
		$nombre = $content->nombre;
		$telefono = $content->telefono;
		$email = $content->email;
		$cedula2 = $content->cedula2;
		$nombre2 = $content->nombre2;
		$telefono2 = $content->telefono2;
		$direccion2 = $content->direccion2;
		$ciudad2 = $content->ciudad2;
		$email2 = $content->email2;
		$placa = $content->placa;
		$cilindraje = $content->cilindraje;
		$tipo = $content->tipo;
		$modelo = $content->modelo;
		$pasajeros = $content->pasajeros;
		$valor = $content->valor;
		$valor_soat = $content->valor_soat;
		$valor_descuento = $content->valor_descuento;
		$observaciones = $content->observaciones;
		$metodo = $content->metodo;
		$cuotas = $content->cuotas;

		if ($metodo == 1) {
			$metodo1 = "Crédito";
		}
		if ($metodo == 2) {
			$metodo1 = "PSE";
		}

		$archivo = $content->archivo;



		$asunto = "Documento SOAT - TIENDA VIRTUAL Solicitud #" . $id;
		$mensaje = "
	Estimado asociado, hemos generado el documento SOAT para la solicitud #" . $id . " el cual encontrará adjunto.<br><br>

	<table border='1' align='center' cellpadding='5' cellspacing='0' class='tabla'>
	  <tr>
		<td class='titulo_tabla' colspan='2' style='background-color: #01508A; color: #FFF;'>ASOCIADO</td>
	  </tr>
	  <tr>
		<td>CÉDULA</td>
		<td>" . $cedula . "</td>
	  </tr>
	  <tr>
		<td>NOMBRE</td>
		<td>" . $nombre . "</td>
	  </tr>
	  <tr>
		<td>TELÉFONO</td>
		<td>" . $telefono . "</td>
	  </tr>
	  <tr>
		<td>EMAIL</td>
		<td>" . $email . "</td>
	  </tr>

	  <tr>
		<td class='titulo_tabla' colspan='2' style='background-color: #01508A; color: #FFF;'>ASEGURADO (Propietario del vehículo)</td>
	  </tr>
	  <tr>
		<td>CÉDULA</td>
		<td>" . $cedula2 . "</td>
	  </tr>
	  <tr>
		<td>NOMBRE</td>
		<td>" . $nombre2 . "</td>
	  </tr>
	  <tr>
		<td>TELÉFONO</td>
		<td>" . $telefono2 . "</td>
	  </tr>
	  <tr>
		<td>DIRECCIÓN</td>
		<td>" . $direccion2 . "</td>
	  </tr>
	  <tr>
		<td>CIUDAD</td>
		<td>" . $ciudad2 . "</td>
	  </tr>             
	  <tr>
		<td>EMAIL</td>
		<td>" . $email2 . "</td>
	  </tr> 

	  <tr>
		<td class='titulo_tabla' colspan='2' style='background-color: #01508A; color: #FFF;'>DATOS DEL VEHÍCULO</td>
	  </tr>
	  <tr>
		<td>PLACA</td>
		<td>" . $placa . "</td>
	  </tr>
	  <tr>
		<td>MODELO</td>
		<td>" . $modelo . "</td>
	  </tr>       

	  <tr>
		<td>CILINDRAJE</td>
		<td>" . $cilindraje . "</td>
	  </tr> 

	  <tr>
		<td>TIPO DE VEHÍCULO</td>
		<td>" . $tipo . "</td>
	  </tr>

	  <tr>
		<td>NÚMERO DE PASAJEROS</td>
		<td>" . $pasajeros . "</td>
	  </tr>


	  <tr>
		<td>VALOR SOAT</td>
		<td>$ " . number_format($valor_soat) . "</td>
	  </tr>
	  <tr>
		<td>VALOR DESCUENTO</td>
		<td>$ " . number_format($valor_descuento) . "</td>
	  </tr>        
	  <tr>
		<td>VALOR A PAGAR</td>
		<td>$ " . number_format($valor) . "</td>
	  </tr>         

	  <tr>
		<td>OBSERVACIONES</td>
		<td>" . $observaciones . "</td>
	  </tr>

	  <tr>
		<td>MÉTODO DE PAGO</td>
		<td>" .  $metodo1 . "</td>
	  </tr>  

	  ";
		if ($cuotas > 0) {

			$mensaje .= "    
	  <tr>
		<td>CUOTAS</td>
		<td>" . $cuotas . "</td>
	  </tr>";
		}

		$mensaje .= "</table>";

		$data = [];
		if ($email != "") {
			//$data["mailTo"] = "" . $email;
		}
		if ($email2 != "") {
			//$data["mailCc"] = "" . $email2;
		}
		$data["mailTo"] = "desarrollo8@omegawebsystems.com";

		//$data["mailCc"] .= ",auxservicios2@foebbva.com";




		if ($id && $valor > 0) {
			//ENVIO API
			$token = $this->conectar2();
			$data["subject"] = "" . $asunto;
			$data["certimail"] = "CNC";
			$data["richContent"] = "" . $mensaje;
			//$data["bcc"] = "soporteomega@omegawebsystems.com";
			$data["bcc"] = "desarrollo8@omegawebsystems.com";


			$archivo1 = $archivo;
			$archivo = array();
			$archivo["name"] = "" . $archivo1;
			$archivo["pdfCipherPass"] = "";


			$filename = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $archivo1;
			$file = fopen($filename, "r");

			$filesize = filesize($filename);
			$filetext = fread($file, $filesize);
			fclose($file);


			$archivo["content"] = base64_encode($filetext);

			$data["attachments"][] = $archivo;

			// print_r($data);
			$result = $this->enviar($data, $token);
			//echo $result; 
			//$result = "";
			//ENVIO API
			if ($result == "-1" or $result == "" or $result == NULL) {
				Session::getInstance()->set("msg_enviar", "Lo sentimos, ocurrió un error al enviar la PDF");
				header('Location: ' . $this->route . '?res=danger' . '');
			} else {
				Session::getInstance()->set("msg_enviar", "PDF enviado correctamente");
				header('Location: ' . $this->route . '?res=success' . '');
			}
		}
	}


	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Solicitudsoat.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['cedula'] = $this->_getSanitizedParam("cedula");
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['cedula2'] = $this->_getSanitizedParam("cedula2");
		$data['nombre2'] = $this->_getSanitizedParam("nombre2");
		$data['telefono2'] = $this->_getSanitizedParam("telefono2");
		$data['direccion2'] = $this->_getSanitizedParam("direccion2");
		$data['ciudad2'] = $this->_getSanitizedParam("ciudad2");
		$data['email2'] = $this->_getSanitizedParam("email2");
		$data['placa'] = $this->_getSanitizedParam("placa");
		$data['modelo'] = $this->_getSanitizedParam("modelo");
		$data['cilindraje'] = $this->_getSanitizedParam("cilindraje");
		$data['tipo'] = $this->_getSanitizedParam("tipo");
		$data['pasajeros'] = $this->_getSanitizedParam("pasajeros");
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		$data['valor'] = $this->_getSanitizedParam("valor");
		$data['valor_soat'] = $this->_getSanitizedParam("valor_soat");
		$data['valor_descuento'] = $this->_getSanitizedParam("valor_descuento");
		$data['observaciones'] = $this->_getSanitizedParamHtml("observaciones");
		$data['metodo'] = $this->_getSanitizedParam("metodo");
		$data['aseguradora'] = $this->_getSanitizedParam("aseguradora");
		$data['fecha_vencimiento_soat'] = $this->_getSanitizedParam("fecha_vencimiento_soat");
		$data['archivo'] = "";
		$data['cuotas'] = $this->_getSanitizedParam("cuotas");
		$data['cuota'] = $this->_getSanitizedParam("cuota");
		$data['cupo'] = $this->_getSanitizedParam("cupo");
		$data['radicado'] = $this->_getSanitizedParam("radicado");
		$data['completo'] = $this->_getSanitizedParam("completo");
		$data['quien_completo'] = $this->_getSanitizedParam("quien_completo");
		$data['fecha_completo'] = $this->_getSanitizedParam("fecha_completo");
		$data['estado'] = $this->_getSanitizedParam("estado");
		return $data;
	}

	/**
	 * Genera los valores del campo estado.
	 *
	 * @return array cadena con los valores del campo estado.
	 */
	private function getEstado()
	{
		$array = array();
		$array[2] = "FINALIZADA";
		$array[1] = "EN TRAMITE";
		$array[4] = "DECLINADA";
		return $array;
	}

	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{

		$hoy = date("Y-m-d H:i:s");
		$hoy15 = date("Y-m-d H:i:s", strtotime($hoy . " -15 days"));

		$filtros = " 1 = 1  AND ( (cupo>0 AND cuotas IS NOT NULL) OR (cupo IS NULL AND cuotas IS NOT NULL) OR (cupo='0' AND radicado IS NOT NULL) OR fecha<'2022-04-12 00:00:00' OR completo='1' ) ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->cedula != '') {
				$filtros = $filtros . " AND cedula LIKE '%" . $filters->cedula . "%'";
			}
			if ($filters->nombre != '') {
				$filtros = $filtros . " AND nombre LIKE '%" . $filters->nombre . "%'";
			}
			if ($filters->email != '') {
				$filtros = $filtros . " AND email LIKE '%" . $filters->email . "%'";
			}
			if ($filters->placa != '') {
				$filtros = $filtros . " AND placa LIKE '%" . $filters->placa . "%'";
			}
			if ($filters->fecha != '') {
				$filtros = $filtros . " AND fecha LIKE '%" . $filters->fecha . "%'";
			}
			if ($filters->valor != '') {
				$filtros = $filtros . " AND valor LIKE '%" . $filters->valor . "%'";
			}
			if ($filters->estado != '') {
				if ($filters->estado == 2) {
					$filtros = " 1 = 1 AND fecha>='2022-04-12 00:00:00' AND ( (cupo='0' AND radicado IS NULL) OR (cupo>0 AND cuotas IS NULL) OR (cupo IS NULL AND cuotas IS NULL) ) AND completo IS NULL AND (estado IS NOT NULL OR (estado IS NULL AND fecha>'$hoy15'))";
				}
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
			$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
			$parramsfilter['nombre'] =  $this->_getSanitizedParam("nombre");
			$parramsfilter['email'] =  $this->_getSanitizedParam("email");
			$parramsfilter['placa'] =  $this->_getSanitizedParam("placa");
			$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
			$parramsfilter['valor'] =  $this->_getSanitizedParam("valor");
			$parramsfilter['estado'] =  $this->_getSanitizedParam("estado");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
