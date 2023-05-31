<?php

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

session_destroy();
header('Location: ../ticketing/connection/login.php');