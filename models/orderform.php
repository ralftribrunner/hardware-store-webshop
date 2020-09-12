<?php

require_once '../models/db.php';

class OrderForm {
    /** @var string  */
    protected $field_name;
    /** @var string  */
    protected $field_mail;
    /** @var string  */
    protected $field_comment;
    /** @var string  */
    protected $field_newsletter;
    /** @var string  */
    protected $field_terms;
    /** @var integer  */
    protected $token;


    /** @var string|null  */
    protected $error_name = null;
    /** @var string|null  */
    protected $error_mail = null;
    /** @var string|null  */
    protected $error_comment = null;
    /** @var string|null  */
    protected $error_newsletter = null;
    /** @var string|null  */
    protected $error_terms = null;

    /** @var bool  */
    private $is_submitted = false;
    /** @var bool  */
    private $is_valid = false;

    private $conn;

    public function __construct($POST_DATA = null) {
        // Initialize DB connection
        $db = DB::getInstance();
        $this->conn = $db->getConnection();

        $this->token = openssl_random_pseudo_bytes(10);
        $this->token = bin2hex($this->token);

        if(!is_null($POST_DATA)) {
            $this->field_name = $POST_DATA['name'] ?? "";
            $this->field_mail = $POST_DATA['mail'] ?? "";
            $this->field_comment = $POST_DATA['comment'] ?? "";
            $this->field_newsletter = $POST_DATA['newsletter'] ?? null;
            $this->field_terms = $POST_DATA['terms'] ?? "no";

            $this->is_submitted = isset($POST_DATA['submit']);
        }
    }

    public function validate() {
        // Validate name
        $this->valid = true;

        $this->error_name       = $this->validateName()       ? null : 'A név megadása kötelező!';
        $this->error_mail       = $this->validateMail()       ? null : 'Az email cím megadása kötelező!';
        $this->error_comment    = $this->validateComment()    ? null : 'A megjegyzés mező kitöltése hibás!';
        $this->error_newsletter = $this->validateNewsletter() ? null : 'A hírlevél mező kitöltése hibás!';
        $this->error_terms      = $this->validateTerms()      ? null : 'Az ÁSZF elfogadása kötelező!';

        $this->is_valid = is_null($this->error_name) && is_null($this->error_mail) && is_null($this->error_comment) &&
            is_null($this->error_newsletter) && is_null($this->error_terms);
    }

    //  implementálandók a validate() metódusban hivatkozott validateMező() eljárások. A visszatérési értékük
    //  a validálás sikerétől függően igaz vagy hamis. Például:

    /**
     * @return bool
     */
    private function validateName() {
        return strlen($this->field_name) > 0;
    }

    private function validateMail() {
        if (filter_var($this->field_mail,FILTER_VALIDATE_EMAIL)!=false) return true;
        else return false;
    }

    private function validateComment() {
        return true;
    }

    private function validateNewsletter() {
        if ($this->field_newsletter!=null) return true;
        else return false;
    }

    private function validateTerms() {
        if ($this->field_terms!="no") return true;
        else return false;
    }

    /**
     * @param Basket $basket
     * @return bool Success
     */
    public function save($basket) {
        $this->validate();
        if (!$this->is_valid || empty($basket))  return false;
        $this->field_name=htmlentities($this->field_name);
        $this->field_mail=htmlentities($this->field_mail);
        $this->field_comment=htmlentities($this->field_comment);
        $statement_update_orders = $this->conn->prepare('INSERT INTO orders (name, email,comment) VALUES (:name, :email,:comment)');
        $statement_update_orders->bindValue(':name', $this->field_name);
        $statement_update_orders->bindValue(':email',$this->field_mail);
        $statement_update_orders->bindValue(':comment',$this->field_comment);
        $last_id="0";
        $statement_getlastid = $this->conn->prepare('SELECT LAST_INSERT_ID();');
        $successful_db=$statement_update_orders->execute();
        if (!$successful_db) return false;
        $successful_db=$statement_getlastid->execute();
        if (!$successful_db) return false;
        $last_id=$statement_getlastid->fetchAll(PDO::FETCH_ASSOC);
        $last_id=$last_id[0]['LAST_INSERT_ID()'];


        foreach ($basket->getCounter() as $key=>$value) {
            $statement_update_ordersproducts=
                $this->conn->prepare('INSERT INTO orders_products (order_id, product_id,quantity) 
                                            VALUES (:lastid,:key,:value)');
            $statement_update_ordersproducts->bindValue(':lastid',$last_id);
            $statement_update_ordersproducts->bindValue(':key',$key);
            $statement_update_ordersproducts->bindValue(':value',$value['darab']);
            $successful_db=$statement_update_ordersproducts->execute();
            if (!$successful_db) return false;
        }

        $statement_already = $this->conn->prepare('SELECT * FROM newsletter_users WHERE email =:email');
        $statement_already->bindValue(':email',$this->field_mail);
        $successful_db=$statement_already->execute();
        if (!$successful_db) return false;
        $already=$statement_already->fetchAll(PDO::FETCH_ASSOC);
        if ($already) $this->token=$already[0]['token'];


        if ($this->field_newsletter=='on' && !$already) { //ha még nincs feliratkozva, akkor feliratoztatja
                $statement_insertuser=$this->conn->prepare('INSERT INTO newsletter_users (email, name,token) 
                                            VALUES (:email,:name,:token)');
                $statement_insertuser->bindValue(':email',$this->field_mail);
                $statement_insertuser->bindValue(':name',$this->field_name);
                $statement_insertuser->bindValue(':token',$this->token);
                $successful_db=$statement_insertuser->execute();
                if (!$successful_db) return false;
        }
        return true;



    }

    /**
     * GETTERS
     */

    public function isSubmitted() {
        return $this->is_submitted;
    }

    public function isValid() {
        return $this->is_valid;
    }

    public function getNameValue() {
        return $this->field_name;
    }

    public function getNameError() {
        return $this->error_name;
    }

    public function getMailValue() {
        return $this->field_mail;
    }

    public function getMailError() {
        return $this->error_mail;
    }

    public function getCommentValue() {
        return $this->field_comment;
    }

    public function getCommentError() {
        return $this->error_comment;
    }

    public function getNewsletterValue() {
        return $this->field_newsletter == 'on' ? 'on' : 'off';
    }

    public function getNewsletterError() {
        return $this->error_newsletter;
    }

    public function getTermsValue() {
        return $this->field_terms == 'yes' ? 'yes' : 'no';
    }

    public function getTermsError() {
        return $this->error_terms;
    }

    public function getToken() {
        if($this->token) return $this->token;
        else return null;
    }


}
