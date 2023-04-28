<?php

session_start();
require '../../inc/pdo.php';
$erreur = false;

$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
if(isset($_SESSION['send'])){
    $json = $_SESSION['data'];
    $data = json_decode($json, true);
    if($data['statut'] == 'Succès'){
        $token= $_SESSION['token']  ;
        header("Location: ../dashboard.php?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
    }elseif($data['statut'] == 'Erreur'){
        $erreur = true;
    } 
}

if($method == "POST"){

    $data = array(
        'username' => $username,
        'password' => $password
    );

    $json = json_encode($data);
    $_SESSION['data'] = $json;
    header('Location: ../../authentification/login.php');
    exit();
}

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <link href="../ticketing/styles/login.css" rel="stylesheet"></link>

    <title>EasyTickets</title>
    <link href="../../authentification/styles/style.css" rel="stylesheet"></link>

</head>
<body>
            <form method='POST'>
               <h2>Espace Administrateur - Connexion</h2>
                <input type='text' id='username' placeholder="Nom de l'utilisateur" name='username'>
                <input type='password' id='passsword' placeholder="Mot de passe" name='password'>
                <?php if ($erreur == true) { ?>
                <p>Identifiants incorrects !</p>
               <?php }
                ?>
                <input class="submit" type="submit" value="Connexion" name="submit">
                <p>Pas encore inscrit? <a href="../../authentification/register.php">S'inscrire ici</a></p>
            </form>
           
    </div>
   
</body>
</html>