<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de antecedentes</title>
    <style>
        body {
            font-family: Georgia, serif;
            background-color: #f9f5ef;
            padding: 20px;
            text-align: center;
            color: #3b2a1a;
        }
        .mensaje {
            background-color: #fff8f0;
            border: 1px solid #a77b47;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 10px #d1bfa7;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <h1>Proceso de Verificación</h1>
        <p>Gracias por tu interés en adquirir un arma. Antes de proceder con la entrega, revisaremos tus antecedentes penales.</p>
        <p>Recibirás una notificación cuando tu solicitud haya sido procesada.</p>
//agregar algo por si quiere comprar más de un armaaaaaaa
        <a href="comprar.php">⬅ Volver al Catálogo</a>
    </div>
</body>
</html>

