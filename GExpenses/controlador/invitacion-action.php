<?php
require '../controlador/BbddConfig.php';
require '../modelo/tablesMap.php';
//$dadesInvitacion=[[]];
session_start();
try{
    $sql = "INSERT INTO Invitaciones(i_idUsu, i_idAct, i_correoUsuarioInvitado)
                VALUES (:i_idUsu, :i_idAct, :i_correoUsuarioInvitado)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':i_idUsu', $_SESSION["usuario"]->getU_id());
    $stmt->bindParam('i_idAct', $_SESSION['actividad_id']);
    $stmt->bindParam(':i_correoUsuarioInvitado',$email);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $stmt->execute();

    $pdo->commit();

    $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
    header("Location: $referer");

}catch (PDOException $ex) {
    $pdo->rollBack();
    $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
    header("Location: $referer");
} finally {
    $pdo = null;
}
