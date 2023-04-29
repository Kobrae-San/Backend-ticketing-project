<?php
    session_start();
    require '../../inc/pdo.php';
    require '../../inc/functions.php';


    $title = "Créer un évènement";
    $website_part = "Billetterie";
    
    $my_token = $_GET['your_token'];
    $check = token_check($my_token, $auth_pdo);
    if(!$check){
        header("Location: ../dashboard.php");
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

    $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($method == 'POST') {
        $event_name = filter_input(INPUT_POST, 'event-name');
        $event_place = filter_input(INPUT_POST, 'event-place');
        $event_date = filter_input(INPUT_POST, 'event-date');
        $event_description = filter_input(INPUT_POST, 'event-description');
        $verify_existing_event_request = $ticket_pdo->prepare("
            SELECT event_name, event_place, event_date FROM events 
            WHERE event_name = :event_name 
            AND event_place = :event_place 
            AND event_date = :event_date;
        ");
        $verify_existing_event_request->execute([
            ":event_name" => $event_name,
            ":event_place" => $event_place,
            ":event_date" => $event_date
        ]);
        
        $verify_existing_event = $verify_existing_event_request ->fetch(PDO::FETCH_ASSOC);
        if (!$verify_existing_event) {
            $create_event_request = $ticket_pdo->prepare("
            INSERT INTO events (event_name, event_place, event_date, event_description)
            VALUES (:event_name, :event_place, :event_date, :event_description)
            ");
            $create_event_request->execute([
                ":event_name" => $event_name,
                ":event_place" => $event_place,
                ":event_date" => $event_date,
                ":event_description" => $event_description
            ]);
            $create = true;
        } else {
            $existing = true;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= $website_part ?></title>
    <link rel="stylesheet" href="../styles/ticketing.css">
</head>
<body>
    <form method="POST">
    <h1><?= $title ?></h1>
        <label for="event-name">Nom de l'événement : </label>
        <input type="text" id="event-name" name="event-name" placeholder="Indiquez le nom de l'évènement" required>
        <label for="event-place">Lieu de l'évènement : </label>
        <input type="text" id="event-place" name="event-place" placeholder="Indiquez le lieu de l'évènement" required>
        <label for="event-date">Date de l'évènement : </label>
        <input type="date" id="event-date" name="event-date"  required >
        <label for="event-description">Description de l'évènement : </label>
        <textarea name="event-description" id="event-description" placeholder="Description brève de l'évènement..." cols="30" rows="5" required></textarea>
        <input class="submit" type="submit" value="Créer">
        <?php if(isset($create)) { ?>
            <p>L'évènement a bien été créé</p>
        <?php }elseif(isset($existing)) { ?> 
            <p>L'évènement existe déjà</p>
        <?php } ?>
        <a href="create-modify-delete-events.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">Retour à la gestion des évènements</a>
    </form>
</body>
</html>