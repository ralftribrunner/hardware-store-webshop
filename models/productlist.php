<?php

require_once '../models/db.php';
require_once '../models/product.php';

class ProductList {
    /** @var array<Product>  */
    protected $products;

    /** @var PDO  */
    private $conn;

    /**
     * ProductList constructor.
     * @param bool $in_promo
     */
    public function __construct($in_promo = false) {
        // Initialize DB connection
        $db = DB::getInstance();
        $this->conn = $db->getConnection();

        // Select all products from DB
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE in_promo = :in_promo');
        $stmt->bindParam(':in_promo', $in_promo);
        $stmt->execute();

        $this->products = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->products[] = new Product($row['id'], $row['name'], $row['price'],$row['description'],$row['in_promo']);
        }
    }

    /**
     * GETTERS
     */

    public function getProducts() {
        return $this->products;
    }

    public function getProductbyID($id) {
        return $this->products[$id];
    }

    public function getProductnamebyID($id) {
        return $this->products[$id];
    }


}