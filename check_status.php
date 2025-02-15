<?php
session_start();

// Simulación: Devuelve "connected" después de 10 segundos
if (isset($_SESSION['bot_connected']) && $_SESSION['bot_connected'] === true) {
    echo json_encode(["status" => "connected"]);
} else {
    echo json_encode(["status" => "disconnected"]);
}
?>
