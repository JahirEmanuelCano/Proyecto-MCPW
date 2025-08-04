<?php
include("conexion.php");

$confirmacion = "";
$error = "";

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM opiniones WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $confirmacion = "Opinión eliminada correctamente.";
    } else {
        $error = "Error al eliminar la opinión.";
    }
    $stmt->close();
}

$editando = false;
$datos_edicion = null;

if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $stmt = $conexion->prepare("SELECT * FROM opiniones WHERE id = ?");
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
    $calificacion = intval($_POST["calificacion"]);
    $comentario = $_POST["comentario"];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conexion->prepare("UPDATE opiniones SET nombre = ?, calificacion = ?, comentario = ? WHERE id = ?");
        $stmt->bind_param("sisi", $nombre, $calificacion, $comentario, $id);
        if ($stmt->execute()) {
            $confirmacion = "Opinión actualizada correctamente.";
        } else {
            $error = "Error al actualizar la opinión.";
        }
    } else {
        $stmt = $conexion->prepare("INSERT INTO opiniones (nombre, calificacion, comentario) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nombre, $calificacion, $comentario);
        if ($stmt->execute()) {
            $confirmacion = "¡Gracias por tu opinión!";
        } else {
            $error = "Error al enviar la opinión.";
        }
    }
    $stmt->close();
    
    $editando = false;
    $datos_edicion = null;
}

$opiniones = $conexion->query("SELECT * FROM opiniones ORDER BY fecha DESC");

function mostrarEstrellas($calificacion) {
    $estrellas = "";
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $calificacion) {
            $estrellas .= '<i class="fas fa-star text-warning"></i>';
        } else {
            $estrellas .= '<i class="far fa-star text-muted"></i>';
        }
    }
    return $estrellas;
}

function calcularEstadisticas($conexion) {
    $stats = $conexion->query("
        SELECT 
            COUNT(*) as total,
            AVG(calificacion) as promedio,
            MAX(calificacion) as mejor,
            MIN(calificacion) as peor
        FROM opiniones
    ")->fetch_assoc();
    return $stats;
}

$estadisticas = calcularEstadisticas($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Opiniones - CRUD Completo</title>
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

        h2, h4 {
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

        .stats-card {
            background-color: #1c1f26;
            border: 1px solid #00cc33;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .star-rating {
            font-size: 1.2em;
        }

        .rating-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9em;
        }

        .opinion-preview {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="formulario mb-5">
            <?php if ($editando): ?>
                <div class="editing-header">
                    <h2 class="mb-0"><i class="fas fa-edit"></i> Editando Opinión</h2>
                </div>
            <?php else: ?>
                <h2 class="mb-4 text-center">Danos tu Opinión</h2>
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
                    <label class="form-label"><i class="fas fa-user"></i> Nombre</label>
                    <input type="text" name="nombre" class="form-control" 
                           value="<?= $editando ? htmlspecialchars($datos_edicion['nombre']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-star"></i> Calificación (1 a 5⭐)</label>
                    <select name="calificacion" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="1" <?= ($editando && $datos_edicion['calificacion'] == 1) ? 'selected' : '' ?>>
                            1 - Muy Malo 
                        </option>
                        <option value="2" <?= ($editando && $datos_edicion['calificacion'] == 2) ? 'selected' : '' ?>>
                            2 - Malo 
                        </option>
                        <option value="3" <?= ($editando && $datos_edicion['calificacion'] == 3) ? 'selected' : '' ?>>
                            3 - Regular 
                        </option>
                        <option value="4" <?= ($editando && $datos_edicion['calificacion'] == 4) ? 'selected' : '' ?>>
                            4 - Bueno 
                        </option>
                        <option value="5" <?= ($editando && $datos_edicion['calificacion'] == 5) ? 'selected' : '' ?>>
                            5 - Excelente 
                        </option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-comment"></i> Comentario</label>
                    <textarea name="comentario" class="form-control" rows="4" 
                              placeholder="Comparte tu experiencia..." required><?= $editando ? htmlspecialchars($datos_edicion['comentario']) : '' ?></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <?php if ($editando): ?>
                        <button type="submit" class="btn btn-warning flex-fill">
                            <i class="fas fa-save"></i> Actualizar Opinión
                        </button>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    <?php else: ?>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane"></i> Enviar Opinión
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="mb-4">
            <a href="trabajos.php" class="btn btn-success me-2">
                <i class="fas fa-briefcase"></i> Ver Trabajos
            </a>
            <a href="contacto.php" class="btn btn-success me-2">
                <i class="fas fa-envelope"></i> Ver Contactos
            </a>
            <a href="Dashboard.html" class="btn btn-success">
                <i class="fas fa-chart-bar"></i> Ver Estadísticas
            </a>
        </div>

        <h4 class="mb-3">
            <i class="fas fa-comments"></i> Opiniones Recientes 
            <span class="badge bg-success"><?= $opiniones->num_rows ?></span>
        </h4>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Calificación</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($opiniones->num_rows > 0): ?>
                        <?php while ($op = $opiniones->fetch_assoc()): ?>
                            <tr>
                                <td><?= $op["id"] ?></td>
                                <td>
                                    <i class="fas fa-user-circle me-2"></i>
                                    <?= htmlspecialchars($op["nombre"]) ?>
                                </td>
                                <td class="text-center">
                                    <div class="star-rating mb-1">
                                        <?= mostrarEstrellas($op["calificacion"]) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="opinion-preview" title="<?= htmlspecialchars($op["comentario"]) ?>">
                                        <?= htmlspecialchars($op["comentario"]) ?>
                                    </div>
                                </td>
                                <td>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('d/m/Y', strtotime($op["fecha"])) ?><br>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        <?= date('H:i', strtotime($op["fecha"])) ?>
                                    </small>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="?editar=<?= $op['id'] ?>" class="btn btn-warning btn-sm" title="Editar opinión">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?eliminar=<?= $op['id'] ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('⚠️ ¿Estás seguro de que quieres eliminar esta opinión?\n\nEsta acción no se puede deshacer.')" 
                                       title="Eliminar opinión">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="far fa-comments fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="mb-0">No hay opiniones para mostrar</p>
                                <small class="text-muted">¡Sé el primero en dejar tu opinión!</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        document.querySelectorAll('a[href*="eliminar"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (!confirm('⚠️ ¿Estás seguro de que quieres eliminar esta opinión?\n\nEsta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });

        document.querySelectorAll('.star-rating').forEach(function(rating) {
            rating.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
                this.style.transition = 'transform 0.2s';
            });
            rating.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        document.querySelectorAll('.opinion-preview').forEach(function(preview) {
            if (preview.scrollWidth > preview.clientWidth) {
                preview.style.cursor = 'help';
            }
        });
    </script>
</body>

</html>