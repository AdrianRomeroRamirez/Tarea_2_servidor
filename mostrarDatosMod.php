<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloMostrarDatosMod.css" />
        <title>Formulario usuarios</title>
    </head>
    <body>
        <header> <!-- Menú fijo-->
            <?php
            require_once 'menuUsuariosFijo.php';
            ?>
        </header>
        <div id="logo"> 
            <h1><i>Usuarios</i></h1>
        </div> 
        <section class="stark-login">
            <form action="mostrarDatosMod.php" method="get">	
                <div id="fade-box">
                    <?php
                    // Comprueba que todos los campos tienen datos y se ha pulsado el boton enviar
                    if (!empty($_GET['contrasena']) && !empty($_GET['contrasenaRep']) && !empty($_GET['nombre']) && !empty($_GET['fNac']) && !empty($_GET['presupuesto']) && !empty($_GET['enviar'])) {
                        // Comprueba que no tiene carácteres especiales
                        if (preg_match("/^[A-z\sñáéíóúäëïöü0-9]*$/", $_GET['contrasena']) && preg_match("/^[A-z\sñáéíóúäëïöü0-9]*$/", $_GET['nombre'])) {
                            // Comprueba que las contraseñas coincidan
                            if ($_GET['contrasena'] == $_GET['contrasenaRep']) {
                                // Se modifican los datos
                                modificarDatos($_GET['contrasena'], $_GET['nombre'], $_GET['fNac'], $_GET['presupuesto'], $_GET['usuario']);
                            }
                        }
                    }
                    ?>
                    <input type="text" name="usuario" placeholder="Usuario" autofocus="autofocus" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('login', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="text" name="contrasena" placeholder="Contraseña" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('password', $_GET['usuario']);
                    ?>" required>
                    <input type="text" name="contrasenaRep" placeholder="Repite la contraseña" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('password', $_GET['usuario']);
                    ?>" required>
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('nombre', $_GET['usuario']);
                    ?>" required>
                    <input type="date" name="fNac" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('fNacimiento', $_GET['usuario']);
                    ?>" required>
                    <input type="number" name="presupuesto" placeholder="Presupuesto" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('presupuesto', $_GET['usuario']);
                    ?>" step="0.01" required>
                    <input type="submit" name="enviar" value="Modificar"/> <!--Botón de enviar -->
                    <a href="formularioModUsu.php">Volver</a> <!--Enlace para volver -->
                    <?php
                    // Comprueba que todos los campos tienen datos y se ha pulsado el boton enviar
                    if (!empty($_GET['contrasena']) && !empty($_GET['contrasenaRep']) && !empty($_GET['nombre']) && !empty($_GET['fNac']) && !empty($_GET['presupuesto']) && !empty($_GET['enviar'])) {
                        // Comprueba que no tiene carácteres especiales
                        if (preg_match("/^[A-z\sñáéíóúäëïöü0-9]*$/", $_GET['contrasena']) && preg_match("/^[A-z\sñáéíóúäëïöü0-9]*$/", $_GET['nombre'])) {
                            // Comprueba que las contraseñas coincidan
                            if ($_GET['contrasena'] == $_GET['contrasenaRep']) {
                                // Si se cumple todo se muestra este texto
                                echo"<h2>Datos actualizados</h2>";
                            } else {
                                // Si las contraseñas no coinciden
                                echo "<h2>Las contraseñas no coinciden</h2>";
                            }
                        } else {
                            // Si se introducen caracteres especiales
                            echo "<h2>No se admiten carácteres especiales</h2>";
                        }
                    }
                    ?>
                </div>
            </form>
        </section> 
    </body>
</html>

