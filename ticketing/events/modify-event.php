<?php 
    session_start();
    require '../../inc/functions.php';
    require '../../inc/pdo.php';

    $title = "Modification d'un évènement";
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
        $event_name = filter_input(INPUT_POST,'event_name');
        $new_event_place = filter_input(INPUT_POST,'new_event_place');
        $new_event_description = filter_input(INPUT_POST,'new_event_description');
        $new_event_date = filter_input(INPUT_POST,'new_event_date');
        $new_event_name = filter_input(INPUT_POST,'new_event_name');
        
        $verify_existing_event_request = $ticket_pdo->prepare("
            SELECT event_name FROM events 
            WHERE event_name = :event_name;
        ");
        // $verify_existing_event_request->bindParam(':event_name', $event_name, PDO::PARAM_STR);
        $verify_existing_event_request->execute([
            ':event_name' => $event_name
        ]);
    $verify_existing_event = $verify_existing_event_request ->fetch(PDO::FETCH_ASSOC);
    if ($verify_existing_event_request){
        $event_modify_request = $ticket_pdo -> prepare(
            "UPDATE events 
             SET event_name = :new_event_name, 
             event_place = :new_event_place, 
             event_date = :new_event_date,
             event_description = :new_event_description 
             WHERE event_name = :event_name;"
        );
        $event_modify_request -> execute([
            ":event_name" => $event_name,
            ":new_event_place" => $new_event_place,
            ":new_event_date" => $new_event_date,
            "new_event_name" => $new_event_name,
            ":new_event_description" => $new_event_description
        ]);
        $modify = true;
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
        <label for="event_name">Nom de l'événement à modifier : </label>
        <input type="text" id="event_name" placeholder="Nom de l'évènement" name="event_name" required>

        <label for="event_name">Nouveau nom de l'événement à modifier: </label>
        <input type="text" id="event_name" placeholder="Nom de l'évènement" name="new_event_name" required>

        <label for="new_event_place">Nouveau lieu de l'évènement : </label>
        <input type="text" id="new_event_place" placeholder="Nouveau lieu de l'évènement" name="new_event_place" required>

        <label for="new_event_description">Nouvelle description de l'évènement : </label>
        <input type="text" id="new_event_description" placeholder = "Nouvelle description de l'évènement" name="new_event_description" required>

        <label for="new_event_date">Nouvelle date de l'évènement : </label>
        <input type="date" id="new_event_date" name="new_event_date" required>

        <?php if(isset($erreur)){ ?>
            <p>L'évènement n'existe pas</p>
        <?php }elseif(isset($modify)){ ?>
            <p>L'évènement a bien été modifié</p>
        <?php } ?>
        <input class="submit" type="submit" value="Modifier">

        <a class="boutton" href="create-modify-delete-events.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">Retour à la gestion des évènements</a>
    </form>
   
</body>
</html>
