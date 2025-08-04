<?php
include("conexion.php");

$confirmacion = "";
$error = "";

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $confirmacion = "Mensaje eliminado correctamente.";
    } else {
        $error = "Error al eliminar el mensaje.";
    }
    $stmt->close();
}

$editando = false;
$datos_edicion = null;

if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $stmt = $conexion->prepare("SELECT * FROM contactos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($datos_edicion = $resultado->fetch_assoc()) {
        $editando = true;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conexion->prepare("UPDATE contactos SET nombre = ?, correo = ?, asunto = ?, mensaje = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nombre, $correo, $asunto, $mensaje, $id);
        if ($stmt->execute()) {
            $confirmacion = "Mensaje actualizado correctamente.";
        } else {
            $error = "Error al actualizar el mensaje.";
        }
    } else {
        $stmt = $conexion->prepare("INSERT INTO contactos (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
        if ($stmt->execute()) {
            $confirmacion = "Mensaje enviado correctamente.";
        } else {
            $error = "Error al enviar el mensaje.";
        }
    }
    $stmt->close();

    $editando = false;
    $datos_edicion = null;
}

$mensajes = $conexion->query("SELECT * FROM contactos ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contáctanos - CRUD Completo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #000;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            color: #000;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
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

        .action-buttons {
            white-space: nowrap;
        }

        .action-buttons .btn {
            margin: 2px;
            padding: 5px 10px;
            font-size: 12px;
        }

        .table td {
            vertical-align: middle;
        }

        .alert {
            margin-bottom: 20px;
        }

        .editing-header {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: #000;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="formulario mb-5">
            <?php if ($editando): ?>
                <div class="editing-header">
                    <h2 class="mb-0"><i class="fas fa-edit"></i> Editando Mensaje</h2>
                </div>
            <?php else: ?>
                <h2 class="mb-4 text-center">Contáctanos</h2>
            <?php endif; ?>

            <?php if (!empty($confirmacion)): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?= $confirmacion ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <?php if ($editando): ?>
                    <input type="hidden" name="id" value="<?= $datos_edicion['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control"
                        value="<?= $editando ? htmlspecialchars($datos_edicion['nombre']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control"
                        value="<?= $editando ? htmlspecialchars($datos_edicion['correo']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Asunto</label>
                    <input type="text" name="asunto" class="form-control"
                        value="<?= $editando ? htmlspecialchars($datos_edicion['asunto']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mensaje</label>
                    <textarea name="mensaje" class="form-control" rows="4"
                        required><?= $editando ? htmlspecialchars($datos_edicion['mensaje']) : '' ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <?php if ($editando): ?>
                        <button type="submit" class="btn btn-warning flex-fill">
                            <i class="fas fa-save"></i> Actualizar Mensaje
                        </button>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    <?php else: ?>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane"></i> Enviar Mensaje
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="mb-4">
            <a href="trabajos.php" class="btn btn-success me-2">
                <i class="fas fa-briefcase"></i> Ver Trabajos
            </a>
            <a href="opiniones.php" class="btn btn-success me-2">
                <i class="fas fa-comments"></i> Ver Opiniones
            </a>
            <a href="Dashboard.html" class="btn btn-success">
                <i class="fas fa-chart-bar"></i> Ver Estadísticas
            </a>
        </div>

        <h4 class="mb-3">
            <i class="fas fa-inbox"></i> Mensajes Recibidos
            <span class="badge bg-success"><?= $mensajes->num_rows ?></span>
        </h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($mensajes->num_rows > 0): ?>
                        <?php while ($row = $mensajes->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><i class="fas fa-user-circle me-2"></i><?= htmlspecialchars($row["nombre"]) ?></td>
                                <td><?= htmlspecialchars($row["correo"]) ?></td>
                                <td><?= htmlspecialchars($row["asunto"]) ?></td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                        <?= htmlspecialchars(substr($row["mensaje"], 0, 50)) ?>
                                        <?= strlen($row["mensaje"]) > 50 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row["fecha"])) ?></td>
                                <td class="text-center action-buttons">
                                    <a href="?editar=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?eliminar=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este mensaje?')"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="mb-0">No hay mensajes para mostrar</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        document.querySelectorAll('a[href*="eliminar"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (!confirm('⚠️ ¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>