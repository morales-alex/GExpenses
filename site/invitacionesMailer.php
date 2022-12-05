<?php

require '../GExpenses/compruebaEmail.php';
require '../GExpenses/controlador/BbddConfig.php';

$emails = array("freixa.abcd.max@alumnat.copernic.cat", "correofalso@gmail.com");

var_dump($emails);

echo '<br><br>';

foreach ($emails as $comprovar => $values) {
    var_dump($values);
    var_dump(compruebaEmail($values, $pdo));
    echo '<br>';
}


//var_dump($emails);


