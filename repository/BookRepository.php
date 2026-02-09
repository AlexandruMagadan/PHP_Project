<?php

require_once __DIR__ . '/../models/Book.php';

class BookRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function getAll($search = '', $sort = 'asc', $startDate = null, $endDate = null) 
    {
        $sql = "SELECT b.*, 
                    CONCAT(a.first_name, ' ', a.last_name) as author_full_name,
                    p.name as publisher_name
                FROM books b
                LEFT JOIN authors a ON b.id_author = a.id
                LEFT JOIN publishers p ON b.id_publisher = p.id
                WHERE b.deleted = 0";
        
        $params = [];

        if (!empty($search)) {
            $sql .= " AND b.title LIKE :search";
            $params[':search'] = "%" . $search . "%";
        }

        if (!empty($startDate)) {
            $sql .= " AND b.publishing_date >= :startDate";
            $params[':startDate'] = $startDate;
        }

        if (!empty($endDate)) {
            $sql .= " AND b.publishing_date <= :endDate";
            $params[':endDate'] = $endDate;
        }
        
        $direction = (strtolower($sort) === 'desc') ? 'DESC' : 'ASC';
        $sql .= " ORDER BY b.title " . $direction;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(Book $book) 
    {

        $sql = "INSERT INTO books (title, product_photo, publishing_date, id_author, id_publisher, deleted) 
                VALUES (:title, :product_photo, :publishing_date, :id_author, :id_publisher, 0)";

        $stmt = $this->pdo->prepare($sql);

        try {
            return $stmt->execute([
                ':title'         => $book->getTitle(),
                ':product_photo' => $book->getImage(),
                ':publishing_date'          => $book->getDate(),
                ':id_author'     => $book->getAuthorId(),
                ':id_publisher'  => $book->getPublisherId()
            ]);
        } catch (\PDOException $e) {
            
            throw new \RuntimeException("Eroare DB: " . $e->getMessage());
        }
    }

    public function getById($id) 
    {
        $sql = "SELECT b.*, 
                    CONCAT(a.first_name, ' ', a.last_name) as author_full_name,
                    p.name as publisher_name
                FROM books b
                LEFT JOIN authors a ON b.id_author = a.id
                LEFT JOIN publishers p ON b.id_publisher = p.id
                WHERE b.id = :id AND b.deleted = 0";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function updatePublisher($bookId, $newPublisherId) 
    {
        $sql = "UPDATE books SET id_publisher = :publisher_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':publisher_id' => $newPublisherId,
            ':id' => $bookId
        ]);
    }   

    public function softDelete($id) {
        $sql = "UPDATE books SET deleted = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>