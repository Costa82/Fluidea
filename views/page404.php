<?php
ob_start();

include_once './views/default/contents/content_page404.php';

$contenido = ob_get_clean();

include './views/default/templates/template_page404.php';
?>