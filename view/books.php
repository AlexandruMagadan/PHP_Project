<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/AuthorController.php';
require_once __DIR__ . '/../controller/BookController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();

$controller = new BookController($pdo);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $controller->deleteBook($_GET['id']);
}

$books = $controller->index();
$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'asc';

$startDate = $_GET['start_date'] ?? '';
$endDate   = $_GET['end_date'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Online Library - Books</title>
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
                    <h1 class="display-4 fw-bolder">Books</h1>
                    <p class="lead fw-normal text-white-50 mb-0"></p>
                    <br>
                    <div class="text-center"><a class="btn btn-outline-light mt-auto" href="/Project/view/addBook.php">Add New Book</a></div>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
               <form method="GET" action="books.php">
    <div class="row mb-5 p-4 bg-light rounded shadow-sm align-items-end">
        
        <div class="col-md-3 mb-3">
            <label class="form-label fw-bold">Titlu</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" name="search" placeholder="Căutare..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <label class="form-label fw-bold">De la:</label>
            <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
        </div>

        <div class="col-md-2 mb-3">
            <label class="form-label fw-bold">Până la:</label>
            <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label fw-bold">Sortare</label>
            <div class="d-flex align-items-center mt-2">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="order" value="asc" <?php if($order == 'asc') echo 'checked'; ?>>
                    <label class="form-check-label">A - Z</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="order" value="desc" <?php if($order == 'desc') echo 'checked'; ?>>
                    <label class="form-check-label">Z - A</label>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">Filtrează</button>
            <a href="books.php" class="btn btn-outline-secondary" title="Resetează"><i class="bi bi-x-lg"></i></a>
        </div>
    </div>
</form>

                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
$a=new \DateTime('now');                     var_dump($a->format('Y-M-D'));?>
                    <?php if (count($books) > 0): ?>
                        <?php foreach ($books as $row): ?>
                            <div class="col mb-5">
                                <div class="card h-100">
                                    <img class="card-img-top" 
                                         src="<?php echo !empty($row['product_photo']) ? $row['product_photo'] : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'; ?>" 
                                         alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                         style="height: 300px; object-fit: cover;" />
                                    
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder"><?php echo htmlspecialchars($row['title']); ?></h5>
                                            
                                            <div class="mb-2">
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($row['author_full_name'] ?? 'Necunoscut'); ?>
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-building"></i> <?php echo htmlspecialchars($row['publisher_name'] ?? 'Necunoscut'); ?>
                                                </small>
                                            </div>

                                            <?php if(isset($row['price'])): ?>
                                                <span class="text-primary fw-bold">$<?php echo $row['price']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-dark mt-auto" href="viewBook.php?id=<?php echo $row['id']; ?>">View</a>
                                            <a class="btn btn-outline-danger mt-auto" href="books.php?action=delete&id=<?php echo $row['id']; ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning text-center">Nu au fost găsite cărți conform filtrelor.</div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>