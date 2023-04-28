<?php
// logout.php : Comment se déconnecter
// Etape 1 : On démarre la session
require '../inc/pdo.php';
session_start();
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD'); // On récupère la méthode de la session 
$erreur = null;

$username=$_GET["username"];


$requete = $auth_pdo->prepare("
UPDATE token SET token = :null WHERE token.user_id = (SELECT id FROM users WHERE login = :login);
");

$requete->execute([
    ":login" => $username,
    ":null"=> null
]);

// Etape 2 : On supprime tout le contenu de la session
session_destroy();
// Etape 3 : On redirige la personne vers le login (par exemple)
header('Location: ../ticketing/connection/login.php');
// C'est fini !

