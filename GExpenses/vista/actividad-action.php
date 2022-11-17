<?php

session_start();

if (isset($_POST["enviar"])) {

    $dades = [
        [htmlentities($_POST["nombre"]), htmlentities($_POST["moneda"]), htmlentities($_POST["descripcion"])]
    ];

    require '../controlador/BbddConfig.php';

    $sql = "INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion) VALUES (:a_nombre, :a_moneda, :a_descripcion)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':a_nombre', $nomActivitat);
    $stmt->bindParam(':a_moneda', $monedaActivitat);
    $stmt->bindParam(':a_descripcion', $descripcioActivitat);

    try {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();

        foreach ($dades as $reg) {
            $nomActivitat = $reg[0];
            $monedaActivitat = $reg[1];
            $descripcioActivitat = $reg[2];

            $stmt->execute();
        }
        $pdo->commit();

        $_SESSION["mensajeError"] = "Actividad añadida correctamente.";
        $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
        header("Location: $referer");
        
    } catch (PDOException $ex) {
        $pdo->rollBack();
        $_SESSION["mensajeError"] = "Actividad no añadida, revisa los campos.";
        $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
        header("Location: $referer");
        echo 'Error ' . $ex->getMessage();
    } finally {
        $pdo = null;
    }
}
