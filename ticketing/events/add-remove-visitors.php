<?php
session_start();
require '../../inc/pdo.php';
require '../../inc/functions.php';

$title = "Gestion des visiteurs";
$website_part = "Billetterie";

$style_ticketing_path = "../styles/ticketing.css";
$show_ticket_path = "../tickets/show-ticket.php";
$submit_ticket_path = "../tickets/submit-ticket.php";
$login_path = "../connection/login.php";
$logout_path = "../connection/logout.php";
$event_management_path = "./create-modify-delete-events.php";
$visitor_management_path = "./add-remove-visitors.php";
$events_path = "./show-event-visitors.php"; 

$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
    header('Location: ../dashboard.php');
    exit();
}

$add = $_GET['add'];

$nom = filter_input(INPUT_POST, 'last_name');
$prenom = filter_input(INPUT_POST, 'first_name');
$event_name = filter_input(INPUT_POST,'event_name');
$event_place = filter_input(INPUT_POST,'event_place');
$event_date = filter_input(INPUT_POST,'event_date');

$requete = $ticket_pdo->prepare("SELECT id FROM events WHERE event_name = :name AND event_place = :place AND event_date = :date");
$requete->execute([":name" => $event_name, ":place" => $event_place, ":date" => $event_date]);
$check_event = $requete->fetch(PDO::FETCH_ASSOC);

if (!$check_event && $method == 'POST') {
    echo "L'événement que vous souhaitez rentrer n'existe pas !";
} elseif ($check_event && $method == 'POST') {
    $check_event = $check_event["id"];
    $requete = $ticket_pdo->prepare("SELECT * FROM visitors WHERE event_id = :id AND last_name = :last_name AND first_name = :first_name");
    $requete->execute([":id" => $check_event, ":last_name" => $nom, ":first_name" => $prenom]);
    $check_visitor = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($method == 'POST' && $add == 'true') {
        if ($check_visitor) {
            echo "Le visiteur est déjà inscrit à cet évènement";
        } else {
            $requete = $ticket_pdo->prepare("INSERT INTO visitors (last_name,first_name,event_id) VALUES (:last_name,:first_name,:id)");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            $visitor_id = $ticket_pdo->lastInsertId();
            $public_code = public_code();
            $private_key = private_id();
            $requete = $ticket_pdo->prepare("INSERT INTO tickets (visitor_id,event_id,public_code,private_key) VALUES (:visitor_id,:event_id,:public_code,:private_key)");
            $requete->execute([":visitor_id" => $visitor_id, ":event_id" => $check_event, ":public_code" => $public_code, ":private_key" => $private_key]);
            echo "Inscription réussie";
            $add = true;
        }
    } else {
        if ($check_visitor) {
            $requete = $ticket_pdo->prepare("DELETE FROM tickets WHERE event_id = :event_id AND visitor_id = (SELECT id FROM visitors WHERE last_name = :last_name AND first_name = :first_name AND event_id = :event_id)");
            $requete->execute([":event_id" => $check_event, ":last_name"  => $nom, "first_name" => $prenom]);
            $requete = $ticket_pdo->prepare("DELETE FROM visitors WHERE event_id = :id AND last_name = :last_name AND first_name = :first_name");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            echo "Visiteur supprimé";
        } else {
            echo "Le visiteur n'est pas inscrit à cet évènement";
        }
    }
}


?>
<?php include '../../inc/tpl/header_ticketing.php'; ?>
       
        <form method = "POST">
          <h2>Système <?php echo ($add == 'true') ? "d'ajout" : "de suppression";?> de visiteurs à un événement</h2>

            <label>Nom : </label>
            <input type="text" placeholder="Indiquez le nom de famille" name="last_name">
            <br>
            <label>Prénom : </label>
            <input type="text" placeholder="Indiquez le prénom" name="first_name">
            <label>Nom de l'évènement : </label>
            <br>
            <input type="text" placeholder="Indiquez le nom de l'évènement" name="event_name">
            <label>Lieu de l'évènement :</label>
            <br>
            <input type="text" placeholder="Indiquez le lieu de l'évènement" name="event_place">
            <label>Date de l'évènement :</label>
            <br>
            <input type="date" name="event_date">

            <input  class="submit" type="submit" value="Valider">
            <a class="i"  href="add-remove-visitors.php?your_token=<?= $_GET['your_token']?>&username=<?= $_GET['username']?>&add=<?= ($add == 'true') ? "false" : "true" ?>">Vous souhaitez <?= ($add == 'true') ? "supprimer" : "ajouter";?> un visiteur ?</a>
    </body>
        </form>
       
</html>