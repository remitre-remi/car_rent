<?php 
    include('config.php'); 
    include('header.php'); 
?>

<div class="container">
    <h2 class="mb-4">Saadaolevad autod</h2>
    
    <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php
        // Algne päring
        $paring = "SELECT * FROM cars";
        
        // Turvaline otsing
        if (!empty($_GET["otsi"])) {
            // mysqli_real_escape_string takistab pahatahtliku koodi sisestamist otsingusse
            $otsing = mysqli_real_escape_string($yhendus, $_GET["otsi"]);
            $paring .= " WHERE mark LIKE '%$otsing%' OR model LIKE '%$otsing%'";
        } 
        
        $paring .= " LIMIT 8";
        $valjund = mysqli_query($yhendus, $paring);

        if (mysqli_num_rows($valjund) > 0) {
            while($rida = mysqli_fetch_assoc($valjund)) { 
        ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="https://loremflickr.com/400/250/<?php echo str_replace(" ","", $rida["mark"]); ?>,car/all" 
                         class="card-img-top" alt="<?php echo $rida["mark"]; ?>">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $rida["mark"]; ?> <?php echo $rida["model"]; ?></h5>
                        <p class="card-text">
                            <strong>Mootor:</strong> <?php echo $rida["engine"]; ?> <br>
                            <strong>Kütus:</strong> <?php echo $rida["fuel"]; ?><br>
                            <strong>Hind:</strong> <?php echo $rida["price"]; ?>€/päev
                        </p>
                        
                        <div class="mt-auto">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="single_car.php?id=<?php echo $rida["id"]; ?>" class="btn btn-dark w-100">Rendi kohe</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-secondary w-100">Logi sisse, et rentida</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<div class='col-12'><p class='alert alert-warning'>Autosid ei leitud.</p></div>";
        }
        ?>
    </div>
</div>

<?php 
// Me ei vaja siia enam JS linke, need on header.php-s
?>
</body>
</html>