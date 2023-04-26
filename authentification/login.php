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

// $token = null;
// $erreur = null;
// $method = filter_input(INPUT_SERVER,'REQUEST_METHOD');


//     $username = filter_input(INPUT_POST, 'username');
//     $password = filter_input(INPUT_POST, 'password');
//     $requete = $auth_pdo->prepare("
//     SELECT * FROM users WHERE login = :login
//     ");
//     $requete->execute([
//         ":login" => $username
//     ]);
//     $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
//         if(password_verify($password, $utilisateur["password"])){
//             $token = token();
//             $_SESSION["loggedin"] = true;
//             $_SESSION['username'] = $username;
//             $_SESSION['token'] = $token;
//             //var_dump($_SESSION); exit();
//             $requete_token = $auth_pdo->prepare("
//             UPDATE token SET token = :token WHERE token.user_id = (SELECT id FROM users WHERE login = :login) ;
//             ");
//             $requete_token->execute([
//                 ":token" => $token,
//                 ":login" => $username
//             ]);
//             header("Location: {$dashboard_path}?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
//             exit(); //Permet de couper php
//         }else {
//             $erreur = 'Identifiants incorrects !';
//         }
?>
