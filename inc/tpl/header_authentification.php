<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> - <?= $website_part ?></title>
        <link href="<?= $style_login_path ?>" rel="stylesheet"></link>        
    </head>
    <body>
        <header> 
            <nav>
                <ul>
                    <a class="btn" href="<?= $show_ticket_path ?>"><li>Afficher un billet</li></a>
                    <a class="btn" href="<?= $submit_ticket_path ?>"><li>Valider un billet</li></a>
                </ul>
            </nav>
        </header>