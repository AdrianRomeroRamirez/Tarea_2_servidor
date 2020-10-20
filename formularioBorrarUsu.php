<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloFormularioBorrarUsu.css" />
        <title>Formulario usuarios</title>
    </head>
    <body>
        <header> <!-- Menú fijo -->
            <?php
            require_once 'menuUsuariosFijo.php';
            ?>
        </header>
        <div id="logo"> 
            <h1><i>Usuarios</i></h1>
        </div> 
        <section class="stark-login">
            <form action="<?php
            // Comprueba si el campo usuario está vacio
            if (!empty($_GET['usuario'])) {
                // Comprueba si el usuario está en la base de datos
                if (comprobarUsuario($_GET['usuario'])) {
                    // Si el usuario existe se cambia el 'action' a mostrarDatosBorrar.php
                    echo "mostrarDatosBorrar.php";
                } else {
                    // si no existe a formularioBorrarUsu.php
                    echo "formularioBorrarUsu.php";
                }
            } else {
                // si el campo está vacio a formularioModUsu.php
                echo "formularioBorrarUsu.php";
            }
            ?>" method="get">	
                <div id="fade-box">
                    <input type="text" name="usuario" placeholder="Usuario" autofocus="autofocus" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['usuario']))
                        echo $_GET['usuario'];
                    ?>" required>
                    <input type="submit" name="enviar" value="Enviar"/> <!--Botón de enviar -->
                    <a href="menu.php?usuario=daw&contrasena=daw&opcionForm=2">Volver</a> <!-- Enlace para volver -->
                    <?php
                    // Comprueba si el campo 'usuario' está vacio
                    if (!empty($_GET['usuario'])) {
                        // Comprueba si existe
                        if (comprobarUsuario($_GET['usuario'])) {
                            // Se muestra este mensaje en caso afirmativo
                            echo "<h2>Usuario encontrado, pulse 'Enviar' de nuevo para entrar</h2>";
                        } else {
                            // Este mensaje en caso negativo
                            echo "<h2>Usuario no encontrado</h2>";
                        }
                    }
                    ?>
                </div>
            </form>
        </section> 
    </body>
</html>