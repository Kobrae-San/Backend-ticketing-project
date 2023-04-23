<?php
session_start();
$token = 'null';
header('Location: billetterie-dashboard.php?your_token=' . $token);
exit();
