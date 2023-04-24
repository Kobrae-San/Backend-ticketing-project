<?php
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if(!isset($_SESSION["loggedin"]) && $method != "POST"): ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Afficher un billet - Billeterie</title>
    </head>
    <body>
        <h1>Billeterie</h1>
        <div>
            <h2>Afficher mon billet</h2>
            <form method="POST">
                <label for="lastname">Nom: </label>
                <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
                
                <label for="lastname">Prénom: </label>
                <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

                <label for="private-ticket-id">ID privé du Billet</label>
                <input type="text" id="private-ticket-id" name="private-ticket" required>

                <input type="submit" value="Afficher mon billet">
            </form>
        </div>
    </body>
    </html>
    <?php  
    elseif ($method == "POST"):
        $last_name = filter_input(INPUT_POST, "lastname");
        $first_name = filter_input(INPUT_POST, "firstname");
        $ticket_id = filter_input(INPUT_POST, "private-ticket-id")
     ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Imprimez mon Billet</title>
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
        <div>
            <p><?= $last_name ?></p>
            <p><?= $first_name ?></p>
             
        </div>
    </body>
    </html>
    <?php endif;