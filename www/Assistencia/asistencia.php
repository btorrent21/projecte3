<?php
// Incluye el archivo de configuración de la base de datos
require_once "settingsbd.php";

// Verifica si el usuario está autenticado
session_start();
if(!isset($_SESSION["usuario"])){
    header("location: login.php");
    exit();
}

// Consulta SQL para obtener los nombres de los estudiantes asociados al profesor actual
$profesor_id = $_SESSION["id"]; // Suponiendo que guardaste el ID del profesor en la sesión al iniciar sesión
$sql = "SELECT e.nombre 
        FROM estudiante e
        INNER JOIN profesores p ON e.idProfesor = p.id
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error al preparar la consulta: ' . $conn->error);
}

$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = array();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Itera sobre los resultados y guarda los nombres de los estudiantes en un array
    while($row = $result->fetch_assoc()) {
        $estudiantes[] = $row['nombre'];
    }
} else {
    echo "No se encontraron estudiantes asociados a este profesor.";
}

// Cierra la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Asistencia para <?php echo isset($_GET['materia']) ? $_GET['materia'] : 'Sin materia'; ?></h1>
        <form action="registrar.php" method="post">
            <input type="hidden" name="materia" value="<?php echo isset($_GET['materia']) ? $_GET['materia'] : ''; ?>">
            <table>
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>Asistencia</th>
                </tr>
                <?php
                // Itera sobre el array de estudiantes y muestra sus nombres en la tabla
                foreach ($estudiantes as $estudiante) {
                    echo "<tr>";
                    echo "<td>{$estudiante}</td>";
                    echo "<td><input type='checkbox' name='asistencia[]' value='{$estudiante}' checked></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <button type="submit">Registrar Asistencia</button>
        </form>
    </div>
</body>
</html>

