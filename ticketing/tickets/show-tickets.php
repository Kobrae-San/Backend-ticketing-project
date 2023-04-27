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
        $title = "Imprimez un billet";
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
        
        require 'vendor/autoload.php'; // Inclure l'autoloader de Composer

        // Importer les classes nécessaires du package bacon/bacon-qr-code avec des alias
        $pngRendererClass = 'BaconQrCode\Renderer\Image\Png';
        $writerClass = 'BaconQrCode\Writer';
        
        // Créer une nouvelle instance du rendu PNG
        $pngRenderer = new $pngRendererClass();
        
        // Créer une nouvelle instance de l'écrivain de QR code
        $writer = new $writerClass($pngRenderer);
        
        // Générer le QR code
        $text = 'lastname, firstname, private-ticket-id ';
        $qrCode = $writer->writeString($text);
        
        // Afficher l'image du QR code
        header('Content-Type: image/png');
        echo $qrCode;
        
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
