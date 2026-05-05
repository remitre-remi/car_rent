<?php 
    include('config.php'); 
    include('header.php'); // Veendu, et siin on session_start() sees!
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Saadaolevad autod</h2>
        <form class="d-flex" method="get" action="index.php">
            <input name="otsi" class="form-control me-2" type="search" placeholder="Otsi marki või mudelit..." aria-label="Search" value="<?php echo isset($_GET['otsi']) ? htmlspecialchars($_GET['otsi']) : ''; ?>">
            <button class="btn btn-outline-dark" type="submit">Otsi</button>
        </form>
    </div>
    
    <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php
        // Algne päring - lisame tingimuse, et näidatakse ainult VABU autosid
        $paring = "SELECT * FROM cars WHERE status = 'vaba'";
        
        if (!empty($_GET["otsi"])) {
            $otsing = mysqli_real_escape_string($yhendus, $_GET["otsi"]);
            // Kuna meil on juba WHERE status='vaba', lisame otsingu AND-iga
            $paring .= " AND (mark LIKE '%$otsing%' OR model LIKE '%$otsing%')";
        } 
        
        $paring .= " ORDER BY id DESC LIMIT 8";
        $valjund = mysqli_query($yhendus, $paring);

        if (mysqli_num_rows($valjund) > 0) {
            while($rida = mysqli_fetch_assoc($valjund)) { 
        ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <?php 
                        $pilt = !empty($rida['image']) ? "img/".$rida['image'] : "https://loremflickr.com/400/250/car,".str_replace(" ","", $rida["mark"]);
                    ?>
                    <img src="https://loremflickr.com/400/250/car,<?php echo str_replace(' ', '', $rida['mark']); ?>" 
                        class="card-img-top" 
                        alt="<?php echo $rida["mark"]; ?>"
                        style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title"><?php echo $rida["mark"]; ?></h5>
                            <span class="badge bg-success text-white mb-2" style="height: fit-content;">Vaba</span>
                        </div>
                        <h6 class="text-muted"><?php echo $rida["model"]; ?></h6>
                        
                        <p class="card-text mt-2 mb-4">
                            <small class="text-muted">
                                ⛽ <?php echo $rida["fuel"]; ?> | ⚙️ <?php echo $rida["transmission"]; ?> <br>
                                👥 <?php echo $rida["seats"]; ?> kohta
                            </small>
                            <br>
                            <span class="h4 text-primary"><?php echo $rida["price"]; ?>€</span><small>/päev</small>
                        </p>
                        
                        <div class="mt-auto">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="single_car.php?id=<?php echo $rida["id"]; ?>" class="btn btn-dark w-100 py-2">Vaata ja rendi</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-dark w-100">Logi sisse</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<div class='col-12'><div class='alert alert-info shadow-sm'>Hetkel vabu autosid ei leitud või otsingule vasted puuduvad.</div></div>";
        }
        ?>
    </div>
</div>

</body>
</html>