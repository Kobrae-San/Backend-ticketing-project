<?php 


    function token()
    {
        $token = [];
        for ($i = 1; $i <= 30; $i++) {
            $random = rand(48, 122);
            $str = chr($random);
            $token[] = $str;
        }
        $token = implode($token);
        return $token;
    }


    function public_code()
    {
        $public_code = [];
        for ($i = 1; $i <= 30; $i++) {
            $random = rand(48, 122);
            if (($random >= 58 && $random <= 64) || ($random >= 91 && $random <= 96)) {
                $i--;
            } else {
                $str = chr($random);
                $public_code[] = $str;
            }
        }
        $public_code = implode($public_code);
        return $public_code;
    }

    
    function private_id()
    {
        $private_id = [];
        for ($i = 1; $i <= 10 ; $i++) {
            $random = rand(48, 90);
            if (($random >= 58 && $random <= 64)) {
                $i--;
            } else {
                $str = chr($random);
                $private_id[] = $str;
            }
        }
        $private_id = implode($private_id);
        return $private_id;
    }

    
    function token_check($token, $pdo)
    {
        $requete = $pdo->prepare("
        SELECT token FROM token WHERE token = :token;
        ");
        $requete->execute([
            ":token" => $token
        ]);
        $check_token = $requete->fetch(PDO::FETCH_ASSOC);
        return $check_token;
    }