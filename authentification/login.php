<?php
    session_start();
    require '../inc/pdo.php';
    require '../inc/functions.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $username = $data["username"];
    $password = $data["password"];

    $requete = $auth_pdo->prepare("
        SELECT * FROM users WHERE login = :login
        ");
        $requete->execute([
            ":login" => $username
        ]);
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        if($result){
            if(password_verify($password, $result["password"])){
                $token = token();
                $_SESSION['username'] = $username;
                $_SESSION['token'] = $token;
                $requete_token = $auth_pdo->prepare("
                UPDATE token SET token = :token WHERE token.user_id = (SELECT id FROM users WHERE login = :login);
                ");
                $requete_token->execute([
                    ":token" => $token,
                    ":login" => $username
                ]);
                $data = array(
                    'statut' => "Succès",
                    'message' => $token
                );
                $json = json_encode($data);
                echo $json;
                exit();
            }else{
                $data = array(
                    'statut' => "Erreur",
                    'message' => 'Mot de passe incorrect'
                );
                $json = json_encode($data);
                echo $json;
                exit();
            }
        }else{
            $data = array(
                'statut' => "Erreur",
                'message' => "L'utilisateur n'existe pas."
            );
            $json = json_encode($data);
            echo $json;
            exit();
        }