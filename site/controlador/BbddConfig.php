<?php
    try {
        /*Vagrant*/ $pdo = new PDO('mysql:dbname=GExpenses_3P1;host=192.168.50.237', 'admin', '123');
        /*Ale*///$pdo = new PDO('mysql:dbname=GExpenses_3P1;host=127.0.0.1', 'root', '123');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->query('SET NAMES utf8');

    } catch (PDOException $ex) {
        echo 'Error de conexió: ' . $ex->getMessage();
        exit;
    }