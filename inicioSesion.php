<?php
//Sistema de login con opción para nuevos usuarios
//Solo el usuario admin puede ingresar a los formularios php
//Los usuarios normales son redirigidos al index
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if ($clave === $usuario["clave"] && $usuario["es_admin"] == 1) {
            session_start();
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            header("Location: Dashboard.html");
            exit;
        } elseif ($clave === $usuario["clave"] && $usuario["es_admin"] != 1) {
            session_start();
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Contraseña incorrecta";
        }
    } else {
        $mensaje = "Correo no registrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
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
            font-weight: bold;
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
            box-shadow: 0 0 0 0.25rem #00cc33;
        }
        
        .form-control {
            color: #dce6dfff;
            background-color: #101820;
            border-color: #6d716eff;
            outline: 0;
            font-weight: bold;
        }

        .enlace-registro {
            color: #00cc33;
            text-decoration: none;
        }

        .enlace-registro:hover {
            color: #00b32c;
            text-decoration: underline;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <h2 class="mb-4 text-center titulo-verde">Iniciar Sesión</h2>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="titulo-verde">Correo:</label>
                <input type="email" name="correo" class="form-control" placeholder="Correo Electronico"
                 required>
            </div>
            
            <div class="mb-3">
                <label class="titulo-verde">Contraseña:</label>
                <input type="password" name="clave" class="form-control" required>
            </div>
            
            <button class="btn btn-success w-100 mb-3">Iniciar Sesión</button>
        </form>
        
        <div class="text-center">
            <p>¿No tienes cuenta? 
                <a href="registro.php" class="btn btn-success w-100 mb-3">Regístrate aquí</a>
            </p>
        </div>
    </div>
</body>

</html>