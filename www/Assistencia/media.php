<?php
// Incluye el archivo de configuración de la base de datos
require_once "settingsbd.php";

// Nombres de las materias
$materias = [
    'Historia', 'Ingles', 'Ciencias', 'Castellano',
    'Informatica', 'Catalan', 'Tecnologia', 'Geografia', 'EF'
];

// Consulta SQL para obtener la lista de estudiantes
$sql_estudiantes = "SELECT id, nombre FROM estudiante";
$result_estudiantes = $conn->query($sql_estudiantes);

// Comienza la salida HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valores de Materias y Faltas de Estudiantes</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .rojo {
            background-color: red;
        }
    </style>
</head>
<body>
    <h1>Valores de Materias y Faltas de Estudiantes</h1>

    <!-- Tabla para los valores de las materias -->
    <h2>Valores de Materias</h2>
    <table>
        <tr>
            <th>Materia</th>
            <th>Valor</th>
        </tr>
        <?php
        // Iterar sobre las materias
        foreach ($materias as $materia) {
            // Consulta SQL para obtener el valor de la materia desde la tabla horas-asignaturas
            $sql_valor = "SELECT {$materia} FROM `horas_asignaturas`"; // Cambia el idEstudiante según tus necesidades
            $result_valor = $conn->query($sql_valor);

            if ($result_valor && $result_valor->num_rows > 0) {
                $row_valor = $result_valor->fetch_assoc();
                #echo $row_valor[$materia];
                $valor = $row_valor[$materia];

                // Imprimir la fila de la tabla con el nombre de la materia y su valor correspondiente
                echo "<tr>";
                echo "<td>{$materia}</td>";
                echo "<td>{$valor}</td>";
                echo "</tr>";
            } else {
                // Si no se encuentra el valor, imprimir una fila con un mensaje de error
                echo "<tr>";
                echo "<td>{$materia}</td>";
                echo "<td>Error: Valor no encontrado</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <!-- Tabla para los nombres de los estudiantes y faltas en cada asignatura -->
    <h2>Faltas de Estudiantes en Asignaturas</h2>
    <table>
        <tr>
            <th>ID Estudiante</th>
            <th>Nombre Estudiante</th>
            <?php
            // Imprimir las columnas de asignaturas
            foreach ($materias as $materia) {
                echo "<th>{$materia}</th>";
            }
            ?>
        </tr>
        <?php
        // Iterar sobre los resultados de la consulta de estudiantes
        if ($result_estudiantes && $result_estudiantes->num_rows > 0) {
            while ($row_estudiante = $result_estudiantes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row_estudiante['id']}</td>";
                echo "<td>{$row_estudiante['nombre']}</td>";

                // Obtener las horas de falta por asignatura para el estudiante actual
                foreach ($materias as $materia) {
                    // Consulta SQL para obtener las horas de falta
                    $sql_faltas = "SELECT {$materia} FROM `faltas_estudiantes` WHERE idEstudiante = {$row_estudiante['id']}";
                    $result_faltas = $conn->query($sql_faltas);

                    if ($result_faltas && $result_faltas->num_rows > 0) {
                        $row_faltas = $result_faltas->fetch_assoc();
                        $faltas = $row_faltas[$materia]; // Obtener las faltas para la asignatura actual

                        // Calcular el porcentaje de faltas
                        $porcentaje_faltas = ($faltas / $valor) * 100;

                        // Aplicar estilo condicional si el porcentaje de faltas es mayor al 20%
                        if ($porcentaje_faltas >= 20) {
                            echo "<td class='rojo'>{$faltas}</td>";
                        } else {
                            echo "<td>{$faltas}</td>";
                        }
                    } else {
                        echo "<td>0</td>"; // Si no hay faltas registradas, mostrar 0
                    }
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='" . (count($materias) + 2) . "'>No se encontraron estudiantes.</td></tr>";
        }
        ?>
    </table>
    <button><a href="index.php" class="btn btn-danger btn-lg">Faltas</a></button>
</body>
</html>

<?php
// Cierra la conexión
$conn->close();
?>
