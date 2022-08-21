<?php
require_once 'abstract/AbstractBBDD.php';
require_once './config/Utils.php';

class Pedidos extends AbstractBBDD {

	// Propiedades de la tabla de la BBDD
	public $id_pedido;
	public $id_usuario;
	public $tipo;
	public $descripcion;
	public $fecha_alta;
	public $fecha_ult_modificacion;
	public $estado;

	protected $c;
	protected $tabla;

	public function __construct() {
		$bd = Connection::dameInstancia();
		$this->c = $bd->dameConexion();
		$this->tabla = "pedidos";
	}

	// Getters y Setters
	public function getId_usuario() {
		return $this->id_usuario;
	}

	public function setId_usuario($id_usuario) {
		$this->id_usuario = $id_usuario;
	}
	
	public function getTipo() {
		return $this->tipo;
	}

	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}

	public function getDescripcion() {
		return $this->descripcion;
	}

	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}	
		
	public function getFecha() {
		return $this->fecha;
	}

	public function setFecha($fecha) {
		$this->fecha = $fecha;
	}
	
	public function getEstado() {
		return $this->estado;
	}

	public function setEstado($estado) {
		$this->estado = $estado;
	}
	
	public function getById($id) {
			
		$sql = "SELECT * FROM " . $this->tabla . " WHERE id_pedido = " . $id . "";

		if ($this->c->real_query($sql)) {
			if ($resul = $this->c->store_result()) {
				if ($resul->num_rows > 0) {
					return $resul->fetch_assoc();
				}
			}
		}
	}
	
	/**
	 * Insertamos un pedido en BBDD
	 */
	public function savePedido() {

		$save = false;

		$query = "INSERT INTO " . $this->tabla . " (id_usuario, tipo, descripcion, estado)
	                	VALUES('" . $this->id_usuario . "',
	                		'" . $this->tipo . "',
	                       '" . $this->descripcion . "',
	                       '" . $this->estado . "');";

		$save = $this->c->query($query);
		
		return $save;
	}

}