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
    $title = "Validez un billet";
    $website_part = "Billeterie";
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if(!isset($_SESSION["loggedin"]) && $method != "POST"): ?>
    
    <?php include '../../inc/tpl/header.php'; ?>
    <h1>Billetterie</h1>
    <div>
        <h2>Valider un billet</h2>
        <form method="POST">
            <label for="lastname">Nom : </label>
            <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
            
            <label for="lastname">Prénom : </label>
            <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

            <label for="public-ticket-code">Code public du Billet :</label>
            <input type="text" id="public-ticket-code" name="public-ticket" placeholder="Renseignez le code public"
             required>

            <input type="submit" value="Générer le lien du Billet">
        </form>
    </div>
</body>
</html>
<?php  
elseif ($method == "POST"):
    $last_name = filter_input(INPUT_POST, "lastname");
    $first_name = filter_input(INPUT_POST, "firstname");
    $ticket_code = filter_input(INPUT_POST, "public-ticket-code")
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Générer le lien du Billet</title>
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
                    <a href="./events/create-modify-delete-events.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                    <a href="./events/add-remove-visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                    <a href="./events/show-event&visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>   "><li>Visualiser les événements et leurs inscrits</li></a>
                <?php else: ?>
                    <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                    <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                    <a href="../authentification/login.php"><li>Connexion</li></a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <h1>Valider un billet</h1>
    <div>
        <p><?= $last_name ?></p>
        <p><?= $first_name ?></p>
            
    </div>
</body>
</html>
<?php endif;
