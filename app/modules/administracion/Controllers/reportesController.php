<?php
/**
 * Controlador de Usuario que permite la  creacion, edicion  y eliminacion de los Usuarios del Sistema
 */
class Administracion_reportesController extends Administracion_mainController
{
	public $botonpanel = 14;





	public function indexAction()
	{
		$title = "Reportes";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;

	}

	public function reporteusuariosAction()
	{
		$this->setLayout('blanco');
		$usuariosModel = new Administracion_Model_DbTable_Usuariostienda();
		$usuarios = $usuariosModel->getList("id!=-2 AND activo=1", "");
		foreach ($usuarios as $usuario) {
			if ($usuario->correo == '') {
				$cedula = $usuario->usuario;
				$usuario2 = $usuariosModel->getList("usuario='$cedula'", "")[0];
				if ($usuario->nombre == "") {
					$usuario->nombre = $usuario2->nombre;
				}
				if ($usuario->correo == "") {
					$usuario->correo = $usuario2->correo;
				}
				if ($usuario->celular == "") {
					$usuario->celular = $usuario2->celular;
				}
				if ($usuario->telefono == "") {
					$usuario->telefono = $usuario2->telefono;
				}
				if ($usuario->direccion == "") {
					$usuario->direccion = $usuario2->direccion;
				}
				if ($usuario->barrio == "") {
					$usuario->barrio = $usuario2->barrio;
				}
				if ($usuario->ciudad_documento == "") {
					$usuario->ciudad_documento = $usuario2->ciudad_documento;
				}
				if ($usuario->ciudad_residencia == "") {
					$usuario->ciudad_residencia = $usuario2->ciudad_residencia;
				}
				if ($usuario->fecha_nacimiento == "") {
					$usuario->fecha_nacimiento = $usuario2->fecha_nacimiento;
				}


			}
		}

		$this->_view->usuarios = $usuarios;

		$excel = $this->_getSanitizedParam('excel');
		$hoy = date("YmdHis");

		if ($excel == 1) {
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=reporte_usuarios_$hoy.xls");
		}



	}

	public function reportecomprasAction()
	{
		$usuariosModel = new Administracion_Model_DbTable_Usuariostienda();
		$itemsModel = new Administracion_Model_DbTable_Listarcompras();
		$productosModel = new Administracion_Model_DbTable_Productos();
		$fecha1 = $this->_getSanitizedParam('fecha1');
		$fecha2 = $this->_getSanitizedParam('fecha2');

		$f1 = "";
		if ($fecha1 != "" and $fecha2) {
			$fecha1 = $fecha1 . " 00:00:00";
			$fecha2 = $fecha2 . " 23:59:59";
			$this->_view->fecha1 = $fecha1;	
			$this->_view->fecha2 = $fecha2;
			$f1 = " AND items.fecha >= '$fecha1' AND items.fecha <= '$fecha2' ";
		}
		
		
		$excel = $this->_getSanitizedParam('excel');


		$limite = " LIMIT 50";
		if ($excel == "1") {
			$limite = "";
		}

		$usuarios = $usuariosModel->getList("id!=-2 AND activo=1", "");

		$compras = $itemsModel->getList("validacion='1' AND cedula>0 $f1", "orden ASC, cedula ASC, fecha ASC $limite ");


		$hoy = date("YmdHis");
		if ($excel == 1) {
			$this->setLayout('blanco');
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=reporte_compras_$hoy.xls");
		}
	}


}