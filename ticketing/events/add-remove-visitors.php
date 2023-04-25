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

if($method == 'POST'){
    $nom = filter_input(INPUT_POST, 'last_name');
    $prenom = filter_input(INPUT_POST, 'first_name');
    $event_name = filter_input(INPUT_POST,'event_name');
    $event_place = filter_input(INPUT_POST,'event_place');
    $event_date = filter_input(INPUT_POST,'event_date');
    $requete = $ticket_pdo->prepare("
        INSERT INTO events (event_name,event_place,event_date) VALUES (:event_name,:event_place,:event_date)
        ");
        $requete->execute([
            ":event_name" => $event_name,
            ":event_place" => $event_place,
            ":event_date" => $event_date
        ]);
        $requete2 = $ticket_pdo->prepare("
        INSERT INTO visitors (last_name,first_name,event_id) VALUES (:last_name,:first_name,LAST_INSERT_ID())
        ");
        $requete2->execute([
            ":last_name" => $nom,
            ":first_name"=> $prenom
        ]);
        header('Location: login.php');
        exit();
}

?>
    <?php include '../../inc/tpl/header.php'; ?>

    <h2>Système d'ajout de visiteurs à un événement</h2>

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
</body>
<html>