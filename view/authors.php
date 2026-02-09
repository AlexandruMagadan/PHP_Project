<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/AuthorController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();
$controller = new AuthorController($pdo);


$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$orderAge = isset($_GET['orderAge']) ? $_GET['orderAge'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';


if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $controller->deleteAuthor($id);
    header('Location: authors.php');
    exit;
}

$sql = "SELECT * FROM authors WHERE deleted = 0";
$params = [];


if (!empty(trim((string)($_GET['search'] ?? '')))) {
    $params[':search'] = '%' . trim($_GET['search']) . '%';
    $sql .= " AND (first_name LIKE :search OR last_name LIKE :search)";
}

$letter = isset($_GET['letter']) ? $_GET['letter'] : 'all';
if ($letter !== 'all') {
    $params[':letterStart'] = $letter . '%';
    $sql .= " AND first_name LIKE :letterStart";
}

$orderBy=[];
if (isset($_GET['orderAge']) && $_GET['orderAge'] !== '') {
    if ($_GET['orderAge'] === 'oldest') {
        $orderBy[] = 'age DESC';
    } else { 
        $orderBy[] = 'age ASC';
    }
} 
    
if (isset($_GET['order']) && $_GET['order'] === 'desc') {
        $orderBy[] = 'first_name DESC';
    } else {
        $orderBy[] = 'first_name ASC';
    }


$sql .= " ORDER BY " . implode(', ',$orderBy);

$statement = $pdo->prepare($sql);
$statement->execute($params);
$authors = $statement->fetchAll(PDO::FETCH_ASSOC);

$pubStmt = $pdo->prepare("SELECT id, name FROM publishers WHERE deleted = 0");
$pubStmt->execute();
$publishersMap = $pubStmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand fw-bold" href="#!"><i class="bi bi-book-half me-2"></i>Online Library</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active fw-bold" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="books.php">Books</a></li>
                        <li class="nav-item"><a class="nav-link" href="authors.php">Authors</a></li>
                        <li class="nav-item"><a class="nav-link" href="publishers.php">Publishers</a></li>
                    </ul>
                    <form class="d-flex" action="books.php" method="GET">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-search me-1"></i>
                            Search Books
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Authors</h1>
                    <br><br>
                    <div class="text-center"><a class="btn btn-outline-light mt-auto" href="/Project/view/addAuthor.php">Add authors</a></div>
                </div>
            </div>
        </header>
        
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                
                <form method="GET" action="authors.php">
                    <div class="row mb-5 p-4 bg-light rounded shadow-sm align-items-end">
                        
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="searchInput" class="form-label fw-bold">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Author's Name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-bold">Sort Direction</label>
                            <div class="d-flex align-items-center mt-1">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="order" id="radioAsc" value="asc" <?php if($orderBy == 'asc') echo 'checked'; ?>>
                                    <label class="form-check-label" for="radioAsc">A - Z</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="order" id="radioDesc" value="desc" <?php if($order == 'desc') echo 'checked'; ?>>
                                    <label class="form-check-label" for="radioDesc">Z - A</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="orderAge" id="radioYoungest" value="youngest" <?php if($order == 'youngest') echo 'checked'; ?>>
                                    <label class="form-check-label" for="radioYoungest">Youngest</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="orderAge" id="radioOldest" value="oldest" <?php if($order == 'oldest') echo 'checked'; ?>>
                                    <label class="form-check-label" for="radioOldest">Oldest</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                </form>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                   
                   <?php
                   if (count($authors) > 0) {
                       foreach ($authors as $row) {
                   ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="<?php echo htmlspecialchars($row['photo']); ?>" alt="..." />
                                
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                                        <p class="text-muted small">Age: <?php echo $row['age']; ?></p>
                                        <p class="text-muted small">Publisher: <?php echo htmlspecialchars($publishersMap[$row['publisher_id']] ?? 'Unknown'); ?></p>
                                        <!-- <p class="text-muted small">ID: <?php echo $row['id']; ?></p> -->
                                    </div>
                                </div>
                                
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="viewAuthor.php?id=<?php echo $row['id']; ?>">View Details</a></div>
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="publishers.php?action=delete&id=<?php echo $row['id']; ?>">Delete</a></div>
                                </div>
                            </div>
                        </div>
                   <?php 
                       }
                   } else {
                       echo '<div class="col-12"><div class="alert alert-warning text-center">Nu am găsit edituri pentru criteriile selectate.</div></div>';
                   }
                   ?>

                </div>
            </div>
        </section>
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>