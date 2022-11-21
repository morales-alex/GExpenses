<?php

session_start();

if (isset($_POST)) {


    $dades = [htmlentities($_POST["nombre"]), comprobarMoneda($_POST["moneda"]), htmlentities($_POST["descripcion"])];

    if ($dades[1] !== 'Error') {

        require '../controlador/BbddConfig.php';

        try {

            $sql = "INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) 
                        VALUES (:a_nombre, :a_moneda, :a_descripcion, sysdate(), sysdate())";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':a_nombre', $dades[0]);
            $stmt->bindParam(':a_moneda', $dades[1]);
            $stmt->bindParam(':a_descripcion', $dades[2]);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            $stmt->execute();

            $pdo->commit();

            $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
            header("Location: $referer");
        } catch (PDOException $ex) {
            $pdo->rollBack();
            $referer = $_SERVER['HTTP_REFERER']; // Redirige a la página donde se ecuentra
            header("Location: $referer");
        } finally {
            $pdo = null;
        }
    } else {
        $_SESSION["mensajeError"] = "Tipo de moneda no valida";
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    }
}

function comprobarMoneda($moneda)
{
    switch ($moneda) {
        case '€':
            return 'EUR';
            break;
        case '$':
            return 'USD';
            break;
        default:
            return 'Error';
            break;
    }
}
