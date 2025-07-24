<?php
// Consultas/contactos_mes.php
header('Content-Type: application/json');
include_once '../conexionDash.php';

try {
    $stmt = $pdo->query("
        SELECT 
            MONTH(fecha) as mes,
            MONTHNAME(fecha) as nombre_mes,
            COUNT(*) as cantidad 
        FROM contactos 
        WHERE YEAR(fecha) = 2025
        GROUP BY MONTH(fecha), MONTHNAME(fecha)
        ORDER BY MONTH(fecha)
    ");
    
    $mesesCompletos = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    
    $meses = [];
    $datos = [];
    
    // Inicializar todos los meses en 0
    foreach($mesesCompletos as $numeroMes => $nombreMes) {
        $meses[] = $nombreMes;
        $datos[] = 0;
    }
    
    // Llenar con datos reales
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $indice = $row['mes'] - 1;
        $datos[$indice] = (int)$row['cantidad'];
    }
    
    $response = [
        'meses' => $meses,
        'datos' => $datos
    ];
    
    echo json_encode($response);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>