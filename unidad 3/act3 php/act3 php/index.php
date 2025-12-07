<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do List | ITIID-76134</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #2a6496; }
        h2 { border-bottom: 2px solid #ccc; padding-bottom: 5px; }
        .form-add { background: #f9f9f9; padding: 15px; border: 1px solid #eee; margin-bottom: 20px; }
        .lista { border: 1px solid #ddd; padding: 15px; margin-bottom: 30px; }
        .tarea-pendiente { color: #333; }
        .tarea-completada { color: green; text-decoration: line-through; }
        .tarea-vencida { color: red; font-weight: bold; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 8px; padding-bottom: 5px; border-bottom: 1px dotted #eee; }
        .btn-complete { background-color: #5cb85c; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px; }
        .btn-complete:hover { background-color: #4cae4c; }
    </style>
</head>
<body>

    <h1>Gestor de Tareas</h1>
    <hr>

    <h2>Agregar Nueva Tarea</h2>
    <div class="form-add">
        <form method="post" action="guardar.php">
            <label for="tarea">Tarea:</label>
            <input type="text" name="tarea" id="tarea" style="width: 300px;" required><br><br>
            
            <label for="fecha_limite">Fecha Límite:</label>
            <input type="date" name="fecha_limite" id="fecha_limite" required>
            
            <input type="hidden" name="action" value="add">
            <input type="submit" value="Guardar Tarea">
        </form>
    </div>
    
    <?php require_once 'guardar.php'; ?>

    <hr>

    <?php mover_tareas_vencidas('pendientes.txt', 'vencidas.txt'); ?> 

    <h2>Tareas Pendientes</h2>
    <div class="lista">
        <?php
        $archivo_pendientes = 'pendientes.txt';
        if (file_exists($archivo_pendientes) && filesize($archivo_pendientes) > 0) {
            $tareas = file($archivo_pendientes, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (empty($tareas)) {
                echo "<p>No hay tareas pendientes por hacer.</p>";
            } else {
                echo "<ul>";
                foreach ($tareas as $index => $linea) {
                    list($tarea, $fecha_limite) = explode('|', $linea);
                    
                    echo "<li class='tarea-pendiente'>";
                    echo "<strong>$tarea</strong> (Límite: $fecha_limite)";
                    
                    echo " <form method='post' action='guardar.php' style='display:inline; margin-left: 10px;'>";
                    echo " <input type='hidden' name='action' value='complete'>";
                    echo " <input type='hidden' name='task_index' value='$index'>";
                    echo " <input type='submit' value='Completar' class='btn-complete'>";
                    echo " </form>";
                    
                    echo "</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "<p>No hay tareas pendientes por hacer.</p>";
        }
        ?>
    </div>

    <h2>Tareas Completadas</h2>
    <div class="lista">
        <?php
        $archivo_completadas = 'completadas.txt';
        if (file_exists($archivo_completadas) && filesize($archivo_completadas) > 0) {
            $tareas = file($archivo_completadas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            echo "<ul>";
            foreach ($tareas as $linea) {
                list($tarea, $fecha_limite) = explode('|', $linea);
                echo "<li class='tarea-completada'>$tarea (Fecha límite original: $fecha_limite)</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aún no hay tareas completadas.</p>";
        }
        ?>
    </div>

    <h2>Tareas Vencidas</h2>
    <div class="lista">
        <?php
        $archivo_vencidas = 'vencidas.txt';
        if (file_exists($archivo_vencidas) && filesize($archivo_vencidas) > 0) {
            $tareas = file($archivo_vencidas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            echo "<ul>";
            foreach ($tareas as $linea) {
                list($tarea, $fecha_limite) = explode('|', $linea);
                echo "<li class='tarea-vencida'>$tarea (Venció el $fecha_limite)</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay tareas que hayan vencido.</p>";
        }
        ?>
    </div>

</body>
</html>