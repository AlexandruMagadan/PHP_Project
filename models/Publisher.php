<?php
class Publisher {
    private $id;
    private $name;
    private $logo;
    private $deleted;

    public function __construct($name = null, $logo = null, $id = null, $deleted = 0) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->deleted = $deleted;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getLogo() { return $this->logo; }
    public function isDeleted() { return $this->deleted; }

    public function setName($name) { $this->name = $name; }
    public function setLogo($logo) { $this->logo = $logo; }
}
?>