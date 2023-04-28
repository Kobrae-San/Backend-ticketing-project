<?php
    // Import des fichiers requis (fonctions et pdo)
    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    
    // Création des chemins vers les autres pages
    // $show_tickets_path = "./show-tickets.php";
    // $submit_path = "./submit-ticket.php";
    // $login_path = "../../authentification/login.php";
    // $logout_path = "../../authentification/logout.php";
    // $creation_path = "../events/create-modify-delete-events.php";
    // $visitor_path = "../events/add-remove-visitors.php";
    // $show_visitor_path = "../events/show-event&visitors.php";

    // Récupération de la méthode
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    // Variables des titres de la page
    $title = "Afficher billet";
    $website_part = "Billetterie";
    
    // Initialisation des variables erreur à " " et ticket à false (billet n'apparaît pas sur la page)
    $erreur = "";
    $ticket = false;

    // Récupération des données fournies dans le formulaire en POST
    if ($method == "POST"){
        $last_name = filter_input(INPUT_POST, "last-name");
        $first_name = filter_input(INPUT_POST, "first-name");
        $private_key = filter_input(INPUT_POST, "private-key");

        // Vérification de l'existence de ces données dans la bdd
        // Récupération des autres données à afficher
        if ($last_name && $first_name && $private_key) {
            $check_ticket_request = $ticket_pdo -> prepare('
            SELECT private_key, last_name, first_name, event_name,
            event_place, event_date, event_description, current_date 
            FROM tickets
            INNER JOIN visitors on tickets.visitor_id = visitors.id
            INNER JOIN events on tickets.event_id = events.id
            WHERE private_key = :private_key
            AND last_name = :last_name
            AND first_name = :first_name
            ');

            $check_ticket_request -> execute([
                ":private_key" => $private_key,
                ":last_name" => $last_name,
                ":first_name" => $first_name,
            ]);

            $ticket_info = $check_ticket_request -> fetch(PDO::FETCH_ASSOC);

            // Attribution des valeurs aux variables correspondantes si le billet existe
            if ($ticket_info) {
                $event_name = $ticket_info['event_name'];
                $event_place = $ticket_info['event_place'];
                $event_date = $ticket_info['event_date'];
                $event_description = $ticket_info['event_description'];
                $current_date = $ticket_info['current_date'];

                // Condition permettant d'afficher le billet à la place du formulaire quand le billet existe
                $ticket = true;

            // Affichage de l'erreur si les données fournies sont invalides
            } else {
                $erreur = "Billet indisponible. Veuillez vérifier les informations fournies puis réessayer";
            }
        }
    }
?>

<?php include '../../inc/tpl/header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div>
        <!-- Affichage de l'erreur s'il y en a une -->
        <?php if ($erreur != null): ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
        
        <!-- Affichage du formulaire si aucun billet valide n'est affiché -->
        <?php if($ticket != true): ?>
            <h2>Afficher un billet</h2>
            <form method="POST">
                <label for="last-name">Nom : </label>
                <input type="text" id="last-name" name="last-name" placeholder="Indiquez le nom de famille" required>
                <br>
                <label for="first-name">Prénom : </label>
                <input type="text" id="first-name" name="first-name" placeholder="Indiquez le prénom" required>
                <br>
                <label for="private-ticket-id">Identifiant privé du billet :</label>
                <input type="text" id="private-ticket-id" name="private-key" placeholder="Chaîne de 6 à 10 caractères alphanumériques" required>
                <br>
                <input class="submit" type="submit" value="Afficher" id="submit" name="submit">
            </form>
        
        <!-- Affichage du billet si les données sont valides -->
        <?php elseif($ticket == true): ?>
            <h2>Billet</h2>
            <p>Nom : <?= $ticket_info['last_name'] ?></p>
            <br>
            <p>Prénom : <?= $ticket_info['first_name'] ?></p>
            <br>
            <p>Evènement : <?= $ticket_info['event_name'] ?></p>
            <br>
            <p>Lieu : <?= $ticket_info['event_place'] ?></p>
            <br>
            <p>Date : <?= $ticket_info['event_date'] ?></p>
            <br>
            <p>Description : <?= $ticket_info['event_description'] ?></p>
            <br>
            <p>Date de génération du billet : <?= $ticket_info['current_date'] ?></p>
            <br>
            <p>Code QR :</p>
        <?php endif; ?>
    </div>
</body>
</html>