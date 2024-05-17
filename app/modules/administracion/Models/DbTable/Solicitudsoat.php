<?php 
/**
* clase que genera la insercion y edicion  de solicitudsoat en la base de datos
*/
class Administracion_Model_DbTable_Solicitudsoat extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'solicitud_soat';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un solicitudsoat y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$nombre = $data['nombre'];
		$telefono = $data['telefono'];
		$email = $data['email'];
		$cedula2 = $data['cedula2'];
		$nombre2 = $data['nombre2'];
		$telefono2 = $data['telefono2'];
		$direccion2 = $data['direccion2'];
		$ciudad2 = $data['ciudad2'];
		$email2 = $data['email2'];
		$placa = $data['placa'];
		$modelo = $data['modelo'];
		$cilindraje = $data['cilindraje'];
		$tipo = $data['tipo'];
		$pasajeros = $data['pasajeros'];
		$fecha = $data['fecha'];
		$valor = $data['valor'];
		$valor_soat = $data['valor_soat'];
		$valor_descuento = $data['valor_descuento'];
		$observaciones = $data['observaciones'];
		$metodo = $data['metodo'];
		$aseguradora = $data['aseguradora'];
		$fecha_vencimiento_soat = $data['fecha_vencimiento_soat'];
		$archivo = $data['archivo'];
		$cuotas = $data['cuotas'];
		$cuota = $data['cuota'];
		$cupo = $data['cupo'];
		$radicado = $data['radicado'];
		$completo = $data['completo'];
		$quien_completo = $data['quien_completo'];
		$fecha_completo = $data['fecha_completo'];
		$estado = $data['estado'];
		$query = "INSERT INTO solicitud_soat( cedula, nombre, telefono, email, cedula2, nombre2, telefono2, direccion2, ciudad2, email2, placa, modelo, cilindraje, tipo, pasajeros, fecha, valor, valor_soat, valor_descuento, observaciones, metodo, aseguradora, fecha_vencimiento_soat, archivo, cuotas, cuota, cupo, radicado, completo, quien_completo, fecha_completo, estado) VALUES ( '$cedula', '$nombre', '$telefono', '$email', '$cedula2', '$nombre2', '$telefono2', '$direccion2', '$ciudad2', '$email2', '$placa', '$modelo', '$cilindraje', '$tipo', '$pasajeros', '$fecha', '$valor', '$valor_soat', '$valor_descuento', '$observaciones', '$metodo', '$aseguradora', '$fecha_vencimiento_soat', '$archivo', '$cuotas', '$cuota', '$cupo', '$radicado', '$completo', '$quien_completo', '$fecha_completo', '$estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un solicitudsoat  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cedula = $data['cedula'];
		$nombre = $data['nombre'];
		$telefono = $data['telefono'];
		$email = $data['email'];
		$cedula2 = $data['cedula2'];
		$nombre2 = $data['nombre2'];
		$telefono2 = $data['telefono2'];
		$direccion2 = $data['direccion2'];
		$ciudad2 = $data['ciudad2'];
		$email2 = $data['email2'];
		$placa = $data['placa'];
		$modelo = $data['modelo'];
		$cilindraje = $data['cilindraje'];
		$tipo = $data['tipo'];
		$pasajeros = $data['pasajeros'];
		$fecha = $data['fecha'];
		$valor = $data['valor'];
		$valor_soat = $data['valor_soat'];
		$valor_descuento = $data['valor_descuento'];
		$observaciones = $data['observaciones'];
		$metodo = $data['metodo'];
		$aseguradora = $data['aseguradora'];
		$fecha_vencimiento_soat = $data['fecha_vencimiento_soat'];
		$archivo = $data['archivo'];
		$cuotas = $data['cuotas'];
		$cuota = $data['cuota'];
		$cupo = $data['cupo'];
		$radicado = $data['radicado'];
		$completo = $data['completo'];
		$quien_completo = $data['quien_completo'];
		$fecha_completo = $data['fecha_completo'];
		$estado = $data['estado'];
		$query = "UPDATE solicitud_soat SET  cedula = '$cedula', nombre = '$nombre', telefono = '$telefono', email = '$email', cedula2 = '$cedula2', nombre2 = '$nombre2', telefono2 = '$telefono2', direccion2 = '$direccion2', ciudad2 = '$ciudad2', email2 = '$email2', placa = '$placa', modelo = '$modelo', cilindraje = '$cilindraje', tipo = '$tipo', pasajeros = '$pasajeros', fecha = '$fecha', valor = '$valor', valor_soat = '$valor_soat', valor_descuento = '$valor_descuento', observaciones = '$observaciones', metodo = '$metodo', aseguradora = '$aseguradora', fecha_vencimiento_soat = '$fecha_vencimiento_soat', archivo = '$archivo', cuotas = '$cuotas', cuota = '$cuota', cupo = '$cupo', radicado = '$radicado', completo = '$completo', quien_completo = '$quien_completo', fecha_completo = '$fecha_completo', estado = '$estado' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}