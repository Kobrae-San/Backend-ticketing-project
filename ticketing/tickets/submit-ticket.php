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

    if ($method == "GET" && $submit == "Valider le billet") {
        $last_name = trim(filter_input(INPUT_GET, 'last-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $first_name = trim(filter_input(INPUT_GET, 'first-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $public_code = trim(filter_input(INPUT_GET, 'ticket-public-code', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($last_name && $first_name && $public_code) {
            $check_ticket_request = $ticket_pdo->prepare('
                SELECT public_code, last_name, first_name FROM tickets
                INNER JOIN visitors on tickets.visitor_id = visitors.id
                WHERE public_code = :public_code
                AND last_name = :last_name
                AND first_name = :first_name
            ');
            
            $check_ticket_request->bindParam(':public_code', $public_code, PDO::PARAM_STR);
            $check_ticket_request->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $check_ticket_request->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $check_ticket_request->execute();
            $tickets_validate = $check_ticket_request->fetch(PDO::FETCH_ASSOC);
            if ($tickets_validate) {
                http_response_code(200);
                ?><!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Billet valide</title>
            </head>
            <body style="background-color: green;">  
            </body>
            </html><?php
            } else {
                http_response_code(404);
            ?><!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Billet non valide</title>
            </head>
            <body style="background-color: red;">  
            </body>
            </html><?php
            }
        } else {
            $erreur = "Veuillez remplir tous les champs.";
            ?><!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Valider un billet</title>
            <link rel="stylesheet" href="../style.css">
        </head>
        <body>
            <div>
                <?php if ($erreur != null): ?>
                    <p><?= $erreur ?></p>
                <?php endif; ?>
                <form method="GET">
                    <label for="last-name">Nom: </label>
                    <input type="text" id="last-name" name="last-name"  placeholder="Indiquer votre nom de famille" >
                    <br>
                    <label for="first-name">Prenom: </label>
                    <input type="text" id="first-name" name="first-name"  placeholder="Indiquer votre prénom" >
                    <br>
                    <label for="ticket-public-code">Code public du billet: </label>
                    <input type="text" id="ticket-public-code" name="ticket-public-code" placeholder="Indiquer le code public"
                     >
                    <br>
                    <input class="submit" type="submit" value="Valider le billet" id="submit" name="submit">
                </form>
            </div>
        </body>
        </html><?php
        }
    }
?><!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider un billet</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div>
        <?php if ($erreur != null): ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
        <form method="GET">
            <h1>Valider un billet</h1>
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
            <a href=".././dashboard.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>"><li>Retour au menu principal</li></a>
        </form>
    </div>
</body>
</html>
