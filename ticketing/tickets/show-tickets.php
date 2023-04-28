<?php
    session_start();

    require 'vendor/autoload.php';

    use Endroid\QrCode\Color\Color;
    use Endroid\QrCode\Encoding\Encoding;
    use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Label\Label;
    use Endroid\QrCode\Logo\Logo;
    use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\Writer\ValidationException;

    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    
    // Création des chemins vers les autres pages
    $show_tickets_path = "./show-tickets.php";
    $submit_path = "./submit-ticket.php";
    $login_path = "../../authentification/login.php";
    $logout_path = "../../authentification/logout.php";
    $creation_path = "../events/create-modify-delete-events.php";
    $visitor_path = "../events/add-remove-visitors.php";
    $show_visitor_path = "../events/show-event&visitors.php";

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
        <h2>Billetterie</h2>
        <?php if ($method == "POST"){
            $last_name = filter_input(INPUT_POST, "lastname");
            $first_name = filter_input(INPUT_POST, "firstname");
            $ticket_id = filter_input(INPUT_POST, "private-ticket-id");
        ?>
        <div>
            <p><?= $last_name ?></p>
            <p><?= $first_name ?></p>
             
        </div>

        <?php
        }
        else { ?>
        <div>
            <h2>Afficher un billet</h2>
            <form method="POST">
                <label for="lastname">Nom: </label>
                <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
                
                <label for="lastname">Prénom: </label>
                <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

            <label for="private-ticket-id">ID privé du Billet</label>
            <input type="text" id="private-ticket-id" name="private-ticket" placeholder="Renseignez l'identifiant privé"
                required>

            <input class="submit" type="submit" value="Afficher le billet">
        </form>
    </div>
    <?php }?>
</body>
</html>
