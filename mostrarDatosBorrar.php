<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloMostrarDatosBorrar.css" />
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
            <form action="mostrarDatosBorrar.php" method="get">	
                <div id="fade-box">
                    <?php
                    // Comprueba que todos los campos tienen datos y se ha pulsado el boton enviar
                    if (!empty($_GET['contrasena']) && !empty($_GET['contrasenaRep']) && !empty($_GET['nombre']) && !empty($_GET['fNac']) && !empty($_GET['presupuesto']) && !empty($_GET['enviar'])) {
                        // Se borran los datos
                        borrarUsu($_GET['usuario']);
                    }
                    ?>
                    <input type="text" name="usuario" placeholder="Usuario" autofocus="autofocus" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('login', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="text" name="contrasena" placeholder="Contraseña" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('password', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="text" name="contrasenaRep" placeholder="Repite la contraseña" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('password', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('nombre', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="date" name="fNac" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('fNacimiento', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="number" name="presupuesto" placeholder="Presupuesto" value="<?php
                    // Muestra los datos encontrados en la base de datos
                    echo mostraDatos('presupuesto', $_GET['usuario']);
                    ?>" readonly="readonly" required>
                    <input type="submit" name="enviar" value="Borrar"/> <!--Botón de enviar -->
                    <a href="formularioBorrarUsu.php">Volver</a> <!--Enlace para volver -->
                    <?php
                    // Comprueba que todos los campos tienen datos y se ha pulsado el botón de enviar
                    if (!empty($_GET['contrasena']) && !empty($_GET['contrasenaRep']) && !empty($_GET['nombre']) && !empty($_GET['fNac']) && !empty($_GET['presupuesto']) && !empty($_GET['enviar'])) {
                        // Si se cumple las condiciones
                        echo"<h2>Usuario y movimientos borrados</h2>";
                    }
                    ?>
                </div>
            </form>
        </section> 
    </body>
</html>