<?php
session_start();
require_once 'core/Connection.php';
require_once './config/Utils.php';

// Incluimos automaticamente el model que sea necesario
function my_autoloader($class)
{
    require_once ("models/$class.php");
}

spl_autoload_register('my_autoloader');

// Enrutamiento. Selecciona el controlador y la accion a ejecutar
$map = array(

	// Páginas
	'inicio' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'inicio',
        'privada' => false
    ), 'detras_de_fluidea' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'detras_de_fluidea',
        'privada' => false
    ), 'metodo_pop_up_flow' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'metodo_pop_up_flow',
        'privada' => false
    ), 'servicios' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'servicios',
        'privada' => false
    ), 'blog' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'blog',
        'privada' => false
    ), 'contacto' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'contacto',
        'privada' => false
    ), 'login' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'login',
        'privada' => false
    ), 'servicios_paquetes_brujula' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'servicios_paquetes_brujula',
        'privada' => false
    ), 'servicios_paquetes_descongestion' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'servicios_paquetes_descongestion',
        'privada' => false
    ), 'servicios_paquetes_digitalizacion' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'servicios_paquetes_digitalizacion',
        'privada' => false
    ), 'aviso_legal' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'aviso_legal',
        'privada' => false
    ), 'politica_privacidad_y_proteccion_datos' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'politica_privacidad_y_proteccion_datos',
        'privada' => false
    ), 'declaracion_cookies' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'declaracion_cookies',
        'privada' => false
    ), 'newsletter' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'newsletter',
        'privada' => false
    ), 'recurso' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'recurso',
        'privada' => false
    ), 'baja' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'baja',
        'privada' => false
    ),
    
    // Formularios
    'formulario' => array(
        'controller' => 'ControladorFormularios',
        'action' => 'formulario',
        'privada' => false
    ),'formulario_recurso' => array(
        'controller' => 'ControladorFormularios',
        'action' => 'formulario_recurso',
        'privada' => false
    ),'respuesta_envio' => array(
        'controller' => 'ControladorFormularios',
        'action' => 'respuesta_envio',
        'privada' => false
    ),
    
    // Páginas de error
    'page404' => array(
        'controller' => 'ControladorPaginas',
        'action' => 'page404',
     )
);

// Parseo de la ruta
// Comprobamos si hay alguna accion que ejecutar, sino ejecutamos inicio
if (isset($_GET['action'])) {

	$_SESSION['id'] = null;
	if (isset($_GET['id'])) {
		$_SESSION['id'] = Utils::decodifica($_GET['id']);
	}
    
    // Hacemos un replace para las urls amigables con '-'
    $action_normalizado = str_replace("-", "_", $_GET['action']);
    
    // Comprobamos que la accion existe en el mapa del enrutamiento, sino mostramos error 404
    if (isset($map[$action_normalizado])) {
        $action = $action_normalizado;
    } else {
		$action = 'page404';
    }
    
} else {
    $action = 'inicio';
}

// La variable controlador contiene la clase del controlador a ejecutar y el metodo de dicha clase.
$controlador = $map[$action];

// Guardamos en variables el nombre de la clase controladora y del metodo que queremos ejecutar dentro de dicha clase
$clase_controlador = $controlador['controller'];
$metodo = $controlador['action'];

// Si la pagina es privada comprobamos si el usuario es administrador, sino redirigimos a inicio
//if ($controlador['privada'] && (!isset($_SESSION['administrador']) || !$_SESSION['administrador'])) {
//    header('location:./inicio'); 
//    die();
//}

// Creamos un objeto de la clase controladora y ejecutamos el metodo indicado en el action
require_once "controller/$clase_controlador.php";

$obj_controlador = new $clase_controlador();
$obj_controlador->$metodo();

?>
