<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloFormularioNuevoUsu.css" />
        <title>Formulario usuarios</title>
    </head>
    <body>
        <header>  <!-- Esto es el menú fijo con las opciones -->
            <?php
            require_once 'menuUsuariosFijo.php';
            ?>
        </header>
        <div id="logo"> 
            <h1><i>Usuarios</i></h1>
        </div> 
        <section class="stark-login">
            <form action="formularioNuevoUsu.php" method="get">	
                <div id="fade-box">
                    <input type="text" name="usuario" placeholder="Usuario" autofocus="autofocus" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['usuario']))
                        echo $_GET['usuario'];
                    ?>" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['contrasena']))
                        echo $_GET['contrasena'];
                    ?>" required>
                    <input type="password" name="contrasenaRep" placeholder="Repite la contraseña" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['contrasenaRep']))
                        echo $_GET['contrasenaRep'];
                    ?>" required>
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['nombre']))
                        echo $_GET['nombre'];
                    ?>" required>
                    <input type="date" name="fNac" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['fNac']))
                        echo $_GET['fNac'];
                    ?>" required>
                    <input type="number" name="presupuesto" placeholder="Presupuesto" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['presupuesto']))
                        echo $_GET['presupuesto'];
                    ?>" step="0,01" required>
                    <input type="submit" name="enviar" value="Enviar"/> <!--Botón de enviar -->
                    <a href="menu.php?usuario=daw&contrasena=daw&opcionForm=2">Volver</a>  <!-- Enlace para volver atras -->
                </div>
            </form>
        </section> 

        <?php
        // Comprueba que todos los campos contengan datos y se ha pulsado el boton de enviar
        if (!empty($_GET['usuario']) && !empty($_GET['contrasena']) && !empty($_GET['contrasenaRep']) && !empty($_GET['nombre']) && !empty($_GET['fNac']) && !empty($_GET['presupuesto']) && !empty($_GET['enviar'])) {
            // Comprueba que no se introducen caracteres especiales
            if (preg_match("/^[A-z\sñáéíóúäëïöü]*[0-9]*$/", $_GET['usuario']) && preg_match("/^[A-z\sñáéíóúäëïöü]*[0-9]*$/", $_GET['contrasena'])
                    && preg_match("/^[A-z\sñáéíóúäëïöü]*[0-9]*$/", $_GET['nombre'])) {
                // Comprueba que las contraseñas coinciden
                if ($_GET['contrasena'] == $_GET['contrasenaRep']) {
                    // Si todo es correcto se guarda el usuario
                    guardarUsu($_GET['usuario'], $_GET['contrasena'], $_GET['nombre'], $_GET['fNac'], $_GET['presupuesto']);
                } else {
                    // Si las contraseñas no coinciden
                    echo "<h2>Las contraseñas no coinciden</h2>";
                }
            } else {
                // Si se introducen carácteres especiales
                echo "<h2>No se admiten carácteres especiales</h2>";
            }
        }
        ?>

    </body>
</html>