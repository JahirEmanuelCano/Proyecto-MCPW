<?php
//Solo el usuario admin puede ingresar a los formularios php
//El usuario restante lo utilice para que pueda ver toda la estructura del index sin que puede acceder a los formularios
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
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            header("Location: trabajos.php");
            exit;
        } elseif ($usuario["es_admin"] != 1) {
              header("Location: index.html");
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
    <title>Login</title>
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
        }

        .btn-success:hover {
            background-color: #00b32c;
        }

        .titulo-verde {
            color: #00cc33;
            font-weight: bold;
        }

        .form-control:focus {
            color: #101820;
            background-color: rgb(241, 241, 243);
            border-color: #00cc33;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(0, 204, 51, 0.25);
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <h2 class="mb-4 text-center titulo-verde">Iniciar sesion</h2>
        <?php if ($mensaje): ?>
            <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="titulo-verde">Correo:</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="titulo-verde">Contraseña:</label>
                <input type="password" name="clave" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Iniciar Sesion</button>
        </form>
    </div>
</body>

</html>