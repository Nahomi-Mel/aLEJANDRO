<?php
// Datos de conexión BORRA ÉSTO
$servername = "sql309.infinityfree.com";
$username   = "if0_38973681";
$password   = "a2YUPxdN0w8";
$dbname     = "if0_38973681_alejandro";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8 (para mostrar bien los acentos y ñ)
$conn->set_charset("utf8mb4");
?>
