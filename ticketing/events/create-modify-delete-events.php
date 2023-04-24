<?php
    session_start();
    require '../../inc/pdo.php';
    require '../../inc/functions.php';
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
        } else {
            echo 'Cet évènement existe déjà';
        }
    }
    
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header> 
        <nav>
            <h1>EasyTickets</h1>
            <ul>
                <?php if (isset($_GET["your_token"]) && token_check($_GET["your_token"], $auth_pdo)): ?>
                    <a href="./tickets/show-tickets.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                    <a href="./tickets/submit-ticket.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                    <a href="../../authentification/logout.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Deconnexion</li></a>
                    <a href="./events/create-modify-delete-events.php?your_token=<?= $_GET["your_token"] ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                    <a href="../events/add-remove-visitors.php?your_token=<?= $_GET["your_token"] ?>&username=<?= $_GET['username'] ?>"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                    <a href="./events/show-event&visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Visualiser les événements et leurs inscrits</li></a>
                <?php else: ?>
                    <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                    <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                    <a href="../authentification/login.php"><li>Connexion</li></a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <h2>Créer un événement</h2>
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
        <br>
        <input type="submit" value="Créer un évenement">
    </form>
</body>
</html>