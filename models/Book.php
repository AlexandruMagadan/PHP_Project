<?php


class Book {
    private $id;
    private $title;
    private $image;
    private $date;
    private $authorId;
    private $publisherId;
    private $deleted;

    private $authorName;
    private $publisherName;

    
    public function __construct($title, $image, $date ,$authorId, $publisherId, $id = null, $deleted = 0) {
        $this->title = $title;
        $this->image = $image;
        $this->date = $date;
        $this->authorId = $authorId;
        $this->publisherId = $publisherId;
        $this->id = $id;
        $this->deleted = $deleted;
    }

    public function setAuthorName($name) { $this->authorName = $name; }
    public function setPublisherName($name) { $this->publisherName = $name; }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getImage() { return $this->image; }
    public function getDate() { return $this->date; }
    public function getAuthorId() { return $this->authorId; }
    public function getPublisherId() { return $this->publisherId; }
    
    public function getAuthorName() { return $this->authorName; }
    public function getPublisherName() { return $this->publisherName; }
}
?>