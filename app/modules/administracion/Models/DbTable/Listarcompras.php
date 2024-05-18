<?php

/**
 * clase que genera la insercion y edicion  de Listar compras en la base de datos
 */
class Administracion_Model_DbTable_Listarcompras extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'items';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un Listar compras y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$cedula = $data['cedula'];
		$producto = $data['producto'];
		$valor = $data['valor'];
		$cantidad = $data['cantidad'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$nombre = $data['nombre'];
		$direccion = $data['direccion'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$documento = $data['documento'];
		$celular = $data['celular'];
		$barrio = $data['barrio'];
		$cuotas = $data['cuotas'];
		$enviado = $data['enviado'];
		$pagare = $data['pagare'];
		$query = "INSERT INTO items( cedula, producto, valor, cantidad, fecha, validacion, nombre, direccion, ciudad, telefono, documento, celular, barrio, cuotas, enviado, pagare) VALUES ( '$cedula', '$producto', '$valor', '$cantidad', '$fecha', '$validacion', '$nombre', '$direccion', '$ciudad', '$telefono', '$documento', '$celular', '$barrio', '$cuotas', '$enviado', '$pagare')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Listar compras  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$cedula = $data['cedula'];
		$producto = $data['producto'];
		$valor = $data['valor'];
		$cantidad = $data['cantidad'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$nombre = $data['nombre'];
		$direccion = $data['direccion'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$documento = $data['documento'];
		$celular = $data['celular'];
		$barrio = $data['barrio'];
		$cuotas = $data['cuotas'];
		$enviado = $data['enviado'];
		$pagare = $data['pagare'];
		$query = "UPDATE items SET  cedula = '$cedula', producto = '$producto', valor = '$valor', cantidad = '$cantidad', fecha = '$fecha', validacion = '$validacion', nombre = '$nombre', direccion = '$direccion', ciudad = '$ciudad', telefono = '$telefono', documento = '$documento', celular = '$celular', barrio = '$barrio', cuotas = '$cuotas', enviado = '$enviado', pagare = '$pagare' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	public function getListOrdenes($filters = '', $order = '')
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT * FROM ' . $this->_name . ' ' . $filter . ' GROUP BY orden ' . $orders;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}

	public function getListPagesOrdenes($filters = '', $order = '', $page, $amount)
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT * FROM ' . $this->_name . ' ' . $filter . ' GROUP BY orden ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}

	public function getListPagesCompras($filters = '', $order = '', $page, $amount)
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT items.*, usuarios.nombre AS nombre_usuario, productos.nombre AS nombre_producto FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario LEFT JOIN productos ON items.producto = productos.id ' . $filter . ' ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}

	public function getListCompras($filters = '', $order = '')
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT items.*, usuarios.nombre AS nombre_usuario, productos.nombre AS nombre_producto FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario LEFT JOIN productos ON items.producto = productos.id ' . $filter . ' ' . $orders;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}

	public function getListPagesAnalistas($filters = '', $order = '', $page, $amount)
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT items.*, usuarios.nombre AS nombre_usuario, productos.nombre AS nombre_producto, SUM(items.valor*items.cantidad) AS total  FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario LEFT JOIN productos ON items.producto = productos.id ' . $filter . '  GROUP BY items.orden ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}

	public function getListAnalistas($filters = '', $order = '')
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT items.*, usuarios.nombre AS nombre_usuario, productos.nombre AS nombre_producto, SUM(items.valor*items.cantidad) AS total FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario LEFT JOIN productos ON items.producto = productos.id ' . $filter . ' GROUP BY items.orden ' . $orders;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}


	public function getListPagesAlkosto($filters = '', $order = '', $page, $amount)
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT   items.*,
		usuarios.nombre AS nombre_usuario,
		usuarios.ciudad_residencia AS ciudad1,
		usuarios.direccion AS direccion_usuario,
		usuarios.barrio AS barrio_usuario,
		usuarios.celular AS celular_usuario,
		usuarios.telefono AS telefono_usuario, 
		productos.nombre AS nombre_producto,
		SUM(items.valor * items.cantidad) AS total  FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario
		LEFT JOIN productos ON items.producto = productos.id' . $filter . '  GROUP BY items.orden ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}


	public function getListOrdenesYProductos($filters = '', $order = '')
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
		items.*,
		productos.codigo,
		productos.nombre FROM ' . $this->_name . '
		LEFT JOIN productos ON productos.id = items.producto' . $filter . ' ' . $orders;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}
	public function getListAlkosto($filters = '', $order = '')
	{
		$filter = '';
		if ($filters != '') {
			$filter = ' WHERE ' . $filters;
		}
		$orders = "";
		if ($order != '') {
			$orders = ' ORDER BY ' . $order;
		}
		$select = 'SELECT    items.*,
		usuarios.nombre AS nombre_usuario,
		usuarios.ciudad_residencia AS ciudad1,
		usuarios.direccion AS direccion_usuario,
		usuarios.barrio AS barrio_usuario,
		usuarios.celular AS celular_usuario,
		usuarios.telefono AS telefono_usuario, 
		productos.nombre AS nombre_producto,
		SUM(items.valor * items.cantidad) AS total  FROM ' . $this->_name . ' LEFT JOIN usuarios ON items.cedula = usuarios.usuario
		LEFT JOIN productos ON items.producto = productos.id' . $filter . '  GROUP BY items.orden' . $orders;
		$res = $this->_conn->query($select)->fetchAsObject();
		return $res;
	}


	public function insertCarrito($data)
	{
		$cedula = $data['cedula'];
		$producto = $data['producto'];
		$valor = $data['valor'];
		$cantidad = $data['cantidad'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$query = "INSERT INTO items( cedula, producto, valor, cantidad, fecha, validacion) VALUES ( '$cedula', '$producto', '$valor', '$cantidad', '$fecha', '$validacion')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}
	/**
	 * updateCarrito Recibe la información de un carrito y actualiza la información en la base de datos
	 * @param  array $data Array con la información con la cual se va a realizar la actualización en la base de datos
	 * @param  integer $id Identificador al cual se le va a realizar la actualización
	 * @return void
	 */
	public function updateCarrito($cedula, $nombre, $direccion, $ciudad, $telefono, $documento, $barrio, $celular, $cuotas)
	{


		$query = "UPDATE items SET nombre='$nombre', direccion='$direccion',ciudad='$ciudad',telefono='$telefono',documento='$documento',barrio='$barrio',celular='$celular',cuotas='$cuotas' WHERE cedula = '$cedula' AND validacion=0 ";

		$res = $this->_conn->query($query);
		return $res;

	}
	/* http://localhost:8043/page/compra/confirmar?total=%24+179.900&destinatario=BELTRAN+RUIZ+RANFER+MANUEL&tasa=1.58%25&direccion=3123123&-numero-numero=36&barrio=534534&valor-cuota=%24+6.591&ciudad-destino=BOGOTÁ&cuota-fondo-m=%24+750&telefono=123321&documento-destinatario=1069472501&celular=3213213123&cedula=1069472501&valor=179900&cuotas=36&cuota=6590.7802938772&tasa-valor=1.58 */
	public function updateCarritoCantidad($data, $id)
	{
		$cantidad = $data['cantidad'];
		$query = "UPDATE items SET cantidad = '$cantidad', WHERE id = '$id'";
		$res = $this->_conn->query($query);
		return $res;
	}
}
