<?php
require '../inc/functions.php';
require '../inc/pdo.php';
session_start();

if (isset($_GET["your_token"])){
    $hashed = $_GET["your_token"];
}

$website_part = "Billeterie";
?><!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homepage - Billeterie </title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header> 
            <nav>
                <h1>EasyTickets</h1>
                <ul>
                    <?php if (isset($_GET["your_token"]) && token_check($hashed, $auth_pdo)): ?>
                        <a href="../authentification/logout.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Déconnexion</li></a>
                        <a href="./tickets/show-tickets.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                        <a href="./tickets/submit-ticket.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                        <a href="./events/create-modify-delete-events.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                        <a href="./events/add-remove-visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                        <a href="./events/show-event_visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Visualiser les événements et leurs inscrits</li></a>
                    <?php else: ?>
                        <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                        <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                        <a href="../authentification/login.php"><li>Connexion</li></a>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
  </body>
</html>