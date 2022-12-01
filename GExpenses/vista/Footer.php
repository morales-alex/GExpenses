<?php

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./index.php');
}

?>

<footer>
    <div id="footer-container">
        <div class="footerBox">
            <div class="partIzq">
                <img id="logoFooter" src="../img/LOGO.png" alt="Logo pie de página">
                <span>COPYRIGHT © 2022</span>
            </div>
        </div>

        <div class="footerBox">
            <div class="medio">
                ENSURING MONEY PAYMENTS SINCE 2022
            </div>
        </div>

        <div class="footerBox">
            <div class="partDer">
                <div>Max Freixa</div>
                <div>Alex Morales</div>
                <div>Ale Algarra</div>
            </div>
        </div>
    </div>
</footer>