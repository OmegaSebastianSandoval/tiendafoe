<?php

/**
 * clase que genera la insercion y edicion  de usuario en la base de datos
 */
class Administracion_Model_DbTable_Usuariostienda extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'usuarios';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un usuario y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$activo = $data['activo'];
		$usuario = $data['usuario'];
		$password = $data['password'];
		$nombre = $data['nombre'];
		$correo = $data['correo'];
		$celular = $data['celular'];
		$telefono = $data['telefono'];
		$nivel = $data['nivel'];
		$direccion = $data['direccion'];
		$barrio = $data['barrio'];
		$ciudad_documento = $data['ciudad_documento'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$cuotas = $data['cuotas'];
		$paso = $data['paso'];
		$cupo_inicial = $data['cupo_inicial'];
		$cupo_actual = $data['cupo_actual'];
		$fecha = $data['fecha'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$cupo_actual_soat = $data['cupo_actual_soat'];
		$query = "INSERT INTO usuarios( activo, usuario, password, nombre, correo, celular, telefono, nivel, direccion, barrio, ciudad_documento, ciudad_residencia, cuotas, paso, cupo_inicial, cupo_actual, fecha, fecha_nacimiento, cupo_actual_soat) VALUES ( '$activo', '$usuario', '$password', '$nombre', '$correo', '$celular', '$telefono', '$nivel', '$direccion', '$barrio', '$ciudad_documento', '$ciudad_residencia', '$cuotas', '$paso', '$cupo_inicial', '$cupo_actual', '$fecha', '$fecha_nacimiento', '$cupo_actual_soat')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un usuario  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$activo = $data['activo'];
		$usuario = $data['usuario'];
		$password = $data['password'];
		$nombre = $data['nombre'];
		$correo = $data['correo'];
		$celular = $data['celular'];
		$telefono = $data['telefono'];
		$nivel = $data['nivel'];
		$direccion = $data['direccion'];
		$barrio = $data['barrio'];
		$ciudad_documento = $data['ciudad_documento'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$cuotas = $data['cuotas'];
		$paso = $data['paso'];
		$cupo_inicial = $data['cupo_inicial'];
		$cupo_actual = $data['cupo_actual'];
		$fecha = $data['fecha'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$cupo_actual_soat = $data['cupo_actual_soat'];
		$query = "UPDATE usuarios SET  activo = '$activo', usuario = '$usuario', password = '$password', nombre = '$nombre', correo = '$correo', celular = '$celular', telefono = '$telefono', nivel = '$nivel', direccion = '$direccion', barrio = '$barrio', ciudad_documento = '$ciudad_documento', ciudad_residencia = '$ciudad_residencia', cuotas = '$cuotas', paso = '$paso', cupo_inicial = '$cupo_inicial', cupo_actual = '$cupo_actual', fecha = '$fecha', fecha_nacimiento = '$fecha_nacimiento', cupo_actual_soat = '$cupo_actual_soat' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	public function update2($data, $id)
	{

		$nombre = $data['nombre'];
		$correo = $data['correo'];
		$celular = $data['celular'];
		$telefono = $data['telefono'];
		$direccion = $data['direccion'];
		$ciudad_documento = $data['ciudad_documento'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$fecha = date('Y-m-d H:m:s');
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$query = "UPDATE usuarios SET   nombre = '$nombre', correo = '$correo', celular = '$celular', telefono = '$telefono', direccion = '$direccion',ciudad_documento = '$ciudad_documento', ciudad_residencia = '$ciudad_residencia', fecha = '$fecha', fecha_nacimiento = '$fecha_nacimiento' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
	/**
	 * insert recibe la informacion de un usuario y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insertInicio($data)
	{

		$usuario = $data['usuario'];
		$activo = $data['activo'];
		$nombre = $data['nombre'];
		$nivel = $data['nivel'];
		$paso = $data['paso'];
		$cupo_inicial = $data['cupo_inicial'];
		$cupo_actual = $data['cupo_actual'];
		$cupo_actual_soat = $data['cupo_actual_soat'];
		$query = "INSERT INTO usuarios( usuario, activo, nombre, nivel, paso, cupo_inicial, cupo_actual,  cupo_actual_soat) VALUES (  '$usuario','$activo', , '$nombre', '$nivel', '$paso', '$cupo_inicial', '$cupo_actual',  '$cupo_actual_soat')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}
}
