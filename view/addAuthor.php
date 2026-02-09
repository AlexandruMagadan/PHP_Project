<?php
     require_once __DIR__ . '/../config/connection.php';
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../controller/AuthorController.php';

    $connectDb = new Connection();
    $pdo = $connectDb->connect();
    
   
    $controller = new AuthorController($pdo);
    $publishersList = $controller->showPublishers();
    
    $result = null;
    if (isset($_GET['exercise']) && $_GET['exercise'] == '4') {
       
        $result = $controller->handleAddRequest();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add Publisher</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Add Author</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row justify-content-center">
                    
                    <?php if ($result): ?>
                        <div class="alert alert-<?php echo ($result['type'] == 'error') ? 'danger' : 'success'; ?> col-md-6 text-center">
                            <?php echo $result['message']; ?>
                            <div class="text-center"><a class="btn btn-outline-light mt-auto" href="/Project/view/authors.php">Back to Authors</a></div>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="?exercise=4" enctype="multipart/form-data" class="border p-4 rounded shadow-sm" style="max-width: 450px;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Author First Name:</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Author Last Name:</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                          <div class="mb-3">
                            <label class="form-label fw-bold">Author Age:</label>
                            <input type="text" name="age" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Author Image:</label>
                            <input type="file" name="photo" accept="image/*" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Author Publisher:</label>
                            <select name="publisher" class="form-control" required>
                                <option value="">Select Publisher</option>
                                <?php foreach ($publishersList as $publisher): ?>
                                    <option value="<?php echo $publisher['id']; ?>"><?php echo $publisher['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">Upload & Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>