<div class='contenedor_texto'>

	<div class='texto'>
	
	<?php
	
		// Plantillas de la respuesta del envío del formulario
		if (isset($params['error']) && $params['error'] != 0) {
			
			switch ($params['error']) {
				// Error en el envío del formulario
				case 501:
					include_once('./views/default/templates/template_envio_fallido.php');
				break;
				
				// El nombre y el mail tienen que ser obligatorios
				case 502:
					include_once('./views/default/templates/template_envio_fallido.php');
				break;
				
				// Error en la validación del Recaptcha de google
				case 503:
					include_once('./views/default/templates/template_envio_fallido_recaptcha.php');
				break;
				
				// Envío fallido por defecto
				default:
					include_once('./views/default/templates/template_envio_fallido.php');
				break;
			}
			
		// Envío correcto	
		} else {
			include_once('./views/default/templates/template_envio_correcto.php');
		}
		
	?>
	
	</div>

</div>