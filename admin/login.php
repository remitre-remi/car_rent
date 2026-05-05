<?php 
    session_start(); 
    include('config.php'); // Veendu, et tee on õige (kui fail on peakaustas, siis config.php)
?>
<!doctype html>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sisselogimine - Autorent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">

<?php
    $msg = "";

    if (!empty($_POST)) {
        // Kasutame e-posti, sest sinu SQL-is on UNIQUE KEY 'email'
        $email = mysqli_real_escape_string($yhendus, $_POST['email']);
        $password = $_POST['password'];

        // Päring vastavalt sinu uue tabeli struktuurile
        $paring = "SELECT id, email, password_hash, role, first_name FROM users WHERE email='$email'";
        $valjund = mysqli_query($yhendus, $paring);
        $rida = mysqli_fetch_assoc($valjund);

        if ($rida) {
            // Kontrollime parooli räsi
            if (password_verify($password, $rida['password_hash'])) {
                // Salvestame olulised andmed sessiooni
                $_SESSION['user_id'] = $rida['id'];
                $_SESSION['user_name'] = $rida['first_name'];
                $_SESSION['role'] = $rida['role']; // 'customer' või 'admin'
                
                // Suunamine vastavalt rollile
                if ($rida['role'] === 'admin') {
                    header("Location: admin_index.php"); // Või sinu admini pealeht
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
                                <input name="email" type="email" class="form-control" id="e" required placeholder="nimi@eesti.ee">
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