<?php
require_once __DIR__ . '/../repository/BookRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/PublisherRepository.php';
require_once __DIR__ . '/../models/Book.php';

class BookController {
    private $bookRepo;
    private $authorRepo;
    private $publisherRepo;

    public function __construct(PDO $pdo) 
    {
        $this->bookRepo = new BookRepository($pdo);
        $this->authorRepo = new AuthorRepository($pdo);
        $this->publisherRepo = new PublisherRepository($pdo);
    }

   public function index() 
   {
        $search = $_GET['search'] ?? '';
        $order  = $_GET['order'] ?? 'asc';
        
        $startDate = $_GET['start_date'] ?? null;
        $endDate   = $_GET['end_date'] ?? null;

        return $this->bookRepo->getAll($search, $order, $startDate, $endDate);
    }

    public function getFormData() 
    {
        return [
            'authors' => $this->authorRepo->getAll(),
            'publishers' => $this->publisherRepo->getAll()
        ];
    }

    public function getBookById($id) 
    {
        return $this->bookRepo->getById($id);
    }

    public function handleUpdatePublisher() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return null;
    
        $bookId = $_POST['book_id'] ?? null;
        $publisherId = $_POST['publisher_id'] ?? null;

        if (!$bookId || !$publisherId) {
            return ['type' => 'error', 'message' => 'Date invalide.'];
        }

        if ($this->bookRepo->updatePublisher($bookId, $publisherId)) {
            return ['type' => 'success', 'message' => 'Editura a fost actualizată cu succes!'];
        } else {
            return ['type' => 'error', 'message' => 'Eroare la actualizare.'];
        }
    }

    public function handleAddRequest() 
    {
        $uploadDirFs = __DIR__ . '/../uploads/books/'; 
        $uploadWebBase = '/Project/uploads/books/';   
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return null;
            }

            if (empty($_POST['title']) || empty($_POST['author_id']) || empty($_POST['publisher_id'])) {
                return ['type' => 'error', 'message' => 'Toate câmpurile sunt obligatorii!'];
            }

            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                return ['type' => 'error', 'message' => 'Imaginea este obligatorie!'];
            }

            $file = $_FILES['image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (!in_array($ext, $allowed)) return ['type' => 'error', 'message' => 'Format imagine invalid.'];

            if (!is_dir($uploadDirFs)) {
                mkdir($uploadDirFs, 0755, true);
            }

            $fileName = uniqid('book_') . '.' . $ext;
            $destinationFs = $uploadDirFs . $fileName;    
            $destinationWeb = $uploadWebBase . $fileName;  

            if (move_uploaded_file($file['tmp_name'], $destinationFs)) {
                $book = new Book(
                    $_POST['title'],
                    $destinationWeb,
                    $_POST['launch_date'],
                    $_POST['author_id'],
                    $_POST['publisher_id']
                );
                
                if ($this->bookRepo->create($book)) {
                    return ['type' => 'success', 'message' => 'Cartea a fost adăugată!'];
                } else {
                    return ['type' => 'error', 'message' => 'Eroare la salvarea în baza de date.'];
                }
            } else {
                return ['type' => 'error', 'message' => 'Eroare la upload fisier.'];
            }
     }
    public function deleteBook($id) {
        $this->bookRepo->softDelete($id);

        header("Location: books.php");
        exit;
    }
}
?>