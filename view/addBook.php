<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/PublisherController.php';
require_once __DIR__ . '/../controller/BookController.php';

$connectDb = new Connection();
$pdo = $connectDb->connect();

$controller = new BookController($pdo);

$formData = $controller->getFormData();
$authorsList = $formData['authors'];
$publishersList = $formData['publishers'];

$message = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $controller->handleAddRequest();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Add Book</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Add New Book</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row justify-content-center">
                    
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo ($message['type'] == 'error') ? 'danger' : 'success'; ?> col-md-6 text-center">
                            <?php echo $message['message']; ?>
                            <div class="text-center"><a class="btn btn-outline-light mt-auto" href="/Project/view/books.php">Back to Books</a></div>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" enctype="multipart/form-data" class="border p-4 rounded shadow-sm" style="max-width: 500px;">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title:</label>
                            <input type="text" name="title" class="form-control" placeholder="Ex: Harry Potter" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Book Launch Day:</label>
                            <input type="date" name="launch_date" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover:</label>
                            <input type="file" name="image" accept="image/*" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Autor:</label>
                            <select name="author_id" class="form-select" required>
                                <option value="">Alege un autor...</option>
                                <?php foreach ($authorsList as $author): ?>
                                    <option value="<?php echo $author['id']; ?>">
                                        <?php echo htmlspecialchars($author['first_name'] . ' ' . $author['last_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text"><a href="addAuthor.php">Nu găsești autorul? Adaugă-l aici.</a></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Editură:</label>
                            <select name="publisher_id" class="form-select" required>
                                <option value="">Alege o editură...</option>
                                <?php foreach ($publishersList as $publisher): ?>
                                    <option value="<?php echo $publisher['id']; ?>">
                                        <?php echo htmlspecialchars($publisher['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                             <div class="form-text"><a href="addPublisher.php">Nu găsești editura? Adaugă una aici.</a></div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success py-2 fw-bold">Salvează Cartea</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>