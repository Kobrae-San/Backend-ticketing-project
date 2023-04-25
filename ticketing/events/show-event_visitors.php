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

    $requete = $auth_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
    

  
 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="liste_event">
    
        <?php 
        foreach($events as $event){
            echo "<div class='event' data-tooltype='description'>
            
            <h2 id='event_name'>Nom:  <span>{$event['event_name']}</span></h2>
            <h2>lieu:  <span>{$event['event_place']}</span></h2>
            </div>";
        }
        ?>


    
</body>
</html>


