<?php

function mover_tareas_vencidas($archivo_origen, $archivo_destino) {
    if (!file_exists($archivo_origen) || filesize($archivo_origen) == 0) {
        return; 
    }

    $tareas_actuales = file($archivo_origen, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $tareas_pendientes_filtradas = [];
    $tareas_vencidas = [];
    
    $fecha_actual = new DateTime('today');
    $movidas = false;

    foreach ($tareas_actuales as $linea) {
        list($tarea, $fecha_limite_str) = explode('|', $linea);
        
        try {
            $fecha_limite = new DateTime($fecha_limite_str);
            
            if ($fecha_limite < $fecha_actual) {
                $tareas_vencidas[] = $linea;
                $movidas = true;
            } else {
                $tareas_pendientes_filtradas[] = $linea;
            }
        } catch (Exception $e) {
            $tareas_pendientes_filtradas[] = $linea;
        }
    }

    if ($movidas) {
        file_put_contents($archivo_origen, implode("\n", $tareas_pendientes_filtradas) . "\n");
        file_put_contents($archivo_destino, implode("\n", $tareas_vencidas) . "\n", FILE_APPEND);
    }
}


function guardar_tarea($tarea, $fecha_limite, $archivo_destino) {
    $tarea_saneada = htmlspecialchars(trim($tarea), ENT_QUOTES, 'UTF-8');
    $fecha_saneada = htmlspecialchars(trim($fecha_limite), ENT_QUOTES, 'UTF-8');
    
    $texto = $tarea_saneada . "|" . $fecha_saneada . "\n";
    
    if (file_put_contents($archivo_destino, $texto, FILE_APPEND) !== false) {
        return "Tarea '$tarea_saneada' guardada con éxito.";
    } else {
        return "Error al guardar la tarea. Verifique permisos de escritura.";
    }
}


function completar_tarea($index, $archivo_origen, $archivo_destino) {
    if (!file_exists($archivo_origen)) {
        return "Error: No existe el archivo de tareas pendientes.";
    }

    $tareas = file($archivo_origen, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if (!isset($tareas[$index])) {
        return "Error: Tarea no encontrada.";
    }

    $tarea_a_mover = $tareas[$index];
    unset($tareas[$index]); 

    file_put_contents($archivo_destino, $tarea_a_mover . "\n", FILE_APPEND);

    file_put_contents($archivo_origen, implode("\n", array_values($tareas)) . "\n"); 
    
    list($nombre_tarea, ) = explode('|', $tarea_a_mover);
    
    return "Tarea '$nombre_tarea' marcada como completada y movida.";
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    $mensaje = "";
    
    if ($_POST['action'] === 'add') {
        if (isset($_POST['tarea']) && isset($_POST['fecha_limite'])) {
            $mensaje = guardar_tarea($_POST['tarea'], $_POST['fecha_limite'], 'pendientes.txt');
        } else {
             $mensaje = "Faltan datos para guardar la tarea.";
        }
        
    } elseif ($_POST['action'] === 'complete') {
        if (isset($_POST['task_index'])) {
            $index = (int)$_POST['task_index'];
            $mensaje = completar_tarea($index, 'pendientes.txt', 'completadas.txt');
        } else {
             $mensaje = "Faltan datos para completar la tarea.";
        }
    }
    
    echo "<script>alert('$mensaje'); window.location.href = 'index.php';</script>";
    exit(); 
}

?>