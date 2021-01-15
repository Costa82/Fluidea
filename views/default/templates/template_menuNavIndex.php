<?php
// Menu principal para la pagina principal index.php
echo "<ul id='lista_principal_index'>
        <li class='inicio_logo'><a href='.' title='Inicio'><img src='./views/default/img/logos/logotipo_RGB-01.png' alt='Inicio'/></a></li>
        <li class='elementos_menu'><a href='inicio' title='Inicio'>Inicio</a></li>
        <li class='elementos_menu'><a href='quien-soy' title='Quien soy'>Quien soy</a></li>
        <li class='elementos_menu'><a href='servicios' title='Servicios'>Servicios</a></li>
        <li class='elementos_menu'><a href='blog' title='Blog'>Blog</a></li>
        <li class='elementos_menu'><a href='contacto' title='Contacto'>Contacto</a></li>
        <!-- <li class='elementos_menu'><a href='login' title='Login'>Login</a></li> -->
    
        <li id='menu_moviles'><i class='fa fa-bars' aria-hidden='true'></i></a>
            <ul id='lista_movil'>
                <li class='elementos_menu_moviles'><a href='inicio' title='Inicio'>Inicio</a></li>
		        <li class='elementos_menu_moviles'><a href='quien-soy' title='Quien soy'>Quien soy</a></li>
		        <li class='elementos_menu_moviles'><a href='servicios' title='Servicios'>Servicios</a></li>
		        <li class='elementos_menu_moviles'><a href='blog' title='Blog'>Blog</a></li>
		        <li class='elementos_menu_moviles'><a href='contacto' title='Contacto'>Contacto</a></li>
		        <!-- <li class='elementos_menu_moviles'><a href='login' title='Login'>Login</a></li> -->
            </ul>
        </li>
      </ul>";