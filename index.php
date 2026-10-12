<?php
require_once "conexion.php";

$mensaje = "";

// 1. INSERT: Si enviaron el formulario por POST, guardamos en la base de datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $asunto = trim($_POST["asunto"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");

    if (!empty($asunto) && !empty($descripcion)) {
        // Sentencia preparada para evitar inyección SQL
        $stmt = $pdo->prepare("INSERT INTO tickets (asunto, descripcion) VALUES (:asunto, :descripcion)");
        $stmt->execute([
            ":asunto" => $asunto,
            ":descripcion" => $descripcion
        ]);
        $mensaje = "¡Ticket registrado exitosamente!";
    } else {
        $mensaje = "Por favor completa todos los campos.";
    }
}

// 2. SELECT: Consultamos todos los tickets para listarlos
$stmt = $pdo->prepare("SELECT * FROM tickets ORDER BY fecha_creacion DESC");
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Soporte FCE - Gestión de Tickets</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 30px; background: #f4f6f9; color: #333; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); max-width: 650px; margin-bottom: 25px; }
        input, textarea, button { width: 100%; margin-top: 8px; margin-bottom: 12px; padding: 8px; box-sizing: border-box; }
        button { background: #0d47a1; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #e3f2fd; }
        .alert { color: green; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Registrar Solicitud de Soporte</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="alert"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Asunto:</label>
            <input type="text" name="asunto" required placeholder="Ej. Proyector apagado">
            
            <label>Descripción del problema:</label>
            <textarea name="descripcion" required rows="3" placeholder="Detalle la falla observada..."></textarea>
            
            <button type="submit">Guardar Ticket</button>
        </form>
    </div>

    <div class="card">
        <h2>Tickets Registrados</h2>
        <?php if (count($tickets) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asunto</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $t): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($t['id']) ?></td>
                            <td><?= htmlspecialchars($t['asunto']) ?></td>
                            <td><?= htmlspecialchars($t['descripcion']) ?></td>
                            <td><?= htmlspecialchars($t['fecha_creacion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay tickets registrados aún.</p>
        <?php endif; ?>
    </div>

</body>
</html>