<?php 
    session_start();
    require '../../inc/pdo.php';
    if (!isset($_SESSION["token"])) {
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

    $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($method == 'POST') {
        $event_name = filter_input(INPUT_POST,'event_name');
        $new_event_place = filter_input(INPUT_POST,'new_event_place');
        $new_event_date = filter_input(INPUT_POST,'new_event_date');
        
        $verify_existing_event_request = $ticket_pdo->prepare("
        SELECT event_name FROM events 
        WHERE event_name = :event_name;
    ");
        $verify_existing_event_request->execute([
            ":event_name" => $event_name
    ]);
    $verify_existing_event = $verify_existing_event_request ->fetch(PDO::FETCH_ASSOC);
    if ($verify_existing_event_request){
        $event_modify_request = $ticket_pdo -> prepare(
            "UPDATE events 
             SET event_place = :new_event_place, event_date = :new_event_date 
             WHERE event_name = :event_name"
        );
        $event_modify_request -> execute([
            ":event_name" => $event_name,
            ":new_event_place" => $new_event_place,
            ":new_event_date" => $new_event_date
        ]);
    }else{
        echo 'Cette évènement existe pas';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un évènement</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<form method = "POST">
    <h1>Modifier un évènement</h1>
        <label for="event_name">Nom de l'événement à modifier: </label>
        <input type="text" id="event_name" placeholder="Nom de l'évènement" name="event_name" required>

        <br>

        <label for="new_event_place">Nouveau lieu de l'évènement: </label>
        <input type="text" id="new_event_place" placeholder="Nouveau lieu de l'évènement" name="new_event_place" required>

        <br>

        <label for="new_event_date">Nouvelle date de l'évènement: </label>
        <input type="date" id="new_event_date" name="new_event_date" required>

        <br>

        <input class="submit" type="submit" value="Modifier l'évènement">
        <a href="create-modify-delete-events.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">Retour au menu modification</a>
    </form>
   
</body>
</html>
