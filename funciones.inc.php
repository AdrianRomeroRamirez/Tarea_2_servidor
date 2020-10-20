<?php

/*
 * Función que crea un objeto con la conexión a la base de datos
 */

function conexionBD() {
    try {
        // Array con opciones
        $arrOptions = array(
            PDO::ATTR_EMULATE_PREPARES => FALSE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        );
        // se crea la conexión
        $con = new PDO('mysql:host=localhost;dbname=conta2', 'daw', 'daw', $arrOptions);
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
    return $con;
}

/*
 * Función que guarda a un usuario en la base de datos
 */

function guardarUsu($usuario, $contrasena, $nombre, $fNac, $presupuesto) {
    try {
        // Se guarda la consulta
        $sql = "INSERT INTO `Usuarios` (`login`, `password`, `nombre`, `fNacimiento`, `presupuesto`)"
                . " VALUES (?, ?, ?, ?, ?);";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta en la conexión
        $consulta = $con->prepare($sql);
        // Se introducen los parametros
        $consulta->bindParam(1, $usuario);
        $consulta->bindParam(2, $contrasena);
        $consulta->bindParam(3, $nombre);
        $consulta->bindParam(4, $fNac);
        $consulta->bindParam(5, $presupuesto);
        // Se ejecuta
        $consulta->execute();
        echo "<h2>Usuario Guardado</h2>";
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que comprueba si un usuario existe en la base de datos y devuelve un boolean
 */

function comprobarUsuario($usuario) {
    try {
        // Inicia en false
        $usuarioEncontrado = false;
        // se crea la conexión
        $con = conexionBD();
        // Se guarda la consulta
        $sql = "SELECT login FROM Usuarios WHERE login = ?";
        // Se prepara la consulta
        $resultado = $con->prepare($sql);
        // Se ejecuta pasando el parametro 
        $resultado->execute(array($usuario));
        // Si en el registro hay algo guardado es que si ha encontrado al usuario
        if ($registro = $resultado->fetch()) {
            $usuarioEncontrado = true;
        }
        // Se cierra la consulta
        $resultado->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
    // Devuelve si ha encontrado al usuario o no
    return $usuarioEncontrado;
}

/*
 * Función que comprueba si la contraseña pasado por parametro corresponde al usuario también pasado
 */

function comprobarContrasena($usuario, $contrasena) {
    try {
        // Inicia en false
        $contrasenaEncontrada = false;
        // Se establece la conexión
        $con = conexionBD();
        // se guarda la consulta
        $sql = "SELECT password FROM Usuarios WHERE login = ?";
        // Se prepara
        $resultado = $con->prepare($sql);
        // Se ejecuta pasando el parametro
        $resultado->execute(array($usuario));
        // Si encuentra un registro y coincide con la contraseña pasada por parametro, la variable pasa a true
        if ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            if ($registro['password'] == $contrasena) {
                $contrasenaEncontrada = true;
            }
        }
        // Se cierra la consulta
        $resultado->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
    // Devuelve si la contraseña coincide o no
    return $contrasenaEncontrada;
}

/*
 * Función que devuelve los datos de la tabla Usuarios del campo y usuario pasado por parámetros
 */

function mostraDatos($campo, $usuario) {
    try {
        // Se crea la conexión
        $con = conexionBD();
        // Se guerda la consulta
        $sql = "SELECT * FROM Usuarios WHERE login = ?";
        // Se prepara
        $resultado = $con->prepare($sql);
        // Se ejecuta
        $resultado->execute(array($usuario));
        // Si hay datos, los devuelve
        if ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            return $registro[$campo];
        }
        // Se cierra la consulta
        $resultado->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que devuelve el total de ingresos de este año del usuario pasado por parámetro
 */

function mostraDatosIngresos($usuario) {
    try {
        $total = 0; // Variable para guardar el total
        // Se crea la conexión
        $con = conexionBD();
        // se guarda la consulta
        $sql = "SELECT cantidad FROM Movimientos WHERE loginUsu = ? AND cantidad > 0 AND fecha BETWEEN '2019-01-01' AND '2019-12-31'";
        // Se prepara
        $resultado = $con->prepare($sql);
        // Se ejecuta
        $resultado->execute(array($usuario));
        // Mientras haya datos se suman al total
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $total = $total + $registro['cantidad'];
        }
        // se cierra la consulta
        $resultado->closeCursor();
        // Se devuelve el total
        return $total;
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que devuelve el total de gastos de este año del usuario pasado por parámetro
 */

function mostraDatosGastos($usuario) {
    try {
        $total = 0; // Variable para guardar el total
        // Se crea la conexión
        $con = conexionBD();
        // se guarda la consulta
        $sql = "SELECT cantidad FROM Movimientos WHERE loginUsu = ? AND cantidad < 0 AND fecha BETWEEN '2019-01-01' AND '2019-12-31'";
        // Se prepara
        $resultado = $con->prepare($sql);
        // Se ejecuta
        $resultado->execute(array($usuario));
        // Mientras haya datos se suman al total
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $total = $total + $registro['cantidad'];
        }
        // se cierra la consulta
        $resultado->closeCursor();
        // Se devuelve el total
        return $total;
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que modifica los datos pasados por parámetros del usuario pasado por parámetro también
 */

function modificarDatos($contrasena, $nombre, $fNac, $presupuesto, $usuario) {
    try {
        // Se crea la conexión
        $con = conexionBD();
        // Se guarda la consulta
        $sql = "UPDATE `Usuarios` SET `password` = ?, `nombre` = ?, `fNacimiento` = ?, `presupuesto` = ? WHERE `login` = ?";
        // Se prepara
        $consulta = $con->prepare($sql);
        // Se introducen los parametros
        $consulta->bindParam(1, $contrasena);
        $consulta->bindParam(2, $nombre);
        $consulta->bindParam(3, $fNac);
        $consulta->bindParam(4, $presupuesto);
        $consulta->bindParam(5, $usuario);
        // Se ejecuta
        $consulta->execute();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que borra al usuario pasado por parámetro y todos los movimientos de este
 */

function borrarUsu($usuario) {
    try {
        // Se crea la conexión
        $con = conexionBD();
        // Se guardan las dos consultas
        $sqlMov = "DELETE FROM Movimientos WHERE loginUsu = ?";
        $sqlUsu = "DELETE FROM Usuarios WHERE login = ?";
        // Si lees esto, por lo menos se que no he perdido el tiempo en comentar tanto el código jaja
        // Se prepraran y ejecutan las dos consultas
        $consulta = $con->prepare($sqlMov);
        $consulta->execute(array($usuario));
        $consulta = $con->prepare($sqlUsu);
        $consulta->execute(array($usuario));
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que muestra los ultimos 10 movimientos del usuario en una tabla
 */

function ultimos10Mov($usuario) {
    try {
        // Contador para llegar a 10 movimientos como máximo
        $contador = 0;
        // Se guarda la consulta
        $sql = "SELECT fecha, cantidad FROM `Movimientos` WHERE loginUsu = ? order by cast(codigoMov as unsigned) desc";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta
        $consulta = $con->prepare($sql);
        // se ejecuta
        $consulta->execute(array($usuario));
        // Itera mientras el contador sea menor que 10
        while ($contador < 10) {
            // Si tiene datos los escribe en celdas y suma uno a contador
            if ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>" . $registro['fecha'] . "</td>
                    <td>" . $registro['cantidad'] . "€</td>
                </tr>";
                $contador++;
            } else {
                // Si no tiene datos, creas las celdas con el texto S/M y suma uno a contador
                echo "<tr>
                    <td> S/M </td>
                    <td> S/M </td>
                </tr>";
                $contador++;
            }
        }
        // Se cierra la consulta
        $consulta->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que muestra los ultimos 10 movimientos del usuario en un checkbox
 */

function mostrarMovimientosCheckbox($usuario) {
    try {
        // Contador para llegar a 10 movimientos como máximo
        $contador = 0;
        // Se guarda la consulta
        $sql = "SELECT codigoMov, fecha, cantidad FROM `Movimientos` WHERE loginUsu = ? order by cast(codigoMov as unsigned) desc";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta
        $consulta = $con->prepare($sql);
        // se ejecuta
        $consulta->execute(array($usuario));
        // Se imprime el principio de la tabla para ordenar los checkbox horizontalmente
        echo '<table><tr>';
        // Mientras haya datos y el contador sea menor que 10, se imprime un checkbox
        while ($registro = $consulta->fetch(PDO::FETCH_ASSOC) and $contador < 10) {
            echo "<td><label><input type='checkbox' name='movBorrar[]' value='" . $registro['codigoMov'] . "'><p>" . $registro['cantidad'] . "€</p></input></label></td>";
            $contador++;
        }
        echo '</table></tr>';
        // Se cierra la consulta
        $consulta->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que devuelve el ultimo código de movimiento introducido
 */

function ultimoCodigoMov() {
    try {
        // Se guarda la consulta
        $sql = "SELECT codigoMov FROM Movimientos order by cast(codigoMov as unsigned) desc";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta
        $consulta = $con->prepare($sql);
        // Se ejecuta
        $consulta->execute();
        // Si tiene datos, devuelve el primero, que será el mayor al ordenarlo descendentemente
        if ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
            return $resultado['codigoMov'];
        } else {
            // Si no tiene datos, devuelve 0
            return 0;
        }
        // Se cierra la consulta
        $consulta->closeCursor();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que guarda un movimiento con concepto y cantidad del usuario pasado por parametro
 */

function guardarMovimiento($usuario, $concepto, $cantidad) {
    try {
        // Se guarda el ultimo código de movimiento y se le suma uno
        $codigo = ultimoCodigoMov() + 1;
        // Se guarda la fecha actual
        $fecha = date('Y-m-d');
        // Se guarda la consulta
        $sql = "INSERT INTO `Movimientos` (`codigoMov`, `loginUsu`, `fecha`, `concepto`, `cantidad`)"
                . " VALUES (?, ?, ?, ?, ?);";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta
        $consulta = $con->prepare($sql);
        // Se pasa los parámetros a la consulta
        $consulta->bindParam(1, $codigo);
        $consulta->bindParam(2, $usuario);
        $consulta->bindParam(3, $fecha);
        $consulta->bindParam(4, $concepto);
        $consulta->bindParam(5, $cantidad);
        // Se ejecuta
        $consulta->execute();
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

/*
 * Función que borra todos los movimientos que se les pase por array como parametro por el código
 */

function borrarMovimientos($movimientos) {
    try {
        // Se guarda la consulta
        $sql = "DELETE FROM Movimientos WHERE codigoMov = ?";
        // Se crea la conexión
        $con = conexionBD();
        // Se prepara la consulta
        $consulta = $con->prepare($sql);
        // Itera por cada dato dentro del array
        foreach ($movimientos as $movimiento) {
            // Se pasa el código a la consulta y se ejecuta
            $consulta->bindParam(1, $movimiento);
            $consulta->execute();
        }
    } catch (Exception $e) { // Se controla las excepciones
        print "<h2>¡Error!: " . $e->getMessage() . "</h2><br/>";
        die();
    }
}

function crear_autoevaluacion() {
    //Si recibe datos en la  segunda fila de esa columna, se suman todas las filas de esa columna
    //if (isset($_GET['23'])) {
    if (isset($_GET['34'])) {
        $total_prof = $_GET['34'] + $_GET['54'] + $_GET['64'] + $_GET['74'] + $_GET['94'] + $_GET['104'] + $_GET['114'] + $_GET['134'] + $_GET['144'] + $_GET['164'] + $_GET['174'] + $_GET['184'] + $_GET['194'] + $_GET['214'] + $_GET['224'] + $_GET['234'] + $_GET['244'] + $_GET['254'] + $_GET['264'] + $_GET['284'] + $_GET['294'] + $_GET['304'] + $_GET['324'] + $_GET['334'] + $_GET['344'] + $_GET['364'] + $_GET['374'] + $_GET['404'] + $_GET['414'] + $_GET['424'] + $_GET['434'] + $_GET['444'] + $_GET['454'] + $_GET['464'] + $_GET['474'] + $_GET['484'] + $_GET['494'];
    }
    //Si recibe datos en la  segunda fila de esa columna, se suman todas las filas de esa columna
    if (isset($_GET['33'])) {
        $total_alum = $_GET['33'] + $_GET['43'] + $_GET['53'] + $_GET['63'] + $_GET['73'] + $_GET['83'] + $_GET['93'] + $_GET['103'] + $_GET['113'] + $_GET['123'] + $_GET['133'] + $_GET['143'] + $_GET['153'] + $_GET['163'] + $_GET['173'] + $_GET['183'] + $_GET['193'] + $_GET['203'] + $_GET['213'] + $_GET['223'] + $_GET['233'] + $_GET['243'] + $_GET['253'] + $_GET['263'] + $_GET['273'] + $_GET['283'] + $_GET['293'] + $_GET['303'] + $_GET['313'] + $_GET['323'] + $_GET['333'] + $_GET['343'] + $_GET['353'] + $_GET['363'] + $_GET['373'] + $_GET['383'] + $_GET['393'] + $_GET['403'] + $_GET['413'] + $_GET['423'] + $_GET['433'] + $_GET['443'] + $_GET['453'] + $_GET['463'] + $_GET['473'] + $_GET['483'] + $_GET['493'];
    }
    $linea = 0;
    //Abrimos nuestro archivo
    $archivo = fopen("autoevaluacion.csv", "r");
    //Escribimos las etiquetas de formulario y tabla
    echo '<form action="autoevaluacion.php" method="get"><table border="1">';
    //Lo recorremos
    while (($datos = fgetcsv($archivo, ",")) == true) {
        $num = count($datos);
        $linea++;

        echo '<tr>';
        //Recorremos las columnas de esa linea
        for ($columna = 0; $columna < $num - 1; $columna++) {
            //Si es la primera columna se ejecuta este código
            if ($columna === 1) {
                //La primera fila solo se escribe los datos recibidos, en las otras cortamos la cadena a 20 caracteres
                // y mostramos el resto en un "Ver mas"
                if ($linea === 1) {
                    echo '<td>' . $datos[$columna] . "</td>";
                } elseif ($linea === 50) {
                    echo '<td>Total</td>';
                } elseif ($linea > 2 and $linea < 50) {
                    echo '<td>' . substr($datos[$columna], 0, 20) . " <a title ='" . $datos[$columna] . "'> Ver mas</a></td>";
                }
            }

            //Si es la segunda columna, se ejecuta este código
            if ($columna === 3) {
                //En la primera fila se escribe los datos. En las siguientes se crea un campo de formulario
                //y en la fila 17 se impime el total
                if ($linea === 1) {
                    echo '<td style="width:220px;">' . $datos[$columna] . "</td>";
                } elseif ($linea === 50) {
                    echo '<td><input type="text" name="' . $linea . '' . $columna . '" value="';
                    //Si recibe datos, se escribe el total
                    if (isset($_GET['33'])) {
                        echo $total_alum;
                    }
                    echo '"/></td>';
                } elseif ($linea > 2 and $linea < 50) {
                    echo '<td><input type="number"  step= "0.1" name="' . $linea . '' . $columna . '" value="';
                    //Si recibe datos en ese campo, se escriben. En caso contrario se usa 0 como defecto
                    if (isset($_GET[$linea . '' . $columna])) {
                        echo $_GET[$linea . '' . $columna];
                    } else {
                        echo '0';
                    }
                    echo '"/></td>';
                }
            }

            //Si es la tercera columna, se ejecuta este código
            if ($columna === 4) {
                //En la primera fila se escribe los datos. En las siguientes se crea un campo de formulario
                //y en la fila 17 se impime el total
                if ($linea === 1) {
                    echo '<td style="width:220px;">' . $datos[$columna] . "</td>";
                } elseif ($linea === 50) {
                    echo '<td><input type="text" name="' . $linea . '' . $columna . '" value="';
                    //Si recibe datos, se escribe el total
                    if (isset($_GET['34'])) {
                        echo $total_prof;
                    }
                    echo '"/></td>';
                } elseif ($linea > 2 and $linea < 50) {
                    //Se escribe los datos leido del archivo
                    echo '<td><input type="text" name="' . $linea . '' . $columna . '" value="' . $datos[2] . '"/></td>';
                }
            }
        }
        //Cierro etiquetas
        echo'</tr>';
    }
    echo '</table>'
    //Creo un area de texto para las observaciones, si recibe datos, los escribe en el campo
    . 'Observaciones <textarea rows="10" cols="40" name="observaciones">';
    if (isset($_GET['observaciones'])) {
        echo $_GET['observaciones'];
    }
    echo '</textarea><br/>'
    //boton de enviar
    . '<input type="submit" value="Enviar"/>'
    . '</form>';

//Cerramos el archivo
    fclose($archivo);
}
