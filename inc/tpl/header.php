<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> - <?= $website_part ?></title>
    </head>
    <body>
        <header> 
            <nav>
                <h1>EasyTickets</h1>
                <ul>
                    <?php if (isset($_GET["your_token"]) && token_check($_GET["your_token"], $auth_pdo)): ?>
                        <a href="<?= $show_tickets_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                        <a href="<?= $submit_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                        <a href="<?= $logout_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Deconnexion</li></a>
                        <a href="<?= $creation_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                        <a href="<?= $visitor_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>&add=false"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                        <a href="<?= $show_visitor_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>   "><li>Visualiser les événements et leurs inscrits</li></a>
                    <?php else: ?>
                        <a href="<?= $show_tickets_path ?>"><li>Afficher un billet</li></a>
                        <a href="<?= $submit_path ?>"><li>Valider un billet</li></a>
                        <a href="<?= $login_path ?>"><li>Connexion</li></a>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>