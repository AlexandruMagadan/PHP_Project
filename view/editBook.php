<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/BookController.php';
require_once __DIR__ . '/../controller/PublisherController.php'; // Avem nevoie de lista de edituri

$connectDb = new Connection();
$pdo = $connectDb->connect();

$bookController = new BookController($pdo);

require_once __DIR__ . '/../repository/PublisherRepository.php';
$publisherRepo = new PublisherRepository($pdo);


$bookId = $_GET['id'] ?? null;
if (!$bookId) {
    die("Lipseste ID-ul cartii.");
}


$currentBook = $bookController->getBookById($bookId);
if (!$currentBook) {
    die("Cartea nu exista.");
}

$publishersList = $publisherRepo->getAll(); 
$message = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $bookController->handleUpdatePublisher();
 
    $currentBook = $bookController->getBookById($bookId);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Edit Publisher - <?php echo htmlspecialchars($currentBook['title']); ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">Online Library</a>
                <a class="btn btn-outline-dark" href="viewBook.php?id=<?php echo $bookId; ?>">Înapoi la Carte</a>
            </div>
        </nav>

        <section class="py-5">
            <div class="container px-4 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?php echo ($message['type'] == 'error') ? 'danger' : 'success'; ?>">
                                <?php echo $message['message']; ?>
                            </div>
                        <?php endif; ?>

                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Schimbă Editura</h5>
                            </div>
                            <div class="card-body p-4">
                                
                                <h4 class="mb-3"><?php echo htmlspecialchars($currentBook['title']); ?></h4>
                                <p class="text-muted mb-4">
                                    Editura actuală: <strong><?php echo htmlspecialchars($currentBook['publisher_name']); ?></strong>
                                </p>

                                <form method="POST" action="">
                                    <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Selectează Noua Editură:</label>
                                        <select name="publisher_id" class="form-select" required>
                                            <option value="">-- Alege din listă --</option>
                                            <?php foreach ($publishersList as $pub): ?>
                                                <option value="<?php echo $pub['id']; ?>" 
                                                    <?php echo ($pub['id'] == $currentBook['id_publisher']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($pub['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Salvează Modificarea
                                        </button>
                                        <a href="books.php" class="btn btn-secondary">Anulează</a>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>