<?php
session_start();
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

require '../../vendor/autoload.php';
require '../../inc/pdo.php';

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
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if($method == "POST"){
    $client = new \GuzzleHttp\Client();

    $data = [
        'username' => $username,
        'password' => $password
    ];

    $json = json_encode($data);

    $response = $client->post('http://localhost/Backend-ticketing-project/authentification/login.php', [
        'body' => $json
    ]);
    $data = json_decode($response->getBody(), true);
    $_SESSION['username'] = $username;
    if ($data['statut'] == 'Succès'){
        $_SESSION['token'] = $data['message'];
        header("Location: ../dashboard.php?your_token={$_SESSION['token']}&username={$_SESSION['username']}");
        exit();
    }elseif ($data['statut'] == 'Erreur'){
        $erreur = true;
   }
 }

?>

<?php include '../../inc/tpl/header_authentification.php'; ?>

            <form method='POST'>
               <h2>Espace Administrateur - <?= $title ?></h2>
                <input type='text' id='username' placeholder="Nom d'utilisateur" name='username' required>
                <input type='password' id='passsword' placeholder="Mot de passe" name='password' required>
                <?php if (isset($erreur)) { ?>
                <p>Nom d'utilisateur ou mot de passe incrorrect. Veuillez réessayez.</p>
               <?php }
                ?>
                <input class="submit" type="submit" value="Connexion" name="submit">
                <p>Pas encore inscrit? <a href="./register.php">S'inscrire</a></p>
            </form>
           
    </div>
</script>
</body>
</html>