<?php

class ProductForm extends Product
{

    public function __construct($id=null,$POST_DATA=null) {

        if (!is_null($POST_DATA)) {
            $this->id    = $id ?? null;
            $this->price = $POST_DATA['fprice'] ?? "";
            $this->name  = $POST_DATA['fname'] ?? "";
            $this->description=$POST_DATA['fdescription'] ?? "";
            $this->in_promo=$POST_DATA['fin_promo'] ?? "";
        }

    }



    public function validate() { // minden mezőben van-e content

        $valid = true;

        $okay_name = $this->validateName();

        $okay_price  = $this->validatePrice() ;

        $okay_id= $this->validateID() ;

        $okay_description = $this->validateDescription();

        $okay_in_promo=$this->validateIn_promo();

        $result= ($okay_name && $okay_price && $okay_id && $okay_description && $okay_in_promo);

        return $result;
    }
    public function save() {  // adatbázisba ment

        if(!$this->validate()) return false;

        $this->id=htmlentities($this->id);
        $this->name=htmlentities($this->name);
        $this->price=htmlentities($this->price);
        $this->description=htmlentities($this->description);


        $db = DB::getInstance();
        $conn = $db->getConnection();

        // Select all products from DB
        if (!$this->id) { //ha null az id,akkor új sor
            $stmt = $conn->prepare('INSERT INTO products (name, price,stock,in_promo,description) 
                                                        VALUES (:name,:price,10, :in_promo,:description)');
        }
        else { //ha nem akkor frissítjük a db-t
            $stmt = $conn->prepare('UPDATE products SET id=:id,name=:name, price=:price,in_promo=:in_promo,description=:description
                                                        WHERE id=:id');
            $stmt->bindParam(':id', $this->id);
        }
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':in_promo', $this->in_promo);
        $stmt->bindParam(':description', $this->description);


        $result=$stmt->execute();

        return ($result);

    }
    public function delete() { // töröl az adatbázisból
        if (!$this->validateID()) return false;
        $this->id=htmlentities($this->id);
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $stmt=$conn->prepare('DELETE FROM products WHERE id=:id;');
        $stmt->bindParam(':id',$this->id);
        $result=$stmt->execute();
        return($result);
    }
    public static function new() { //return null product példány
        return new Product(null,null,null,null,null);
    }

    private function validateName()
    {
        return strlen($this->name)>0;
    }

    private function validatePrice()
    {
        return is_numeric($this->price);
    }

    private function validateID()
    {
        return true;
    }

    private function validateDescription()
    {
        return true;
    }

    private function validateIn_promo()
    {
        return true;
    }
}