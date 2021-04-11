<?php
include ("phpmailer.php");

class Correo {

	private $contrasena;

	private $correoAdministrador;

	private $correoBea;

	public function __construct() {
		$this->contrasena = "735jbZ13";
		$this->correoAdministrador = "hola@fluidea.es";
	}

	/**
	 * enviarMailsConsulta
	 * Envía el mail de contacto
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @param  $consulta
	 * @param  $newsletter
	 * @return string
	 */
	public function enviarMailsConsulta($mail, $nombre, $consulta, $newsletter, $id) {
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$mail => $nombre
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>Bienvenido a Fluidea! Como ya sabes si has llegado hasta aquí, soy Bea, y mi único fin es 
							valorar contigo los inicios de tu proyecto o negocio y brindarte todo el tiempo del mundo para que 
							tus ideas creativas fluyan sin fin. Y a la vez estés completamente tranquilx ya que tendrás 
							todo lo importante, pero secundario, bien atado.</p>
							<p>¿Empezamos?</p>";

		if ($newsletter == "SI" && $id != null) {
			$contenidoHTML .= "<p>¡¡Sólo te queda un paso más para recibir nuestra Newsletter!! Haz click en este
        	<a href='https://www.fluidea.es/newsletter+".$id."'>enlace</a> para terminar tu registro.</p>";
		}

		$contenidoHTML .= "<p>¡Un saludo!</p>
                           <p><strong>Teléfono:</strong> 611 41 29 17</p>
                           <p><strong>Correo:</strong> hola@fluidea.es</p>
                           <p><strong>Web:</strong> https://www.fluidea.es</p>
						   </br>
						   <p>P.D. Enseguida me pondré en contacto contigo.</p>
						   <p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>
											<p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>FLUIDEA</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita 
											que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el 
											envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y 
											oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es <strong>FLUIDEA</strong>.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto 
											de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			// Envía el correo.
			if ($smtp->Send()) {
				$this->enviarCorreoInformativoConsulta($mail, $nombre, $consulta);
				$envio = "OK";
			} else {
				$envio = "KO";
			}
		}

		return $envio;
	}
	
	/**
	 * enviarMailsConsulta
	 * Envía el mail de contacto
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @param  $id
	 * @return string
	 */
	public function enviarMailsConfirmacionFichero($mail, $nombre, $id) {
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$mail => $nombre
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>Bienvenido a Fluidea! Como ya sabes si has llegado hasta aquí, soy Bea, y mi único fin es 
							valorar contigo los inicios de tu proyecto o negocio y brindarte todo el tiempo del mundo para que 
							tus ideas creativas fluyan sin fin. Y a la vez estés completamente tranquilx ya que tendrás 
							todo lo importante, pero secundario, bien atado.</p>
							<p>¿Empezamos?</p>";

		if ($id != null) {
			$contenidoHTML .= "<p>¡¡Sólo te queda un paso más para recibir tu recurso gratuito y registrate en nuestra Newsletter!! Haz click en este
        	<a href='https://www.fluidea.es/recurso+".$id."'>enlace</a> para recibirlo.</p>";
		}

		$contenidoHTML .= "<p>¡Un saludo!</p>
                           <p><strong>Teléfono:</strong> 611 41 29 17</p>
                           <p><strong>Correo:</strong> hola@fluidea.es</p>
                           <p><strong>Web:</strong> https://www.fluidea.es</p>
						   </br>
						   <p>P.D. Enseguida me pondré en contacto contigo.</p>
						   <p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a>
											<p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>FLUIDEA</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita 
											que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el 
											envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y 
											oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es <strong>FLUIDEA</strong>.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto 
											de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			// Envía el correo.
			if ($smtp->Send()) {
				$this->enviarCorreoInformativoRecurso($mail, $nombre);
				$envio = "OK";
			} else {
				$envio = "KO";
			}
		}

		return $envio;
	}
	
	/**
	 * enviarMailsBajaNewsletter
	 * Envía el mail de baja de la newsletter
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @return string
	 */
	public function enviarMailsBajaNewsletter($mail, $nombre) {
		
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$mail => $nombre
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>Te has dado de baja correctamente de nuestra Newsletter. En cualquier momento puedes volver a darte de alta y seguir recibiendo toda nuestra información</p>";

		$contenidoHTML .= "<p>¡Un saludo!</p>
                           <p><strong>Teléfono:</strong> 611 41 29 17</p>
                           <p><strong>Correo:</strong> hola@fluidea.es</p>
                           <p><strong>Web:</strong> https://www.fluidea.es</p>
						   </br>
						   <p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a>
											<p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>FLUIDEA</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita 
											que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el 
											envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y 
											oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es <strong>FLUIDEA</strong>.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto 
											de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			// Envía el correo.
			if ($smtp->Send()) {
				$this->enviarCorreoInformativoBaja($mail, $nombre);
				$envio = "OK";
			} else {
				$envio = "KO";
			}
		}

		return $envio;
	}

	/**
	 * enviarCorreoInformativoConsulta
	 * Envía el correo informando al administrador de la consulta
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @param  $telefono
	 * @param  $consulta
	 */
	public function enviarCorreoInformativoConsulta($mail, $nombre, $consulta) {
		 
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$this->correoAdministrador => "Administrador"
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola Administrador!</h2>";
		$contenidoHTML .= "<p>" . $nombre . " ha realizado una consulta.</p>";

		if ($consulta != null) {
			$contenidoHTML .= "<p><strong>Consulta: </strong>" . $consulta . ".</p>";
		}

		$contenidoHTML .= "<p><strong>Mail: </strong>" . $mail . ".</p>";

		$contenidoHTML .= "<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>";

		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			$smtp->Send(); // Envía el correo.
		}
	}
	
	/**
	 * enviarCorreoInformativoRecurso
	 * Envía el correo informando al administrador de la consulta
	 *
	 * @param  $mail
	 * @param  $nombre
	 */
	public function enviarCorreoInformativoRecurso($mail, $nombre) {
		 
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$this->correoAdministrador => "Administrador"
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola Administrador!</h2>";
		$contenidoHTML .= "<p>" . $nombre . " ha solicitado el envío del recurso gratuito.</p>";

		$contenidoHTML .= "<p><strong>Mail: </strong>" . $mail . ".</p>";

		$contenidoHTML .= "<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>";

		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			$smtp->Send(); // Envía el correo.
		}
	}
	
	/**
	 * enviarCorreoInformativoBaja
	 * Envía el correo informando al administrador de la baja
	 *
	 * @param  $mail
	 * @param  $nombre
	 */
	public function enviarCorreoInformativoBaja($mail, $nombre) {
		 
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$this->correoAdministrador => "Administrador"
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola Administrador!</h2>";
		$contenidoHTML .= "<p>" . $nombre . " se ha dado de baja de la newsletter.</p>";

		$contenidoHTML .= "<p><strong>Mail: </strong>" . $mail . ".</p>";

		$contenidoHTML .= "<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>";

		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			$smtp->Send(); // Envía el correo.
		}
	}

	/**
	 * enviarMailsNewsletter
	 * Envía el mail de la newsletter
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @param  $id
	 * @return string
	 */
	public function enviarMailsNewsletter($mail, $nombre, $id) {
		 
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$mail => $nombre
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>Muchas gracias por apuntarte a la newsletter, en breve recibirás noticias nuestras.</p>
						   <p>Puedes darte de baja y dejar de recibir nuestra newsletter en cualquier momento pinchando en este <a href='https://www.fluidea.es/baja+".$id."'>enlace</a></p>
        				   <p>Un saludo!!</p>
                           <p><strong>Teléfono:</strong> 611 41 29 17</p>
                           <p><strong>Correo:</strong> hola@fluidea.es</p>
                           <p><strong>Web:</strong> https://www.fluidea.es</p>
						   </br>
											<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>
											<p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>FLUIDEA</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita 
											que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el 
											envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y 
											oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es <strong>FLUIDEA</strong>.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto 
											de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			// Envía el correo.
			if ($smtp->Send()) {
				$this->enviarCorreoInformativoNewsletter($mail, $nombre);
				$envio = "OK";
			} else {
				$envio = "KO";
			}
		}

		return $envio;
	}
	
	/**
	 * enviarMailsConFichero
	 * Envía el mail con el fichero
	 *
	 * @param  $mail
	 * @param  $nombre
	 * @param  $id
	 * @return string
	 */
	public function enviarMailsConFichero($mail, $nombre, $id) {
		 
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$mail => $nombre
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>¡Aquí tienes tu recurso gratuíto!</p>
						   <p>Puedes darte de baja y dejar de recibir nuestra newsletter en cualquier momento pinchando en este <a href='https://www.fluidea.es/baja+".$id."'>enlace</a></p>
        				   <p>Un saludo!!</p>
                           <p><strong>Teléfono:</strong> 611 41 29 17</p>
                           <p><strong>Correo:</strong> hola@fluidea.es</p>
                           <p><strong>Web:</strong> https://www.fluidea.es</p>
						   </br>
											<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>
											<p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>FLUIDEA</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita 
											que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el 
											envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y 
											oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es <strong>FLUIDEA</strong>.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto 
											de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAdjunto = "./views/default/files/Esquema_Lienzo_Canvas_Fluidea.pdf";
		$nombreAdjunto = "Esquema_Lienzo_Canvas_Fluidea.pdf";
		$smtp->AddAttachment($rutaAdjunto, $nombreAdjunto);

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			// Envía el correo.
			if ($smtp->Send()) {
				$this->enviarCorreoInformativoEnvioFichero($mail, $nombre);
				$envio = "OK";
			} else {
				$envio = "KO";
			}
		}

		return $envio;
	}

	/**
	 * enviarCorreoInformativoNewsletter
	 * Envía el correo informando al administrador de la newsletter
	 *
	 * @param  $mail
	 * @param  $nombre
	 */
	public function enviarCorreoInformativoNewsletter($mail, $nombre)
	{
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$this->correoAdministrador => "Administrador"
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola Administrador!</h2>";
		$contenidoHTML .= "<p>" . $nombre . " se ha apuntado a la newsletter.</p>";

		$contenidoHTML .= "<p><strong>Mail: </strong>" . $mail . ".</p>";

		$contenidoHTML .= "<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>";

		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			$smtp->Send(); // Envía el correo.
		}
	}
	
	/**
	 * enviarCorreoInformativoEnvioFichero
	 * Envía el correo informando al administrador del envío del fichero
	 *
	 * @param  $mail
	 * @param  $nombre
	 */
	public function enviarCorreoInformativoEnvioFichero($mail, $nombre)
	{
		$imagen = 'https://i.ibb.co/7zpwCdR/logos-versiones-Mesa-de-trabajo-1-copia-4.png';

		$smtp = new PHPMailer();

		// Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		// Definimos el formato del correo con UTF-8
		$smtp->CharSet = "UTF-8";

		// autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host = "smtp.buzondecorreo.com";
		$smtp->Username = $this->correoAdministrador;
		$smtp->Password = $this->contrasena;
		$smtp->Port = 465;

		// datos de quien realiza el envio
		$smtp->From = "hola@fluidea.es"; // from mail
		$smtp->FromName = "Fluidea"; // from mail name

		// Indicamos las direcciones donde enviar el mensaje con el formato
		// "correo"=>"nombre usuario"
		// Se pueden poner tantos correos como se deseen
		$mailTo = array(
		$this->correoAdministrador => "Administrador"
		);

		// establecemos un limite de caracteres de anchura
		$smtp->WordWrap = 50; // set word wrap

		// NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		// cualquier programa de correo pueda leerlo.

		// Definimos el contenido HTML del correo
		$contenidoHTML = "<head>";
		$contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML .= "</head><body>";
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Hola Administrador!</h2>";
		$contenidoHTML .= "<p>" . $nombre . " ha reciibido el recurso gratuito.</p>";

		$contenidoHTML .= "<p><strong>Mail: </strong>" . $mail . ".</p>";

		$contenidoHTML .= "<p><a href='https://www.fluidea.es'><img src='" . $imagen . "' height='130'/></a></p>";

		$contenidoHTML .= "</body>\n";

		// Definimos el contenido en formato Texto del correo
		// $contenidoTexto="Contenido en formato Texto";
		// $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";

		// Definimos el subject
		$smtp->Subject = "FLUIDEA";

		// Adjuntamos el archivo "leameLWP.txt" al correo.
		// Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		// archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		// script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		// /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		// /home/xve/test/leameLWP.txt
		$rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
		// $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");

		// Indicamos el contenido
		$smtp->MsgHTML($contenidoHTML); // Text body HTML

		foreach ($mailTo as $mail => $name) {
			$smtp->ClearAllRecipients();
			$smtp->AddAddress($mail, $name);

			$smtp->Send(); // Envía el correo.
		}
	}

	/**
	 * console_log
	 * Sacamos por consola lo que le pasemos
	 *
	 * @param
	 *            $data
	 */
	function console_log($data)
	{
		echo '<script>';
		echo 'console.log(' . json_encode($data) . ')';
		echo '</script>';
	}
}