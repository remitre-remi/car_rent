<?php include("config.php"); ?>
<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Auto detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Autorent</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#">Avaleht</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Autod</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Hinnad</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>
      </ul>
      <form class="d-flex">
        <input class="form-control form-control-sm me-2" type="search" placeholder="Otsi autot">
        <button class="btn btn-outline-secondary btn-sm">🔍</button>
      </form>
    </div>
  </div>
</nav>

<!-- SISU -->
<div class="container my-5">

<?php
$paring = "SELECT * FROM cars WHERE id=102";
$valjund = mysqli_query($yhendus, $paring);
$rida = mysqli_fetch_array($valjund);
print_r($rida);
?>


  <div class="card shadow-sm">
    <div class="row g-0">

      <!-- Pilt -->
      <div class="col-md-6">
        <img src="https://loremflickr.com/800/500/audi"
             class="img-fluid h-100 object-fit-cover rounded-start"
             alt="Auto pilt">
      </div>

      <!-- Info -->
      <div class="col-md-6">
        <div class="card-body p-4">

          <h3 class="card-title mb-3">Audi R8 Spyder</h3>
          <p class="text-muted mb-4">Cabrio · 2021</p>

          <ul class="list-unstyled mb-4">
            <li><strong>Mootor:</strong> V10</li>
            <li><strong>Kütus:</strong> Bensiin</li>
            <li><strong>Käigukast:</strong> Automaat</li>
            <li><strong>Kohad:</strong> 2</li>
          </ul>

          <h4 class="mb-3">250 € / päev</h4>

          <button class="btn btn-dark w-100">Rendi</button>

        </div>
      </div>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>