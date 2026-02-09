<?php
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/PublisherRepository.php';
require_once __DIR__ . '/../models/Author.php';

class AuthorController {
    private $authorRepo;
    private $publisherRepo; 
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->authorRepo = new AuthorRepository($pdo);
        $this->publisherRepo = new PublisherRepository($pdo); 
    }

    public function showPublishers() {
        
        $publishers = $this->publisherRepo->getAll(); 
        return $publishers; 
    }

   
    public function handleAddRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }

        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $ageRaw = $_POST['age'] ?? '';
        $age = $ageRaw !== '' ? (int)$ageRaw : null;
        $publisherId = isset($_POST['publisher']) ? (int)$_POST['publisher'] : null;

        if ($firstName === '' || $lastName === '' || $age === null || $publisherId === null) {
            return ['type' => 'error', 'message' => 'Completează toate câmpurile.'];
        }

        $photoPath = null;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/authors/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('author_') . '.' . $ext;
            $dest = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
                return ['type' => 'error', 'message' => 'Eroare la încărcare imagine.'];
            }
            $photoPath = '/Project/uploads/authors/' . $fileName;
        }

        $sql = "INSERT INTO authors (first_name, last_name, age, photo, publisher_id) VALUES (:fn, :ln, :age, :photo, :pub)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':fn', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':ln', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':photo', $photoPath, PDO::PARAM_STR);
        $stmt->bindValue(':pub', $publisherId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['type' => 'success', 'message' => 'Author added successfully.'];
        } else {
            return ['type' => 'error', 'message' => 'Eroare la salvare în baza de date.'];
        }
    }

    public function getAuthorDetails($id) {
        $author = $this->authorRepo->getById($id);
        
        if (!$author) return null;

        $books = $this->authorRepo->getBooksByAuthorId($id);

        return [
            'author' => $author,
            'books' => $books
        ];
    }

    public function deleteAuthor($id) {
       
        $this->authorRepo->softDelete($id);
       
        header("Location: authors.php");
        exit;
    }
}
?>