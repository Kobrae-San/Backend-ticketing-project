<?php

    session_start();
    require '../inc/pdo.php';
    $existing_user = "";
    
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    if ($data) {
        $username = $data['login'];
        $password = $data['password'];

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
                ':login' => $username,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            $requete_token = $auth_pdo->prepare("
            INSERT INTO token (token, user_id) VALUES (:token, LAST_INSERT_ID())
            ");
            
            $requete_token->execute([
                ':token' => ""
            ]);
            $response = array('statut' => 'Succès', 'message' => "Ajout d'utilisateur réussi.");
            echo json_encode($response);
        } else {
            $response = array('statut' => 'Erreur', 'message' => "Utilisateur déja existant.");
            echo json_encode($response);
        }
    } else {
        $response = array('statut' => 'Erreur', 'message' => "JSON incorrect");
        echo json_encode($response);
    }
?>