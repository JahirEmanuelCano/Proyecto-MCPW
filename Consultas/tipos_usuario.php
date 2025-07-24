<?php
// Consultas/tipos_usuario.php
header('Content-Type: application/json');
include_once '../conexionDash.php';

try {
    $stmt = $pdo->query("
        SELECT 
            CASE 
                WHEN es_admin = 1 THEN 'Administradores'
                ELSE 'Usuarios Regulares'
            END as tipo,
            COUNT(*) as cantidad
        FROM usuarios 
        GROUP BY es_admin
        ORDER BY es_admin DESC
    ");
    
    $datos = [];
    $colores = ['#dc3545', '#007bff'];
    $i = 0;
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $datos[] = [
            'name' => $row['tipo'],
            'y' => (int)$row['cantidad'],
            'color' => $colores[$i]
        ];
        $i++;
    }
    
    echo json_encode($datos);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>