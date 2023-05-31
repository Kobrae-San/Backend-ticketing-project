<?php

    $auth_engine = "mysql";

    $host = "localhost";

    $auth_port = 6385;
    $ticket_port = 8003;

    $auth_bdd = "railway";

    $ticket_bdd = "railway";

    $user = "root";
    
    $password_auth = "A4W2ioRdSwIzxXG62P01";
    $password_ticket = "1zGYSGUYuIfUcjv5O7HF";

    $host_auth = "containers-us-west-108.railway.app";
    $host_ticket = "containers-us-west-170.railway.app";


    $auth_dsn = "$auth_engine:host=$host_auth:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

    $ticket_dsn = "$auth_engine:host=$host_ticket:$ticket_port;dbname=$ticket_bdd";
    $ticket_pdo = new PDO($ticket_dsn, $user, $password_auth);
