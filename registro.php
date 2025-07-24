<?php
//Formulario de registro para nuevos usuarios
//Los nuevos usuarios se registran como usuarios normales (es_admin = 0)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion.php");

$mensaje = "";
$tipo_mensaje = "danger"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clave = $_POST["clave"];
    $confirmar_clave = $_POST["confirmar_clave"];

    // Validaciones
    if (empty($nombre) || empty($correo) || empty($clave) || empty($confirmar_clave)) {
        $mensaje = "Todos los campos son obligatorios";
    } elseif ($clave !== $confirmar_clave) {
        $mensaje = "Las contraseñas no coinciden";
    } elseif (strlen($clave) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido";
    } else {
        // Verificar si el correo ya existe
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "Este correo ya está registrado";
        } else {
            // Insertar nuevo usuario (es_admin = 0 por defecto para usuarios normales)
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, clave, es_admin) VALUES (?, ?, ?, 0)");
            $stmt->bind_param("sss", $nombre, $correo, $clave);

            if ($stmt->execute()) {
                $mensaje = "Usuario registrado exitosamente. Ya puedes iniciar sesión.";
                $tipo_mensaje = "success";

                // Limpiar el formulario después del registro exitoso
                $nombre = $correo = "";
            } else {
                $mensaje = "Error al registrar el usuario. Intenta nuevamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #101820;
            color: #fff;
        }

        .card {
            background-color: #1c1f26;
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px #0f0;
        }

        .btn-success {
            background-color: #00cc33;
            border: none;
            font-weight: bold;
        }

        .btn-success:hover {
            background-color: #00b32c;
        }

        .titulo-verde {
            color: #f0f4f1ff;
            font-weight: bold;
        }

        .form-control:focus {
            color: #dce6dfff;
            background-color: #101820;
            border-color: #6d716eff;
            outline: 0;
            box-shadow: 0 0 0 0.20rem #00cc33;
        }

        .form-control {
            color: #dce6dfff;
            background-color: #101820;
            border-color: #6d716eff;
            outline: 0;
            font-weight: bold;
        }

        .enlace-login {
            color: #00cc33;
            text-decoration: none;
        }

        .enlace-login:hover {
            color: #00b32c;
            text-decoration: underline;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <h2 class="mb-4 text-center titulo-verde">Crear Cuenta</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipo_mensaje ?>"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="titulo-verde">Nombre completo:</label>
                <input type="text" name="nombre" class="form-control"
                    value="<?= isset($nombre) ? htmlspecialchars($nombre) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="titulo-verde">Correo electrónico:</label>
                <input type="email" name="correo" class="form-control"
                    value="<?= isset($correo) ? htmlspecialchars($correo) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="titulo-verde">Contraseña:</label>
                <input type="password" name="clave" class="form-control" minlength="6" required>
                <small class="text-muted">Mínimo 6 caracteres</small>
            </div>

            <div class="mb-3">
                <label class="titulo-verde">Confirmar contraseña:</label>
                <input type="password" name="confirmar_clave" class="form-control" minlength="6" required>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-3">REGISTRARSE</button>
        </form>

        <div class="text-center">
            <p>¿Ya tienes cuenta?
                <a href="inicioSesion.php" class="btn btn-success w-100 mb-3">INICIE SESION</a>
            </p>
        </div>
    </div>
</body>

</html>