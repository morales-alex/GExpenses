<?php
    try {
        /*Vagrant*/ //$pdo = new PDO('mysql:dbname=GExpenses_3P1;host=192.168.1.1', 'admin', 'mamadol');
        /*Ale*/$pdo = new PDO('mysql:dbname=GExpenses_3P1;host=127.0.0.1', 'root', '123456');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo 'Error de conexió: ' . $ex->getMessage();
        exit;
    }