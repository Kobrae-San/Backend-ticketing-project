<?php
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
$existing_user = "";
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

$pdo = new PDO(
    "$moteur:host=$hote:$port;dbname=$nomBdd", 
    $nomUtilisateur,
    $motDePasse
);

if($method == 'POST'){
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $first_requete = $pdo->prepare("
    SELECT * FROM users WHERE login = :login;
    ");
    $first_requete->execute([
        ":login" => $username
    ]);

    $verif_user = $first_requete->fetch(PDO::FETCH_ASSOC);
    if(!$verif_user){
        $requete = $pdo->prepare("
        INSERT INTO users (login, password) VALUES (:login, :password)
        ");
        $requete->execute([
            ":login" => $username,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $requete_token = $pdo->prepare("
        INSERT INTO token (token, user_id) VALUES (:token, LAST_INSERT_ID())
        ");
        $requete_token->execute([
            ":token" => "",
        ]);
        header('Location: login.php');
        exit();
    }
    else {
        $existing_user = "Ce nom d'utilisateur est déjà pris.";
    }
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Admin</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <?php if ($existing_user): ?>
        <p style="color: red;"><?= $existing_user ?></p>
    <?php endif; ?>

    <form method='POST'>
        <label for='username' placeholder="lucas">Nom d'utilisateur</label>
        <input type='text' id='username' name='username'>
        <label for='password' placeholder="123">Mot de passe</label>
        <input type='password' id='passsword' name='password'>
        <input type="submit">
    </form>
    <p>Déjà inscrit ?<a href="./login.php">Cliquez ici.</a></p>
</body>
</html>