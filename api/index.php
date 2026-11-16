<?php
require_once __DIR__ . '/../src/db.php';

$pdo = getDbConnection();
$userInput = isset($_GET['query']) ? trim($_GET['query']) : '';

$searchResults = [];
if ($userInput !== '') {
    $stmt = $pdo->prepare(
        'SELECT * FROM destination
         WHERE country ILIKE :q OR location ILIKE :q OR activity ILIKE :q
         ORDER BY price'
    );
    $stmt->execute([':q' => '%' . $userInput . '%']);
    $searchResults = $stmt->fetchAll();
}

$trendingStmt = $pdo->query('SELECT * FROM destination LIMIT 4 OFFSET 2');
$trending = $trendingStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/assets/logo.svg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/index.js" defer></script>
    <title>MyHoliday</title>
</head>
<body>
    <header>
        <nav class="navbar bg-primary text-light">
            <a href="/" class="navbar-brand" id="nav-brand"><p class="text-light"><i class="bi bi-brightness-alt-high"></i> MyHoliday</p></a>
            <a class="text-light planner-link" href="/planner.php">&#9825; MyPlanner</a>
        </nav>
    </header>
    <br>

    <div class="container">
        <div class="d-flex justify-content-center">
            <form action="/" method="GET" class="d-flex justify-content-center col-5">
                <input name="query" id="query" class="form-control mr-sm-2 col-6" type="text" placeholder="Search a destination/activity..." value="<?= htmlspecialchars($userInput) ?>">
                <button class="btn btn-outline-primary my-2 my-sm-0 search-btn" type="submit">Search</button>
            </form>
        </div>

        <div id="resultsContainer" class="resultsContainer">
            <?php if ($userInput !== ''): ?>
                <?php if (count($searchResults) > 0): ?>
                    <?php foreach ($searchResults as $row): ?>
                        <div class="destination-container">
                            <a href="<?= htmlspecialchars($row['site_url']) ?>"><img class="destination-img" src="<?= htmlspecialchars($row['img_url']) ?>" alt=""></a>
                            <div class="destination-info">
                                <p class="location"><?= htmlspecialchars($row['location']) ?>, <?= htmlspecialchars($row['country']) ?></p>
                                <p class="activity"><?= htmlspecialchars($row['activity']) ?></p>
                                <span class="duration"><?= htmlspecialchars((string)$row['duration']) ?></span><span> day(s)</span><br><br>
                                <span>From $</span><span class="price"><?= htmlspecialchars((string)$row['price']) ?></span>
                                <button class="btn btn-primary add-location"><i class="bi bi-plus-circle"></i> Add</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="searchFeedback">No corresponding results for <b>"<?= htmlspecialchars($userInput) ?>"</b></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="trending-title-container">
            <hr>
            <h5 class="text-center">Trending now</h5>
        </div>

        <div class="trending-destinations" id="trending-destinations">
            <?php foreach ($trending as $row): ?>
                <div class="destination-container">
                    <a href="<?= htmlspecialchars($row['site_url']) ?>"><img class="destination-img" src="<?= htmlspecialchars($row['img_url']) ?>" alt=""></a>
                    <div class="destination-info">
                        <p class="location"><?= htmlspecialchars($row['location']) ?>, <?= htmlspecialchars($row['country']) ?></p>
                        <p class="activity"><?= htmlspecialchars($row['activity']) ?></p>
                        <span class="duration"><?= htmlspecialchars((string)$row['duration']) ?></span><span> day(s)</span><br><br>
                        <span>From $</span><span class="price"><?= htmlspecialchars((string)$row['price']) ?></span>
                        <button class="btn btn-primary add-location"><i class="bi bi-plus-circle"></i> Add</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <div class="container my-5">
            <hr>
            <p class="text-center text-muted">MyHoliday Travel Itinerary</p>
            <p class="text-center text-muted">
                Created with &#10084;&#65039; by <a href="https://github.com/haingo-raz" target="_blank" rel="noopener noreferrer">haingo-raz</a>
            </p>
        </div>
    </footer>
</body>
</html>
