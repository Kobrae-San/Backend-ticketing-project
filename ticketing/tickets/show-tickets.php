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
    $title = "Afficher un billet";
    $website_part = "Billetterie";
    if ($method == "POST") {
        $title = "Imprimez un billet";
    }

?>
        <?php include '../../inc/tpl/header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier évènement</title>
    <link rel="stylesheet" href="../style.css">
</head>
        <h2>Billetterie</h2>
        <?php if ($method == "POST"):
            $last_name = filter_input(INPUT_POST, "lastname");
            $first_name = filter_input(INPUT_POST, "firstname");
            $ticket_id = filter_input(INPUT_POST, "private-ticket-id");
        ?>
        <div>
            <p><?= $last_name ?></p>
            <p><?= $first_name ?></p>
             
        </div>
        <?php else: ?>
        <div>
            <h2>Afficher un billet</h2>
            <form method="POST">
                <label for="lastname">Nom: </label>
                <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
                
                <label for="lastname">Prénom: </label>
                <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

                <label for="private-ticket-id">ID privé du Billet</label>
                <input type="text" id="private-ticket-id" name="private-ticket" placeholder="Renseignez l'identifiant privé"
                 required>

                <input class="submit" type="submit" value="Afficher le billet">
            </form>
        </div>
        <?php endif; ?>
    </body>
    </html>
