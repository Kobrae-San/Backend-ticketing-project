<?php
require '../inc/functions.php';
require '../inc/pdo.php';
session_start();
$website_part = "Billeterie";
$erreur = null;

if (isset($_GET["your_token"])){
    $hashed = $_GET["your_token"];
}

?><!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homepage - Billeterie </title>
    </head>

    <body>
        <header>
            <h1>EasyTickets</h1>
            <nav>
                <ul>
                    <?php if (isset($_GET["your_token"]) && token_check($hashed, $auth_pdo)): ?>
                        <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                        <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                        <a href="../authentification/logout.php?username=<?= $_SESSION['username'] ?>"><li>Deconnexion</li></a>
                        <a href="./events/create-modify-delete-events.php?your_token=<?= $hashed ?>&username=<?= $_SESSION['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                        <a href="./events/add-remove-visitors.php"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                        <a href="./events/show-event&visitors.php"><li>Visualiser les événements et leurs inscrits</li></a>
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

