<?php
    session_start();
    require '../../inc/pdo.php';
    if (!isset($_GET["your_token"])) {
        header('Location: ../dashboard.php');
        exit();
    }
    $username = $_GET['username'];
    $verify_token_request = $auth_pdo->prepare("
        SELECT login, token FROM users
        INNER JOIN token ON users.id = token.user_id
        WHERE login = :login
    ");
    
    $verify_token_request->execute([
        ":login" => $username
    ]);

    $verify_token =  $verify_token_request->fetch(PDO::FETCH_ASSOC);
    if ($verify_token) {
        if ($_GET['your_token'] != $verify_token['token'] || $verify_token['token'] == null) {
            header('Location: ../dashboard.php');
            exit();
        }
    } else {
        header('Location: ../dashboard.php');
        exit();
    }

    
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Créer-Modifier-Annuler un événement</h1>

    <form method="POST">
        <label for="event-name">Nom de l'événement: </label>
        <input type="text" id="event-name" name="event-name" required>

        <br>

        <label for="event-place">Lieux de l'évènement: </label>
        <input type="text" id="event-place" name="event-place" required>

        <br>

        <label for="event-date">Date de l'évènement: </label>
        <input type="date" id="event-date" name="event-date" required>

        <br>

        <label for="event-description">Description de l'évènement: </label>
        <textarea name="event-description" id="event-description" cols="30" rows="5" required></textarea>

    </form>
</body>
</html>