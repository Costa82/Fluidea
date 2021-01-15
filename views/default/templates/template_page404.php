<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Error 404 - Página no encontrada</title>
<link type="text/css" rel="stylesheet"
	href="./views/default/css/font-awesome.css" />

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

<script src="./views/default/jquery/jquery-3.1.1.min.js"></script>

<!-- Metemos un aleatorio para la recarga automática del css y el js -->
<script>

    var rutacss1 = "./views/default/css/main.css?" + Math.random();
    var rutajs = "./views/default/jquery/jquery_general.js?" + Math.random();
    var script = "script";
    
    document.write('<link rel="stylesheet" href="' + rutacss1 + '" type="text/css" media="screen" />');
    document.write('<script src="' + rutajs + '"></' + script + '>');
	
</script>

</head>
<body>
	<header>

	</header>

	<!-- Contenido -->
    <?php echo $contenido; ?>

</body>
</html>
