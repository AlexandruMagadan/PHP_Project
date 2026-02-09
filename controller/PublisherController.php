<?php
require_once __DIR__ . '/../repository/PublisherRepository.php';

class PublisherController {
    private $repository;

    public function __construct($pdo) {
        $this->repository = new PublisherRepository($pdo);
    }

    public function handleAddRequest() {
        $upload_dir = '/Project/uploads/publishers/';
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }

        if (!isset($_FILES['image']) || !isset($_POST['name']) || empty($_POST['name'])) {
             return ['type' => 'error', 'message' => 'Numele și imaginea sunt obligatorii!'];
        }

        $file = $_FILES['image'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['type' => 'error', 'message' => 'Eroare la încărcarea fișierului.'];
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed)) {
            return ['type' => 'error', 'message' => 'Doar formatele JPG, PNG și GIF sunt permise.'];
        }
        
        if ($file['size'] > 2097152) {
            return ['type' => 'error', 'message' => 'Fișierul este prea mare (Max 2MB).'];
        }

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $new_filename = uniqid('img_') . '.' . $file_ext;
        $destination = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            try {
                $publisher = new Publisher($_POST['name'], $destination);
                $result = $this->repository->create($publisher);

                if ($result) {
                    return ['type' => 'success', 'message' => 'Editura a fost adăugată cu succes!'];
                } else {
                    return ['type' => 'error', 'message' => 'Imaginea s-a încărcat, dar salvarea în DB a eșuat.'];
                }
            } catch (Exception $e) {
                return ['type' => 'error', 'message' => 'Eroare DB: ' . $e->getMessage()];
            }
        } else {
            return ['type' => 'error', 'message' => 'Nu s-a putut salva fișierul pe server.'];
        }
    }
    public function getPublisherDetails($id) {
    $publisher = $this->repository->getById($id);
    
    if (!$publisher) {
        return null;
    }

    $books = $this->repository->getBooksByPublisherId($id);
    return [
        'publisher' => $publisher,
        'books' => $books
    ];
    }

    public function deletePublisher($id) 
    {
        $this->repository->softDelete($id);
        header("Location: publishers.php");
        exit;
    }
}
?>