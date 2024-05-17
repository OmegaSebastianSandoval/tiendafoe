<?php 
/**
* clase que genera la insercion y edicion  de cedulas en la base de datos
*/
class Administracion_Model_DbTable_Cedulas extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'cedulas';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'cedula';

	/**
	 * insert recibe la informacion de un cedulas y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$nombre = $data['nombre'];
		$cupo = $data['cupo'];
		$cupo_soat = $data['cupo_soat'];
		$query = "INSERT INTO cedulas(cedula, nombre, cupo, cupo_soat) VALUES ( '$cedula', '$nombre', '$cupo', '$cupo_soat')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un cedulas  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		$cedula = $data['cedula'];
	
		$nombre = $data['nombre'];
		$cupo = $data['cupo'];
		$cupo_soat = $data['cupo_soat'];
		$query = "UPDATE cedulas SET  nombre = '$nombre', cupo = '$cupo', cupo_soat = '$cupo_soat' WHERE cedula = '".$id."'";
		$res = $this->_conn->query($query);
	}
}