<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); 
    echo json_encode(["status" => "error", "message" => "No has iniciado sesión"]);
    exit();
}
?>