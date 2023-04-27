<?php
    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    $show_tickets_path = "./show-tickets.php";
    $submit_path = "./submit-ticket.php";
    $login_path = "../../authentification/login.php";
    $logout_path = "../../authentification/logout.php";
    $creation_path = "../events/create-modify-delete-events.php";
    $visitor_path = "../events/add-remove-visitors.php";
    $show_visitor_path = "../events/show-event&visitors.php";
    $title = "Valider un billet";
    $website_part = "Billetterie";
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $erreur = "";

    $submit = filter_input(INPUT_GET, "submit");

    if ($method == "GET" && $submit == "Valider un billet") {
        $last_name = trim(filter_input(INPUT_GET, 'last-name'));
        $first_name = trim(filter_input(INPUT_GET, 'first-name'));
        $public_code = trim(filter_input(INPUT_GET, 'ticket-public-code'));
        if ($last_name && $first_name && $public_code) {
            $check_ticket_request = $ticket_pdo->prepare('
                SELECT public_code, last_name, first_name FROM tickets
                INNER JOIN visitors on tickets.visitor_id = visitors.id
                WHERE public_code = :public_code
                AND last_name = :last_name
                AND first_name = :first_name
            ');
            $check_ticket_request->execute([
                ":public_code" => $public_code,
                ":last_name" => $last_name,
                ":first_name" => $first_name
            ]);
            $tickets_validate = $check_ticket_request->fetch(PDO::FETCH_ASSOC);
            if ($tickets_validate) {
                header("HTTP/1.1 200 OK");
                echo "Ticket valide.";
            } else {
                header("HTTP/1.1 404 Not Found");
                echo "Ce ticket n'existe pas.";
            }
        } else {
            $erreur = "Veuillez remplir tous les champs.";
        }
    }
?><!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier évènement</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div>
        <?php if ($erreur != null): ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
        <form method="GET">
            <label for="last-name">Nom: </label>
            <input type="text" id="last-name" name="last-name"  placeholder="Indiquer votre nom de famille" required>
            <br>
            <label for="first-name">Prenom: </label>
            <input type="text" id="first-name" name="first-name"  placeholder="Indiquer votre prénom" required>
            <br>
            <label for="ticket-public-code">Code public du billet: </label>
            <input type="text" id="ticket-public-code" name="ticket-public-code" placeholder="Indiquer le code public"
             required>
            <br>
            <input class="submit" type="submit" value="Valider le billet" id="submit" name="submit">
        </form>
    </div>
</body>
</html>
