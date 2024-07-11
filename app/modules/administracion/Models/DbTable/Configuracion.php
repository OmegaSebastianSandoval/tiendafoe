<?php 
/**
* clase que genera la insercion y edicion  de configuracion en la base de datos
*/
class Administracion_Model_DbTable_Configuracion extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'configuracion';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'config_id';

	/**
	 * insert recibe la informacion de un configuracion y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$config_fechacierre = $data['config_fechacierre'];
		$config_fechaapertura = $data['config_fechaapertura'];
		$query = "INSERT INTO configuracion( config_fechacierre, config_fechaapertura) VALUES ( '$config_fechacierre', '$config_fechaapertura')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un configuracion  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$config_fechacierre = $data['config_fechacierre'];
		$config_fechaapertura = $data['config_fechaapertura'];
		$query = "UPDATE configuracion SET  config_fechacierre = '$config_fechacierre', config_fechaapertura = '$config_fechaapertura' WHERE config_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}