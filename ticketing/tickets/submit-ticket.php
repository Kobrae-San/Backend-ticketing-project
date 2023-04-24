<!DOCTYPE html>
<html lang="en">
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
                    <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                    <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                    <a href="../../authentification/logout.php?username=<?= $_GET['username'] ?>"><li>Deconnexion</li></a>
                    <a href="./events/create-modify-delete-events.php?your_token=<?= $hashed ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
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
    <h1>Valider un billet</h1>
</body>
</html>