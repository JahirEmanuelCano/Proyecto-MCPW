<?php
include("conexion.php");

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $categoria = $_POST["categoria"];
    $fecha = $_POST["fecha"];
    $cliente = $_POST["cliente"];
    $descripcion = $_POST["descripcion"];
    $overview = $_POST["overview"];
    $reto = $_POST["reto"];
    $solucion = $_POST["solucion"];

    $stmt = $conexion->prepare("INSERT INTO trabajos (titulo, categoria, fecha, cliente, descripcion, overview, reto, solucion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $titulo, $categoria, $fecha, $cliente, $descripcion, $overview, $reto, $solucion);
    $stmt->execute();
    $trabajo_id = $conexion->insert_id;

    if (!empty($_FILES["imagen"]["name"])) {
        $nombreImagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = "uploads/" . time() . "_" . $nombreImagen;
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);

        $stmt_img = $conexion->prepare("INSERT INTO imagenes (trabajo_id, ruta) VALUES (?, ?)");
        $stmt_img->bind_param("is", $trabajo_id, $rutaDestino);
        $stmt_img->execute();
    }

    $stmt->close();
}

$trabajos = $conexion->query("
    SELECT t.*, i.ruta 
    FROM trabajos t 
    LEFT JOIN imagenes i ON t.id = i.trabajo_id
");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Trabajos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #101820;
            color: #00cc33;
        }

        .btn-success {
            background-color: #00cc33;
            border: none;
        }

        .btn-success:hover {
            background-color: #00b32c;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .table {
            background-color: #1c1f26;
            color: #ffffff;
        }

        .table th,
        .table td {
            border-color: #444;
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
        <h2 class="mb-4">Bienvenido, <?= $_SESSION["nombre"] ?></h2>
        <div> <a href="opiniones.php" class="btn btn-success">ver comentarios</a>
            <a href="contacto.php" class="btn btn-success">ver contactos</a>
            <a href="Dashboard.html" class="btn btn-success">ver estadisticas</a>
        </div>
        <h4 class="mb-3">Agregar trabajo</h4>
        <form method="POST" enctype="multipart/form-data" class="row g-3 mb-5">
            <div class="col-md-6">
                <label>Trabajo</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Categoría del trabajo</label>
                <input type="text" name="categoria" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Fecha que se realizo</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label>Cliente</label>
                <input type="text" name="cliente" class="form-control" required>
            </div>
            <div class="col-12">
                <label>Breve Descripción del Trabajo</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="col-12">
                <label>Planteamiento de Ejecucion</label>
                <textarea name="overview" class="form-control"></textarea>
            </div>
            <div class="col-12">
                <label>Reto del Trabajo</label>
                <textarea name="reto" class="form-control"></textarea>
            </div>
            <div class="col-12">
                <label>Solución de los problemas</label>
                <textarea name="solucion" class="form-control"></textarea>
            </div>
            <div class="col-12">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="col-12">
                <button class="btn btn-success">Guardar Trabajo</button>
            </div>
            <div>
                <a href="inicioSesion.php" class="btn btn-danger mb-4">Cerrar sesión</a>
            </div>
        </form>

        <h4>Trabajos registrados</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre </th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $trabajos->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila["titulo"]) ?></td>
                        <td><?= htmlspecialchars($fila["categoria"]) ?></td>
                        <td><?= htmlspecialchars($fila["fecha"]) ?></td>
                        <td><?= htmlspecialchars($fila["cliente"]) ?></td>
                        <td>
                            <?php if ($fila["ruta"]): ?>
                                <img src="<?= $fila["ruta"] ?>" width="80">
                            <?php else: ?>
                                Sin imagen
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>