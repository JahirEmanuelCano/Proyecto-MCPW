<?php
include("conexion.php");
/*
if (!isset($_SESSION["usuario_id"])) {
    header("Location: inicioSesion.php");
    exit;
}*/

$confirmacion = "";
$error = "";

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
   
    $stmt_img = $conexion->prepare("SELECT ruta FROM imagenes WHERE trabajo_id = ?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $imagenes = $stmt_img->get_result();
    
    while ($img = $imagenes->fetch_assoc()) {
        if (file_exists($img['ruta'])) {
            unlink($img['ruta']); 
        }
    }
    $stmt_img->close();
    
    $stmt_del_img = $conexion->prepare("DELETE FROM imagenes WHERE trabajo_id = ?");
    $stmt_del_img->bind_param("i", $id);
    $stmt_del_img->execute();
    $stmt_del_img->close();
    
    $stmt = $conexion->prepare("DELETE FROM trabajos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $confirmacion = "Trabajo eliminado correctamente.";
    } else {
        $error = "Error al eliminar el trabajo.";
    }
    $stmt->close();
}

if (isset($_GET['eliminar_imagen'])) {
    $imagen_id = intval($_GET['eliminar_imagen']);
    
    $stmt_get = $conexion->prepare("SELECT ruta FROM imagenes WHERE id = ?");
    $stmt_get->bind_param("i", $imagen_id);
    $stmt_get->execute();
    $resultado = $stmt_get->get_result();
    
    if ($img_data = $resultado->fetch_assoc()) {
        if (file_exists($img_data['ruta'])) {
            unlink($img_data['ruta']);
        }
        
        $stmt_del = $conexion->prepare("DELETE FROM imagenes WHERE id = ?");
        $stmt_del->bind_param("i", $imagen_id);
        if ($stmt_del->execute()) {
            $confirmacion = "Imagen eliminada correctamente.";
        }
        $stmt_del->close();
    }
    $stmt_get->close();
}

$editando = false;
$datos_edicion = null;
$imagenes_trabajo = [];

if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $stmt = $conexion->prepare("SELECT * FROM trabajos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($datos_edicion = $resultado->fetch_assoc()) {
        $editando = true;
  
        $stmt_img = $conexion->prepare("SELECT * FROM imagenes WHERE trabajo_id = ?");
        $stmt_img->bind_param("i", $id);
        $stmt_img->execute();
        $imagenes_resultado = $stmt_img->get_result();
        while ($img = $imagenes_resultado->fetch_assoc()) {
            $imagenes_trabajo[] = $img;
        }
        $stmt_img->close();
    }
    $stmt->close();
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

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conexion->prepare("UPDATE trabajos SET titulo = ?, categoria = ?, fecha = ?, cliente = ?, descripcion = ?, overview = ?, reto = ?, solucion = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $titulo, $categoria, $fecha, $cliente, $descripcion, $overview, $reto, $solucion, $id);
        if ($stmt->execute()) {
            $confirmacion = "Trabajo actualizado correctamente.";
            $trabajo_id = $id;
        } else {
            $error = "Error al actualizar el trabajo.";
        }
    } else {
        $stmt = $conexion->prepare("INSERT INTO trabajos (titulo, categoria, fecha, cliente, descripcion, overview, reto, solucion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $titulo, $categoria, $fecha, $cliente, $descripcion, $overview, $reto, $solucion);
        if ($stmt->execute()) {
            $confirmacion = "Trabajo guardado correctamente.";
            $trabajo_id = $conexion->insert_id;
        } else {
            $error = "Error al guardar el trabajo.";
        }
    }
    $stmt->close();

    if (isset($trabajo_id) && !empty($_FILES["imagenes"]["name"][0])) {
        $imagenes_subidas = 0;
        $total_imagenes = count($_FILES["imagenes"]["name"]);
        
        for ($i = 0; $i < $total_imagenes; $i++) {
            if (!empty($_FILES["imagenes"]["name"][$i])) {
                $nombreImagen = basename($_FILES["imagenes"]["name"][$i]);
                $extension = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
    
                $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($extension, $extensiones_permitidas)) {
                    $rutaDestino = "uploads/" . time() . "_" . $i . "_" . $nombreImagen;
                    
                    if (move_uploaded_file($_FILES["imagenes"]["tmp_name"][$i], $rutaDestino)) {
                        $stmt_img = $conexion->prepare("INSERT INTO imagenes (trabajo_id, ruta) VALUES (?, ?)");
                        $stmt_img->bind_param("is", $trabajo_id, $rutaDestino);
                        if ($stmt_img->execute()) {
                            $imagenes_subidas++;
                        }
                        $stmt_img->close();
                    }
                }
            }
        }
        
        if ($imagenes_subidas > 0) {
            $confirmacion .= " Se subieron $imagenes_subidas imagen(es) correctamente.";
        }
    }

    $editando = false;
    $datos_edicion = null;
    $imagenes_trabajo = [];
}

$trabajos = $conexion->query("
    SELECT t.*, COUNT(i.id) as total_imagenes
    FROM trabajos t 
    LEFT JOIN imagenes i ON t.id = i.trabajo_id
    GROUP BY t.id
    ORDER BY t.fecha DESC
");

function obtenerImagenesTrabajo($conexion, $trabajo_id) {
    $stmt = $conexion->prepare("SELECT * FROM imagenes WHERE trabajo_id = ?");
    $stmt->bind_param("i", $trabajo_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $imagenes = [];
    while ($img = $resultado->fetch_assoc()) {
        $imagenes[] = $img;
    }
    $stmt->close();
    return $imagenes;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Trabajos - CRUD Completo</title>
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
            margin-bottom: 30px;
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

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .table {
            background-color: #1c1f26;
            color: #ffffff;
            border-color: #00cc33;
        }

        .table th,
        .table td {
            border-color: #444;
            vertical-align: middle;
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

        h2, h4 {
            color: #00cc33;
        }

        .editing-header {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: #000;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .image-preview {
            max-width: 100px;
            max-height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin: 2px;
            border: 2px solid #00cc33;
        }

        .images-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .image-item {
            position: relative;
            display: inline-block;
        }

        .delete-image-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons {
            white-space: nowrap;
        }

        .action-buttons .btn {
            margin: 2px;
            padding: 5px 10px;
            font-size: 12px;
        }

        .file-input-container {
            border: 2px dashed #00cc33;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 204, 51, 0.1);
            margin-bottom: 15px;
        }

        .current-images {
            background-color: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .modal-content {
            background-color: #1c1f26;
            color: #fff;
        }

        .modal-header {
            border-bottom: 1px solid #444;
        }

        .modal-footer {
            border-top: 1px solid #444;
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <h2 class="mb-4">
            <i class="fas fa-briefcase"></i> Panel de Trabajos
            <?php if (isset($_SESSION["nombre"])): ?>
                - Bienvenido, <?= $_SESSION["nombre"] ?>
            <?php endif; ?>
        </h2>

        <div class="mb-4">
            <a href="opiniones.php" class="btn btn-success me-2">
                <i class="fas fa-comments"></i> Ver Comentarios
            </a>
            <a href="contacto.php" class="btn btn-success me-2">
                <i class="fas fa-envelope"></i> Ver Contactos
            </a>
            <a href="Dashboard.html" class="btn btn-success me-2">
                <i class="fas fa-chart-bar"></i> Ver Estadísticas
            </a>
            <a href="inicioSesion.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>

        <div class="formulario">
            <?php if ($editando): ?>
                <div class="editing-header">
                    <h2 class="mb-0"><i class="fas fa-edit"></i> Editando Trabajo</h2>
                </div>
            <?php else: ?>
                <h4 class="mb-3 text-center">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Trabajo
                </h4>
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

            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <?php if ($editando): ?>
                    <input type="hidden" name="id" value="<?= $datos_edicion['id'] ?>">
                <?php endif; ?>

                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-briefcase"></i> Título del Trabajo</label>
                    <input type="text" name="titulo" class="form-control" 
                           value="<?= $editando ? htmlspecialchars($datos_edicion['titulo']) : '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-tags"></i> Categoría del Trabajo</label>
                    <input type="text" name="categoria" class="form-control" 
                           value="<?= $editando ? htmlspecialchars($datos_edicion['categoria']) : '' ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-calendar"></i> Fecha de Realización</label>
                    <input type="date" name="fecha" class="form-control" 
                           value="<?= $editando ? $datos_edicion['fecha'] : '' ?>" required>
                </div>

                <div class="col-md-8">
                    <label class="form-label"><i class="fas fa-user-tie"></i> Cliente</label>
                    <input type="text" name="cliente" class="form-control" 
                           value="<?= $editando ? htmlspecialchars($datos_edicion['cliente']) : '' ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-align-left"></i> Breve Descripción del Trabajo</label>
                    <textarea name="descripcion" class="form-control" rows="3" 
                              ><?= $editando ? htmlspecialchars($datos_edicion['descripcion']) : '' ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-list-ul"></i> Planteamiento de Ejecución</label>
                    <textarea name="overview" class="form-control" rows="3" 
                              ><?= $editando ? htmlspecialchars($datos_edicion['overview']) : '' ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-exclamation-triangle"></i> Reto del Trabajo</label>
                    <textarea name="reto" class="form-control" rows="3" 
                              ><?= $editando ? htmlspecialchars($datos_edicion['reto']) : '' ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="fas fa-lightbulb"></i> Solución de los Problemas</label>
                    <textarea name="solucion" class="form-control" rows="3" 
                             ><?= $editando ? htmlspecialchars($datos_edicion['solucion']) : '' ?></textarea>
                </div>

                <?php if ($editando && !empty($imagenes_trabajo)): ?>
                    <div class="col-12">
                        <div class="current-images">
                            <h6><i class="fas fa-images"></i> Imágenes Actuales</h6>
                            <div class="images-container">
                                <?php foreach ($imagenes_trabajo as $img): ?>
                                    <div class="image-item">
                                        <img src="<?= $img['ruta'] ?>" class="image-preview" alt="Imagen del trabajo">
                                        <button type="button" class="delete-image-btn" 
                                                onclick="eliminarImagen(<?= $img['id'] ?>)" 
                                                title="Eliminar imagen">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-12">
                    <div class="file-input-container">
                        <label class="form-label">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i><br>
                            <strong><?= $editando ? 'Agregar Más Imágenes' : 'Subir Imágenes del Trabajo' ?></strong><br>
                            <small class="text-muted">Puedes seleccionar múltiples imágenes (JPG, PNG, GIF, WEBP)</small>
                        </label>
                        <input type="file" name="imagenes[]" class="form-control" multiple 
                               accept="image/*" onchange="previewImages(this)">
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex gap-2">
                        <?php if ($editando): ?>
                            <button type="submit" class="btn btn-warning flex-fill">
                                <i class="fas fa-save"></i> Actualizar Trabajo
                            </button>
                            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> Guardar Trabajo
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <h4 class="mb-3">
            <i class="fas fa-list"></i> Trabajos Registrados 
            <span class="badge bg-success"><?= $trabajos->num_rows ?></span>
        </h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Imágenes</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($trabajos->num_rows > 0): ?>
                        <?php while ($fila = $trabajos->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila["id"] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($fila["titulo"]) ?></strong>
                                    <?php if (!empty($fila["descripcion"])): ?>
                                        <br><small class="text-muted">
                                            <?= htmlspecialchars(substr($fila["descripcion"], 0, 50)) ?>...
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($fila["categoria"]) ?></span>
                                </td>
                                <td>
                                    <i class="far fa-calendar"></i>
                                    <?= date('d/m/Y', strtotime($fila["fecha"])) ?>
                                </td>
                                <td>
                                    <i class="fas fa-user-tie"></i>
                                    <?= htmlspecialchars($fila["cliente"]) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($fila["total_imagenes"] > 0): ?>
                                        <button class="btn btn-sm btn-info" 
                                                onclick="verImagenes(<?= $fila['id'] ?>)" 
                                                title="Ver imágenes">
                                            <i class="fas fa-images"></i> 
                                            <?= $fila["total_imagenes"] ?>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">Sin imágenes</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="?editar=<?= $fila['id'] ?>" class="btn btn-warning btn-sm" title="Editar trabajo">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?eliminar=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('⚠️ ¿Estás seguro de que quieres eliminar este trabajo?\n\nSe eliminarán también todas las imágenes asociadas.\n\nEsta acción no se puede deshacer.')" 
                                       title="Eliminar trabajo">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-briefcase fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="mb-0">No hay trabajos registrados</p>
                                <small class="text-muted">¡Agrega tu primer trabajo!</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="imagenesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-images"></i> Imágenes del Trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="imagenesContent">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalle del Trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detalleContent">
                </div>
            </div>
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

        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files.length > 0) {
                const container = document.createElement('div');
                container.className = 'images-container mt-2';
                
                Array.from(input.files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'image-preview';
                            img.title = file.name;
                            container.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
                
                preview.appendChild(container);
            }
        }

        function eliminarImagen(imageId) {
            if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
                window.location.href = `?eliminar_imagen=${imageId}&editar=<?= $editando ? $datos_edicion['id'] : '' ?>`;
            }
        }

        function verImagenes(trabajoId) {
            fetch(`obtener_imagenes.php?trabajo_id=${trabajoId}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="images-container">';
                    if (data.length > 0) {
                        data.forEach(img => {
                            html += `<img src="${img.ruta}" class="img-fluid m-1" style="max-height: 200px;">`;
                        });
                    } else {
                        html += '<p class="text-center">No hay imágenes para este trabajo.</p>';
                    }
                    html += '</div>';
                    
                    document.getElementById('imagenesContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('imagenesModal')).show();
                });
        }

        function verDetalle(trabajoId) {
            fetch(`obtener_detalle.php?trabajo_id=${trabajoId}`)
                .then(response => response.json())
                .then(data => {
                    const html = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-briefcase"></i> Título:</h6>
                                <p>${data.titulo}</p>
                                
                                <h6><i class="fas fa-tags"></i> Categoría:</h6>
                                <p><span class="badge bg-info">${data.categoria}</span></p>
                                
                                <h6><i class="fas fa-calendar"></i> Fecha:</h6>
                                <p>${new Date(data.fecha).toLocaleDateString('es-ES')}</p>
                                
                                <h6><i class="fas fa-user-tie"></i> Cliente:</h6>
                                <p>${data.cliente}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-align-left"></i> Descripción:</h6>
                                <p>${data.descripcion || 'Sin descripción'}</p>
                                
                                <h6><i class="fas fa-list-ul"></i> Planteamiento:</h6>
                                <p>${data.overview || 'Sin planteamiento'}</p>
                            </div>
                            <div class="col-12">
                                <h6><i class="fas fa-exclamation-triangle"></i> Reto:</h6>
                                <p>${data.reto || 'Sin retos definidos'}</p>
                                
                                <h6><i class="fas fa-lightbulb"></i> Solución:</h6>
                                <p>${data.solucion || 'Sin solución definida'}</p>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('detalleContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('detalleModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('detalleContent').innerHTML = '<p class="text-danger">Error al cargar los detalles.</p>';
                    new bootstrap.Modal(document.getElementById('detalleModal')).show();
                });
        }
    </script>
</body>

</html>