<?php
require_once __DIR__ . '/../src/db.php';

$pdo = getDbConnection();

$totals = $pdo->query(
    'SELECT COALESCE(SUM(added_price), 0) AS total_price,
            COALESCE(SUM(added_duration), 0) AS total_duration
     FROM added_destination'
)->fetch();

$added = $pdo->query('SELECT * FROM added_destination ORDER BY id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/logo.svg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js" defer></script>
    <title>Itinerary planner</title>
</head>
<body>
    <header>
        <nav class="navbar bg-primary text-light">
            <a href="index.php" class="navbar-brand" id="nav-brand"><p class="text-light"><i class="bi bi-brightness-alt-high"></i> MyHoliday</p></a>
        </nav>
    </header>

    <div class="container planner" id="planner">
        <h4 class="text-center">Oh all the places we will go!</h4>
        <hr>

        <div class="planner-info">
            <p><b>Approximate duration:</b> <span id="total-days"><?= htmlspecialchars((string)$totals['total_duration']) ?></span> day(s)</p>
            <p><b>Approximate total price:</b> $<span id="total-price"><?= htmlspecialchars((string)$totals['total_price']) ?></span></p>
        </div>

        <div class="all-added-destinations" id="all-added-destinations">
            <?php $count = 1; foreach ($added as $row): ?>
                <div class="added-destination">
                    <div class="number-container">
                        <p class="number"><?= $count++ ?></p>
                    </div>
                    <div>
                        <span class="close">X</span>
                        <p class="destination-name"><b>Destination: </b><span class="addedLocation"><?= htmlspecialchars($row['added_location']) ?></span></p>
                        <p><b>Duration: </b><span class="addedDuration"><?= htmlspecialchars((string)$row['added_duration']) ?></span> days</p>
                        <p><b>Activities: </b><span class="addedActivity"><?= htmlspecialchars($row['added_activity']) ?></span></p>
                        <p><b>Price: </b>As from $<span class="addedPrice"><?= htmlspecialchars((string)$row['added_price']) ?></span></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button onclick="window.print()" class="btn btn-primary btn-print"><i class="bi bi-printer"></i> Print</button>
    </div>

    <footer>
        <div class="container my-5">
            <hr>
            <p class="text-center text-muted">
                Created with &#10084;&#65039; by <a href="https://github.com/haingo-raz" target="_blank" rel="noopener noreferrer">haingo-raz</a>
            </p>
        </div>
    </footer>
</body>
</html>
