<!--
- Pagina inicio Fluidea.
- @author Miguel Costa.
-->

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
<!--  <link href="apple-touch-icon.png" rel="apple-touch-icon" /> -->
<!--  <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon"
	sizes="152x152" /> -->
<!--  <link href="apple-touch-icon-167x167.png" rel="apple-touch-icon"
	sizes="167x167" /> -->
<!--  <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon"
	sizes="180x180" /> -->
<!--  <link href="icon-hires.png" rel="icon" sizes="192x192" /> -->
<!--  <link href="icon-normal.png" rel="icon" sizes="128x128" /> -->
<script src="./views/default/jquery/jquery-3.1.1.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.min.js"
	type="text/javascript"></script>

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
		echo "<!-- <script id='Cookiebot' src='https://consent.cookiebot.com/uc.js'
			data-cbid='02242fa2-d798-4493-bc01-ef4d666afa09'
			data-blockingmode='auto' type='text/javascript'></script> -->";
	}
	?>
	
	<header>

		<!-- Menú navegación -->
		<?php 
		if (isset($_SESSION['nombre_pagina']) && $_SESSION['nombre_pagina'] == 'Fluidea')
			echo "<nav class='menuNavIndex'>";
		else
			echo "<nav class='menuNav'>";

		include_once("template_menuNav.php");
		echo "</nav>";
		?>

	</header>

	<!-- Contenido -->
	<?php echo $contenido;?>

	<footer>
	<?php include_once("template_footer.php");?>
	</footer>

</body>
</html>
