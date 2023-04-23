<?php
// logout.php : Comment se déconnecter
// Etape 1 : On démarre la session
session_start();
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD'); // On récupère la méthode de la session 

// Ces six informations sont nécessaires pour vous connecter à une BDD :
// Type de moteur de BDD : mysql
$moteur = "mysql";
// Hôte : localhost
$hote = "localhost";
// Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
$port = 3306;
// Nom de la BDD (facultatif) : sakila
$nomBdd = "authentification";
// Nom d'utilisateur : root
$nomUtilisateur = "root";
// Mot de passe : 
$motDePasse = "";
$erreur = null;
$pdo = new PDO(
    "$moteur:host=$hote:$port;dbname=$nomBdd", 
    $nomUtilisateur, 
    $motDePasse
);
$username=$_GET["username"];


$requete = $pdo->prepare("
UPDATE token SET token = :null WHERE token.user_id = (SELECT id FROM users WHERE login = :login);
");

$requete->execute([
    ":login" => $username,
    ":null"=> Null
]);

// Etape 2 : On supprime tout le contenu de la session
session_destroy();
// Etape 3 : On redirige la personne vers le login (par exemple)
header('Location: login.php');
// C'est fini !





