<?php
require_once './config/Validations.php';

/**
 * ControladorPaginas
 */
class ControladorPaginas {

	/**
	 * Metodo que llama a la accion inicio
	 */
	public function inicio() {
		$_SESSION['nombre_pagina'] = 'Fluidea';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/inicio.php';
	}

	/**
	 * Metodo que llama a la accion detras_de_fluidea
	 */
	public function detras_de_fluidea() {
		$_SESSION['nombre_pagina'] = 'Detrás de Fluidea';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/detras_de_fluidea.php';
	}
	
	/**
	 * Metodo que llama a la accion metodo_pop_up_flow
	 */
	public function metodo_pop_up_flow() {
		$_SESSION['nombre_pagina'] = 'Método Pop Up Flow';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/metodo_pop_up_flow.php';
	}
	
	/**
	 * Metodo que llama a la accion servicios
	 */
	public function servicios() {
		$_SESSION['nombre_pagina'] = 'Servicios';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/servicios.php';
	}
	
	/**
	 * Metodo que llama a la accion blog
	 */
	public function blog() {
		$_SESSION['nombre_pagina'] = 'Blog';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/blog.php';
	}
	
	/**
	 * Metodo que llama a la accion contacto
	 */
	public function contacto() {
		$_SESSION['nombre_pagina'] = 'Contacto';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/contacto.php';
	}
	
	/**
	 * Metodo que llama a la accion login
	 */
	public function login() {
		$_SESSION['nombre_pagina'] = 'Login';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/login.php';
	}

	/**
	 * Metodo para cargar la pagina de error 404
	 */
	public function page404() {
		$_SESSION['nombre_pagina'] = 'Página de Error 404';
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}

		require './views/page404.php';
	}

}