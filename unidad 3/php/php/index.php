<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Multiplicar</title>
    <link rel="stylesheet" href="stilo.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>TABLA DE MULTIPLICAR</h1>
        </header>

        <section class="input-area">
            <form method="POST" action="index.php">
                <div class="input-group">
                    <label for="numero">Ingrese el número que quiere multiplicar:</label>
                    <input type="number" id="numero" name="numero" value="<?php echo isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : '15'; ?>">
                </div>
                <div class="input-group">
                    <label for="multiplicador">Ingrese las veces que se multiplicará:</label>
                    <input type="number" id="multiplicador" name="multiplicador" value="<?php echo isset($_POST['multiplicador']) ? htmlspecialchars($_POST['multiplicador']) : '5'; ?>">
                </div>
                <button type="submit" id="mostrarBtn" name="submit">Mostrar</button>
            </form>
        </section>

        <section class="result-header">
            <h2>SU RESULTADO ES:</h2>
        </section>

        <section class="result-area">
            <div id="tabla-resultado">
                <?php
                    // Lógica PHP para generar la tabla

                    // Por defecto, se establece una bandera para generar la tabla inicial
                    $generar_inicial = true;

                    // Si se envió el formulario (por el botón con name="submit")
                    if (isset($_POST['submit'])) {
                        $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
                        $multiplicador_maximo = filter_input(INPUT_POST, 'multiplicador', FILTER_VALIDATE_INT);
                        $generar_inicial = false; // Ya no es la carga inicial, sino el resultado del submit
                    } else {
                        // Carga inicial: se toman los valores por defecto del value en HTML (15 y 5)
                        $numero = 15;
                        $multiplicador_maximo = 5;
                    }

                    // La validación ahora es manejada por PHP antes de generar la tabla
                    if (!is_numeric($numero) || !is_numeric($multiplicador_maximo) || $multiplicador_maximo < 1) {
                        echo '<p style="color: red;">Por favor, ingrese números válidos.</p>';
                    } else {
                        // Comienza a construir la tabla HTML usando PHP
                        echo '<table>';

                        // Encabezado de la tabla
                        echo '<thead><tr>';
                        echo '<th>Numero</th>';
                        echo '<th>Multiplicador</th>';
                        echo '<th>Resultado</th>';
                        echo '</tr></thead>';

                        // Cuerpo de la tabla
                        echo '<tbody>';

                        for ($i = 1; $i <= $multiplicador_maximo; $i++) {
                            $resultado = $numero * $i;

                            echo '<tr>';
                            echo "<td>{$numero}</td>";
                            echo "<td>{$i}</td>";
                            echo "<td>{$resultado}</td>";
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    }
                ?>
            </div>
        </section>
    </div>
</body>
</html>
