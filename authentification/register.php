<?php

    session_start();
    require '../inc/pdo.php';
    $existing_user = "";
    
    $data = json_decode($_SESSION['data']);
    if ($data) {
        $username = $data->login;
        $password = $data->password;

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
            header('HTTP/1.1 200 OK');
            header('Location: ../ticketing/connection/login.php');
            exit();
        } elseif ($data == null) {
            header('HTTP/1.1 400 Bad Request');
            header('Location: ../connection/register.php');
            exit();
        }
    }
?>
