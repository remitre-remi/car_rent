<?php 
    session_start();
    include('../config.php');

    // 1. TURVAKONTROLL
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../index.php");
        exit();
    }

    $msg = "";

    // 2. ANDMETE UUENDAMINE (Seda teeme ENNE igasugust HTML väljastust)
    if(isset($_POST["updateid"])){
        $id = intval($_POST["updateid"]);
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

        $paring = "UPDATE cars SET 
                    mark = '$mark', 
                    model = '$model', 
                    engine = '$engine', 
                    fuel = '$fuel', 
                    price = '$price', 
                    year = '$year', 
                    transmission = '$transmission', 
                    seats = '$seats', 
                    description = '$description', 
                    status = '$status' 
                  WHERE id = $id";

        if (mysqli_query($yhendus, $paring)) {
            header("Location: index.php?msg=uuendatud");
            exit();
        } else {
            $msg = "<div class='alert alert-danger'>Viga uuendamisel: " . mysqli_error($yhendus) . "</div>";
        }
    }

    // 3. ANDMETE PÄRIMINE VORMI TÄITMISEKS
    if(isset($_GET["editid"])){
        $id = intval($_GET["editid"]);
        $paring = "SELECT * FROM cars WHERE id=$id";
        $valjund = mysqli_query($yhendus, $paring);
        $rida = mysqli_fetch_assoc($valjund);
    } else if(!isset($_POST["updateid"])) {
        header("Location: index.php");
        exit();
    }

    include('../header.php'); 
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Muuda auto andmeid</h2>
            <?php echo $msg; ?>
            
            <form action="muuda.php" method="post">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <input type="hidden" name="updateid" value="<?= $rida['id']; ?>">

                        <label for="mark" class="form-label">Mark</label>
                        <input type="text" class="form-control" id="mark" name="mark" value="<?= $rida['mark']; ?>" required>
                        
                        <label for="model" class="form-label mt-2">Mudel</label>
                        <input type="text" class="form-control" id="model" name="model" value="<?= $rida['model']; ?>" required>
                        
                        <label for="engine" class="form-label mt-2">Mootor</label>
                        <input type="text" class="form-control" id="engine" name="engine" value="<?= $rida['engine']; ?>">
                        
                        <label for="fuel" class="form-label mt-2">Kütus</label>
                        <input type="text" class="form-control" id="fuel" name="fuel" value="<?= $rida['fuel']; ?>">
                        
                        <label for="price" class="form-label mt-2">Hind (€/päev)</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= $rida['price']; ?>" required>
                    </div>
                    
                    <div class="col-sm-6">
                        <label for="year" class="form-label">Aasta</label>
                        <input type="number" class="form-control" id="year" name="year" value="<?= $rida['year']; ?>">
                        
                        <label for="transmission" class="form-label mt-2">Käigukast</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" value="<?= $rida['transmission']; ?>">
                        
                        <label for="seats" class="form-label mt-2">Istmete arv</label>
                        <input type="number" class="form-control" id="seats" name="seats" value="<?= $rida['seats']; ?>">
                        
                        <label for="description" class="form-label mt-2">Muu info</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?= $rida['description']; ?>">
                        
                        <label for="status" class="form-label mt-2">Olek</label>
                        <select class="form-select" name="status">
                            <option value="vaba" <?= ($rida['status'] == 'vaba') ? 'selected' : ''; ?>>Vaba</option>
                            <option value="renditud" <?= ($rida['status'] == 'renditud') ? 'selected' : ''; ?>>Renditud</option>
                            <option value="hoolduses" <?= ($rida['status'] == 'hoolduses') ? 'selected' : ''; ?>>Hoolduses</option>
                        </select>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5">Salvesta muudatused</button>
                        <a href="index.php" class="btn btn-outline-secondary">Tühista</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>