<?php
session_start();
$json = $_SESSION['data'];
require '../inc/pdo.php';
require '../inc/functions.php';
$data = json_decode($json, true);
$_SESSION['send'] = true;

$username = $data['username'];
$password = $data['password'];

$requete = $auth_pdo->prepare("
    SELECT * FROM users WHERE login = :login
    ");
    $requete->bindParam(':login', $username, PDO::PARAM_STR);
    $requete->execute();
    $result = $requete->fetch(PDO::FETCH_ASSOC);
    if(password_verify($password, $result["password"])){
        $token = token();
        $_SESSION['username'] = $username;
        $_SESSION['token'] = $token;
        $requete_token = $auth_pdo->prepare("
        UPDATE token SET token = :token WHERE token.user_id = (SELECT id FROM users WHERE login = :login);
        ");
        $requete_token->bindParam(":token", $token, PDO::PARAM_STR);
        $requete_token->bindParam(":login", $login, PDO::PARAM_STR);
        $requete_token->execute();
        $data = array(
            'statut' => "Succès",
            'message' => $token
        );
        $json = json_encode($data);
        $_SESSION['data'] = $json;
        header("HTTP/1.1 200 OK");
    }elseif (!password_verify($password, $result['password'])){
        $data = array(
            'statut' => "Erreur",
            'message' => $token
        );
        $json = json_encode($data);
        $_SESSION['data'] = $json;
        
    }


    header('Location: ../ticketing/connection/login.php');
    exit(); //Permet de couper php
