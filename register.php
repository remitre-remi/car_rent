<?php 
    include('config.php'); 
    include('header.php'); 
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Loo uus konto</h2>
                    
                    <?php
                    if (isset($_POST['submit'])) {
                        $fname = mysqli_real_escape_string($yhendus, $_POST['first_name']);
                        $lname = mysqli_real_escape_string($yhendus, $_POST['last_name']);
                        $email = mysqli_real_escape_string($yhendus, $_POST['email']);
                        $phone = mysqli_real_escape_string($yhendus, $_POST['phone']);
                        $pass  = $_POST['password'];

                        // 1. Kontrolli, ega e-mail juba olemas pole
                        $kontroll = mysqli_query($yhendus, "SELECT id FROM users WHERE email='$email'");
                        
                        if (mysqli_num_rows($kontroll) > 0) {
                            echo "<div class='alert alert-danger'>See e-mail on juba registreeritud!</div>";
                        } else {
                            // 2. Parooli räsimine (Ülesande turvanõue!)
                            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                            // 3. Andmete sisestamine
                            $sql = "INSERT INTO users (first_name, last_name, email, phone, password_hash, role) 
                                    VALUES ('$fname', '$lname', '$email', '$phone', '$hashed_pass', 'customer')";
                            
                            if (mysqli_query($yhendus, $sql)) {
                                echo "<div class='alert alert-success'>Kasutaja loodud! <a href='login.php'>Logi nüüd sisse</a></div>";
                            } else {
                                echo "<div class='alert alert-danger'>Viga: " . mysqli_error($yhendus) . "</div>";
                            }
                        }
                    }
                    ?>

                    <form method="post" action="register.php">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Eesnimi</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Perekonnanimi</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-post</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parool</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100 py-2">Registreeru</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Siia alla ei pea midagi lisama, sest headeris on body avatud
?>