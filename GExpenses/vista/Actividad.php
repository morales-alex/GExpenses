<?php

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

//echo $_GET["id"];

//$Actividad = getActividad($_GET["id"]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php include_once './Header.php' ?>

<body>

    <div id="contenidoActividad">



        <div id="actividadMain">

            <h1 id="tituloActividad">Viaje al congo</h1>


            <div id="gastoWrapper">

                <div id="gasto">
                    <p id="nombreGasto">Buceo Guiado</p>
                    <p>Pagado por:</p>
                    <p>Alfonso Fernández</p>

                    <p id="precioGasto">390.20€</p>
                </div>

                <div id="gasto">
                    <p id="nombreGasto">Buceo Guiado</p>
                    <p>Pagado por:</p>
                    <p>Alfonso Fernández</p>

                    <p id="gasto">390.20€</p>
                </div>

                <div id="gasto">
                    <p id="nombreGasto">Buceo Guiado</p>
                    <p>Pagado por:</p>
                    <p>Alfonso Fernández</p>

                    <p id="precioGasto">390.20€</p>
                </div>

                <div id="gasto">
                    <p id="nombreGasto">Buceo Guiado</p>
                    <p>Pagado por:</p>
                    <p>Alfonso Fernández</p>

                    <p id="precioGasto">390.20€</p>
                </div>

                <div id="gasto">
                    <p id="nombreGasto">Buceo Guiado</p>
                    <p>Pagado por:</p>
                    <p>Alfonso Fernández</p>

                    <p id="precioGasto">390.20€</p>
                </div>


            </div>


        </div>

        <div id="linea"></div>

        <div id="participantes">
            <div id="tituloParticipantes">
                <h2>Participantes</h2>
                <a href="" id="addParticipantes">+</a>
            </div>

            <p id="participante">Alfonso99 [ correo@correo.com ]</p>
            <p id="participante">Alfonso99 [ correo@correo.com ]</p>
            <p id="participante">Alfonso99 [ correo@correo.com ]</p>
            <p id="participante">Alfonso99 [ correo@correo.com ]</p>
        </div>



    </div>

</body>

<?php include_once './Footer.php' ?>

<script src="../script/actividad.js"></script>

</html>


<?php

function getActividad()
{
}

?>