<?php

require_once '../models/db.php';
require_once '../models/product.php';
require_once '../models/productlist.php';

class Basket {

    /** @var array<int,int> */
    protected $counter;

    /** @var PDO  */
    private $conn;

    /**
     * Basket constructor.
     * @param $session
     */
    public function __construct(& $session) {
        $db = DB::getInstance();
        $this->conn = $db->getConnection();

        $this->counter = & $session;
    }

    /**
     * Add a Product to the basket
     * @param Product $product
     * @return string
     */
    public function add($product) {
        $id=$product->getId();
        $price=$product->getPrice();
        $name=$product->getName();
        $is_new=true;
        $amount_inbasket=-1;

        foreach ($this->counter as $key=>$value) {

            if ($key==$id) {

                $this->counter[$id]['darab']++;
                $amount_inbasket=$this->counter[$id]['darab'];
                $is_new=false;
            }

        }
        if ($is_new) {
            $this->counter[$id]['product_id']=$id;
            $this->counter[$id]['darab']=1;
            $amount_inbasket=1;
            $this->counter[$id]['price']=$price;

            $this->counter[$id]['nev']=$name;
        }
        return $this->getJSONBasket();
        //return strval($amount_inbasket) . ";" . strval($this->getTotal());

    }

    /**
     * Add a Product to the basket
     * @param Product $product
     * @return float|int
     */
    public function remove($product) {
        $id=$product->getId();
        unset($this->counter[$id]);
        return $this->getJSONBasket();
        //return $this->getTotal();
    }

    /**
     * Add a Product to the basket
     * @param Product $product
     * @return float|int|string
     */
    public function minus($product) {
        $id=$product->getId();
        if($this->counter[$id]['darab']==1) {
            unset($this->counter[$id]);
           // return $this->getTotal();
        }
        else if($this->counter[$id]['darab']>1) {
            $this->counter[$id]['darab']--;
            $amount_inbasket=$this->counter[$id]['darab'];
           // return strval($this->getTotal()).';'.strval($amount_inbasket);
        }
        return $this->getJSONBasket();
    }



    /**
     * GETTERS
     */

    /**
     * Add a Product to the basket
     * @return float|int
     */
    public function getTotal() {
        $sum=0;
        foreach ($this->counter as $key=>$value) {
            $sum+=$this->counter[$key]['darab']*$this->counter[$key]['price'];
        }
        return $sum;
        //  Ez a metódus adja vissza a kosár összegét: SUM(termék darabszáma × termék ára)
    }

    public function getJSONBasket() {
        $array=[];
        foreach ($this->counter as $key=>$value) {
            $array[$key]['id']=$this->counter[$key]['product_id'];
            $array[$key]['name']=$this->counter[$key]['nev'];
            $array[$key]['quantity']=$this->counter[$key]['darab'];
            $array[$key]['price']=$this->counter[$key]['darab']*$this->counter[$key]['price'];
        }
        return json_encode($array);
    }

    /**
     * Add a Product to the basket
     * @return array
     */

    public function getContent() {
        $array=[];
        $i=0;
        foreach ($this->counter as $key=>$value) {
            $array[$i]=["id"=>$value['product_id'],"nev"=>$value['nev'],"darab"=>$value['darab'],"ar"=>$value['price']];
            $i++;
        }
        return $array;


    }

    public function getCounter() {
        return $this->counter;
    }

    public function deleteBasket() {
        $this->counter=[];
    }
}