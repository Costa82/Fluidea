<!-- Plantilla genérica -->

<!DOCTYPE html>
<html lang="es" prefix="og: http://ogp.me/ns#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="es"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description"
	content="" />
<meta name="robots" content="NOODP">
<title>

<?php 
if (isset($_SESSION['nombre_pagina']))
	echo $_SESSION['nombre_pagina'];
else
	echo 'Fluidea';
?>

</title>
<link type="text/css" rel="stylesheet" href="./views/default/css/font-awesome.css" />

<link href='https://fonts.googleapis.com/css?family=Pathway+Gothic+One'
	rel='stylesheet' type='text/css' />
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah"
	rel="stylesheet">
<link href="apple-touch-icon.png" rel="apple-touch-icon" />
<link href="apple-touch-icon-152x152.png" rel="apple-touch-icon"
	sizes="152x152" />
<link href="apple-touch-icon-167x167.png" rel="apple-touch-icon"
	sizes="167x167" />
<link href="apple-touch-icon-180x180.png" rel="apple-touch-icon"
	sizes="180x180" />
<link href="icon-hires.png" rel="icon" sizes="192x192" />
<link href="icon-normal.png" rel="icon" sizes="128x128" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
<script src="./views/default/jquery/jquery-3.1.1.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.min.js"
	type="text/javascript"></script>
	
<!-- Inicio Calendly -->
<link href="https://assets.calendly.com/assets/external/widget.css"
	rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js"
	type="text/javascript"></script>
<!-- Fin Calendly -->

<!-- Inicio Recaptcha -->
<script
	src='https://www.google.com/recaptcha/api.js?render=6Ld0YqUaAAAAAE8bIzEdbqnkxxAlJB8C609rz53B'> 
	//6LeZYaUaAAAAAKmOGIfLSFGo7We4TrIDUQWvMcOH local
	//6Ld0YqUaAAAAAE8bIzEdbqnkxxAlJB8C609rz53B producción
</script>

<script>
	grecaptcha.ready(function() {
	grecaptcha.execute('6Ld0YqUaAAAAAE8bIzEdbqnkxxAlJB8C609rz53B', {action: 'newsletter'})
	.then(function(token) {
	var recaptchaResponse = document.getElementById('recaptchaResponse');
	recaptchaResponse.value = token;
	});});
</script>
<!-- Fin Recaptcha -->

<!-- Inicio Validación formulario -->
<script>
     function validar(){
     	if (document.getElementById('condiciones').checked){
        	return true;
        } else {
            alert("El formulario no puede ser enviado si no acepta el Aviso Legal y la Política de Privacidad");
            return false;
        }
      }
</script>
<!-- Fin Validación formulario -->

<!-- Metemos un aleatorio para la recarga automAtica del css y el js -->
<script>

    var rutacss1 = "./views/default/css/main.css?" + Math.random();
    var rutajs1 = "./views/default/jquery/jquery_general.js?" + Math.random();
    var script = "script";
    
    document.write('<link rel="stylesheet" href="' + rutacss1 + '" type="text/css" media="screen" />');
    document.write('<script src="' + rutajs1 + '"></' + script + '>');
	
</script>

</head>
<body>
	
	<!-- Cookiebot -->
	<?php 
	if (isset($_SESSION['nombre_pagina']) && $_SESSION['nombre_pagina'] == 'Fluidea') {
		echo "<script id='Cookiebot' src='https://consent.cookiebot.com/uc.js' data-cbid='dbca5b10-a523-48f1-a962-c8c8871393a7' 
		data-blockingmode='auto' type='text/javascript'></script>";
	}
	?>
	
	<header>

		<!-- Menú navegación -->
		<?php 
		if (isset($_SESSION['nombre_pagina'])) {
			$nombre_pagina = $_SESSION['nombre_pagina'];
			
			switch ($nombre_pagina) {
		    case 'Fluidea':
		        echo "<nav class='menuNavGrande fluidea'>";
		        break;
		    case 'Detrás de Fluidea':
		        echo "<nav class='menuNavGrande detras'>";
		        break;
		    case 'Servicios':
		        echo "<nav class='menuNavGrande servicios'>";
		        break;
		    case 'Contacto':
		        echo "<nav class='menuNavGrande contacto'>";
		        break;
		    default:
		        echo "<nav class='menuNav'>";
		        break;
			}
			
		} else
			echo "<nav class='menuNav'>";
			
		include_once("template_menuNav.php"); 
		echo "</nav>"
		?>

	</header>

	<!-- Contenido -->
	<?php echo $contenido;?>
	
	<!-- Formulario contacto -->
	<?php 
		if (isset($_SESSION['nombre_pagina']) && $_SESSION['nombre_pagina'] == 'Contacto' || 
			$_SESSION['nombre_pagina'] == 'Servicios' || $_SESSION['nombre_pagina'] == 'Servicios Brújula' ||
			$_SESSION['nombre_pagina'] == 'Servicios Descongestión' || $_SESSION['nombre_pagina'] == 'Servicios Digitalización')
			include_once("template_formulario_contacto.php");
	?>

	<!-- Footer -->
	<?php 
		if (isset($_SESSION['nombre_pagina']) && ($_SESSION['nombre_pagina'] == 'Envio' ||
		$_SESSION['nombre_pagina'] == 'Página de Error 404' || $_SESSION['nombre_pagina'] == 'Newsletter'
		|| $_SESSION['nombre_pagina'] == 'Recurso' || $_SESSION['nombre_pagina'] == 'Baja'))
			echo "<footer class='fixed'>";
		else
			echo "<footer>";
				
		include_once("template_footer.php");
		echo "</footer>";
	?>

</body>
</html>
