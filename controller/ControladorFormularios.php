<?php
require_once './config/Validations.php';
require_once './config/Correo.php';

$correo = new Correo();

/**
 * Controlador de gestión de formularios
 */
class ControladorFormularios {

	/**
	 * Método para el formulario
	 */
	public function formulario() {
		
		$_SESSION['nombre_pagina'] = 'Envio';
		
		//6LeZYaUaAAAAAO-MQb520J8lKHd6CYxPRN_uuRip local
		//6Ld0YqUaAAAAAEfdIihx_EjQ9mzIoVG-a7WdotyP producción
		$recaptcha_secret = '6Ld0YqUaAAAAAEfdIihx_EjQ9mzIoVG-a7WdotyP';
		$recaptcha_response = $_POST['recaptcha_response'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify?");
		curl_setopt($ch, CURLOPT_POST, 1);
		$campos=array('secret'=>$recaptcha_secret,'response'=>$recaptcha_response);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$campos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ch_exec = curl_exec($ch);
		curl_close ($ch);

		$respuesta_google = json_decode($ch_exec);
		
		//FIXME Quitamos hasta más adelante la seguridad de Google
		if($respuesta_google->success === true){

			if(isset($_REQUEST['nombre']) AND isset($_REQUEST['mail']) AND isset($_REQUEST['consulta'])){

				// Creamos un usuario
				$usuario = new Usuarios();

				$usuario->setTipo_usuario("USU");
				$usuario->setEstado("ACTV");
				
				// Campos obligatorios
				$nombre = $_REQUEST['nombre'];
				$usuario->setNombre($nombre);

				$mail = $_REQUEST['mail'];
				$usuario->setEmail($mail);
				$usuario->setNewsletter('NO');
					
				$consulta = $_REQUEST['consulta'];
				
				if (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') {
					$newsletter = "SI";
				} else {
					$newsletter = "NO";
				}
					
				// Enviamos el correo de contacto
				// Comprobamos que no sea ninguno de estos correos (info@basededatos-info.com, yourmail@gmail.com)
				if ($mail === "info@basededatos-info.com" || $mail === "yourmail@gmail.com" || $mail === "artyea@msn.com") {
					$envio = "KO";
				} else {
					$correo = new Correo();
					$id = null;
					// Buscamos si existe el usuario para actualizar su fecha de última entrada
					$id = $usuario->getCampoBy("id_usuario", "email", $mail);
					
					if ($id != null) {
						$hoy = date('Y-m-d H:i:s');
						$usuario->udpateById("fecha_ult_modificacion", $hoy, $id);
						
					} else {
						
						// Guardamos el usuario y calculamos su id para enviarlo en el enlace de la newsletter si hiciera falta
						$usuario->saveUsuario();
						
						if (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') {
							$id = $usuario->getCampoBy("id_usuario", "email", $mail);
						}
					}
					
					$envio = $correo->enviarMailsConsulta($mail, $nombre, $consulta, $newsletter, $id);
				}
					
				// Comprobamos cómo ha ido el envío y registramos el usuario
				if ($envio == "OK") {
					if (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') {
						$_SESSION['nombre_pagina'] = 'Envio_Newsletter';
						$_SESSION['error'] = 101;
					}
					else {
						$_SESSION['error'] = 100;
					}
				} else {
					$_SESSION['error'] = 501;
				}

				// El nombre y el mail tienen que ser obligatorios
			} else {
				$_SESSION['error'] = 502;
			}

		}
		// El recaptcha ha ido mal
		else {
			$_SESSION['error'] = 503;
		}

		if (!headers_sent()) {
			header('Location:respuesta_envio');
			exit;
		}
	}
	
	/**
	 * Método para el formulario_recurso
	 */
	public function formulario_recurso() {
		
		$_SESSION['nombre_pagina'] = 'Envio';
		
		//6LeZYaUaAAAAAO-MQb520J8lKHd6CYxPRN_uuRip local
		//6Ld0YqUaAAAAAEfdIihx_EjQ9mzIoVG-a7WdotyP producción
		$recaptcha_secret = '6Ld0YqUaAAAAAEfdIihx_EjQ9mzIoVG-a7WdotyP';
		$recaptcha_response = $_POST['recaptcha_response'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify?");
		curl_setopt($ch, CURLOPT_POST, 1);
		$campos=array('secret'=>$recaptcha_secret,'response'=>$recaptcha_response);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$campos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ch_exec = curl_exec($ch);
		curl_close ($ch);

		$respuesta_google = json_decode($ch_exec);
		
		//FIXME Quitamos hasta más adelante la seguridad de Google
		if($respuesta_google->success === true){

			if(isset($_REQUEST['nombre']) AND isset($_REQUEST['mail'])){

				// Creamos un usuario
				$usuario = new Usuarios();

				$usuario->setTipo_usuario("USU");
				$usuario->setEstado("ACTV");
				
				// Campos obligatorios
				$nombre = $_REQUEST['nombre'];
				$usuario->setNombre($nombre);

				$mail = $_REQUEST['mail'];
				$usuario->setEmail($mail);
				$usuario->setNewsletter('NO');
					
				// Enviamos el correo de contacto
				// Comprobamos que no sea ninguno de estos correos (info@basededatos-info.com, yourmail@gmail.com)
				if ($mail === "info@basededatos-info.com" || $mail === "yourmail@gmail.com" || $mail === "artyea@msn.com") {
					$envio = "KO";
				} else {
					$correo = new Correo();
					$id = null;
					// Buscamos si existe el usuario para actualizar su fecha de última entrada
					$id = $usuario->getCampoBy("id_usuario", "email", $mail);
					
					if ($id != null) {
						$hoy = date('Y-m-d H:i:s');
						$usuario->udpateById("fecha_ult_modificacion", $hoy, $id);
						
					} else {
						
						// Guardamos el usuario y calculamos su id para enviarlo en el enlace de la newsletter si hiciera falta
						$usuario->saveUsuario();
						
						$id = $usuario->getCampoBy("id_usuario", "email", $mail);
					}
					
					$envio = $correo->enviarMailsConfirmacionFichero($mail, $nombre, $id);
				}
					
				// Comprobamos cómo ha ido el envío y registramos el usuario
				if ($envio == "OK") {
					if ($id != null) {
						$_SESSION['nombre_pagina'] = 'Envio_Recurso';
						$_SESSION['error'] = 101;
					}
					else 
						$_SESSION['error'] = 100;
				} else {
					$_SESSION['error'] = 501;
				}

				// El nombre y el mail tienen que ser obligatorios
			} else {
				$_SESSION['error'] = 502;
			}

		}
		// El recaptcha ha ido mal
		else {
			$_SESSION['error'] = 503;
		}

		if (!headers_sent()) {
			header('Location:respuesta_envio');
			exit;
		}
	}

	/**
	 * Método para cargar la respuesta_envio
	 */
	public function respuesta_envio() {
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/respuesta_envio.php';
	}

}
?>