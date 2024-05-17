<?php 
/**
* clase que genera la insercion y edicion  de costossoat en la base de datos
*/
class Administracion_Model_DbTable_Costossoat extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'costos_soat';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un costossoat y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$codigo = $data['codigo'];
		$clase = $data['clase'];
		$subtipo = $data['subtipo'];
		$antiguedad = $data['antiguedad'];
		$valor = $data['valor'];
		$query = "INSERT INTO costos_soat( codigo, clase, subtipo, antiguedad, valor) VALUES ( '$codigo', '$clase', '$subtipo', '$antiguedad', '$valor')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un costossoat  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$codigo = $data['codigo'];
		$clase = $data['clase'];
		$subtipo = $data['subtipo'];
		$antiguedad = $data['antiguedad'];
		$valor = $data['valor'];
		$query = "UPDATE costos_soat SET  codigo = '$codigo', clase = '$clase', subtipo = '$subtipo', antiguedad = '$antiguedad', valor = '$valor' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}