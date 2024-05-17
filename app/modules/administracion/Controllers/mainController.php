<?php 

/**
*
*/

class Administracion_mainController extends Controllers_Abstract
{
	protected $namepages;

	

	public function init()
	{
		$this->_view->botonpanel = $this->botonpanel;
		$this->setLayout('administracion_panel');
		$botoneralateral = $this->_view->getRoutPHP('modules/administracion/Views/partials/botoneralateral.php');
		$this->getLayout()->setData("panel_botones",$botoneralateral);
		$botonerasuperior = $this->_view->getRoutPHP('modules/administracion/Views/partials/botonerasuperior.php');
		$this->getLayout()->setData("panel_header",$botonerasuperior);
		if((Session::getInstance()->get("kt_login_id") < 0 || Session::getInstance()->get("kt_login_id","") == '')){
			header('Location: /administracion/');
		}
		$inactivo = 9000000;
		if( Session::getInstance()->get('tiempo') != '' ) {
			$vida_session = time() - Session::getInstance()->get('tiempo');
			if($vida_session > $inactivo){
				session_destroy();
				header('Location: /administracion/?inactividad==1');
			}
		}
		Session::getInstance()->set("tiempo",time());
	}

	public function changepageAction()
	{
		Session::getInstance()->set($this->namepages,$this->_getSanitizedParam("pages"));
	}

	public function orderAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id1 =  $this->_getSanitizedParam("id1");
			$id2 =  $this->_getSanitizedParam("id2");
			if (isset($id1) && $id1 > 0 && isset($id2) && $id2 > 0) {
				$content1 = $this->mainModel->getById($id1);
				$content2 = $this->mainModel->getById($id2);
				if (isset($content1) && isset($content2)) {
					$order1 = $content1->orden;
					$order2 = $content2->orden;
					$this->mainModel->changeOrder($order2,$id1);
					$this->mainModel->changeOrder($order1,$id2);
				}
			}
		}
	}

	public function deleteimageAction(){
		$this->setLayout('blanco');
		header('Content-Type:application/json');
		$campo = $this->_getSanitizedParam("campo");
		$id = $this->_getSanitizedParam("id");
		$csrf = $this->_getSanitizedParam("csrf");
		$elimino = 0;
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->$campo != '') {
				$modelUploadImage= new Core_Model_Upload_Image();
				$this->mainModel->editField($id,$campo,'');
				$modelUploadImage->delete($content->$campo);
				$elimino = 1;
			}
		}
		echo json_encode(array('elimino' => $elimino ));
	}
	public function deletearchivoAction(){
		$this->setLayout('blanco');
		header('Content-Type:application/json');
		$campo = $this->_getSanitizedParam("campo");
		$id = $this->_getSanitizedParam("id");
		$csrf = $this->_getSanitizedParam("csrf");
		$elimino = 0;
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->$campo != '') {
				$modelUploadDocument= new Core_Model_Upload_Document();
				$this->mainModel->editField($id,$campo,'');
				$modelUploadDocument->delete($content->$campo);
				$elimino = 1;
			}
		}
		echo json_encode(array('elimino' => $elimino ));
	}

	function conectar2()
	{


		$url = "http://notify-it.com/notify/services/checkAccount?u=comercial@foebbva.notify-it.com&p=9864912c-77e8-4a0b-aed0-e009489aca2d";

		$data = array();

		$ch = curl_init($url);
		# Setup request to send json via POST.
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		//echo "<pre>$result</pre>";

		return $result;
	}

	function enviar($data, $token)
	{


		$url = "http://notify-it.com/notify/services/sendImmediateEmailNotification?login=comercial@foebbva.notify-it.com&password=9864912c-77e8-4a0b-aed0-e009489aca2d";

		$authorization = "Authorization: Bearer " . $token; // Prepare the authorisation token

		$ch = curl_init($url);
		# Setup request to send json via POST.
		$payload = json_encode($data);

		//echo $payload;

		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
		# Return response instead of printing.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		# Send request.
		$result = curl_exec($ch);
		//echo 'Curl error: ' . curl_error($ch).'<br>';
		curl_close($ch);
		# Print response.
		//echo "<pre>$result</pre>";

		return $result;
	}

}