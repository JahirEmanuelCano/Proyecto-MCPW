<?php
// Consultas/calificaciones.php
header('Content-Type: application/json');
include_once '../conexionDash.php';

try {
    $stmt = $pdo->query("
        SELECT 
            calificacion, 
            COUNT(*) as cantidad 
        FROM opiniones 
        GROUP BY calificacion 
        ORDER BY calificacion DESC
    ");
    
    $datos = [];
    $colores = ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#dc3545'];
    
    // Inicializar todas las calificaciones en 0
    for($i = 5; $i >= 1; $i--) {
        $datos[] = [
            'name' => $i . ' Estrella' . ($i > 1 ? 's' : ''),
            'y' => 0,
            'color' => $colores[5-$i]
        ];
    }
    
    // Llenar con datos reales
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $indice = 5 - $row['calificacion'];
        $datos[$indice]['y'] = (int)$row['cantidad'];
    }
    
    echo json_encode($datos);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>