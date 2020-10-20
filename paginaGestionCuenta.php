<!DOCTYPE html>
<?php
require_once 'funciones.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./estiloPaginaGestionCuenta.css" />
        <title>Menú</title>
    </head>
    <body>
        <?php
        // Si el boton enviar es 'Ingresar' y el campo de ingreso no está vacio se guarda el movimiento como ingreso
        if(isset($_GET['enviar']) && $_GET['enviar']=="Ingresar" && !empty($_GET['ingreso'])){
            guardarMovimiento($_GET['usuario'], 'Ingreso', $_GET['ingreso']);
            echo'<h2>Ingresado</h2>';
        }
        // Si el boton enviar es 'Descontar' y el campo de gasto no está vacio se guarda el movimiento como gasto
        if(isset($_GET['enviar']) && $_GET['enviar']=="Descontar" && !empty($_GET['gasto'])){
            guardarMovimiento($_GET['usuario'], 'Gasto', $_GET['gasto']);
            echo'<h2>Descontado</h2>';
        }
        // Si el boton enviar es 'Eliminar' y el campo de movBorrar no está vacio se eliminan los movimientos
        if(isset($_GET['enviar']) && $_GET['enviar']=="Eliminar" && !empty($_GET['movBorrar'])){
            borrarMovimientos($_GET['movBorrar']);
            echo'<h2>Movimiento/os borrados</h2>';
        }
        ?>
        <header> <!-- Datos del usuario -->
            <p>Nombre: <?php echo mostraDatos('nombre', $_GET['usuario']); ?> | Presupuesto: <?php echo number_format(mostraDatos('presupuesto', $_GET['usuario']), 2); ?>€ | 
                Total ingresos anual: <?php echo number_format(mostraDatosIngresos($_GET['usuario']), 2); ?>€ | Total gastos anual: <?php
                // Si los gastos no superan el presupusto, se muestran de color normal, pero si lo supera, se muestra en rojo
                if (abs(mostraDatosGastos($_GET['usuario'])) < mostraDatos('presupuesto', $_GET['usuario'])) {
                    echo number_format(abs(mostraDatosGastos($_GET['usuario'])), 2) . '€';
                } else {
                    echo '<font color = "red">' . number_format(abs(mostraDatosGastos($_GET['usuario'])), 2) . '€</font>';
                }
                ?></p>
        </header>
        <div> 
            <h2><i>Gestionar mi cuenta</i></h2>
        </div> 
        <section>
            <div id="tabla"> <!-- Tabla con los ultimos 10 movimientos -->
                <table border="1">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Función que muestra los ultimos 10 movimientos
                        ultimos10Mov($_GET['usuario']);
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">S/M = Sin movimiento</td>
                        </tr>
                    </tfoot>
                </table>
                <form action="paginaGestionCuenta.php?usuario=<?php $_GET['usuario'] ?>" method="get">
                    <p>Usuario: </p>
                    <input type="text" name="usuario" value="<?php
                    //Si recibe datos del formulario, lo escribe como valor
                    if (isset($_GET['usuario']))
                        echo $_GET['usuario'];
                    ?>" readonly="readonly">
                    <label><p>Contavilizar un ingreso</p>
                    <!-- Campo para los ingresos -->
                    <input type="number" name="ingreso" placeholder="Cantida a ingresar" step="0.01" min="0"></label>
                    <input type="submit" name="enviar" value="Ingresar"/> <!--Botón de enviar -->
                    <label><p>Contavilizar un gasto</p>
                    <!-- Campo para los gastos -->
                    <input type="number" name="gasto" placeholder="Cantida gastada" step="0.01" max="0"></label>
                    <input type="submit" name="enviar" value="Descontar"/> <!--Botón de enviar -->
                    <p>Eliminar movimientos</p>
                    <?php
                    // Función que muestra los ultimos 10 movimientos en checkbox
                    mostrarMovimientosCheckbox($_GET['usuario']);
                    ?>
                    <br/>
                    <input type="submit" name="enviar" value="Eliminar"/> <!--Botón de enviar -->
                </form>
            </div>
            <div>
                <li><a href="index.php">Salir</a></li> <!-- Enlace para salir -->
            </div>
        </section> 
    </body>
</html>