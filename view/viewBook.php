<?php

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/BookController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();

$controller = new BookController($pdo);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Eroare: ID-ul cărții lipsește.");
}

$book = $controller->getBookById($_GET['id']);

if (!$book) {
    die("Eroare: Cartea nu a fost găsită sau a fost ștearsă.");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?php echo htmlspecialchars($book['title']); ?> - Details</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Online library</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" href="books.php">Back to Books</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    
                    <div class="col-md-6">
                        <img class="card-img-top mb-5 mb-md-0 rounded shadow" 
                             src="<?php echo !empty($book['product_photo']) ? $book['product_photo'] : 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($book['title']); ?>" 
                             style="max-height: 600px; object-fit: cover;" />
                    </div>

                    <div class="col-md-6">
                        <div class="small mb-1 text-muted">ID: <?php echo $book['id']; ?></div>
                        
                        <h1 class="display-5 fw-bolder mb-3"><?php echo htmlspecialchars($book['title']); ?></h1>
                        
                        <div class="fs-5 mb-4">
                            </div>


                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row" class="ps-0" style="width: 150px;">Author:</th>
                                    <td>
                                        <a href="authors.php" class="text-decoration-none fw-bold">
                                            <i class="bi bi-person-fill"></i> 
                                            <?php echo htmlspecialchars($book['author_full_name'] ?? 'Unknown'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        .
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="ps-0">Publisher:</th>
                                    <td>
                                        <a href="publisher.php" class="text-decoration-none fw-bold">
                                            <i class="bi bi-building"></i> 
                                            <?php echo htmlspecialchars($book['publisher_name'] ?? 'Unknown'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="editBook.php?id=<?php echo $book['id']; ?>" class="text-decoration-none fw-bold">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="ps-0">Launch Date:</th>
                                    <td>
                                        <?php 
                                            if (!empty($book['publishing_date'])) {
                                                echo date("M d, Y", strtotime($book['publishing_date']));
                                            } else {
                                                echo "-";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex mt-5">
                            <a href="books.php" class="btn btn-outline-dark flex-shrink-0 me-2">
                                <i class="bi-arrow-left me-1"></i>
                                Back to List
                            </a>
                            
                            <a href="books.php?action=delete&id=<?php echo $book['id']; ?>" 
                               class="btn btn-danger flex-shrink-0"
                               onclick="return confirm('Are you sure you want to delete this book?');">
                                <i class="bi-trash me-1"></i>
                                Delete Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>