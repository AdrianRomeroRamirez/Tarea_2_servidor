<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloMenu.css" />
        <title>Menú</title>
    </head>
    <body>
        <?php
        // Comprueba si se ha elegido la primera opción
        if ($_GET["opcionForm"] == 1) {
            // Comprueba si el usuario es correcto
            if (comprobarUsuario($_GET['usuario'])) {
                // Comprueba si la contraseña corresponde a ese usuario
                if (comprobarContrasena($_GET['usuario'], $_GET['contrasena'])) {
                    // Si todo es correcto se abre la siguiente pagina vinculada al usuario
                    header('Location: paginaGestionCuenta.php?usuario=' . $_GET['usuario']);
                } else {
                    // Si la contraseña no corresponde al usuario
                    echo"<h2>Usuario existe pero no coincide contraseña</h2>" .
                    '<section class="stark-login">
                        <ul>	
                            <div>
                                <li><a href="index.php">Salir</a></li>
                            </div>
                        </ul>
                    </section>';
                }
            } else {
                //Si el usuario no se encuentra en la base de datos
                echo '<h2>usuario no existe</h2>' .
                '<section class="stark-login">
                    <ul>	
                        <div>
                            <li><a href="index.php">Salir</a></li>
                        </div>
                    </ul>
                </section>';
            }
        }
        // Comprueba que se ha elegido la opción 2
        if ($_GET["opcionForm"] == 2) {
            // Comprueba si el usuario y la contraseña son "daw"
            if ($_GET["usuario"] == "daw" && $_GET["contrasena"] == "daw") {
                // Se muestra el menu de administrador
                echo '<div id="logo"> 
                        <h1><i>Gestionar Usuarios</i></h1>
                    </div> 
                    <section class="stark-login">
                        <form>
                            <div id="fade-box">
                                <a href="formularioNuevoUsu.php">Nuevo usuario</a>
                                <a href="formularioNuevoUsu.php?usuario=1&contrasena=1&contrasenaRep=1&nombre=prueba1&fNac=2001-01-01&presupuesto=5">Nuevo usuario precargado 1</a>
                                <a href="formularioNuevoUsu.php?usuario=Kvothe&contrasena=1234&contrasenaRep=1234&nombre=Maria+Teresa+Campos&fNac=1941-06-18&presupuesto=50000">Nuevo usuario precargado 2</a>
                                <a href="formularioModUsu.php">Modificar usuario</a>
                                <a href="formularioBorrarUsu.php">Borrar usuario</a>
                                <a href="index.php">Salir</a>
                            </div>
                        </form>
                    </section> ';
            } else {
                // Si no se ha introducido el usuario administrador
                echo "<h2>Usuario administrador no correcto</h2>"
                . '<section class="stark-login">
                        <ul>	
                            <div>
                                <li><a href="index.php">Salir</a></li>
                            </div>
                        </ul>
                    </section>';
            }
        }
        ?>
    </body>
</html>
