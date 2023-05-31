<?php
    session_start();
    $title = "Connexion";
    $website_part = "Authentification";

    $style_login_path = "../styles/login_register.css";
    $style_ticketing_path = "../styles/ticketing.css";
    $show_ticket_path = "../tickets/show-ticket.php";
    $submit_ticket_path = "../tickets/submit-ticket.php";
    $login_path = "./login.php";
    $logout_path = "./logout.php";
    $event_management_path = "../events/create-modify-delete-events.php";
    $visitor_management_path = "../events/add-remove-visitors.php";
    $events_path = "../events/show-event_visitors.php";


    $method = filter_input(INPUT_SERVER,'REQUEST_METHOD');
    $erreur = null;
    if($method == 'POST') {
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($username && $password) {
            $data = array(
                "login" => $username,
                "password" => $password
            );
            $json_data = json_encode($data);
            // Attention, c'est une URL, pas un chemin
            $ch = curl_init('http://localhost/Project-ticketing-final/authentification/register.php');
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

?>
<?php include '../../inc/tpl/header_authentification.php'; ?>
    <form method='POST'>
        <h2>Espace Administrateur - Inscription</h2>
       
        <input type='text' id='username' placeholder="Nom d'utilisateur" name='username'>

        <input type='password' id='passsword' placeholder="Mot de passe" name='password'>
        <input class="submit" type="submit" value="S'inscrire">
        <?php if ($erreur != null): ?>
        <p><?= $erreur ?></p>
        <?php endif; ?>
        <p>Déjà inscrit? <a href="./login.php">Se connecter</a></p>
    </form>
    
</body>
</html>