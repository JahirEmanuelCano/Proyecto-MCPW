<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
    $stmt->execute();
    $stmt->close();

    $confirmacion = "Mensaje enviado correctamente.";
}

$mensajes = $conexion->query("SELECT * FROM contactos ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contáctanos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #101820;
            color: #00cc33;
        }

        .formulario {
            background-color: #1c1f26;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px #0f0;
        }

        .btn-success {
            background-color: #00cc33;
            border: none;
        }

        .btn-success:hover {
            background-color: #00b32c;
        }

        h2,
        h4 {
            color: #00cc33;
        }

        .table {
            background-color: #1c1f26;
            color: #fff;
            border-color: #00cc33;
        }

        .form-control:focus,
        .form-select,
        textarea:focus {
            color: #101820;
            background-color: rgb(241, 241, 243);
            border-color: #00cc33;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(5, 254, 67, 0.9);
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="formulario mb-5">
            <h2 class="mb-4 text-center">Contactanos</h2>
            <?php if (isset($confirmacion)): ?>
                <div class="alert alert-success"><?= $confirmacion ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Correo Electroanico</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Asunto</label>
                    <input type="text" name="asunto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Mensaje</label>
                    <textarea name="mensaje" class="form-control" rows="4" required></textarea>
                </div>
                <button class="btn btn-success w-100">Enviar Mensaje</button>
            </form>
        </div>
        <div> <a href="trabajos.php" class="btn btn-success">ver trabajos</a>
            <a href="opiniones.php" class="btn btn-success">ver opiniones</a>
            <a href="Dashboard.html" class="btn btn-success">ver estadisticas</a>
        </div>
        <h4 class="mb-3">Mensajes Recibidos</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $mensajes->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["nombre"]) ?></td>
                        <td><?= htmlspecialchars($row["correo"]) ?></td>
                        <td><?= htmlspecialchars($row["asunto"]) ?></td>
                        <td><?= htmlspecialchars($row["mensaje"]) ?></td>
                        <td><?= $row["fecha"] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>