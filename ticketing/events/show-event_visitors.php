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
.boutton {
  color: #ffffff;
  background: #91c788 ;

  width: 60%;
  overflow: hidden;
  display: flex;
  box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.3);
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
                    <th>event_name</th>
                    <th>event_place</th>
                    <th>event_description</th>
                    <th>Participants</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $event): ?>
                <tr>
                    <td><?= $event['event_name'] ?></td>
                    <td><?= $event['event_place'] ?></td>
                
                    <td><?= substr($event['event_description'], 0, 50)."..." ?></td>
                    
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


