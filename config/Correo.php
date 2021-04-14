<?php
include ("phpmailer.php");
require_once './config/Utils.php';

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
	 * @param  $id
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
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡Bienvenidx a Fluidea " . $nombre . "!</h2>";
		$contenidoHTML .= "<p>Gracias por querer formar parte de mi Clan de emprendedores con ganas de implementar de 
						   manera real y eficaz sus ideas, para pasar a hacerlas proyectos y después negocios reales, viables y solventes.</p>
						   <p>Solo queda que pulses el botón para confirmar que este es tu email y que guardes mi dirección en tu lista de direcciones
						   para que nada se interponga entre nosotros.</p>";

		if ($newsletter == "SI" && $id != null) {
			$codificado = Utils::codifica($id);
			$contenidoHTML .= "<p><a href='https://www.fluidea.es/newsletter+".$codificado."'>BEA, CONFIRMO MI SUSCRIPCIÓN</a></p>";
		}

		$contenidoHTML .= "<p><strong>P.D.</strong> Como ya sabes, porque vienes de echar un buen vistazo a mi web, mi único fin es valorar contigo los inicios de tu proyecto o 
						   negocio y brindarte todo el tiempo del mundo para que tus ideas creativas fluyan sin fin y te puedas dedicar a lo que realmente solo tú puedes hacer, desarrollar tu genial idea. Pero, además, conmigo acompañándote, estarás completamente tranquilx ya que tendrás todo bien atado y conseguirás tus objetivos mucho antes que si anduvieses ese camino tú solx.</p>
						   <p>¿Empezamos?</p>
						   <p>Bea de Fluidea</p>
						   </br>
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
		$smtp->Subject = "FLUIDEA - (ACCIÓN NECESARIA) Confirma tu suscripción";

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
	 * enviarMailsConfirmacionFichero
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

		if ($id != null) {
			$codificado = Utils::codifica($id);
			$contenidoHTML .= "<p>¡¡Estoy a punto de darte acceso a mi 
        					  <a href='https://www.fluidea.es/recurso+".$codificado."'><ins>SUPER GUÍA DEFINITIVA SOBRE CÓMO REALIZAR PASO A PASO EL MODELO CANVAS DE TU PROYECTO</ins></a>!</p>";
			$contenidoHTML .= "<p>Sólo te queda un simple paso, que es el de confirmar tu acceso para poder descargártela.</p>";
			$contenidoHTML .= "<p>Es muy sencillo, sólo tienes que hacer click en el enlace de abajo y te enviaremos un *PDF  con la guía, además de darte acceso a otros recursos gratuitos de mucho valor, apuntándote en el mismo paso a mi Newsletter.</p>";
			$contenidoHTML .= "<p><a href='https://www.fluidea.es/recurso+".$codificado."'>BEA, ENVÍAME LA GUÍA</a></p>";
		}

		$contenidoHTML .= "<p>La GUÍA GRATUITA te facilitará lo siguiente:</p>
						   <p><strong>1. ¿CÓMO REALIZO Y RELLENO EL MODELO CANVAS?</strong></p>
						   <p><strong>2. ¿QUÉ SIGNIFICA CADA UNO DE LOS APARTADOS DE ESTE MODELO?</strong></p>
						   <p><strong>Y si, aun habiendo llegado hasta aquí, no sabes qué es este modelo, porqué lo necesitas y cómo te ayudará a pasar de tener una “idea mágica” en la cabeza, a un negocio tangible, pincha 
						   aquí y vete a mi entrada de blog donde explico todo este intríngulis. </strong></p>
                           <p>Un abrazo,</p>
                           <p>Bea de Fluidea.</p>
                           </br><p>P.D. Sígueme en mis redes:</p>
                           <p>Instagram: <a href='https://www.instagram.com/fluidea.es/' title='Instagram'
						   target='_blank' rel='noopener'>@fluidea.es</a></p>
                           <p>Facebook: <a href='https://www.facebook.com/beafluidea/' title='Facebook'
						   target='_blank' rel='noopener'>@fluidea</a></p>
						   </br><p><strong>Teléfono:</strong> 611 41 29 17</p>
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
		$smtp->Subject = "FLUIDEA - SOLO UN PASO MÁS PARA DESCARGAR LA GUÍA";

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
		$contenidoHTML .= "<p>Siento mucho que te vayas del Clan, pero entiendo que, si no es tu sitio, es mejor para ambxs que no sigas recibiendo mis email.</p>";

		$contenidoHTML .= "<p>Un abrazo y ¡que encuentres tu camino!</p>
						   </br><p>P.D. Si algún día te das cuenta de que este sí era tu sitio, estaré encantada de volver a recibirte por aquí.</p>
						   <p>Un abrazo,</p>
						   <p>Bea de Fluidea.</p>
                           </br><p><strong>Teléfono:</strong> 611 41 29 17</p>
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
		$smtp->Subject = "FLUIDEA - CONFIRMADO, YA ESTÁS DADX DE BAJA";

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

		$codificado = Utils::codifica($id);

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
		$contenidoHTML .= "<h2 style='color: #f7c300'>¡LISTO!</h2>";
		$contenidoHTML .= "<p>¡¡Ya estás dadx de alta en mi CLAN de emprendedores reales!!</p>
						   <p>Mientras te llega mi primer email puedes:</p>
						   <p>-	Darte un paseo por mi blog y leer los posts que tengo colgados, seguro que podrás ir sacando ideas de cómo vas a poner en marcha esa idea tan increíble que tienes en la cabecita.</p>
						   <p>-	Pasarte por mi IG, @fluidea.es, y comentar conmigo y con el resto del CLAN, todo lo que te interesa, te vuelve un poco locx, lo que no sabes ni por donde coger… en definitiva, TODO 
						   lo que te apetezca soltar para mantener tu superenergía emprendedora a tope, ya sabes, una de mis máximas es que JUNTOS ES MEJOR.</p>
						   <p>-	Ver mis servicios con los que podemos trabajar juntos para que tu idea tome forma mucho antes y mucho mejor. Recuerda: yo trabajaré junto a ti, codo con codo, no te enseñaré (bueno, 
						   si quieres aprender sobre cómo lo hago, está en tu mano), lo haré contigo para que todo vaya bien.</p>
						   </br><p>¡Que tengas feliz día!</p>
						   <p>Bea de Fluidea.</p>
						   </br><p>Puedes darte de baja y dejar de recibir nuestra newsletter en cualquier momento pinchando en este <a href='https://www.fluidea.es/baja+".$codificado."'>enlace</a></p>
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
		$smtp->Subject = "FLUIDEA - ¡YA ERES PARTE DEL CLAN DE FLUIDEA!";

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

		$codificado = Utils::codifica($id);

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
		$contenidoHTML .= "<p>Gracias por el interés en mi GUÍA GRATUITA SOBRE CÓMO CREAR TU LIENZO CANVAS PASO A PASO. Es una guía que he creado tras revisar y realizar desde cero, los lienzos de muchos 
					       emprendedores que, como tú, no sabían por dónde empezar ni qué significaba este lienzo en blanco.</p>
						   <p>Te aseguro que cuando veas ese lienzo en blanco, rellenado con toda la información que ahora está en tu cabeza hecha un batiburrillo de ideas desordenadas, serás cual pintor 
						   cuando ha acabado su cuadro estrella: un conjunto de emociones positivas a punto de explotar, tanto que no cabrás en ti de gozo y ¡¡tendrás que ir a contárselo a todo el mundo!!</p>
					       <p>Tranquilx, sé que si estás aquí es porque:</p>
					       <p>1.	Tienes una idea genial que te persigue y no sabes cómo empezar a ponerla en marcha</p>
					       <p>2.	Nadie te ha explicado cuáles son los primeros pasos que tienes que dar para empezar a ordenar las ideas de tu proyecto</p>
					       <p>3.	Has oído hablar del Método Lean Startup y del Lienzo del Modelo de Negocio, pero no sabes cómo implementarlo.</p>
						   </br><p>Sea cual sea la razón, estás en el lugar correcto. Olvídate de todo lo que has leído y visto en las redes sociales de “gurús sobre los negocios” y descubre la manera real de 
						   empezar a dar forma a tu idea, para que pase a ser un proyecto y para que éste se convierta en tu negocio rentable y viable.</p>
					       </br><p>Un abrazo,</p>
					       <p>Bea de Fluidea.</p>
						   </br><p>Puedes darte de baja y dejar de recibir nuestra newsletter en cualquier momento pinchando en este <a href='https://www.fluidea.es/baja+".$codificado."'>enlace</a></p>
                           </br><p><strong>Teléfono:</strong> 611 41 29 17</p>
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
		$smtp->Subject = "FLUIDEA - BIENVENIDX, AQUÍ TIENES TU GUÍA";

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