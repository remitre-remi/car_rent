<?php
session_start();
session_destroy(); // Kustutab kõik sessiooni andmed
header("Location: index.php"); // Suunab tagasi avalehele
exit();
?>