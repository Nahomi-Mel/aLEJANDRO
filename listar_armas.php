<<?php
include("conexion.php");

$sql = "SELECT armas.*, categorias.nombre AS categoria FROM armas 
        INNER JOIN categorias ON armas.id_categoria = categorias.id";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Armas</title>
</head>
<body>
    <h1>Armas registradas</h1>
<form action="panel.php" method="get" style="margin: 20px 0;">
    <button type="submit" style="
        background-color: #a97855;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-family: 'Playfair Display', serif;
        transition: background-color 0.3s ease;
    " onmouseover="this.style.backgroundColor='#d9c4a3'; this.style.color='#000';"
       onmouseout="this.style.backgroundColor='#a97855'; this.style.color='white';">
        ⬅ Volver al Panel
    </button>
</form>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th> <!-- Nueva columna ID -->
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Tipo de Bala</th>
            <th>Categoría</th>
            <th>Precio</th>
            <!-- No hay columna de acciones -->
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['id']) ?></td> <!-- Aquí el ID -->
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                <td>$<?= htmlspecialchars($fila['precio']) ?></td>
                <td><?= htmlspecialchars($fila['tipo_bala']) ?></td>
                <td><?= htmlspecialchars($fila['categoria']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>


