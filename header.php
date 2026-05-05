<?php 
  if (session_status() === PHP_SESSION_NONE) {
      session_start(); 
  }
?>
<!doctype html>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autorent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm mb-4">
      <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🚗 AUTORENT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Avaleht</a>
            </li>
      
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link fw-bold text-primary" href="admin/index.php">Admin Paneel</a>
              </li>
            <?php endif; ?>

            <?php if (!isset($_SESSION['user_id'])): ?>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Logi sisse</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="register.php">Registreeru</a>
              </li>
            <?php endif; ?>
          </ul>

          <div class="d-flex align-items-center gap-2">
            <form class="d-flex" role="search" method="get" action="index.php">
              <input class="form-control me-2" type="search" placeholder="Otsi autot..." name="otsi">
              <button class="btn btn-outline-success" type="submit">Otsi</button>
            </form>

            <?php if (isset($_SESSION['user_id'])): ?>
              <a href="logout.php" class="btn btn-outline-danger btn-sm">Logi välja</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>