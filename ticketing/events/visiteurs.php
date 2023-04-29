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
 if(isset($_GET["id"])){
    $requete2 = $ticket_pdo->prepare("
    SELECT * FROM events
    WHERE id = :id
    ");
    $requete2->execute([
        ":id" => $_GET["id"]
    ]);
    $event = $requete2->fetch(PDO::FETCH_ASSOC);
    //requete pour recuperer les inscrits a levenement cliquer
    $requete3 = $ticket_pdo->prepare("
    select * from visitors where event_id=:id
    ");
    $requete3->execute([
        ":id" => $_GET["id"]
    ]);
    $users = $requete3->fetchAll(PDO::FETCH_ASSOC);}
    else{
        $users = [];
    }
    //delete
    if(isset($_GET["delete"])){
        $requete4 = $ticket_pdo->prepare("
        DELETE FROM visitors WHERE id = :id 
        ");
        $requete4->execute([
            ":id" => $_GET["delete"]
           
        ]);
        header("Location: visiteurs.php?id=".$_GET["id"]);
    }


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style.css">
    
    <style>

.delete {
  color: #ffffff;
  background: red ;

  width: 10px;
  overflow: hidden;
  display: flex;

  padding: 5px 5px;
  text-align: center;
  justify-content: center;
  border-radius: 5px;
  text-decoration: none;
  font-size: 16px;
  transition: 0.1s;
  cursor: pointer;
}

.delete:hover {
  
  background-color: red;


  transform: scale(1.005);
}


    </style>
</head>
<body>
    <h1> inscrits</h1>
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
                    <td><a href="visiteurs.php?id=<?= $event["id"] ?>&delete=<?= $user["id"] ?>&name=<?= $user["last_name"]?>"class='delete'>-</a></td>
                </tr>
               
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
