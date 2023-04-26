<?php
    session_start();
    $method = filter_input(INPUT_SERVER,'REQUEST_METHOD');
    if($method == 'POST'){
        $username = trim(filter_input(INPUT_POST, 'username'));
        $password = trim(filter_input(INPUT_POST, 'password'));
        $data = array(
            "login" => $username,
            "password" => $password
        );
        $data = json_encode($data);
        $_SESSION['data'] = $data;
        header("Location: ../../authentification/register.php");
        exit();
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
    <form method='POST'>
        <h1>Espace Administrateur - Inscription</h1>
       
        <input type='text' id='username' placeholder="username" name='username'>

        <input type='password' id='passsword' placeholder="mots de passe" name='password'>
        <input class="submit" type="submit" value="S'inscrire">
        <p>Déjà inscrit?<a href="./login.php">Connectez-vous ici</a></p>
    </form>
    
</body>
</html>