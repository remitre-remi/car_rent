<?php 
    // 1. KÕIGEPEALT LOOGIKA (Ei tohi olla ühtegi tühikut ega HTML-i enne seda!)
    include('config.php'); 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $msg = "";

    if (!empty($_POST)) {
        $email = mysqli_real_escape_string($yhendus, $_POST['email']);
        $password = $_POST['password'];

        $paring = "SELECT id, email, password_hash, role, first_name FROM users WHERE email='$email'";
        $valjund = mysqli_query($yhendus, $paring);
        $rida = mysqli_fetch_assoc($valjund);

        if ($rida) {
            if (password_verify($password, $rida['password_hash'])) {
                $_SESSION['user_id'] = $rida['id'];
                $_SESSION['user_name'] = $rida['first_name'];
                $_SESSION['role'] = $rida['role'];
                
                // Nüüd header() töötab, sest me pole veel HTML-i saatnud!
                if ($rida['role'] === 'admin') {
                    header("Location: admin/index.php"); 
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $msg = "<div class='alert alert-danger'>Vale parool!</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Kasutajat ei leitud!</div>";
        }
    }

    // 2. ALLES NÜÜD TULEB VISUAALNE POOL
    include('header.php'); 
?>

<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Logi sisse</h3>
                    <form method="post" action="login.php" autocomplete="off">
                        <div class="mb-3">
                            <label for="e" class="form-label">E-post</label>
                            <input name="email" type="email" class="form-control" id="e" required>
                        </div>
                        <div class="mb-3">
                            <label for="p" class="form-label">Parool</label>
                            <input name="password" type="password" class="form-control" id="p" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Logi sisse</button>
                    </form>
                    <div class="mt-3 text-center">
                        <?php echo $msg; ?>
                        <hr>
                        <p>Pole kontot? <a href="register.php">Registreeru siin</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>