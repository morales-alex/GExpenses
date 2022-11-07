<?php

if (!empty($_POST["login"])) {
    session_start();
    $username = $_POST["user_name"];
    $password = $_POST["password"];
    
    if ($username === '123' AND $password === '123') {
        
        $_SESSION["errorMessage"] = "Credenciales Inválidos!";
        header("Location: ./index.php");
    } else {
        header("Location: ./login.php");
    }
}
