<?php

session_start();

if (isset($_POST["enviar"])) {

    var_dump($_POST["enviar"]);
    var_dump($_POST["nombre"]);
    var_dump($_POST["moneda"]);
    var_dump($_POST["descripcion"]);

    $dades = [
        [$_POST["nombre"], $_POST["moneda"], $_POST["descripcion"]]
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
    } catch (PDOException $ex) {
        $pdo->rollBack();
        echo 'Error ' . $ex->getMessage();
    } finally {
        $pdo = null;
    }
}
