<?php
require_once 'abstract/AbstractBBDD.php';
require_once './config/Utils.php';

class Usuarios extends AbstractBBDD {

	// Propiedades de la tabla de la BBDD
	public $nombre;
	public $apellidos;
	public $telefono;
	public $email;
	public $cif_nif;
	public $direccion;
	public $codigo_postal;
	public $newsletter;
	public $password;
	public $fecha_alta;
	public $tipo_usuario;
	public $estado;

	protected $c;
	protected $tabla;

	public function __construct()
	{
		$bd = Connection::dameInstancia();
		$this->c = $bd->dameConexion();
		$this->tabla = "usuarios";
	}

	// Getters y Setters
	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function getApellidos() {
		return $this->apellidos;
	}

	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}

	public function getTelefono() {
		return $this->telefono;
	}

	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getFecha_alta() {
		return $this->fecha_alta;
	}

	public function setFecha_alta($fecha_alta) {
		$this->fecha_alta = $fecha_alta;
	}

	public function getTipo_usuario() {
		return $this->tipo_usuario;
	}

	public function setTipo_usuario($tipo_usuario) {
		$this->tipo_usuario = $tipo_usuario;
	}

	public function getEstado() {
		return $this->estado;
	}

	public function setEstado($estado) {
		$this->estado = $estado;
	}
	
	public function getCif_nif() {
		return $this->cif_nif;
	}

	public function setCif_nif($cif_nif) {
		$this->cif_nif = $cif_nif;
	}
	
	public function getDireccion() {
		return $this->direccion;
	}

	public function setDireccion($direccion) {
		$this->direccion = direccion;
	}
	
	public function getCodigo_postal() {
		return $this->codigo_postal;
	}

	public function setCodigo_postal($codigo_postal) {
		$this->codigo_postal = codigo_postal;
	}
	
	public function getNewsletter() {
		return $this->newsletter;
	}

	public function setNewsletter($newsletter) {
		$this->newsletter = newsletter;
	}
	
	public function getById($id) {
			
		$sql = "SELECT * FROM " . $this->tabla . " WHERE id_usuario = " . $id . "";

		if ($this->c->real_query($sql)) {
			if ($resul = $this->c->store_result()) {
				if ($resul->num_rows > 0) {
					return $resul->fetch_assoc();
				}
			}
		}
	}
	
	/**
	 * Recupera todos los usuarios de la tabla por nombre
	 */
	public function mostrarUsuariosPorNombreEnTabla()
	{
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE estado = 'ACTV' AND tipo_usuario = 'USU' ORDER BY nombre ASC";
		$resultados = Usuarios::ejecutarQuery($consulta);
		
		// Pintamos los resultados
		Usuarios::mostrarResultadosUsuarios($resultados);
	}
		
	/**
	 * Recupera todos los usuarios de la tabla por fecha actualización
	 */
	public function mostrarUsuariosPorFechaEnTabla()
	{
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE estado = 'ACTV' AND tipo_usuario = 'USU' ORDER BY fecha_alta DESC";
		$resultados = Usuarios::ejecutarQuery($consulta);

		// Pintamos los resultados
		Usuarios::mostrarResultadosUsuarios($resultados);
	}

	/**
	 * Insertamos un usuario en BBDD
	 */
	public function saveUsuario() {

		$save = false;

		$query = "INSERT INTO " . $this->tabla . " (nombre, apellidos, password,
						email, telefono, cif_nif, direccion, codigo_postal, newsletter, tipo_usuario, estado)
	                	VALUES('" . $this->nick . "',
	                       '" . $this->nombre . "',
	                       '" . $this->apellidos . "',
	                       '" . $this->password . "',
	                       '" . $this->email . "',
	                       '" . $this->telefono . "',
	                       '" . $this->cif_nif . "',
	                       '" . $this->direccion . "',
	                       '" . $this->codigo_postal . "',
	                       '" . $this->newsletter . "',
	                       '" . $this->tipo_usuario . "',
	                       '" . $this->estado . "');";

		$save = $this->c->query($query);
		
		return $save;
	}

	/**
	 * Método que se utiliza para comprobar si un usuario está registrado y poder loguearse.
	 *
	 * @param String $nick
	 * @param String $pass
	 * @return boolean
	 */
	public function esRegistrado($email, $password, $tipo_usuario)
	{
		$resultado = false;

		$passMD5 = md5($password);
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE email = '$email' AND password = '$passMD5' AND tipo_usuario = '$tipo_usuario' AND estado = 'ACTV'";

		$resultados = Usuarios::ejecutarQuery($consulta);

		if ($resultados == 0 || $resultados['numero'] == 0) {
			// No hay datos para mostrar
		} else {
			$resultado = true;
		}

		return $resultado;
	}

	/**
	 * Método que se utiliza para comprobar si un usuario está registrado por su mail.
	 *
	 * @param String $email
	 * @return boolean
	 */
	public function esRegistradoMail($email)
	{
		$resultado = false;

		$consulta = "SELECT * FROM " . $this->tabla . " WHERE email = '" . $mail . "' AND estado = 'ACTV'";
		$resultados = Usuarios::ejecutarQuery($consulta);

		if ($resultados == 0 || $resultados['numero'] == 0) {
			// No hay datos para mostrar
		} else {
			$resultado = true;
		}

		return $resultado;
	}
}