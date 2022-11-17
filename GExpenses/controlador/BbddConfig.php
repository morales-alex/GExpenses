<?php
    try {
        $pdo = new PDO('sqlsrv:server=DESKTOP-8NG2OQ8\SQLEXPRESS;database=GExpenses_3P1');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo 'Error de conexió: ' . $ex->getMessage();
        exit;
    }