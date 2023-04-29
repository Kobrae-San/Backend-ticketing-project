<?php
require '../../inc/functions.php';
require '../../inc/pdo.php';
session_start();

$title = "Les évènements";
$website_part = "Billetterie";

    //Requête pour récupérer le nom de l'évènement cliqué
    $requete = $ticket_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?> - <?= $website_part ?></title>
    
    <style>
        body {
            background-color: white;
            font-family: sans-serif;
        }
        table {
  border-collapse: collapse;
  width: 100%;
  margin: 0 auto;
  background-color: #fff;
}

thead {
  background-color: #91c788;
  color: #fff;
}

th, td {
  padding: 12px;
  text-align: left;
}

th {
  font-size: 18px;
  font-weight: bold;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

tbody tr:hover {
  background-color: #ddd;
}
.boutton {
  color: #ffffff;
  background: #91c788 ;

  width: 60%;
  overflow: hidden;
  display: flex;

  padding: 15px 32px;
  text-align: center;
  justify-content: center;
  border-radius: 5px;
  text-decoration: none;

  font-size: 16px;
  margin: 4px 2px;

  transition: 0.1s;
  cursor: pointer;
}

.boutton:hover {
    box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.3);
  background-color: #a9dba0;
  color: rgb(0, 0, 0);
  border: solid 1px #34d87e;
  transform: scale(1.05);
}

    </style>
</head>

<body class="liste_event">
        
    
     
        
        
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Lieu</th>
                    <th>Description</th>
                    <th>Visiteurs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $event): ?>
                <tr>
                    <td><?= $event['event_name'] ?></td>
                    <td><?= $event['event_place'] ?></td>
                
                    <td><?= substr($event['event_description'], 0, 50) ?></td>
                    
                    <td><a class="boutton" href="visitors-list.php?id=<?= $event['id']."........." ?>">Voir les visiteurs</a></td>
                </tr>
                <?php endforeach; ?>
                <!-- bouton retour -->

            </tbody>
        </table>
        

       <script>
     //afficher les visiteurs 
        const event = document.querySelectorAll('.event');

    </script>

</body>
</html>


