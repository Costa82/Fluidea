<?php
require_once './config/Validations.php';
require_once './config/Correo.php';

ob_start();

$correo = new Correo();

$id = null;

if (isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	
	// Obtenemos el nombre y mail del usuario para enviar el correo del registro en la newsletter
	if ($id != null) {
		
		// Creamos un usuario
		$usuario = new Usuarios();
		
		$usuarioActual = $usuario->getById($id);
		
		if ($usuarioActual != null && $usuarioActual["nombre"] != null && $usuarioActual["email"] != null) {
			
			$nombre = $usuarioActual["nombre"];
			$mail = $usuarioActual["email"];
			
			$envio = $correo->enviarMailsNewsletter($mail, $nombre);
			
			if ($envio == "OK") {
				$usuario->udpateById("newsletter", "SI", $id);
			}
		}
	}
}
	
include_once './views/default/contents/content_newsletter.php';

$contenido = ob_get_clean();

include './views/default/templates/template_generico.php';
?>