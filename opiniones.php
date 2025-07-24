<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $calificacion = $_POST["calificacion"];
    $comentario = $_POST["comentario"];

    $stmt = $conexion->prepare("INSERT INTO opiniones (nombre, calificacion, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nombre, $calificacion, $comentario);
    $stmt->execute();
    $stmt->close();

    $mensaje = "¡Gracias por tu opinión!";
}

$opiniones = $conexion->query("SELECT * FROM opiniones ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Opiniones</title>
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
        textarea:focus,
        .form-select:focus {
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
            <h2 class="mb-4 text-center">Danos tu Opinion</h2>
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success"><?= $mensaje ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Calificacion (1 a 5⭐)</label>
                    <select name="calificacion" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="1">1 - Muy Malo</option>
                        <option value="2">2 - Malo</option>
                        <option value="3">3 - Regular</option>
                        <option value="4">4 - Bueno</option>
                        <option value="5">5 - Excelente</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Comentario</label>
                    <textarea name="comentario" class="form-control" rows="4" required></textarea>
                </div>
                <button class="btn btn-success w-100">Enviar Opinion</button>
            </form>
        </div>
        <div> <a href="trabajos.php" class="btn btn-success">ver trabajos</a>
            <a href="contacto.php" class="btn btn-success">ver contactos</a>
               <a href="Dashboard.html" class="btn btn-success">ver estadisticas</a>
        </div>
        <h4 class="mb-3">Opiniones Recientes</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Calificacion</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($op = $opiniones->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($op["nombre"]) ?></td>
                        <td><?= $op["calificacion"] ?> ⭐</td>
                        <td><?= htmlspecialchars($op["comentario"]) ?></td>
                        <td><?= $op["fecha"] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>