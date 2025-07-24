<?php
// Consultas/estadisticas.php
header('Content-Type: application/json');
include_once '../conexionDash.php';

try {
    // Total de usuarios
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $totalUsuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total de trabajos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM trabajos");
    $totalTrabajos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total de contactos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM contactos");
    $totalContactos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total de opiniones
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM opiniones");
    $totalOpiniones = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Promedio de calificaciones
    $stmt = $pdo->query("SELECT AVG(calificacion) as promedio FROM opiniones");
    $promedioCalificacion = round($stmt->fetch(PDO::FETCH_ASSOC)['promedio'], 1);
    
    $response = [
        'usuarios' => $totalUsuarios,
        'trabajos' => $totalTrabajos,
        'contactos' => $totalContactos,
        'opiniones' => $totalOpiniones,
        'promedio_calificacion' => $promedioCalificacion
    ];
    
    echo json_encode($response);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>