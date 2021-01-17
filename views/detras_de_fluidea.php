<?php
ob_start();

include_once './views/default/contents/content_detras_de_fluidea.php';

$contenido = ob_get_clean();

include './views/default/templates/template_generico.php';
?>