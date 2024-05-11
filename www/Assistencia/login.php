<?php
// Incluimos el archivo de configuración de la base de datos
require_once "settingsbd.php";

// Definimos las variables y las inicializamos con valores vacíos
$usuario = $contraseña = "";
$usuario_err = $contraseña_err = "";

// Procesamos los datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos si el campo de usuario está vacío
    if (empty(trim($_POST["usuario"]))) {
        $usuario_err = "Por favor, ingrese su nombre de usuario.";
    } else {
        $usuario = trim($_POST["usuario"]);
    }

    // Verificamos si el campo de contraseña está vacío
    if (empty(trim($_POST["contraseña"]))) {
        $contraseña_err = "Por favor, ingrese su contraseña.";
    } else {
        $contraseña = trim($_POST["contraseña"]);
    }
    
    // Validamos las credenciales
    // Preparamos la declaración SQL para verificar las credenciales
    $sql = "SELECT usuario, id password FROM profesores WHERE usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Vinculamos las variables a la declaración preparada como parámetros
        $stmt->bind_param("s", $param_usuario);

        // Establecemos los parámetros
        $param_usuario = $usuario;

        // Intentamos ejecutar la declaración preparada
        if ($stmt->execute()) {
            // Guardamos el resultado
            $stmt->store_result();

            // Verificamos si el usuario existe
            if ($stmt->num_rows == 1) {
                // Vinculamos las variables de resultado
                $stmt->bind_result($usuario, $hashed_password);
                if ($stmt->fetch()) {
                    // Verificamos la contraseña
                        // Consultamos el ID del usuario
                        $sql_id = "SELECT id FROM profesores WHERE usuario = ?";
                        if ($stmt_id = $conn->prepare($sql_id)) {
                            // Vinculamos las variables a la declaración preparada como parámetros
                            $stmt_id->bind_param("s", $param_usuario);

                            // Intentamos ejecutar la declaración preparada
                            if ($stmt_id->execute()) {
                                // Vinculamos las variables de resultado
                                $stmt_id->bind_result($id);
                                if ($stmt_id->fetch()) {
                                    // Iniciamos la sesión
                                    session_start();
                                    // Guardamos las variables de sesión
                                    $_SESSION["id"] = $id;
                                    $_SESSION["usuario"] = $usuario;
                                    // Redireccionamos al usuario a la página de inicio
                                    header("location: index.php");
                                }
                            }
                            // Cerramos la declaración preparada
                            $stmt_id->close();
                        }
                    
                }
            } else {
                // No se encontró ninguna cuenta con ese nombre de usuario
                $usuario_err = "No hay ninguna cuenta asociada a ese nombre de usuario.";
            }
        } else {
            echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
        }

        // Cerramos la declaración preparada
        $stmt->close();
    }

    // Cerramos la conexión
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($usuario_err)) ? 'has-error' : ''; ?>">
                <label>Usuario</label>
                <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>">
                <span class="help-block"><?php echo $usuario_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="contraseña" class="form-control">
                <span class="help-block"><?php echo $contraseña_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
            </div>
        </form>
    </div>
</body>
</html>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    width: 360px;
    margin: 100px auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.has-error .form-control {
    border-color: #ff0000;
}

.help-block {
    color: #ff0000;
    font-size: 14px;
}

.btn-primary {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>

