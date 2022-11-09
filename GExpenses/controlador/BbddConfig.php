<?php
    try {
        $pdo = new PDO('sqlsrv:server=DESKTOP-5M44N70\SQLEXPRESS;database=GExpenses_3P1');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo 'Error de conexió: ' . $ex->getMessage();
        exit;
    }