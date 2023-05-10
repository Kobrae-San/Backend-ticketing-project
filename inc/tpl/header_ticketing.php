<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> - <?= $website_part ?></title>
        <link href="<?= $style_ticketing_path ?>" rel="stylesheet"></link>
    </head>
    <body>
        <header> 
            <nav>
                <ul>
                    <?php if (isset($_GET["your_token"]) && token_check($_GET["your_token"], $auth_pdo)): ?>
                        <a class="boutton" href="<?= $show_ticket_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                        <a class="boutton" href="<?= $submit_ticket_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                        <a class="boutton" href="<?= $event_management_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Gestion des évènements</li></a>
                        <a class="boutton" href="<?= $visitor_management_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>&add=false"><li>Gestion des visiteurs</li></a>
                        <a class="boutton" href="<?= $events_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>   "><li>Les évènements</li></a>
                        <a class="boutton" href="<?= $logout_path ?>?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Déconnexion</li></a>
                    <?php else: ?>
                        <a class="boutton" href="<?= $show_ticket_path ?>"><li>Afficher un billet</li></a>
                        <a class="boutton" href="<?= $submit_ticket_path ?>"><li>Valider un billet</li></a>
                        <a class="boutton" href="<?= $login_path ?>"><li>Connexion</li></a>
                        <a class="boutton" href="<?= $register_path ?>"><li>Inscription</li></a>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>