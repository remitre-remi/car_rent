<?php include('config.php'); ?>
<?php include('header.php'); ?>

<!-- sisu -->
<div class="container">
    <h2>Auto lisamine</h2>
    <form action="lisa.php" method="get">
        <div class="row-g4">
            <div class="col-sm-6">
                <label for="mark" class="form-label">Mark</label>
                <input type="text" class="form-control" id="mark" name="mark">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model">
                <label for="engine" class="form-label">Mootor</label>
                <input type="text" class="form-control" id="engine" name="engine">
                <label for="fuel" class="form-label">Kütus</label>
                <input type="text" class="form-control" id="fuel" name="fuel">
                <label for="price" class="form-label">Hind</label>
                <input type="number" class="form-control" id="price" name="price">
            </div>
            <div class="col-sm-6">

            </div>
            <input type="submit" value="Salvesta" class="btn btn-success">
        </div>
    </form>
   

</div>
<!-- /sisu -->

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>