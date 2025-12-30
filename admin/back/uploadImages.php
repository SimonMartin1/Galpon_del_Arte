<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(); 
}

require 'auth.php';
require '../../back/conexion.php';

$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$prefijo = $_POST['prefijo'] ?? '';

if (!isset($_FILES['images'])) {
    http_response_code(400);
    echo json_encode(["error" => "No se encontraron imágenes"]);
    exit();
}

$images = $_FILES['images'];
$uploadDir = '../../front/assets/images/'; 

$uploadedFiles = [];

foreach ($images['name'] as $key => $name) {
    if ($images['error'][$key] === UPLOAD_ERR_OK) {
        $tmpName = $images['tmp_name'][$key];
        $fileName = $prefijo . basename($name);
        $filePath = $uploadDir . $fileName;

        // Verificar si es una imagen
        $fileType = mime_content_type($tmpName);
        if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            continue; // Saltar si no es imagen
        }

        // Mover archivo
        if (move_uploaded_file($tmpName, $filePath)) {
            // Insertar en base de datos
            try {
                $stmt = $pdo->prepare("INSERT INTO imagenes (imagen_path, titulo, descripcion) VALUES (?, ?, ?)");
                $stmt->execute([$fileName, $titulo, $descripcion]);
                $uploadedFiles[] = $fileName;
            } catch (PDOException $e) {
                // Si falla la BD, eliminar archivo
                unlink($filePath);
                http_response_code(500);
                echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
                exit();
            }
        }
    }
}

if (count($uploadedFiles) > 0) {
    echo json_encode(["message" => "Imágenes subidas correctamente", "files" => $uploadedFiles]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "No se pudieron subir las imágenes"]);
}

?>