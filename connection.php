<?php
class Connection {

    public function connect(): PDO {
        try {
            $dsn='mysql:host=localhost;dbname=biblioteca;charset=utf8mb4';
            $pdo = new PDO( $dsn, 'root', '');
            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
        return $pdo;
    }
}
?>