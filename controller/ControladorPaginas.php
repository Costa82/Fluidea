<?php
require_once './config/Validaciones.php';

/**
 * ControladorPaginas
 */
class ControladorPaginas
{

	/**
	 * Metodo que llama a la accion inicio
	 */
	public function inicio()
	{
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/inicio.php';
	}
	
	/**
	 * Metodo para cargar la pagina de error 404
	 */
	public function page404()
	{
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		
		require './views/page404.php';
	}

}