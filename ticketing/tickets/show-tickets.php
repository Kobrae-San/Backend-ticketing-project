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

    if ($method == "POST"){
        $last_name = filter_input(INPUT_POST, "lastname");
        $first_name = filter_input(INPUT_POST, "firstname");
        $private_key = filter_input(INPUT_POST, "private-key");
        if ($last_name && $first_name && $private_key) {
            $display_ticket_request = $ticket_pdo -> prepare('
            SELECT private_key, last_name, first_name, event_name,
            event_place, event_date, event_description, current_date 
            FROM tickets
            INNER JOIN visitors on tickets.visitor_id = visitors.id
            INNER JOIN events on tickets.event_id = events.id
            WHERE private_key = :private_key
            AND last_name = :last_name
            AND first_name = :first_name
            AND event_name = :event_name
            AND event_place = :event_place
            AND event_date = :event_date
            AND event_description = :event_description
            AND current_date = :current_date
            ');

            $display_ticket_request -> execute([
                ":private_key" => $private_key,
                ":last_name" => $last_name,
                ":first_name" => $first_name,
                ":event_name" => $event_name,
                ":event_place" => $event_place,
                ":event_date" => $event_date,
                ":event_description" => $event_description,
                ":current_date" => $current_date
            ]);

            $display_ticket = $display_ticket_request -> fetch(PDO::FETCH_ASSOC);
            if ($display_ticket) {
                
            }
        } else {
            $erreur = "Champs invalides ou manquants.";
        }
    }

?>

        <?php include '../../inc/tpl/header.php'; ?>
        
        <div>
            <p><?= $last_name ?></p>
            <p><?= $first_name ?></p>
             
        </div>
        <div>
            <h2>Afficher mon billet</h2>
            <form method="POST">
                <label for="lastname">Nom: </label>
                <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
                
                <label for="lastname">Prénom: </label>
                <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

                <label for="private-ticket-id">ID privé du Billet</label>
                <input type="text" id="private-ticket-id" name="private-key" required>

                <input type="submit" value="Afficher mon billet">
            </form>
        </div>
    </body>
    </html>