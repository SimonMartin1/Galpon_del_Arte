<?php
session_start();
session_destroy();

setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
echo json_encode(["status" => "success"]);
?>