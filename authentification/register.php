<?php

require '../inc/pdo.php';
$existing_user = "";

$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');


if($method == 'POST'){
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $first_requete = $auth_pdo->prepare("
    SELECT * FROM users WHERE login = :login;
    ");
    $first_requete->execute([
        ":login" => $username
    ]);

    $verif_user = $first_requete->fetch(PDO::FETCH_ASSOC);
    if(!$verif_user){
        $requete = $auth_pdo->prepare("
        INSERT INTO users (login, password) VALUES (:login, :password)
        ");
        $requete->execute([
            ":login" => $username,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $requete_token = $auth_pdo->prepare("
        INSERT INTO token (token, user_id) VALUES (:token, LAST_INSERT_ID())
        ");
        $requete_token->execute([
            ":token" => "",
        ]);
        header('Location: login.php');
        exit();
    }
    else {
        $existing_user = "Ce nom d'utilisateur est déjà utilisé.";
    }
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur - Inscription</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
   
    <?php if ($existing_user): ?>
        <p style="color: red;"><?= $existing_user ?></p>
    <?php endif; ?>

    <form method='POST'>
        <h1>Espace Administrateur - Inscription</h1>
       
        <input type='text' id='username' placeholder="username" name='username'>

        <input type='password' id='passsword' placeholder="mots de passe" name='password'>
        <input class="submit" type="submit" value="S'inscrire">
        <p>Déjà inscrit?<a href="./login.php">Se connecter ici</a></p>
    </form>
    
</body>
</html>