<?php 
/**
* clase que genera la insercion y edicion  de producto en la base de datos
*/
class Administracion_Model_DbTable_Productos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'productos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un producto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$activo = $data['activo'];
		$categoria = $data['categoria'];
		$n1 = $data['n1'];
		$codigo = $data['codigo'];
		$marca = $data['marca'];
		$nombre = $data['nombre'];
		$imagen = $data['imagen'];
		$precio = $data['precio'];
		$precio_antes = $data['precio_antes'];
		$disponibles = $data['disponibles'];
		$distribuidor = $data['distribuidor'];
		$descripcion = $data['descripcion'];
		$query = "INSERT INTO productos( activo, categoria, n1, codigo, marca, nombre, imagen, precio, precio_antes, disponibles, distribuidor, descripcion) VALUES ( '$activo', '$categoria', '$n1', '$codigo', '$marca', '$nombre', '$imagen', '$precio', '$precio_antes', '$disponibles', '$distribuidor', '$descripcion')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un producto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$activo = $data['activo'];
		$categoria = $data['categoria'];
		$n1 = $data['n1'];
		$codigo = $data['codigo'];
		$marca = $data['marca'];
		$nombre = $data['nombre'];
		$imagen = $data['imagen'];
		$precio = $data['precio'];
		$precio_antes = $data['precio_antes'];
		$disponibles = $data['disponibles'];
		$distribuidor = $data['distribuidor'];
		$descripcion = $data['descripcion'];
		$query = "UPDATE productos SET  activo = '$activo', categoria = '$categoria', n1 = '$n1', codigo = '$codigo', marca = '$marca', nombre = '$nombre', imagen = '$imagen', precio = '$precio', precio_antes = '$precio_antes', disponibles = '$disponibles', distribuidor = '$distribuidor', descripcion = '$descripcion' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}


	public function getListReporte()
	{

	  $select = "SELECT productos.*, marca.nombre AS marca, categoria.nombre AS categoria, distribuidor.nombre AS distribuidor, categoria2.nombre AS n1 FROM (((productos LEFT JOIN categoria ON productos.categoria = categoria.id) LEFT JOIN marca ON productos.marca = marca.id) LEFT JOIN distribuidor ON distribuidor.id = productos.distribuidor) LEFT JOIN categoria AS categoria2 ON categoria2.id = productos.n1 ORDER BY categoria.nombre, marca.nombre, distribuidor.nombre ";
	  $res = $this->_conn->query($select)->fetchAsObject();
	  return $res;
	}
}