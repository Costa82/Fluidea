<?php
ob_start();

include_once './views/default/contents/content_politica_privacidad_y_proteccion_datos.php';

$contenido = ob_get_clean();

include './views/default/templates/template_generico.php';
?>