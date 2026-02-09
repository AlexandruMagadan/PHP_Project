<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Welcome to the Online Library" />
        <meta name="author" content="" />
        <title>Home - Online Library</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="/Project/css/styles.css" rel="stylesheet" />
        
        <style>
            .hero-header {
                background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1507842217121-9e93c8aaf27f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
                background-size: cover;
                background-position: center;
                min-height: 60vh;
                display: flex;
                align-items: center;
            }
            .feature-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .card:hover {
                transform: translateY(-5px);
                transition: transform 0.3s ease;
                box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            }
        </style>
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

        <header class="hero-header py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-1 fw-bolder">Knowledge is Power</h1>
                    <p class="lead fw-normal text-white-50 mb-4 fs-4">Discover a world of stories, wisdom, and adventure. <br>Manage your library efficiently.</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="books.php">Browse Books</a>
                        <a class="btn btn-outline-light btn-lg px-4" href="addBook.php">Add New Book</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-5" id="features">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 justify-content-center">
                    
                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <div class="feature-icon text-primary"><i class="bi bi-journal-bookmark-fill"></i></div>
                                <h2 class="h4 fw-bolder">Library Books</h2>
                                <p class="mb-4 text-muted">Explore our vast collection of books. Sort by title, check prices, and view details.</p>
                                <a class="btn btn-outline-primary" href="books.php">View Books &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <div class="feature-icon text-success"><i class="bi bi-people-fill"></i></div>
                                <h2 class="h4 fw-bolder">Famous Authors</h2>
                                <p class="mb-4 text-muted">Discover the minds behind the masterpieces. Manage author profiles and biographies.</p>
                                <a class="btn btn-outline-success" href="authors.php">View Authors &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <div class="feature-icon text-warning"><i class="bi bi-building"></i></div>
                                <h2 class="h4 fw-bolder">Publishing Houses</h2>
                                <p class="mb-4 text-muted">Organize books by their publishers. Add new partners and keep track of editions.</p>
                                <a class="btn btn-outline-warning" href="publisher.php">View Publishers &rarr;</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h2 class="text-dark fw-bold">Ready to expand the library?</h2>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-muted mb-5">Our system allows you to easily manage inventory with a user-friendly interface. Start adding content today!</p>
                        <a class="btn btn-dark btn-xl" href="addBook.php">Start Adding Content</a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Online Library 2023</p></div>
        </footer>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>