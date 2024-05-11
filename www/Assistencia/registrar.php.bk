<?php
// Incluye el archivo de configuración de la base de datos
require_once "settingsbd.php";

// Verifica si el usuario está autenticado
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
    exit();
}

// Verifica si se ha recibido el parámetro de materia por POST
if (!isset($_POST['materia'])) {
    die("Error: No se especificó la materia.");
}

// Obtiene el nombre de la materia desde el POST
$materia = $_POST['materia'];

// Valida que la materia recibida sea una columna válida en la tabla
$columnas_validas = [
    'Historia', 'Ingles', 'Ciencias', 'Castellano',
    'Informatica', 'Catalan', 'Tecnologia', 'Geografia', 'EF'
];

if (!in_array($materia, $columnas_validas)) {
    die("Error: La materia especificada no es válida.");
}

// Preparar la declaración SQL para actualizar las faltas según la materia
$sql_update = "UPDATE faltas_estudiantes SET {$materia} = {$materia} + 1 WHERE idEstudiante = ?";

$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
    die('Error al preparar la consulta de actualización: ' . $conn->error);
}

// Itera sobre los estudiantes y actualiza las faltas para cada uno
if (isset($_POST['asistencia']) && is_array($_POST['asistencia'])) {
    foreach ($_POST['asistencia'] as $nombreEstudiante) {
        // Consulta SQL para obtener el ID del estudiante por su nombre
        $sql_id_estudiante = "SELECT id FROM estudiante WHERE nombre = ?";
        $stmt_id_estudiante = $conn->prepare($sql_id_estudiante);
        $stmt_id_estudiante->bind_param("s", $nombreEstudiante);
        $stmt_id_estudiante->execute();
        $result_id_estudiante = $stmt_id_estudiante->get_result();

        if ($result_id_estudiante->num_rows > 0) {
            $row = $result_id_estudiante->fetch_assoc();
            $idEstudiante = $row['id'];

            // Actualiza las faltas para el estudiante en la materia especificada
            $stmt_update->bind_param("i", $idEstudiante);
            $stmt_update->execute();
            
            if ($stmt_update->affected_rows > 0) {
                echo "Faltas actualizadas para el estudiante con ID: $idEstudiante en la materia $materia<br>";
            } else {
                echo "No se encontró el estudiante con ID: $idEstudiante<br>";
            }
        } else {
            echo "Error: No se encontró el estudiante '$nombreEstudiante'.<br>";
        }
        $stmt_id_estudiante->close();
    }
}

// Mostrar todas las variables POST para depuración
echo "<h2>Variables POST:</h2>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";

// Cierra las consultas preparadas
$stmt_update->close();
$conn->close();

// Redirige de vuelta a la página principal después de registrar las faltas
header('Location: www.insviladegracia.cat/Assistencia/registrar.php');
exit();
?>
