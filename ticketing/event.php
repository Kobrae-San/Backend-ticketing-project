<?php 
session_start();

$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if (!isset($_SESSION["loggedin"])){
    header('Location: dashboard.php');
    exit();
}

if($method == 'POST'){
    $nom = filter_input(INPUT_POST, 'last_name');
    $prenom = filter_input(INPUT_POST, 'first_name');
    $event_name = filter_input(INPUT_POST,'event_name');
    $event_place = filter_input(INPUT_POST,'event_place');
    $event_date = filter_input(INPUT_POST,'event_date');
    $requete = $pdo->prepare("
        INSERT INTO event (event_name,event_place,event_date) VALUES (:event_name,:event_place,:event_date)
        ");
        $requete->execute([
            ":event_name" => $event_name,
            ":event_place" => $event_place,
            ":event_date" => $event_date
        ]);
        $requete2 = $pdo->prepare("
        INSERT INTO visitor (last_name,first_name,event_id) VALUES (:last_name,:first_name,LAST_INSERT_ID())
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
    <h1>Système d'ajout de visiteurs à un événement</h1>
    <form method = "POST">
    <label>Nom: </label>
    <input type="text" placeholder="nom" name="last_name">
    <label>Prénom: </label>
    <input type="text" placeholder="prenom" name="first_name">
    <label>Nom évènement: </label>
    <input type="text" placeholder="Nom de l'évènement" name="event_name">
    <label>Lieu de l'évènement:</label>
    <input type="text" placeholder="Lieu de l'évènement" name="event_place">
    <label>Date de l'évènement</label>
    <input type="date" name="event_date">
    <input type="submit">
    </form>
</body>
</html>