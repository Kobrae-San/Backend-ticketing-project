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
    if ($method == "POST") {
        $title = "Imprimer un billet";
    }

?>
        <?php include '../../inc/tpl/header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier événement</title>
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
        // Html d'une carte d'événement avec qr code
      
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
