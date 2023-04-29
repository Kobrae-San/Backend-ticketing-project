
<?php
    require '../../inc/functions.php';
    require '../../inc/pdo.php';

    $title = "Valider un billet";
    $website_part = "Billetterie";

    $style_ticketing_path = "../styles/ticketing.css";
    $show_ticket_path = "./show-ticket.php";
    $submit_ticket_path = "./submit-ticket.php";
    $register_path = "../connection/register.php";
    $login_path = "../connection/login.php";
    $logout_path = "../connection/logout.php";
    $event_management_path = "../events/create-modify-delete-events.php";
    $visitor_management_path = "../events/add-remove-visitors.php";
    $events_path = "../events/show-event&visitors.php";

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $erreur = "";

    $submit = filter_input(INPUT_GET, "submit");

    if (isset($_GET["your_token"])&&isset($_GET["username"])){
        $hashed = $_GET["your_token"];
        $username = $_GET["username"];
    }

    if ($method == "GET" && $submit == "Valider le billet") {
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
                http_response_code(200);
            } else {
                http_response_code(404);
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
    <title>Valider un billet</title>
    <link rel="stylesheet" href="../styles/ticketing.css">
</head>
<?php if ((isset($_GET['last-name']) && isset($_GET['first-name']) && isset($_GET['ticket-public-code'])) && ($last_name && $first_name && $public_code) && ($submit == "Valider le billet" && $tickets_validate)): ?>
    <body style="background-color: green;">
    </body>
<?php elseif ((isset($_GET['last-name']) && isset($_GET['first-name']) && isset($_GET['ticket-public-code'])) && ($last_name && $first_name && $public_code) && ($submit == "Valider le billet" && !$tickets_validate)): ?>
    <body style="background-color: red;">
    </body>
<?php else: ?>
<body>
    <header> 
        <nav>
            <ul>
                <?php if (isset($_GET["your_token"]) && token_check($_GET["your_token"], $auth_pdo)): ?>
                    <a href="<?= $show_ticket_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                    <a href="<?= $submit_ticket_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                    <a href="<?= $events_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>   "><li>Les évènements</li></a>
                    <a href="<?= $event_management_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Gestion des évènements</li></a>
                    <a href="<?= $visitor_management_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>&add=false"><li>Gestion des visiteurs</li></a>
                    <a href="<?= $logout_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Déconnexion</li></a>
                <?php else: ?>
                    <a href="<?= $show_ticket_path ?>"><li>Afficher un billet</li></a>
                    <a href="<?= $submit_ticket_path ?>"><li>Valider un billet</li></a>
                    <a href="<?= $login_path ?>"><li>Connexion</li></a>
                    <a href="<?= $register_path ?>"><li>Inscription</li></a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div>
        <?php if ($erreur != null): ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
        <h2><?= $title ?></h2>
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
            <input class="submit" type="submit" value="Valider" id="submit" name="submit">
        </form>
    </div>
</body>
</html>
<?php endif; ?>