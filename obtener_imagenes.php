<?php
header('Content-Type: application/json');
include("conexion.php");

if (isset($_GET['trabajo_id'])) {
    $trabajo_id = intval($_GET['trabajo_id']);
    
    $stmt = $conexion->prepare("SELECT * FROM imagenes WHERE trabajo_id = ? ORDER BY id");
    $stmt->bind_param("i", $trabajo_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $imagenes = [];
    while ($img = $resultado->fetch_assoc()) {
        $imagenes[] = $img;
    }
    
    $stmt->close();
    echo json_encode($imagenes);
} else {
    echo json_encode([]);
}
?>