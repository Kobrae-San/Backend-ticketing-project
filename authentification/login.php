<?php
session_start();
// Si la personne est deja connecté alors on l'a redirige
$dashboard_path = "../ticketing/dashboard.php";
if(isset($_SESSION["username"])){
    header("Location: {$dasboard_path}?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
    exit();
}

require '../inc/functions.php';
$token = null;
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

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
$dsn = "$moteur:host=$hote:$port;dbname=$nomBdd";
$pdo = new PDO($dsn, $nomUtilisateur, $motDePasse);

if($method == 'POST'){
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $requete = $pdo->prepare("
    SELECT * FROM users WHERE login = :login
    ");
    $requete->execute([
        ":login" => $username
    ]);
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $utilisateur["password"])){
            $token = token();
            $hashed=password_hash($token, PASSWORD_DEFAULT);
            $_SESSION["loggedin"] = true;
            $_SESSION['username'] = $username;
            $_SESSION['token'] = $hashed;
            $requete_token = $pdo->prepare("
            UPDATE token SET token = :token WHERE token.user_id = (SELECT id FROM users WHERE login = :login) ;
            ");
            $requete_token->execute([
                ":token" => $hashed,
                ":login" => $username
            ]);
            header("Location: {$dashboard_path}?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
            exit(); //Permet de couper php
        }else {
            $erreur = 'Identifiants incorrects !';
        }
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./styles/style.css" rel="stylesheet"></link>
</head>
<body>
    <div id="login-form">
        <h1>Login - Admin</h1>
        <?php if($erreur !== null) : ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
            <form method='POST'>
                <label for='username'>Username: </label>
                <input type='text' id='username' name='username'>
                <label for='password'>Password: </label>
                <input type='password' id='passsword' name='password'>
                <input type="submit">
            </form>
            <p>Pas encore de compte ? <a href="./register.php">Cliquez ici.</a></p>
    </div>
</body>
</html>