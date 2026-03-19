// *** Protseduuriline *** //
<?php
    // Sinu andmed
    $db_server = 'localhost';
    $db_andmebaas = 'car_rent';
    $db_kasutaja = 'Remi';
    $db_salasona = 'remi';


    // Ühendus andmebaasiga
    $yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);


    // Ühenduse kontroll
    if (!$yhendus) {
        die('Ei saa ühendust andmebaasiga');
    }
?>