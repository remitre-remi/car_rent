<?php 
include('config.php'); 
include('header.php'); // Kasutame ühist päist, et menüü oleks igal pool sama

$id = mysqli_real_escape_string($yhendus, $_GET['id']);
$paring = "SELECT * FROM cars WHERE id='$id'";
$valjund = mysqli_query($yhendus, $paring);
$rida = mysqli_fetch_assoc($valjund);

// Kui autot ei leita
if (!$rida) {
    die("Autot ei leitud!");
}
?>

<div class="container mt-4">
    <a href="index.php" class="btn btn-outline-dark mb-4">← Tagasi valikusse</a>

    <div class="row">
        <div class="col-md-6">
            <h1><?php echo $rida["mark"] . " " . $rida["model"]; ?></h1>
            <hr>
            <div class="row">
                <div class="col-6">
                    <p><strong>Aasta:</strong> <?php echo $rida["year"]; ?></p>
                    <p><strong>Käigukast:</strong> <?php echo $rida["transmission"]; ?></p>
                    <p><strong>Kütus:</strong> <?php echo $rida["fuel"]; ?></p>
                </div>
                <div class="col-6">
                    <p><strong>Mootor:</strong> <?php echo $rida["engine"]; ?></p>
                    <p><strong>Istmeid:</strong> <?php echo $rida["seats"]; ?></p>
                    <p><strong>Päevahind:</strong> <span id="pricePerDay"><?php echo $rida["price"]; ?></span>€</p>
                </div>
            </div>

            <div class="card bg-light p-4 mt-4">
                <h4 class="mb-3">Broneeri see auto</h4>
                
                <?php
                // BRONEERIMISE LOOGIKA
                if (isset($_POST['book_now'])) {
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];
                    $user_id = $_SESSION['user_id'];

                    // 1. KONTROLL: Kas kuupäevad on loogilised?
                    if ($start_date >= $end_date) {
                        echo "<div class='alert alert-danger'>Lõppkuupäev peab olema hilisem kui algus!</div>";
                    } else {
                        // 2. KONTROLL: Topeltbroneeringu vältimine
                        $check_query = "SELECT * FROM bookings 
                                      WHERE car_id = '$id' 
                                      AND NOT (end_date < '$start_date' OR start_date > '$end_date')";
                        $check_res = mysqli_query($yhendus, $check_query);

                        if (mysqli_num_rows($check_res) > 0) {
                            echo "<div class='alert alert-danger'>See auto on nendel kuupäevadel juba kinni!</div>";
                        } else {
                            // 3. SALVESTAMINE
                            $insert = "INSERT INTO bookings (car_id, user_id, start_date, end_date) 
                                      VALUES ('$id', '$user_id', '$start_date', '$end_date')";
                            if (mysqli_query($yhendus, $insert)) {
                                echo "<div class='alert alert-success'>Broneering õnnestus!</div>";
                            }
                        }
                    }
                }
                ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Alguskuupäev</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lõppkuupäev</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    
                    <div id="totalPriceSection" class="mb-3 p-2 bg-white border rounded d-none">
                        <strong>Kogumaksumus: </strong> <span id="totalPrice">0</span> €
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button type="submit" name="book_now" class="btn btn-dark btn-lg w-100">Kinnita broneering</button>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-warning w-100">Logi sisse, et broneerida</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="col-md-6 text-center">
            <img src="https://loremflickr.com/800/500/<?php echo str_replace(" ","", $rida["mark"]); ?>,car/all" class="img-fluid rounded shadow" alt="Auto pilt">
        </div>
    </div>
</div>

<script>
const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');
const totalPriceSpan = document.getElementById('totalPrice');
const totalPriceSection = document.getElementById('totalPriceSection');
const pricePerDay = <?php echo $rida["price"]; ?>;

function calculatePrice() {
    if (startInput.value && endInput.value) {
        const start = new Date(startInput.value);
        const end = new Date(endInput.value);
        
        if (end > start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            totalPriceSpan.innerText = diffDays * pricePerDay;
            totalPriceSection.classList.remove('d-none');
        } else {
            totalPriceSection.classList.add('d-none');
        }
    }
}

startInput.addEventListener('change', calculatePrice);
endInput.addEventListener('change', calculatePrice);
</script>

</body>
</html>