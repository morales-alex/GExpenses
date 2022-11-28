<?php
    try {
        $pdo = new PDO('mysql:dbname=GExpenses_3P1;host=192.168.1.1', 'admin', 'mamadol');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo 'Error de conexió: ' . $ex->getMessage();
        exit;
    }