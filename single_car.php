<?php 
    include('config.php'); 
    include('header.php'); 

    // 1. Hankime auto andmed
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($yhendus, $_GET['id']);
        $paring = "SELECT * FROM cars WHERE id = '$id'";
        $valjund = mysqli_query($yhendus, $paring);
        $auto = mysqli_fetch_assoc($valjund);
        
        if (!$auto) {
            die("Autot ei leitud!");
        }
    } else {
        header("Location: index.php");
        exit();
    }

    // 2. Broneerimise loogika
    $msg = "";
    if (isset($_POST['book_now']) && isset($_SESSION['user_id'])) {
        $start_date = mysqli_real_escape_string($yhendus, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($yhendus, $_POST['end_date']);
        $user_id = $_SESSION['user_id'];
        $car_id = $auto['id'];

        // KONTROLL: Kas kuupäevad on loogilised?
        if ($start_date > $end_date) {
            $msg = "<div class='alert alert-danger'>Alguskuupäev ei saa olla hiljem kui lõppkuupäev!</div>";
        } else {
            // KONTROLL: Topeltbroneeringu vältimine (Ülesande nõue!)
            $check_sql = "SELECT id FROM reservations 
                          WHERE car_id = '$car_id' 
                          AND status != 'cancelled'
                          AND NOT (end_date < '$start_date' OR start_date > '$end_date')";
            
            $check_res = mysqli_query($yhendus, $check_sql);

            if (mysqli_num_rows($check_res) > 0) {
                $msg = "<div class='alert alert-danger'>Vabandust, see auto on valitud perioodil juba broneeritud!</div>";
            } else {
                // Arvutame hinna
                $d1 = new DateTime($start_date);
                $d2 = new DateTime($end_date);
                $paevad = $d1->diff($d2)->days + 1;
                $koguhind = $paevad * $auto['price'];

                // Salvestame broneeringu
                $sql = "INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status) 
                        VALUES ('$user_id', '$car_id', '$start_date', '$end_date', '$koguhind', 'pending')";
                
                if (mysqli_query($yhendus, $sql)) {
                    $msg = "<div class='alert alert-success'>Broneering tehtud! Hind kokku: $koguhind €</div>";
                }
            }
        }
    }
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="https://loremflickr.com/600/400/car,<?php echo str_replace(' ', '', $auto['mark']); ?>" class="img-fluid rounded shadow" alt="auto">
        </div>
        <div class="col-md-6">
            <h1><?php echo $auto['mark'] . " " . $auto['model']; ?></h1>
            <p class="lead"><?php echo $auto['description']; ?></p>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Aasta:</strong> <?php echo $auto['year']; ?></li>
                <li class="list-group-item"><strong>Kütus:</strong> <?php echo $auto['fuel']; ?></li>
                <li class="list-group-item"><strong>Käigukast:</strong> <?php echo $auto['transmission']; ?></li>
                <li class="list-group-item text-primary h4">Hind: <?php echo $auto['price']; ?>€ / päev</li>
            </ul>

            <?php echo $msg; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="card bg-light border-0 p-4">
                    <h5>Broneeri see auto</h5>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Algus</label>
                                <input type="date" name="start_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Lõpp</label>
                                <input type="date" name="end_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <button type="submit" name="book_now" class="btn btn-dark w-100">Kinnita broneering</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    Broneerimiseks pead olema <a href="login.php">sisse logitud</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>