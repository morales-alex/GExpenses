<?php

if(session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

?>

<header>
    <nav>
        <div id="opcionesBox">
            <img id="logo" src="../img/LOGO_ESTIRADO.png" alt="Logo cabecera">
            <div class="opcion"><a href="./home.php">Actividades</a></div>
            <div class="opcion">Invitaciones</div>
            <div class="opcion">Social</div>
            <div class="opcion">Glosario</div>
        </div>

        <a id="usuario"> <?php echo $_SESSION['usuario'] ?> </a>
    </nav>
</header>