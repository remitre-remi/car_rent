<?php
session_start();

// 1. Kontrollime rolli (meie süsteemis on selleks 'role', mitte 'tuvastamine')
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

include('../config.php');
include('../header.php');
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Adminni ala - Autode haldus</h2>
        <a href="lisa.php" class="btn btn-success shadow-sm">+ Lisa uus auto</a>
    </div>

    <?php
    // Sõnumite kuvamine (kui kustutamine või lisamine õnnestus)
    if(isset($_GET['msg'])){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Tegevus õnnestus!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Mark</th>
                        <th>Mudel</th>
                        <th>Aasta</th>
                        <th>Kütus</th>
                        <th>Käigukast</th>
                        <th>Hind/p</th>
                        <th>Staatus</th>
                        <th class="text-end">Tegevused</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Päring kõigi autode saamiseks
                    $paring = "SELECT * FROM cars";
                    
                    if (!empty($_GET["otsi"])) {
                        $otsing = mysqli_real_escape_string($yhendus, $_GET["otsi"]);
                        $paring .= " WHERE mark LIKE '%$otsing%' OR model LIKE '%$otsing%'";
                    } 
                    
                    $valjund = mysqli_query($yhendus, $paring);

                    while($rida = mysqli_fetch_assoc($valjund)){ 
                ?>
                    <tr>
                        <th scope="row"><?php echo $rida["id"]; ?></th>
                        <td><?php echo $rida["mark"]; ?></td>
                        <td><?php echo $rida["model"]; ?></td>
                        <td><?php echo $rida["year"]; ?></td>
                        <td><?php echo $rida["fuel"]; ?></td>
                        <td><?php echo $rida["transmission"]; ?></td>
                        <td><strong><?php echo $rida["price"]; ?>€</strong></td>
                        <td>
                            <span class="badge <?php echo ($rida['status'] == 'vaba') ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                <?php echo $rida["status"]; ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="muuda.php?editid=<?php echo $rida["id"]; ?>" class="btn btn-sm btn-outline-warning">Muuda</a>
                                <a href="kustuta.php?delid=<?php echo $rida["id"]; ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Kas oled kindel, et soovid selle auto kustutada?')">Kustuta</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="index.php" class="btn btn-outline-dark">Värskenda nimekirja</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>