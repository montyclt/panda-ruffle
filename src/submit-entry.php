<?php

require_once __DIR__ . '/utilities.php';

function error($message)
{
    $language = trim(filter_input(INPUT_POST, 'language'));

    if ($language === 'es' || $language === 'en') {
        header("Location: /$language/error.html");
    } else {
        header("Location: /en/error.html");
    }
    exit;
}

set_error_handler(function ($error_number, $error_message, $error_file, $error_line) {
    error($error_message);
});

set_exception_handler(function ($exception) {
    error($exception->getMessage());
});

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    error('Method not allowed.');
}

$count = filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT);
$payment_method = strtoupper(trim(filter_input(INPUT_POST, 'payment_method')));
$transaction_value = trim(filter_input(INPUT_POST, 'transaction'));
$transaction_id = $payment_method . ' ' . $transaction_value;
$name = trim(filter_input(INPUT_POST, 'name'));
$twitter = trim(filter_input(INPUT_POST, 'twitter'));
$instagram = trim(filter_input(INPUT_POST, 'instagram'));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$language = trim(filter_input(INPUT_POST, 'language'));

if ($count === false
    || $count < 1
    || empty($payment_method)
    || empty($transaction_value)
    || empty($name)
    || $email === false
    || empty($language)
    || ($language !== 'en' && $language !== 'es')
    || !in_array($payment_method, ['PAYPAL', 'BIZUM', 'BITCOIN'])) {
    error('Invalid input data.');
}

insertParticipation($transaction_id, $count, $name, $twitter, $instagram, $email);

try {
    sendEmail($email, $name, $language);
} catch (Exception $e) {
}

header("Location: /$language/check-entries.php?email=" . urlencode($email) . "&thankyou=1");
