<!-- Plantilla Formulario contacto -->

	<div class="formulario">
	
		<i class="fa fa-times cerrar_recurso_gratuito"></i>

		<form action="formulario_recurso" method="post" class="formulario"
			onSubmit="return validar();">
			<div>
				<input type="text" name="nombre" class="izquierda"
					required="required" placeholder="¿Cómo te llamas?" />
			</div>

			<div>
				<input type="email" name="mail" class="derecha" required="required"
					placeholder="¿Cuál es tu mejor email?" />
			</div>

			<div class="condiciones">
				<p>
					<input type="checkbox" name="condiciones" id="condiciones"
						class="condiciones"><label>He leído y acepto la <a
						class="amarillo1" href="politica-privacidad-y-proteccion-datos"
						title="Aviso Legal"><i>Política de privacidad y Protección de
								datos</i> </a> </label>
				</p>
			</div>

			</br>
			<div class="texto_legal_formulario">
				<p class="titulo_proteccion_datos">
					<strong>Protección de datos</strong>
				</p>
				<p>El responsable del tratamiento es FLUIDEA, Beatriz Lozares. La
					finalidad de la recogida de datos es la de poder atender sus
					cuestiones, sin ceder sus datos a terceros. Tiene derecho a saber
					qué información tenemos sobre usted, corregirla o eliminarla tal y
					como se explica en nuestra <a
						class="amarillo1" href="politica-privacidad-y-proteccion-datos"
						title="Aviso Legal"><i>Política de privacidad</i></a>.</p>
			</div>

			<input type="hidden" name="recaptcha_response" id="recaptchaResponse">

			<div class="texto_centrado">
				<button type="submit" name="enviar" class="boton amarillo">
					<p class="letra_indie">¡Envíame el recurso gratis!</p>
				</button>
			</div>
			
		</form>

	</div>

