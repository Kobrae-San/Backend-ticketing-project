<?php 
    session_start();
    require '../../inc/pdo.php';
    require '../../inc/functions.php';

    $title = "Suppression d'un évènement";
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

        if ($verify_existing_event){
            $event_remove_request = $ticket_pdo -> prepare(
                "   DELETE from events 
                    WHERE event_name= :event_name AND
                    event_date = :event_date AND
                    event_place = :event_place; "
            );
            $event_remove_request -> execute([
                ":event_name" => $event_name,
                ":event_place" => $event_place,
                ":event_date" => $event_date
            ]);
            $delete = true;
        }else{
            $erreur = true;
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
    <form method = "POST">
        <h1><?= $title ?></h1>    
        <label for="event-name">Nom de l'événement : </label>
        <input type="text" id="event-name" placeholder="Nom de l'évènement" name="event-name" required>

        <label for="event-place">Lieu de l'évènement : </label>
        <input type="text" id="event-place" placeholder="Lieu de l'évènement" name="event-place" required>

        <label for="event-date">Date de l'évènement : </label>
        <input type="date" id="event-date"  name="event-date" required>

        <?php if(isset($erreur)){ ?>
            <p>Cet évènement n'existe pas !</p>
        <?php }elseif(isset($delete)) { ?>
            <p>L'évènement a bien été supprimé</p>
        <?php } ?>
        <input class="submit" type="submit" value="Supprimer">

        <a class="boutton" href="create-modify-delete-events.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">Retour à la gestion des évènements</a>
    </form>
</body>
</html>