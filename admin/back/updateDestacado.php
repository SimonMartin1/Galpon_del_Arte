<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(); 
}

require 'auth.php';
require 'conexion.php';


$json = file_get_contents('php://input');
$data = json_decode($json, true);


if (!isset($data['id']) || !isset($data['titulo']) || !isset($data['descripcion'])) {
    http_response_code(400); 
    echo json_encode(["error" => "Datos incompletos. Se requiere id, titulo y descripcion"]);
    exit();
}

try {
    
    $sql = "UPDATE destacado SET titulo = :titulo, descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    
    $stmt->execute([
        ':titulo' => $data['titulo'],
        ':descripcion' => $data['descripcion'],
        ':id' => $data['id']
    ]);

    
    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Actualizado correctamente"]);
    } else {
        
        echo json_encode(["message" => "No se realizaron cambios o ID no encontrado"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>