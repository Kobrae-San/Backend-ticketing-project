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

if (!isset($_GET['your_token'])) {
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
            echo "L'utilisateur est déjà inscrit à cette évènement";
        } else {
            $requete = $ticket_pdo->prepare("INSERT INTO visitors (last_name,first_name,event_id) VALUES (:last_name,:first_name,:id)");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            echo "Inscription réussite";
        }
    } else {
        if ($check_visitor) {
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
    <h2>Système <?php echo ($add == 'true') ? "d'ajout" : "de suppression";?> de visiteurs à un événement</h2>

    <form method = "POST">
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
        <input type="submit">
    </form>
    <a href="add-remove-visitors.php?your_token=<?= $_GET['your_token']?>&username=<?= $_GET['username']?>&add=<?= ($add == 'true') ? "false" : "true" ?>">Vous souhaitez <?= ($add == 'true') ? "supprimer" : "ajouter";?> un visiteur ?</a>
</body>
</html>