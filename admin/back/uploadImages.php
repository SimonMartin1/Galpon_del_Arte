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

if (!isset($_FILES['images']) || !isset($_POST['titulos']) || !isset($_POST['descripciones']) || !isset($_POST['destacados'])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit();
}

$images = $_FILES['images'];
$titulos = $_POST['titulos'];
$descripciones = $_POST['descripciones'];
$destacados = $_POST['destacados'];

$uploadDir = '../../assets/images/';

// Obtener el último ID
try {
    $stmt = $pdo->query("SELECT MAX(id) AS max_id FROM imagenes");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxId = $result['max_id'] ?? 0;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al obtener el último ID: " . $e->getMessage()]);
    exit();
}

$uploadedFiles = [];

foreach ($images['name'] as $key => $name) {
    if ($images['error'][$key] === UPLOAD_ERR_OK) {
        $tmpName = $images['tmp_name'][$key];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newId = $maxId + $key + 1;
        $fileName = $newId . '.' . $extension;
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
                $titulo = $titulos[$key] ?? '';
                $descripcion = $descripciones[$key] ?? '';
                $destacado = $destacados[$key] ?? 0;
                $stmt = $pdo->prepare("INSERT INTO imagenes (imagen_path, titulo, descripcion, destacada) VALUES (?, ?, ?, ?)");
                $stmt->execute([$fileName, $titulo, $descripcion, $destacado]);
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