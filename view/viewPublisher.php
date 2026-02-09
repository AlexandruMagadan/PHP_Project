<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/PublisherController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();
$controller = new PublisherController($pdo);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Publisher ID is missing.");
}

$data = $controller->getPublisherDetails($_GET['id']);

if (!$data) {
    die("Editura nu a fost găsită sau a fost ștearsă.");
}

$publisher = $data['publisher'];
$books = $data['books'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($publisher['name']); ?> - Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/Project/css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Online Library</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="publishers.php">Back to Publishers</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-5">
                
                <div class="col-lg-4 mb-5">
                    <div class="card shadow border-0 text-center p-4">
                        <div class="bg-light rounded mb-4 d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px; overflow: hidden;">
                            <img src="<?php echo !empty($publisher['logo']) ? $publisher['logo'] : 'https://dummyimage.com/200x200/dee2e6/6c757d.jpg&text=No+Logo'; ?>" 
                                 class="img-fluid" 
                                 alt="Logo" />
                        </div>
                        
                        <h2 class="fw-bolder"><?php echo htmlspecialchars($publisher['name']); ?></h2>
                        <p class="text-muted">Publisher ID: <?php echo $publisher['id']; ?></p>
                        
                        <hr>
                        
                        
                    </div>
                </div>

                <div class="col-lg-8">
                    <h3 class="fw-bold mb-4">Books published by <?php echo htmlspecialchars($publisher['name']); ?></h3>
                    
                    <?php if (count($books) > 0): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($books as $book): ?>
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="<?php echo !empty($book['product_photo']) ? $book['product_photo'] : 'https://dummyimage.com/100x150/dee2e6/6c757d.jpg'; ?>" 
                                                     class="img-fluid rounded-start h-100" 
                                                     style="object-fit: cover;" 
                                                     alt="...">
                                            </div>
                                            
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <h5 class="card-title text-truncate"><?php echo htmlspecialchars($book['title']); ?></h5>
                                                    
                                                    <p class="card-text mb-1">
                                                        <small class="text-muted">
                                                            <i class="bi bi-person"></i> 
                                                            <?php echo htmlspecialchars($book['author_full_name'] ?? 'Unknown Author'); ?>
                                                        </small>
                                                    </p>
                                                    
                                                    <?php if(!empty($book['launch_date'])): ?>
                                                    <p class="card-text mb-2">
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar"></i>
                                                            <?php echo date("Y", strtotime($book['launch_date'])); ?>
                                                        </small>
                                                    </p>
                                                    <?php endif; ?>

                                                    <a href="viewBook.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-outline-primary stretched-link">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info py-4">
                            <i class="bi bi-info-circle me-2"></i> 
                            This publisher has not added any books to the system yet.
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>
</body>
</html>