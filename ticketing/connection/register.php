<?php
//ini_set('display_errors', 1);
    session_start();
    $method = filter_input(INPUT_SERVER,'REQUEST_METHOD');
    $erreur = null;
    if($method == 'POST') {
        $username = trim(filter_input(INPUT_POST, 'username'));
        $password = trim(filter_input(INPUT_POST, 'password'));
        if ($username && $password) {
            $data = array(
                "login" => $username,
                "password" => $password
            );
            $erreur = 'je suis passé ici';
            $json_data = json_encode($data);
            // Attention, c'est une URL, pas un chemin
            $ch = curl_init('http://localhost/Back-End/backend-project/authentification/register.php');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            // Ca, ça permet que $result contienne le résultat de la requête
            // Par défaut, cURL echo directement le résultat dans la page
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
            if ($result['statut'] == 'Succès') {
                header('Location: ./login.php');
                exit();
            } else if ($result['statut'] == 'Erreur' && $result['message'] == 'Utilisateur déja existant.') {
                $erreur = $result['message'];
            }
        } else {
            $erreur = "Veuillez remplir tous les champs";
        }
    }

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur - Inscription</title>
    <link rel="stylesheet" href="../../authentification/styles/style.css">
</head>
<body>
    <?php if ($erreur != null): ?>
        <p><?= $erreur ?></p>
    <?php endif; ?>
    <form method='POST'>
        <h1>Espace Administrateur - Inscription</h1>
       
        <input type='text' id='username' placeholder="username" name='username'>

        <input type='password' id='passsword' placeholder="mots de passe" name='password'>
        <input class="submit" type="submit" value="S'inscrire">
        <p>Déjà inscrit?<a href="./login.php">Connectez-vous ici</a></p>
    </form>
    
</body>
</html>