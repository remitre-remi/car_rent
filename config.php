<?php
    // Dockeri keskkonnas on serveri nimeks teenuse nimi, mille määrasid docker-compose failis
    $db_server = 'db'; 
    $db_andmebaas = 'car_rent';
    $db_kasutaja = 'root'; // Docker-compose näites kasutasime 'root' kasutajat
    $db_salasona = 'rootpassword'; // See peab ühtima docker-compose MYSQL_ROOT_PASSWORD-iga

    // Ühendus andmebaasiga
    $yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);

    // Ühenduse kontroll
    if (!$yhendus) {
        // Lisame veateate, et näha täpset põhjust, kui ühendus ebaõnnestub
        die('Ei saa ühendust andmebaasiga: ' . mysqli_connect_error());
    }

    // Määrame tähestiku, et täpitähed (ä, ö, ü, õ) näidataks õigesti
    mysqli_set_charset($yhendus, "utf8mb4");
?>