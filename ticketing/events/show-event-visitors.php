<?php
require '../../inc/functions.php';
require '../../inc/pdo.php';
session_start();

$title = "Les évènements";
$website_part = "Billetterie";

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
    
    //requete pour recuperer le nom de levenement cliquer
    if(isset($_GET["delete_id"])){

      $requete4 = $ticket_pdo->prepare("
      DELETE FROM tickets WHERE tickets.event_id = :id 
      ");
      $requete4->execute([
          ":id" => $_GET["delete_id"]
      ]);


      $requete4 = $ticket_pdo->prepare("
      DELETE FROM visitors WHERE visitors.event_id = :id 
      ");
      $requete4->execute([
          ":id" => $_GET["delete_id"]
      ]);


    $requete4 = $ticket_pdo->prepare("
    DELETE FROM events WHERE events.id = :id 
    ");
    $requete4->execute([
        ":id" => $_GET["delete_id"]
    ]);

    header ('Location: ./show-event-visitors.php?your_token='. $_GET["your_token"] ."&username=" . $_GET["username"]);

   };
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?> - <?= $website_part ?></title>
    <script src="https://kit.fontawesome.com/2f1c507e66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/ticketing.css">
    
</head>

<body class="liste_event">
        
        <h1>Les événements</h1>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Lieu</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Supprimer</th>
                    <th>Visiteurs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $event): ?>
                <tr>
                    <td><?= $event['event_name'] ?></td>
                    <td><?= $event['event_place'] ?></td>
                    <td><?= $event['event_date'] ?></td>
                    <td><?= substr($event['event_description'], 0, 50) ?></td>
                    
                    <td><a class="delete" href="show-event-visitors.php?delete_id=<?= $event['id'] ?>&your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">-</a></td>
                    <td><a class="boutton" href="visitors-list.php?id=<?= $event['id'] ?>&your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">Voir les visiteurs</a></td>
                    
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
        

       <script>
     //afficher les visiteurs 
        const event = document.querySelectorAll('.event');

    </script>
    <a href="../dashboard.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Retour</li></a>

</body>
</html>


