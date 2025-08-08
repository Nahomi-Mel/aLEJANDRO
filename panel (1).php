<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("conexion.php");

// Obtener el rol
$usuario = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT rol FROM LOGIN WHERE usuarios = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();
$rol = $datos['rol'] ?? 'usuario';

// Procesar formulario para redireccionar a editar o borrar arma
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id_arma = intval($_POST['id_arma'] ?? 0);

    if ($id_arma > 0) {
        if ($accion === 'editar') {
            header("Location: editar_arma.php?id=$id_arma");
            exit();
        } elseif ($accion === 'borrar') {
            header("Location: borrar_arma.php?id=$id_arma");
            exit();
        }
    } else {
        $error = "Por favor ingresa un ID válido de arma.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel - Armería RDR2</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Playfair Display', serif;
            background-image: url('imagenes/fondo_saint_denis.jpg');
            background-size: cover;
            background-position: center;
            color: #f8f0e3;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .contenedor {
            background-color: rgba(43, 32, 25, 0.95);
            padding: 40px;
            border: 3px solid #b7936b;
            border-radius: 15px;
            box-shadow: 0 0 20px #b7936b;
            text-align: center;
            width: 420px;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #d9c4a3;
        }
        h2 {
            margin-top: 20px;
            font-size: 20px;
            color: #f1d7b6;
        }
        .boton {
            display: inline-block;
            background-color: #a97855;
            color: #fff;
            padding: 12px 20px;
            margin: 10px 5px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .boton:hover {
            background-color: #d9c4a3;
            color: #000;
        }
        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            width: 100px;
            border-radius: 6px;
            border: 1px solid #b7936b;
            margin-right: 10px;
            text-align: center;
        }
        .error {
            color: #f33;
            margin-top: 10px;
        }
        .form-accion {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Bienvenido, <?= htmlspecialchars($usuario) ?></h1>
        <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>

        <?php if ($rol === 'admin'): ?>
            <h2>Panel de Administración</h2>

            <a href="listar_armas.php" class="boton">📜 Inventario</a>
            <a href="agregar_arma.php" class="boton">➕ Agregar Arma</a>

            <div class="form-accion">
                <form method="post" action="">
                    <label for="id_arma">ID de Arma:</label>
                    <input type="number" name="id_arma" id="id_arma" min="1" required>
                    <button type="submit" name="accion" value="editar" class="boton">✏️ Editar Arma</button>
                    <button type="submit" name="accion" value="borrar" class="boton" onclick="return confirm('¿Seguro que quieres borrar esta arma?');">🗑️ Borrar Arma</button>
                </form>
                <?php if (!empty($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
            </div>

            <!-- Botón para ir al panel de comprar armas -->
            <a href="comprar.php" class="boton" style="margin-top: 20px;">🛒 Comprar Armas</a>

        <?php else: ?>
            <h2>Catálogo de Armas</h2>
            <a href="comprar(1).php" class="boton">🛒 Comprar Armas</a>
        <?php endif; ?>

        <a href="cerrar_sesion.php" class="boton" style="margin-top: 20px;">🚪 Cerrar Sesión</a>
    </div>
</body>
</html>

