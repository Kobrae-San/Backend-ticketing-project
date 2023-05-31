<?php
    // Import des fichiers requis (fonctions et pdo)
    require '../../inc/functions.php';
    require '../../inc/pdo.php';
    require_once('../phpqrcode-master/qrlib.php');
    
    // Variables des titres de la page
    $title = "Afficher un billet";
    $website_part = "Billetterie";

    //Création des chemins vers les autres pages
    $style_ticketing_path = "../styles/ticketing.css";
    $show_ticket_path = "./show-ticket.php";
    $submit_ticket_path = "./submit-ticket.php";
    $register_path = "../connection/register.php";
    $login_path = "../connection/login.php";
    $logout_path = "../connection/logout.php";
    $event_management_path = "../events/create-modify-delete-events.php";
    $visitor_management_path = "../events/add-remove-visitors.php";
    $events_path = "../events/show-event-visitors.php";

    // Récupération de la méthode
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    
    // Initialisation des variables erreur à " " et ticket à false (billet n'apparaît pas sur la page)
    $ticket = false;


    // Récupération des données fournies dans le formulaire en POST
    if ($method == "POST"){
        $last_name = trim(filter_input(INPUT_POST, "last-name"));
        $first_name = trim(filter_input(INPUT_POST, "first-name"));
        $private_key = trim(filter_input(INPUT_POST, "private-key"));
        $ticket_id = filter_input(INPUT_POST, "private-ticket-id");

        if ($last_name && $first_name && $private_key) {
            $check_ticket_request = $ticket_pdo->prepare('
            SELECT private_key, last_name, first_name FROM tickets
            INNER JOIN visitors on tickets.visitor_id = visitors.id
            WHERE private_key = :private_key
            AND last_name = :last_name
            AND first_name = :first_name
        ');
        $check_ticket_request->execute([
            ":private_key" => $private_key,
            ":last_name" => $last_name,
            ":first_name" => $first_name
        ]);

        $tickets_validate = $check_ticket_request->fetch(PDO::FETCH_ASSOC);

        if (isset($tickets_validate) && $tickets_validate){

            $check_ticket_request = $ticket_pdo -> prepare('
            SELECT private_key, last_name, first_name, event_name,
            event_place, event_date, event_description, current_date, tickets.id, public_code
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

            $public_code = $ticket_info["public_code"];
            $ticket_id = $ticket_info["id"];

            // The data to encode
            $texte = "http://localhost/Project-ticketing-final/ticketing/tickets/submit-ticket.php?last-name={$last_name}&first-name={$first_name}&ticket-public-code={$public_code}&submit=Valider";

            $options = array('version' => 5, 'ecc' => QR_ECLEVEL_H);

            // Generate the QR code image and output it to the browser
            QRcode::png($texte, "code_qr.png", QR_ECLEVEL_H, 5);

            $event_name = $ticket_info['event_name'];
            $event_place = $ticket_info['event_place'];
            $event_date = $ticket_info['event_date'];
            $event_description = $ticket_info['event_description'];
            $current_date = $ticket_info['current_date'];
            $ticket = true;
        } else{
            $erreur = true;
        }
        }else{
            $empty = true;
        }
    }




?>
<?php include '../../inc/tpl/header_ticketing.php'; ?>

    <div>
        
        <!-- Affichage du formulaire si aucun billet valide n'est affiché -->
        <?php if($ticket != true): ?>
            <h2><?= $title ?></h2>
            <form method="POST">
                <label for="last-name">Nom : </label>
                <input type="text" id="last-name" name="last-name" placeholder="Indiquez le nom de famille" >

                <label for="first-name">Prénom : </label>
                <input type="text" id="first-name" name="first-name" placeholder="Indiquez le prénom" >

                <label for="private-ticket-id">Identifiant privé du billet :</label>
                <input type="text" id="private-ticket-id" name="private-key" placeholder="Chaîne de 6 à 10 caractères alphanumériques" >

                <input class="submit" type="submit" value="Afficher" id="submit" name="submit">

                <?php if(isset($erreur)): ?>
                    <p>Billet invalide</p>
                <?php elseif (isset($empty)): ?>   
                    <p>Veuillez remplir tous les champs.</p>
                <?php endif; ?>

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
            <p>Code QR :<?= '<img src="code_qr.png" />' ?></p>
        <?php endif; ?>
    </div>
</body>
</html>