<?php
require_once __DIR__ . '/../models/Author.php';

class AuthorRepository {
    private $pdo;

    public function __construct($pdo) 
    {
        $this->pdo = $pdo;
    }


    
    public function create(Author $author) 
    {
    $sql = "INSERT INTO authors (first_name, last_name, photo, age, publisher_id, deleted) 
            VALUES (:first_name, :last_name, :photo, :age, :publisher_id, 0)";
    
    $stmt = $this->pdo->prepare($sql);
    
    return $stmt->execute([
        ':first_name'   => $author->getFirstName(),
        ':last_name'    => $author->getLastName(),
        ':photo'        => $author->getPhoto(),
        ':age'          => $author->getAge(),
        ':publisher_id' => $author->getPublisherId() 
    ]);
    }

  
    public function softDelete($id) 
    {
        $sql = "UPDATE authors SET deleted = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


    public function getById($id) {
        $sql = "SELECT a.*, p.name as publisher_name 
                FROM authors a
                LEFT JOIN publishers p ON a.publisher_id = p.id
                WHERE a.id = :id AND a.deleted = 0";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBooksByAuthorId($authorId) {
        $sql = "SELECT * FROM books WHERE id_author = :author_id AND deleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':author_id' => $authorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getAll($search = '') {
        $sql = "SELECT * FROM authors WHERE deleted = 0";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (first_name LIKE :search OR last_name LIKE :search)";
            $params[':search'] = "%" . $search . "%";
        }
        
        $sql .= " ORDER BY last_name ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>