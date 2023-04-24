<?php 
session_start();
require '../../inc/pdo.php';
require '../../inc/functions.php';

$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if (!isset($_GET['your_token'])) {
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header> 
        <nav>
            <h1>EasyTickets</h1>
            <ul>
                <?php if (isset($_GET["your_token"]) && token_check($_GET["your_token"], $auth_pdo)): ?>
                    <a href="../tickets/show-tickets.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Afficher un billet</li></a>
                    <a href="../tickets/submit-ticket.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Valider un billet</li></a>
                    <a href="../../authentification/logout.php?username=<?= $_GET['username'] ?>"><li>Deconnexion</li></a>
                    <a href="../events/create-modify-delete-events.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Créer/Modifier/Annuler un événement</li></a>
                    <a href="./add-remove-visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Ajouter/Annuler un visiteur à l'événement</li></a>
                    <a href="../events/show-event&visitors.php?your_token=<?= $_GET['your_token'] ?>&username=<?= $_GET['username'] ?>"><li>Visualiser les événements et leurs inscrits</li></a>
                <?php else: ?>
                    <a href="./tickets/show-tickets.php"><li>Afficher un billet</li></a>
                    <a href="./tickets/submit-ticket.php"><li>Valider un billet</li></a>
                    <a href="../authentification/login.php"><li>Connexion</li></a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

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