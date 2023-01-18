<?php

if(session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./index.php');
}

?>

<header>
    <nav>
        <div id="opcionesBox">
            <a href="./home.php"><img id="logo" src="../img/LOGO_ESTIRADO.png" alt="Logo cabecera"></a>
            
            <a href="./home.php">
            <div class="opcion">Actividades</div>
            </a>
        </div>

    
        <div class="opcionesUsuario">
        <a id="usuario"> <?php echo $_SESSION["usuario"]->getU_username(); ?> </a>
        <a href="./logout.php"><img class="logout" src="../img/logout.png" alt="Icono Logout"></a>
        </div>

    </nav>
</header>