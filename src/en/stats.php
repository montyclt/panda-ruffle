<?php

require_once __DIR__ . '/../utilities.php';

// Get all raffle statistics
$stats = getRaffleStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffle Statistics - Panda Raffle</title>
    <link rel="stylesheet" href="/statics/style.css">
</head>
<body>
    <h1>Raffle Statistics</h1>

    <div class="important">
        <p>Current statistics for Panda's raffle:</p>
        <ul>
            <li><strong>Total participations:</strong> <?= $stats['total_participations'] ?></li>
            <li><strong>Total income:</strong> <?= $stats['income'] ?> €</li>
            <li><strong>Income after prize cost (45€):</strong> <?= $stats['income_minus_prize'] ?> €</li>
        </ul>
    </div>

    <div class="privacy-note">
        <p><strong>Note about the statistics:</strong></p>
        <ul>
            <li>Each participation costs 2€.</li>
            <li>A discount of 1€ is applied for every 5 participations bought by the same person at the same time.</li>
            <li>The font used for the raffle cost 45€, which is deducted from the total income.</li>
        </ul>
    </div>

    <p>Rest in Peace, 🐼</p>

    <p><a href="/en">Go back</a></p>
</body>
</html>