<?php
    session_start();
    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    $show_tickets_path = "./show-tickets.php";
    $submit_path = "./submit-ticket.php";
    $login_path = "../../authentification/login.php";
    $logout_path = "../../authentification/logout.php";
    $creation_path = "../events/create-modify-delete-events.php";
    $visitor_path = "../events/add-remove-visitors.php";
    $show_visitor_path = "../events/show-event&visitors.php";
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $title = "Afficher un billet";
    $website_part = "Billetterie";
    
    // Initialisation des variables erreur à " " et ticket à false (billet n'apparaît pas sur la page)
    $erreur = "";
    $ticket = false;

    // Récupération des données fournies dans le formulaire en POST
    if ($method == "POST"){
        $last_name = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $first_name = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $private_key = filter_input(INPUT_POST, "private-key", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

            // $check_ticket_request->bindParam(':private_key', $private_key, PDO::PARAM_STR);
            // $check_ticket_request->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            // $check_ticket_request->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $check_ticket_request -> execute([
                ':private_key', $private_key,
                ':last_name', $last_name,
                ':first_name', $first_name
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
    <title>Modifier évènement</title>
    <link rel="stylesheet" href="../style.css">
</head>
    <h2>Billetterie</h2>
    <?php if ($method == "POST"){
        $last_name = filter_input(INPUT_POST, "lastname");
        $first_name = filter_input(INPUT_POST, "firstname");
        $ticket_id = filter_input(INPUT_POST, "private-ticket-id");
   
        // Inclure le fichier qrlib.php
        require_once('../phpqrcode/qrlib.php');

        // Texte à encoder en code QR
        $texte = 'http://localhost/Backend-ticketing-project/ticketing/tickets/afficher.php?lastname='.$last_name.'&firstname='.$first_name.'&private-ticket-id='.$ticket_id.'';

        // Options pour la génération du code QR
        $options = array('version' => 5, 'ecc' => QR_ECLEVEL_H);

        // Générer le code QR
        QRcode::png($texte, 'code_qr.png', QR_ECLEVEL_H, 5);

        // Afficher le code QR généré
        //html d'une carte devenement avec qr code
      
        echo '<img src="code_qr.png" />'

       ;


        
    }
 else{ ?>
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
