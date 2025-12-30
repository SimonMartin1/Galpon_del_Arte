<?php
// Configuración de seguridad para cookies de sesión (ANTES de session_start)
ini_set('session.cookie_httponly', 1); // Javascript no puede robar la cookie
ini_set('session.use_only_cookies', 1); // Evita ataques por URL

session_start();
header("Content-Type: application/json");


require '../../back/conexion.php';


$json = file_get_contents('php://input');
$datos = json_decode($json, true);

$usuario = $datos['usuario'] ?? '';
$password = $datos['password'] ?? '';

if (empty($usuario) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Faltan datos"]);
    exit;
}

$sql = "SELECT id, password FROM usuarios WHERE usuario = :usuario LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':usuario' => $usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user && password_verify($password, $user['password'])) {
    
    
    session_regenerate_id(true); 
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['usuario'] = $usuario;

    echo json_encode(["status" => "success", "message" => "Bienvenido"]);
} else {
    echo json_encode(["status" => "error", "message" => "Credenciales inválidas"]);
}
?>