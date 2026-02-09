<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/AuthorController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();
$controller = new AuthorController($pdo);

if (!isset($_GET['id'])) die("Author ID missing.");

$data = $controller->getAuthorDetails($_GET['id']);
if (!$data) die("Author not found.");

$author = $data['author'];
$books = $data['books'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($author['first_name']); ?> - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/Project/css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Online Library</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="authors.php">Back to Authors</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-5">
                
                <div class="col-lg-4 mb-5">
                    <div class="card shadow border-0 text-center p-4">
                        <img class="img-fluid rounded-circle mx-auto mb-4" 
                             src="<?php echo !empty($author['photo']) ? $author['photo'] : 'https://dummyimage.com/300x300/dee2e6/6c757d.jpg'; ?>" 
                             style="width: 200px; height: 200px; object-fit: cover;" alt="..." />
                        
                        <h2 class="fw-bolder"><?php echo htmlspecialchars($author['first_name'] . ' ' . $author['last_name']); ?></h2>
                        <p class="text-muted">Age: <?php echo $author['age']; ?></p>
                        
                        <hr>
                        
                        <div class="text-start">
                            <h5 class="mb-3"><i class="bi bi-building me-2"></i>Publisher</h5>
                            <p class="lead fs-6"><?php echo htmlspecialchars($author['publisher_name'] ?? 'Not Assigned'); ?></p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-8">
                    <h3 class="fw-bold mb-4">Books by <?php echo htmlspecialchars($author['last_name']); ?></h3>
                    
                    <?php if (count($books) > 0): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($books as $book): ?>
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="<?php echo !empty($book['product_photo']) ? $book['product_photo'] : 'https://dummyimage.com/100x150/dee2e6/6c757d.jpg'; ?>" 
                                                     class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="...">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                                                    <p class="card-text"><small class="text-muted">ID: <?php echo $book['id']; ?></small></p>
                                                    <a href="viewBook.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-outline-dark stretched-link">View Book</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> This author hasn't written any books yet (or none are added to the database).
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
</body>
</html>