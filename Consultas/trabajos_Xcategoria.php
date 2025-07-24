<?php
// Consultas/trabajos_categoria.php
header('Content-Type: application/json');
include_once '../conexionDash.php';

try {
    $stmt = $pdo->query("
        SELECT 
            categoria, 
            COUNT(*) as cantidad 
        FROM trabajos 
        WHERE categoria IS NOT NULL AND categoria != '' 
        GROUP BY categoria 
        ORDER BY cantidad DESC
    ");
    
    $categorias = [];
    $datos = [];
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categorias[] = $row['categoria'];
        $datos[] = (int)$row['cantidad'];
    }
    
    $response = [
        'categorias' => $categorias,
        'datos' => $datos
    ];
    
    echo json_encode($response);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>