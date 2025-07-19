<?php

require_once __DIR__ . '/../utilities.php';

$stats = getRaffleStats();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sorteo - Sorteo de Panda</title>
    <link rel="stylesheet" href="/statics/style.css">
</head>
<body>
    <h1>Estadísticas del Sorteo</h1>

    <div class="important">
        <p>Estadísticas actuales del sorteo de Panda:</p>
        <ul>
            <li><strong>Total de participaciones:</strong> <?= $stats['total_participations'] ?></li>
            <li><strong>Ingresos totales:</strong> <?= $stats['income'] ?> €</li>
            <li><strong>Ingresos después del coste del premio (45€):</strong> <?= $stats['income_minus_prize'] ?> €</li>
        </ul>
    </div>

    <div class="privacy-note">
        <p><strong>Nota sobre las estadísticas:</strong></p>
        <ul>
            <li>Cada participación cuesta 2€.</li>
            <li>Se aplica un descuento de 1€ por cada 5 participaciones compradas por la misma persona al mismo tiempo.</li>
            <li>La fuente utilizada para el sorteo costó 45€, que se deduce de los ingresos totales.</li>
        </ul>
    </div>

    <p>Descansa en Paz, 🐼</p>

    <p><a href="/es">Volver</a></p>
</body>
</html>