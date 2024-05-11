<?php
// Iniciar sesión si aún no se ha iniciado
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario"])) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("location: login.php");
    exit;
}

// Obtener el usuario de la sesión
$usuario = $_SESSION["usuario"];
$id = $_SESSION["id"];

// Realizar la consulta a la base de datos para obtener el horario del profesor
require_once "settingsbd.php";

// Consulta SQL para obtener el horario del profesor
$sql = "SELECT horario FROM profesores WHERE usuario = ?";
$horario = "";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($horario);
    $stmt->fetch();
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();

// Mostrar el valor de la variable de horario
echo "Horario del profesor $usuario: $horario: $id";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Horario</h1>
        <table>
            <tr>
                <th>Hora</th>
                <th>Clase</th>
            </tr>
            <?php
            // Iterar sobre el horario obtenido y mostrarlo en la tabla
            $horario = json_decode(file_get_contents($horario), true);
            foreach ($horario as $hora => $clase) {
                echo "<tr>";
                echo "<td>$hora</td>";
                echo "<td><a href='asistencia.php?materia=" . urlencode($clase) . "'>$clase</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <button><a href="media.php" class="btn btn-danger btn-lg">Faltas</a></button>
    </div>
</body>
</html>
