<?php
require '../inc/functions.php';
require '../inc/pdo.php';
session_start();

$title = "Acceuil";
$website_part = "Billetterie";

$style_ticketing_path = "./styles/ticketing.css";
$show_ticket_path = "./tickets/show-ticket.php";
$submit_ticket_path = "./tickets/submit-ticket.php";
$login_path = "./connection/login.php";
$logout_path = "./connection/logout.php";
$event_management_path = "./events/create-modify-delete-events.php";
$visitor_management_path = "./events/add-remove-visitors.php";
$events_path = "./events/show-event-visitors.php"; 

$my_token = $_GET['your_token'];
$check = token_check($my_token, $auth_pdo);
if(!$check){
    header("Location: ../dashboard.php");
    exit();
}

?>

<?php include '../inc/tpl/header_ticketing.php'; ?>

  </body>
</html>