<?php
session_start();
include('../config.php');

// 1. TURVAKONTROLL: Ainult admin pääseb ligi
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$msg = "";

// 2. ANDMETE TÖÖTLUS (Enne HTML-i väljastamist)
if (!empty($_POST)) {
    // Puhastame sisendi
    $mark = mysqli_real_escape_string($yhendus, $_POST['mark']);
    $model = mysqli_real_escape_string($yhendus, $_POST['model']);
    $engine = mysqli_real_escape_string($yhendus, $_POST['engine']);
    $fuel = mysqli_real_escape_string($yhendus, $_POST['fuel']);
    $price = mysqli_real_escape_string($yhendus, $_POST['price']);
    $year = mysqli_real_escape_string($yhendus, $_POST['year']);
    $transmission = mysqli_real_escape_string($yhendus, $_POST['transmission']);
    $seats = mysqli_real_escape_string($yhendus, $_POST['seats']);
    $description = mysqli_real_escape_string($yhendus, $_POST['description']);
    $status = mysqli_real_escape_string($yhendus, $_POST['status']);

    $sql = "INSERT INTO cars (mark, model, engine, fuel, price, year, transmission, seats, description, status) 
            VALUES ('$mark', '$model', '$engine', '$fuel', '$price', '$year', '$transmission', '$seats', '$description', '$status')";

    $valjund = mysqli_query($yhendus, $sql);

    if (mysqli_affected_rows($yhendus) == 1) {
        header("Location: index.php?msg=lisatud");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Viga lisamisel: " . mysqli_error($yhendus) . "</div>";
    }
}

include('../header.php');
?>

<div class="container mt-4">
    <div class="card shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-body">
            <h2 class="mb-4">Auto lisamine</h2>
            <?php echo $msg; ?>
            
            <form action="lisa.php" method="post">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Mark</label>
                        <input type="text" class="form-control" name="mark" required>
                        
                        <label class="form-label mt-2">Mudel</label>
                        <input type="text" class="form-control" name="model" required>
                        
                        <label class="form-label mt-2">Mootor</label>
                        <input type="text" class="form-control" name="engine">
                        
                        <label class="form-label mt-2">Kütus</label>
                        <select name="fuel" class="form-select">
                            <option value="bensiin">Bensiin</option>
                            <option value="diisel">Diisel</option>
                            <option value="elekter">Elekter</option>
                        </select>
                        
                        <label class="form-label mt-2">Hind (€/päev)</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    
                    <div class="col-sm-6">
                        <label class="form-label">Aasta</label>
                        <input type="number" class="form-control" name="year" value="2024">
                        
                        <label class="form-label mt-2">Käigukast</label>
                        <select name="transmission" class="form-select">
                            <option value="automaat">Automaat</option>
                            <option value="manuaal">Manuaal</option>
                        </select>
                        
                        <label class="form-label mt-2">Istmete arv</label>
                        <input type="number" class="form-control" name="seats" value="5">
                        
                        <label class="form-label mt-2">Muu info</label>
                        <input type="text" class="form-control" name="description">
                        
                        <label class="form-label mt-2">Olek</label>
                        <select name="status" class="form-select">
                            <option value="vaba">Vaba</option>
                            <option value="hoolduses">Hoolduses</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-5">Salvesta auto</button>
                    <a href="index.php" class="btn btn-outline-secondary">Tühista</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>