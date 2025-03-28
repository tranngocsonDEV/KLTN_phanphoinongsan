<?php
session_start(); // Bắt đầu session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = '6LflLZMqAAAAAK9Q2fsn7Qxw1mJ43znj15xji_9H'; // Thay bằng Secret Key của bạn
    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

    $response = file_get_contents($verifyURL . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
    $responseData = json_decode($response, true);
    file_put_contents('recaptcha_debug.log', json_encode($responseData) . PHP_EOL, FILE_APPEND);

    if ($responseData['success']) {
        $_SESSION['is_verified'] = true;
        header('Location: ../view/homePage.php');
        exit();
    } else {
        file_put_contents('recaptcha_debug.log', "Error: " . implode(", ", $responseData['error-codes']) . PHP_EOL, FILE_APPEND);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

}
?>