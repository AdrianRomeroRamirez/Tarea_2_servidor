
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autoevaluación</title>
    </head>
    <body>
        <?php
        //Llamo al archivo externo para usas sus funciones
        require_once 'funciones.inc.php';
        ?>
        <?php
        //Llamo a la función que crea la tabla/formulario de autoevaluación
        crear_autoevaluacion();
        ?>
        <h3>Captura de movimientos sin pasarse del presupuesto</h3>
        <img src="img/movimientoSinPasarse.png" border="1" alt="Captura de movimientos sin pasarse" width="600" height="550">
        <h3>Captura de movimientos pasandose</h3>
        <img src="img/movimientoPasandose.png" border="1" alt="Captura de movimientos pasandose" width="600" height="550">
        <h3>Captura intentando introducir dos veces el mismo usuario</h3>
        <img src="img/usuarioDoble.png" border="1" alt="Captura intentando introducir dos veces el mismo usuario" width="600" height="550">
        <h3>Captura intentando introducir datos erroneos</h3>
        <img src="img/caracterEspecial.png" border="1" alt="Captura intentando introducir datos erroneos" width="600" height="550">
        <br/>
        <a href="tarea2.side" download="tarea2.side">Archivo Para Selenium</a>
    </body>
</html>