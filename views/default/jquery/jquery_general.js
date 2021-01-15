$(document).ready(function() {  

	// popUps
    $(window).resize(function(){
    	var aviso = $('.aviso');
        aviso.css({ 
             'left': ($(window).width() / 2 - $(aviso).width() / 2) + 'px', 
             'top': ($(window).height() / 2 - $(aviso).height() / 2) + ($(window).scrollTop()) + 'px'
             });
    });
        
    $(window).resize();

    $('.aviso').click(function(e){
    	e.preventDefault();
        if ( $('.aviso').is(":visible") ) {
        	$('.aviso').fadeOut('slow');
        }else {
            $('.aviso').fadeIn('slow');
        }
    });
    
    // leer más
    $('.leerMas').on('click',function() {
		$(this).siblings( ".texto_leerMas" ).toggle("slow");
	    $(this).hide();
	    $(this).siblings('.leerMenos').show();
	});
	
	$('.leerMenos').on('click',function() {
		$(this).siblings( ".texto_leerMas" ).toggle("slow");
		$(this).siblings('.leerMas').show();
	    $(this).hide();
	});
	
	// Función que abre y cierra, al hacer click, lentamente el menú principal
	// de los dispositivos móviles.
	$('#menu_moviles').click(function(e) {
		e.stopPropagation();
		if ($("#lista_movil").is(":hidden")) {
			$("#lista_movil").slideDown("slow");
		} else {
			$("#lista_movil").slideUp("slow");
		}
	});

	$('html').click(function() {
		$("#lista_movil").slideUp("slow");
	});
	
	$('.rechazar').on('click',function() {
	    $('#overbox3').hide();
	});
	
	//almacenar slider en una variable
	var slider = $('#slider');
	//almacenar botones
	var siguiente = $('#btn-next');
	var anterior = $('#btn-prev');
	
	//mover ultima imagen al primer lugar
	$('#slider .slider__section:last').insertBefore('#slider .slider__section:first');
	//mostrar la primera imagen con un margen de -100%
	slider.css('margin-left', '-'+100+'%');
	
	$('#slider .slider__section:nth-child(2) h2').fadeIn('slow');
	$('#slider .slider__section:nth-child(2) .saber_mas').fadeIn('slow');

	function moverD() {
	    slider.animate({
	        marginLeft:'-'+200+'%'
	    } ,700, function(){
	    	$('#slider .slider__section h2').fadeOut('fast');
	    	$('#slider .slider__section:last h2').fadeIn('slow');
	    	$('#slider .slider__section .saber_mas').fadeOut('fast');
	    	$('#slider .slider__section:last .saber_mas').fadeIn('slow');
	        $('#slider .slider__section:first').insertAfter('#slider .slider__section:last');
	        slider.css('margin-left', '-'+100+'%');
	    });
	}

	function moverI() {
	    slider.animate({
	        marginLeft:0
	    } ,700, function(){
	    	$('#slider .slider__section h2').fadeOut('fast');
	    	$('#slider .slider__section:first h2').fadeIn('slow');
	    	$('#slider .slider__section .saber_mas').fadeOut('fast');
	    	$('#slider .slider__section:first .saber_mas').fadeIn('slow');
	        $('#slider .slider__section:last').insertBefore('#slider .slider__section:first');
	        slider.css('margin-left', '-'+100+'%');
	    });
	}

	function autoplay() {
	    interval = setInterval(function(){
	        moverD();
	    }, 5000);
	}
	siguiente.on('click',function() {
	    moverD();
	    clearInterval(interval);
	    autoplay();
	});

	anterior.on('click',function() {
	    moverI();
	    clearInterval(interval);
	    autoplay();
	});

	autoplay();
	
});

// anclas
$(function() {
	$('a[href*="#"]:not([href="#"])').click(
	function() {
		if (location.pathname.replace(/^\//, '') == this.pathname
			.replace(/^\//, '')
			&& location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name='
						+ this.hash.slice(1) + ']');
				if (target.length) {
						$('html, body').animate({
							scrollTop : target.offset().top}, 1000);
				
				return false;
			}
		}
	});
});

// mostrar listado
function showContent() {
	element = document.getElementById("listado");
	check = document.getElementById("check");
	if (check.checked) {
		element.style.display = 'block';
	} else {
		element.style.display = 'none';
	}
}
 
function popbox3() {
    $('#overbox3').toggle();
}
