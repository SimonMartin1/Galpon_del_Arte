<?php
require 'db.php';
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();
echo json_encode($usuarios);
?>