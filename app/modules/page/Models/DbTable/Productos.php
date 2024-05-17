<?php 
/**
* clase que genera la insercion y edicion  de producto en la base de datos
*/
class Page_Model_DbTable_Productos extends Db_Table
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


	public function getProductos($filters = '', $order = '')
	{
	  $filter = '';
	  if ($filters != '') {
		$filter = ' WHERE ' . $filters;
	  }
	  $orders = "";
	  if ($order != '') {
		$orders = ' ORDER BY ' . $order;
	  }
	    $select = 'SELECT  
	    productos.*, 
	    marca.id  AS marca_id,
	    marca.nombre AS marca_nombre,
		marca.imagen AS marca_imagen,
		SUM(items.cantidad) AS total_cantidad_envalidacion 
		FROM ' . $this->_name .
		' LEFT JOIN marca ON marca.id = productos.marca 
		LEFT JOIN items ON items.producto = productos.id AND items.validacion = 1 '.
		 $filter . ' GROUP BY
		 productos.id, 
		 marca.id, marca.nombre, marca.imagen  ' . $orders;
	  $res = $this->_conn->query($select)->fetchAsObject();
	  return $res;
	}
  
	public function getProductosPages($filters = '', $order = '', $page, $amount)
	{
	  $filter = '';
	  if ($filters != '') {
		$filter = ' WHERE ' . $filters;
	  }
	  $orders = "";
	  if ($order != '') {
		$orders = ' ORDER BY ' . $order;
	  }
	   $select = 'SELECT  
	  productos.*, 
	  marca.id  AS marca_id,
	  marca.nombre AS marca_nombre,
	  marca.imagen AS marca_imagen,
		SUM(items.cantidad) AS total_cantidad_envalidacion 
		FROM ' . $this->_name . 
	  ' LEFT JOIN marca ON marca.id = productos.marca 
	  LEFT JOIN items ON items.producto = productos.id AND items.validacion = 1 ' .
	   $filter . '  GROUP BY
	   productos.id, 
	   marca.id, marca.nombre, marca.imagen ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
	  $res = $this->_conn->query($select)->fetchAsObject();
	  return $res;
	}
  
}