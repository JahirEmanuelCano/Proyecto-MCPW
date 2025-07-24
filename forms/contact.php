<?php
ob_clean(); 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["name"] ?? '');
    $correo = trim($_POST["email"] ?? '');
    $asunto = trim($_POST["subject"] ?? '');
    $mensaje = trim($_POST["message"] ?? '');
    
    if (!empty($nombre) && !empty($correo) && !empty($asunto) && !empty($mensaje)) {
        $stmt = $conexion->prepare("INSERT INTO contactos (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "sent" => true, 
                    "message" => "Mensaje guardado correctamente."
                ]);
            } else {
                echo json_encode([
                    "sent" => false, 
                    "message" => "Error al guardar el mensaje."
                ]);
            }
            $stmt->close();
        } else {
            echo json_encode([
                "sent" => false, 
                "message" => "Error en la consulta."
            ]);
        }
    } else {
        echo json_encode([
            "sent" => false, 
            "message" => "Faltan campos obligatorios."
        ]);
    }
} else {
    echo json_encode([
        "sent" => false, 
        "message" => "Método no permitido."
    ]);
}

exit;
?>