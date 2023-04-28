<?php

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
  text-align: left;
  padding: 8px;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
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
          
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user["last_name"] ?></td>
                    <td><?= $user["first_name"] ?></td>
                
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
