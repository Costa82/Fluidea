<!-- Plantilla Formulario contacto -->
<div class="contenedor_texto">

	<div class="formulario">
	
		<form action="formulario" method="post" class="formulario" onSubmit="return validar();">
			<div class="form">
				<input type="text" name="nombre" class="izquierda" required="required" placeholder="¿Cómo te llamas?"/>
			</div>
			
			<div class="form">
				<input type="email" name="mail" class="derecha" required="required" placeholder="¿Cuál es tu email?"/>
			</div>
			
			<div class="form">
				<textarea name="consulta" rows="10" cols="50" required="required" placeholder="Cuéntame, ¿qué puedo hacer por ti? :)"></textarea>
			</div>
			
			<div class="form condiciones">
				<p><input type="checkbox" name="condiciones" id="condiciones" class="condiciones"><label>Acepta
					la <a class="amarillo1" href="politica-privacidad-y-proteccion-de-datos"
					title="Aviso Legal"><i>Política de privacidad y Protección de datos</i>
				</a></label></p>
			</div>
	
			<div class="texto_legal_formulario">
				<p class="titulo_proteccion_datos">
					<strong>Protección de datos</strong>
				</p>
				<p>
					En virtud de lo dispuesto en la Ley 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, 
					te informamos que mediante la cumplimentación del presente formulario tus datos personales quedarán incorporados 
					a los ficheros titularidad de Valladolid Home Staging, y serán tratados con la finalidad de contactarte para responder a 
					peticiones de información, envío de presupuestos y otras finalidades relacionadas con nuestra actividad. 
					Puedes ejercer, en cualquier momento, los derechos de acceso, rectificación, cancelación y oposición de tus datos 
					de carácter personal mediante correo electrónico dirigido a hola@valladolidhomestaging.es.
				</p>
			</div>
	
			<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
	
			<div class="texto_centrado ">
				<button type="submit" name="enviar" class="boton"><p class="letra_indie">Enviar</p></button>
			</div>
		</form>
		
	</div>
	
</div>