<?php

    // PARAMS
    
    $host = '127.0.0.1';
    $user = 'root';
    $password = "";
    $dbname = "paragraf";

    // SET DSN

    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

    // Create a PDO Instance
    
    $pdo = new PDO($dsn, $user, $password);
  