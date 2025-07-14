<?php

require_once __DIR__ . '/vendor/autoload.php';
$config = require_once __DIR__ . '/config.php';

function getPdo()
{
    global $config;
    $db_host = $config['mysql']['host'];
    $db_name = $config['mysql']['database'];
    $db_user = $config['mysql']['username'];
    $db_pass = $config['mysql']['password'];

    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $db_user, $db_pass, $options);
}

function getEntryCount($email)
{
    $pdo = getPdo();

    $sql = "SELECT COUNT(*) as total_entries FROM participations WHERE email_address = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch();
    if (!$result || !isset($result['total_entries'])) {
        return 0;
    }

    return (int)$result['total_entries'];
}

function getEntryIds($email)
{
    $pdo = getPdo();

    $sql = "SELECT id FROM participations WHERE email_address = :email ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $ids = [];
    while ($row = $stmt->fetch()) {
        $ids[] = $row['id'];
    }

    return $ids;
}

function insertParticipation($transaction_id, $count, $name, $twitter, $instagram, $email)
{
    $pdo = getPdo();
    $pdo->beginTransaction();

    try {
        $sql = "INSERT INTO participations (paypal_transaction_id, nickname, twitter_account, instagram_account, email_address, participation_date)
                VALUES (:transaction_id, :name, :twitter, :instagram, :email, NOW())";
        $stmt = $pdo->prepare($sql);

        $firstId = null;

        for ($i = 0; $i < $count; $i++) {
            $stmt->bindParam(':transaction_id', $transaction_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':twitter', $twitter);
            $stmt->bindParam(':instagram', $instagram);
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            if ($i === 0) {
                $firstId = $pdo->lastInsertId();
            }
        }

        $pdo->commit();
        return $firstId;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/**
 * @throws Exception
 */
function sendEmail($address, $name, $language)
{
    global $config;

    if ($language !== 'en' && $language !== 'es') {
        throw new Exception('Invalid language');
    }

    $totalEntries = getEntryCount($address);
    $entryIds = getEntryIds($address);

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $config['smtp']['host'];
    $mail->Username = $config['smtp']['username'];
    $mail->Password = $config['smtp']['password'];
    $mail->SMTPSecure = $config['smtp']['secure'];
    $mail->Port = $config['smtp']['port'];
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($config['smtp']['from']['address'], $config['smtp']['from']['name']);
    $mail->addAddress($address, $name);

    $mail->isHTML(false);

    if ($language === 'en') {
        $mail->Subject = 'Confirmation of participation in Panda\'s raffle';

        $email_body_plain = "Hello $name,\n\n";
        $email_body_plain .= "Thank you for participating in the raffle to help with Panda's veterinary expenses.\n\n";
        $participationText = $totalEntries == 1 ? "participation" : "participations";
        $email_body_plain .= "You currently have a total of $totalEntries $participationText in the raffle.\n\n";
        $email_body_plain .= "Your entry numbers are: " . implode(", ", $entryIds) . "\n\n";
        $email_body_plain .= "Remember that you can participate as many times as you wish, thus increasing your chances.\n\n";
        $email_body_plain .= "Your contact information will be kept until the winner is announced.\n\n";
        $email_body_plain .= "Good luck!\n\nRegards,\n — Ivan";
    } else {
        $mail->Subject = 'Confirmación de participación en el sorteo de Panda';

        $email_body_plain = "Hola $name,\n\n";
        $email_body_plain .= "Gracias por participar en el sorteo para ayudar con los gastos veterinarios de Panda.\n\n";
        $participacionText = $totalEntries == 1 ? "participación" : "participaciones";
        $email_body_plain .= "Actualmente tienes un total de $totalEntries $participacionText en el sorteo.\n\n";
        $email_body_plain .= "Tus números de participación son: " . implode(", ", $entryIds) . "\n\n";
        $email_body_plain .= "Recuerda que puedes volver a participar tantas veces como desees, aumentando así tus probabilidades.\n\n";
        $email_body_plain .= "Se guardarán tus datos de contacto hasta anunciar al ganador.\n\n";
        $email_body_plain .= "¡Mucha suerte!\n\nSaludos,\n — Ivan";
    }

    $mail->Body = $email_body_plain;

    $mail->send();
}
