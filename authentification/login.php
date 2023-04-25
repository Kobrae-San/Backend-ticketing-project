<?php
session_start();

// Si la personne est deja connecté alors on l'a redirige
require '../inc/pdo.php';
require '../inc/functions.php';

$dashboard_path = "../ticketing/dashboard.php";
$show_tickets_path = "../ticketing/tickets/show-tickets.php";
$submit_path = "../ticketing/tickets/submit-ticket.php";
$login_path = "./login.php";
$logout_path = "./logout.php";
$creation_path = "../events/create-modify-delete-events.php";
$visitor_path = "../events/add-remove-visitors.php";
$show_visitor_path = "../events/show-event&visitors.php";

if(isset($_SESSION["username"])){
    
    header("Location: {$dashboard_path}?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
    exit();
}
else{
    session_destroy();
}

$token = null;
$erreur = null;
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if($method == 'POST'){
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $requete = $auth_pdo->prepare("
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
            $requete_token = $auth_pdo->prepare("
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
    <title>EasyTickets</title>
    <link href="./styles/style.css" rel="stylesheet"></link>
</head>
<body>
    <header>
    <nav>
        <ul>
            <a href="<?= $show_tickets_path ?>"><li>Afficher un billet</li></a>
            <a href="<?= $submit_path ?>"><li>Valider un billet</li></a>    
        </ul>
    </nav>
    </header>
    <div id="login-form">
        <h2>Espace Administrateur - Connexion</h2>
        <?php if($erreur !== null) : ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>
            <form method='POST'>
                <label for='username'>Nom d'utilisateur :</label>
                <input type='text' id='username' placeholder="lucas" name='username'>
                <label for='password'>Mot de passe :</label>
                <input type='password' id='passsword' placeholder="123" name='password'>
                <input type="submit" value="Se connecter">
            </form>
            <p>Pas encore inscrit? <a href="./register.php">S'inscrire ici</a></p>
    </div>
<script type="text/javascript">
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>
</body>
</html>