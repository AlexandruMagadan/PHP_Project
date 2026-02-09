<?php

class Author {
    private $id;
    private $firstName;
    private $lastName;
    private $photo;
    private $age;
    private $deleted;

    public function __construct($firstName, $lastName, $photo, $age, $publisherId,$id = null, $deleted = 0) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->photo = $photo;
        $this->age = $age;
        $this->id = $id;
        $this->publisherId = $publisherId;
        $this->deleted = $deleted;
    }

    public function getId() { return $this->id; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getPhoto() { return $this->photo; }
    public function getAge() { return $this->age; }
    public function getPublisherId() { return $this->publisherId; }
    
    public function getFullName() { return $this->firstName . ' ' . $this->lastName; }
}
?>