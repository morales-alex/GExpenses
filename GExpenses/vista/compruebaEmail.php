<?php
function compruebaEmail($correo, $pdo) {


try {
    $sql = "SELECT u_correo FROM Usuarios where u_correo = :u_correo";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':u_correo', $correo);

    $stmt->execute();
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if($datos == false) {
        return false;
    } else {
        return true;
    }
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}
}