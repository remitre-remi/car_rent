<?php
session_start();
include('../config.php');

// 1. TURVAKONTROLL: Ainult admin saab kustutada
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// 2. KUSTUTAMISE LOOGIKA
if (!empty($_GET['delid'])) {
    // Muudame ID numbriks, et keegi ei saaks pahatahtlikku koodi sisestada
    $id = intval($_GET['delid']); 
    
    $paring = "DELETE FROM cars WHERE id=$id";
    $valjund = mysqli_query($yhendus, $paring);
    
    if ($valjund) {
        // Suuname tagasi nimekirja koos edusõnumiga
        header("Location: index.php?msg=1");
        exit(); // Alati pane exit() peale suunamist
    } else {
        echo "Viga kustutamisel: " . mysqli_error($yhendus);
    }   
} else {
    // Kui delid puudub, suuname lihtsalt tagasi
    header("Location: index.php");
    exit();
}
?>