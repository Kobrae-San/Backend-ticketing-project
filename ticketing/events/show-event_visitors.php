<?php
  session_start();

  require '../../inc/pdo.php';

  if(!isset($_SESSION["token"])){
      header('Location: ../dashboard.php');
      exit();
  }
  $username = $_GET['username'];
  $verify_token_request = $auth_pdo->prepare("
      SELECT login, token FROM users
      INNER JOIN token ON users.id = token.user_id
      WHERE login = :login
  ");
  
  $verify_token_request->execute([
      ":login" => $username
  ]);

  $verify_token =  $verify_token_request->fetch(PDO::FETCH_ASSOC);
  if ($verify_token) {
      if ($_GET['your_token'] != $verify_token['token'] || $verify_token['token'] == null) {
          header('Location: ../dashboard.php');
          exit();
      }
  } else {
      header('Location: ../dashboard.php');
      exit();
  }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/2f1c507e66.js" crossorigin="anonymous"></script>
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
                    <td><a class="delete" href="show-event_visitors.php?delete_id=<?= $event['id'] ?>&your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">-</a></td>
                    <td><a class="boutton" href="visiteurs.php?id=<?= $event['id'] ?>&your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>">voir les Participants</a></td>
                    

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


