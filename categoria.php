<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");  // Conexión a la BD

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

if (!$tipo) {
    echo "No se especificó categoría.";
    exit();
}

$mapaCategorias = [
    'revolveres' => 1,
    'pistolas'   => 2,
    'rifles'     => 3,
    'escopetas'  => 6,
    'fusiles'    => 5,
    'municiones' => 4
];

if (!array_key_exists($tipo, $mapaCategorias)) {
    echo "Categoría no válida.";
    exit();
}

$id_categoria = $mapaCategorias[$tipo];

$stmt = $conn->prepare("SELECT * FROM armas WHERE id_categoria = ?");
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Armas - <?php echo htmlspecialchars(ucfirst($tipo)); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

 /*Todo lo que tenga que ver con el style, ponerlo en otro archivo tipo .css*/
    <style>
        body {
            font-family: Georgia, serif;
            background: #f9f5ef;
            padding: 20px;
            color: #3b2a1a;
        }
        .arma {
            border: 1px solid #a77b47;
            background: #fff8f0;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px #d1bfa7;
        }
        .arma-info {
            max-width: 100%;
        }
        h1 {
            text-align: center;
            color: #5a3e26;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #a77b47;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            background-color: #a77b47;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #8b6640;
        }
    </style>
</head>
<body>

    <h1>Armas: <?php echo htmlspecialchars(ucfirst($tipo)); ?></h1>

    <?php
    if ($resultado->num_rows === 0) {
        echo "<p>No hay armas disponibles en esta categoría.</p>";
    } else {
        while ($fila = $resultado->fetch_assoc()) {
            echo '<div class="arma">';
            echo '<div class="arma-info">';
            echo '<h2>' . htmlspecialchars($fila['nombre']) . '</h2>';
            echo '<p>' . htmlspecialchars($fila['descripcion']) . '</p>';
            if (!empty($fila['precio'])) {
                echo '<p><strong>Precio:</strong> $' . htmlspecialchars($fila['precio']) . '</p>';
            }
            if (!empty($fila['tipo_bala'])) {
                echo '<p><strong>Tipo de bala:</strong> ' . htmlspecialchars($fila['tipo_bala']) . '</p>';
            }
            // Botón para comprar con confirmación
            echo '<button onclick="confirmarCompra(\'' . $fila['id'] . '\')">Comprar</button>';
            echo '</div></div>';
        }
    }
    ?>

    <a href="comprar.php">⬅ Volver al Catálogo</a>

    <script>
    function confirmarCompra(id) {
        if (confirm("¿Estás seguro de que deseas comprar esta arma?")) {
            window.location.href = "verificacion.php?id=" + id;
        }
    }
    </script>

</body>
</html>
