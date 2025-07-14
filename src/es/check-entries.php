<?php

require_once __DIR__ . '/../utilities.php';

$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
$total_entries = getEntryCount($email);
$entry_ids = getEntryIds($email);
$email_display = htmlspecialchars($email);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobar Mis Participaciones - Sorteo Panda</title>
    <link rel="stylesheet" href="/statics/style.css">
</head>
<body>
    <h1>Muchas gracias por tu ayuda</h1>

    <div class="important">
        <?php if (isset($_GET['thankyou'])): ?>
            <p>Se ha registrado tu participación.</p>
            <p>Muchísimas gracias por ayudar a financiar los gastos veterinarios de Panda. Recuerda que puedes
                participar tantas veces como quieras.</p>
        <?php endif; ?>

        <?php if ($total_entries > 0): ?>
            <p>¡Tienes un total de <strong><?= $total_entries ?></strong> participaciones registradas con el correo <?= $email_display ?>!</p>
            <?php 
            if (count($entry_ids) > 0) {
                $last_id = array_pop($entry_ids);
                $ids_text = count($entry_ids) > 0 ? implode(', ', $entry_ids) . ' y ' . $last_id : $last_id;
                echo "<p>Tus números son: $ids_text</p>";
            }
            ?>
        <?php else: ?>
            <p>No se encontraron participaciones registradas con el correo <?= $email_display ?>.</p>
        <?php endif; ?>
    </div>

    <div class="privacy-note">
        <p><strong>Nota sobre tus datos:</strong></p>
        <ul>
            <li><strong>Nombre o apodo:</strong> Puede no ser real. Lo usaré cuando anuncie al ganador y haré
                público el nombre introducido (ej: "El sorteo lo ha ganado Filemon Pi"). Se recomienda que sea un
                nombre o apodo único para evitar confusiones. Sólo se hará público en caso de ganar.
            </li>
            <li><strong>Correo electrónico:</strong> Únicamente lo usaré para confirmar la participación y para
                comunicarme con el ganador. Nunca se hará público.
            </li>
            <li><strong>Cuentas de Twitter e Instagram:</strong> Son opcionales. Si el ganador me las ha
                proporcionado, las mencionaré al anunciar el ganador.
            </li>
            <li>Una vez finalizado el sorteo, la base de datos con las participaciones será eliminada para
                siempre.
            </li>
        </ul>
    </div>

    <p>Rest in Peace, 🐼</p>

    <p><a href="/es">Volver atrás</a></p>
</body>
</html>
<?php exit; ?>
