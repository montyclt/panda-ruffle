<?php

require_once __DIR__ . '/../utilities.php';

$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
$total_entries = getEntryCount($email);
$entry_ids = getEntryIds($email);
$email_display = htmlspecialchars($email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check My Entries - Panda Raffle</title>
    <link rel="stylesheet" href="/statics/style.css">
</head>
<body>
    <h1>Thank you very much for your help</h1>

    <div class="important">
        <?php if (isset($_GET['thankyou'])): ?>
            <p>Your entry has been received.</p>
            <p>Thank you very much for helping to fund Panda's veterinary expenses. Remember that you can participate as many times as you want.</p>
        <?php endif; ?>

        <?php if ($total_entries > 0): ?>
            <p>You have a total of <strong><?= $total_entries ?></strong> entries registered with the email <?= $email_display ?>!</p>
            <?php 
            if (count($entry_ids) > 0) {
                $last_id = array_pop($entry_ids);
                $ids_text = count($entry_ids) > 0 ? implode(', ', $entry_ids) . ' and ' . $last_id : $last_id;
                echo "<p>Your participation numbers are: $ids_text</p>";
            }
            ?>
        <?php else: ?>
            <p>No entries were found registered with the email <?= $email_display ?>.</p>
        <?php endif; ?>
    </div>

    <div class="privacy-note">
        <p><strong>Note about your data:</strong></p>
        <ul>
            <li><strong>Name or nickname:</strong> It doesn't have to be real. I'll use it when announcing the winner and will make public the name entered (e.g., "The raffle was won by Filemon Pi"). It's recommended to use a unique name or nickname to avoid confusion. It will only be made public if you win.</li>
            <li><strong>Email address:</strong> I will only use it to confirm your participation and to communicate with the winner. It will never be made public.</li>
            <li><strong>Twitter and Instagram accounts:</strong> They are optional. If the winner has provided them, I will mention them when announcing the winner.</li>
            <li>Once the raffle is over, the database with the entries will be permanently deleted.</li>
        </ul>
    </div>

    <p>Rest in Peace, 🐼</p>

    <p><a href="/en">Go back</a></p>
</body>
</html>