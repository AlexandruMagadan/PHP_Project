<?php

require_once __DIR__ . '/../models/Publisher.php';

class PublisherRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    public function getAll($search = '', $letter = 'all', $order = 'asc') {
        $sql = "SELECT * FROM publishers WHERE deleted = 0";
        $params = [];

        
        if (!empty($search)) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%" . $search . "%";
        }

        if ($letter !== 'all') {
            $sql .= " AND name LIKE :letter";
            $params[':letter'] = $letter . "%";
        }

        $direction = (strtolower($order) === 'desc') ? 'DESC' : 'ASC';
        $sql .= " ORDER BY name " . $direction;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create(Publisher $publisher) {
        $sql = "INSERT INTO publishers (name, logo) VALUES (:name, :logo)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $publisher->getName(),
            ':logo' => $publisher->getLogo()
        ]);
    }

    public function update(Publisher $publisher) {
        if ($publisher->getLogo()) {
            $sql = "UPDATE publishers SET name = :name, logo = :logo WHERE id = :id";
            $params = [
                ':name' => $publisher->getName(),
                ':logo' => $publisher->getLogo(),
                ':id'   => $publisher->getId()
            ];
        } else {
            $sql = "UPDATE publishers SET name = :name WHERE id = :id";
            $params = [
                ':name' => $publisher->getName(),
                ':id'   => $publisher->getId()
            ];
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function softDelete($id) {
        $sql = "UPDATE publishers SET deleted = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getById($id) {
    $sql = "SELECT * FROM publishers WHERE id = :id AND deleted = 0";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBooksByPublisherId($publisherId) {
    $sql = "SELECT b.*, 
                   CONCAT(a.first_name, ' ', a.last_name) as author_full_name
            FROM books b
            LEFT JOIN authors a ON b.id_author = a.id
            WHERE b.id_publisher = :publisher_id AND b.deleted = 0";
            
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':publisher_id' => $publisherId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
}
?>