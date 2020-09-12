<?php

require_once '../models/db.php';

class Product {
    /** @var int  */
    protected $id;

    /** @var string  */
    protected $name;

    /** @var int  */
    protected $price;

    /** @var string  */
    protected $description;

    /** @var boolean */
    protected $in_promo;

    /**
     * Product constructor.
     * @param int $id
     * @param string $name
     * @param int $price
     * @param string $description
     * @param $in_promo
     */
    public function __construct($id, $name, $price,$description,$in_promo) {
        $this->id    = $id;
        $this->price = $price;
        $this->name  = $name;
        $this->description=$description;
        $this->in_promo=$in_promo;

    }

    /**
     * @return bool
     */
    public function isInPromo(): bool
    {
        return $this->in_promo??false;
    }

    /**
     * Find a product in the DB by ID. The function returns the Product (as object) or null if ID not found
     * @param int $id
     * @return Product|null
     */
    public static function find($id) {
        // Initialize DB connection
        $db = DB::getInstance();
        $conn = $db->getConnection();

        // Select all products from DB
        $stmt = $conn->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Product($row['id'], $row['name'], $row['price'],$row['description'],$row['in_promo']);
        } else {
            return null;
        }
    }

    /**
     * GETTERS
     */

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }



}