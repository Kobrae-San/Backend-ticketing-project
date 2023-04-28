
<?php 

session_start();
require '../../inc/pdo.php';
require '../../inc/functions.php';
$title = "Ajoutez/Supprimez des visiteurs";
$website_part = "Billeterie";
$show_tickets_path = "../tickets/show-tickets.php";
$submit_path = "../tickets/submit-ticket.php";
$login_path = "../../authentification/login.php";
$logout_path = "../../authentification/logout.php";
$creation_path = "./create-modify-delete-events.php";
$visitor_path = "add-remove-visitors.php";
$show_visitor_path = "../events/show-event&visitors.php";
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
    header('Location: ../dashboard.php');
    exit();
}

$add = $_SESSION['add'];

$nom = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$event_name = filter_input(INPUT_POST,'event_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$event_place = filter_input(INPUT_POST,'event_place', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$event_date = filter_input(INPUT_POST,'event_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
            echo "L'utilisateur est déjà inscrit à cet évènement";
        } else {
            $requete = $ticket_pdo->prepare("INSERT INTO visitors (last_name,first_name,event_id) VALUES (:last_name,:first_name,:id)");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            $visitor_id = $ticket_pdo->lastInsertId();
            $public_code = public_code();
            $private_key = private_id();
            $requete = $ticket_pdo->prepare("INSERT INTO tickets (visitor_id,event_id,public_code,private_key) VALUES (:visitor_id,:event_id,:public_code,:private_key)");
            $requete->execute([":visitor_id" => $visitor_id, ":event_id" => $check_event, ":public_code" => $public_code, ":private_key" => $private_key]);
            echo "Inscription réussite";
        }
    } else {
        if ($check_visitor) {
            $requete = $ticket_pdo->prepare("DELETE FROM tickets WHERE event_id = :event_id AND visitor_id = (SELECT id FROM visitors WHERE last_name = :last_name AND first_name = :first_name AND event_id = :event_id)");
            $requete->execute([":event_id" => $check_event, ":last_name"  => $nom, "first_name" => $prenom]);
            $requete = $ticket_pdo->prepare("DELETE FROM visitors WHERE event_id = :id AND last_name = :last_name AND first_name = :first_name");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            echo "Visiteur supprimé";
        } else {
            echo "L'utilisateur n'est pas inscrit à cette évenement";
        }
    }
}




?>
    <?php include '../../inc/tpl/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../style.css">
   
    </head>
    <body>
       
        <form method = "POST">
          <h2>Système <?php echo ($add == 'true') ? "d'ajout" : "de suppression";?> de visiteurs à un événement</h2>

            <label>Nom: </label>
            <input type="text" placeholder="nom" name="last_name">
            <br>
            <label>Prénom: </label>
            <input type="text" placeholder="prenom" name="first_name">
            <label>Nom évènement: </label>
            <br>
            <input type="text" placeholder="Nom de l'évènement" name="event_name">
            <label>Lieu de l'évènement:</label>
            <br>
            <input type="text" placeholder="Lieu de l'évènement" name="event_place">
            <label>Date de l'évènement</label>
            <br>
            <input type="date" name="event_date">
            <input  class="submit" type="submit">
            <a class="i"  href="add-remove-visitors.php?your_token=<?= $_GET['your_token']?>&username=<?= $_GET['username']?>&add=<?= ($add == 'true') ? "false" : "true" ?>">Vous souhaitez <?= ($add == 'true') ? "supprimer" : "ajouter";?> un visiteur ?</a>
    </body>
        </form>
       
</html>