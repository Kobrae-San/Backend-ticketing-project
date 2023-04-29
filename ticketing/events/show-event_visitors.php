<?php
// Type de moteur de BDD : mysql
$auth_engine = "mysql";
// Hôte : localhost
$host = "localhost";
// Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
$auth_port = 3306; // port XAMP
$mamp_auth_port = 8888; // port MAMP
// Nom de la BDD (facultatif) : sakila
$auth_bdd = "billeterie";
$ticket_bdd = "billeterie";
// Nom d'utilisateur : root
$user = "root";
// Mot de passe : 
$password_bdd = "";

$auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
$auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

$ticket_dsn = "$auth_engine:host=$host:$auth_port;dbname=$ticket_bdd";
$ticket_pdo = new PDO($ticket_dsn, $user, $password_bdd);
require '../../inc/functions.php';
session_start();

    $requete = $ticket_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
    //requete pour recuperer le nom de levenement cliquer
   if(isset($_GET["delete_id"])){
    $requete4 = $ticket_pdo->prepare("
    DELETE FROM events WHERE id = :id 
    ");
    $requete4->execute([
        ":id" => $_GET["delete_id"]
       
    ]);

   };


?>

   
    

  
 

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    
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



    </style>
    <link rel="stylesheet" href="../style.css">
</head>

<body class="liste_event">
        
    
     
        <h1>Visualiser les événements et leurs inscrits</h1>
        
        <table>
            <thead>
                <tr>
                    <th>event_name</th>
                    <th>event_place</th>
                    <th>event_description</th>
                    <th>Supprimer</th>
                    <th>Participants</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $event): ?>
                <tr>
                    <td><?= $event['event_name'] ?></td>
                    <td><?= $event['event_place'] ?></td>
                
                    <td><?= substr($event['event_description'], 0, 50)."..." ?></td>
                    <td><a class="boutton" href="show-event_visitors.php?delete_id=<?= $event['id'] ?>">Supprimer</a></td>
                    <td><a class="boutton" href="visiteurs.php?id=<?= $event['id']."........." ?>">voir les Participants</a></td>
                    

                </tr>
                <?php endforeach; ?>


            </tbody>
        </table>
        

       <script>
       
       
        

     //afficher les visiteurs 
        const event = document.querySelectorAll('.event');

    </script>

</body>
</html>


