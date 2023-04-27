<?php
    session_start();
    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    
    $show_tickets_path = "./show-tickets.php";
    $submit_path = "./submit-ticket.php";
    $login_path = "../../authentification/login.php";
    $logout_path = "../../authentification/logout.php";
    $creation_path = "../events/create-modify-delete-events.php";
    $visitor_path = "../events/add-remove-visitors.php";
    $show_visitor_path = "../events/show-event&visitors.php";

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    $title = "Afficher billet";
    $website_part = "Billetterie";
    
    $erreur = "";
    $ticket = false;

    if ($method == "POST"){
        $last_name = filter_input(INPUT_POST, "last-name");
        $first_name = filter_input(INPUT_POST, "first-name");
        $private_key = filter_input(INPUT_POST, "private-key");

        if ($last_name && $first_name && $private_key) {
            $check_ticket_request = $ticket_pdo -> prepare('
            SELECT private_key, last_name, first_name, event_name,
            event_place, event_date, event_description, current_date 
            FROM tickets
            INNER JOIN visitors on tickets.visitor_id = visitors.id
            INNER JOIN events on tickets.event_id = events.id
            WHERE private_key = :private_key
            AND last_name = :last_name
            AND first_name = :first_name
            ');

            $check_ticket_request -> execute([
                ":private_key" => $private_key,
                ":last_name" => $last_name,
                ":first_name" => $first_name,
            ]);

            $ticket_info = $check_ticket_request -> fetch(PDO::FETCH_ASSOC);

            if ($ticket_info) {
                $ticket = true;
                $event_name = $ticket_info['event_name'];
                $event_place = $ticket_info['event_place'];
                $event_date = $ticket_info['event_date'];
                $event_description = $ticket_info['event_description'];
                $current_date = $ticket_info['current_date'];
                //header('Location: ./show-tickets-succes.php');
            } else {
                $erreur = "Billet non disponible. Veuillez vérifier les informations fournies puis réessayez";
            }
        } else {
            $erreur = "Champs invalides ou manquants.";
        }
    }

?><!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div>
        <?php if ($erreur != null): ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>

        <h2>Afficher un billet</h2>
        <form method="POST">
            <label for="last-name">Nom: </label>
            <input type="text" id="last-name" name="last-name" placeholder="Indiquez votre nom de famille" required>
            <br>
            <label for="first-name">Prénom: </label>
            <input type="text" id="first-name" name="first-name" placeholder="Indiquez votre prénom" required>
            <br>
            <label for="private-ticket-id">ID privé du Billet</label>
            <input type="text" id="private-ticket-id" name="private-key" required>
            <br>
            <input type="submit" value="Afficher">
        </form>

        <?php
        if ($ticket == true){
            echo "<p>Nom : ".$ticket_info['last_name']."</p>";
            echo "<p>Prénom : ".$ticket_info['first_name']."</p>";
            echo "<p>Evènement : ".$ticket_info['event_name']."</p>";
            echo "<p>Lieu : ".$ticket_info['event_place']."</p>";
            echo "<p>Date : ".$ticket_info['event_date']."</p>";
            echo "<p>Description : ".$ticket_info['event_description']."</p>";
            echo "<p>Date de génération du billet : ".$ticket_info['current_date']."</p>";
        }
        ?>
    </div>
</body>
</html>