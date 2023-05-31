<?php

require '../../inc/pdo.php';
require '../../inc/functions.php';
session_start();

$my_token = $_GET['your_token'];
$check = token_check($my_token, $auth_pdo);
if(!$check){
    header("Location: ../dashboard.php");
    exit();
}

    $requete = $ticket_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);

    //requête pour récupérer le nom de l'évènement cliqué
 if(isset($_GET["id"])){
    $requete2 = $ticket_pdo->prepare("
    SELECT * FROM events
    WHERE id = :id
    ");
    $requete2->execute([
        ":id" => $_GET["id"]
    ]);
    $event = $requete2->fetch(PDO::FETCH_ASSOC);
    //requête pour récupérer les inscrits a l'évenement cliqué
    $requete3 = $ticket_pdo->prepare("
    select * from visitors where event_id=:id
    ");
    $requete3->execute([
        ":id" => $_GET["id"]
    ]);
    $users = $requete3->fetchAll(PDO::FETCH_ASSOC);}

    if(isset($_GET["delete"])){

        $name = $_GET['name'];
        $requete4 = $ticket_pdo->prepare("
        DELETE FROM tickets WHERE tickets.event_id = :event_id AND visitor_id = :visitor_id
        ");
        $requete4->execute([
            ":visitor_id" => $_GET["delete"],
            ":event_id" => $_GET["id"]
        ]);

        $requete4 = $ticket_pdo->prepare("
        DELETE FROM visitors WHERE id = :id
        ");
        $requete4->execute([
            ":id" => $_GET["delete"]
        ]);
        header("Location: visitors-list.php?id=".$_GET["id"]."&your_token=".$_SESSION["token"]."&username=".$_SESSION['username'])
    ;}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/ticketing.css">
    

</head>
<body class="liste_event">
    <h1>Participants</h1>
    <table>
   
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Supprimer</th>
          
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user["last_name"] ?></td>
                    <td><?= $user["first_name"] ?></td>
                    <td><a href="visitors-list.php?id=<?= $event['id'] ?>&your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>&delete=<?= $user["id"] ?>&name=<?= $user["last_name"]?>"class='delete'>-</a></td>
                </tr>
               
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="./show-event-visitors.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Retour</li></a>

</body>
</html>
