<?php

require_once '../models/db.php';

class Admin
{
    private $username;

    /** @var PDO  */
    private $conn;

    /**
     * Admin constructor.
     * @param string $username
     */
    public function __construct($username)
    {
        $username=htmlentities($username);
        $this->username = $username;
        $db = DB::getInstance();
        $this->conn = $db->getConnection();

    }

    public function signup() { //this is for just a script, to generate some admins
        $hash = password_hash("webprog", PASSWORD_BCRYPT, ['cost' => 12]);
        $statement_insert=$this->conn->prepare('INSERT INTO admin(user, pass) VALUES (:username,:hash)');
        $statement_insert->bindValue(':username',$this->username);
        $statement_insert->bindValue(':hash',$hash);
        $result=$statement_insert->execute();
        if ($result) return true;
        else return false;
    }
    /* Sign-up script in admin_index.php
     * for ($i = 1; $i <= 5; $i++) {
    $ADMIN=new Admin('ADMIN'.$i);
    $ADMIN->signup();
       }
     */

    public function getOrders() {
        $statement_getOrders=$this->conn->prepare('SELECT * FROM orders');
        $result=$statement_getOrders->execute();
        if(!$result) return false;
        $orders=$statement_getOrders->fetchAll(PDO::FETCH_ASSOC);
        if (empty($orders) ) return "The orders table is empty";
        return $orders;
    }

    public function auth($pass) {
        $pass=htmlentities($pass);
        $statement_getHash=$this->conn->prepare('SELECT pass FROM admin WHERE user = :username');
        $statement_getHash->bindValue(':username',$this->username);
        $success=$statement_getHash->execute();
        if (!$success) return false;
        $result=$statement_getHash->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) return false;
        $valid = password_verify($pass,$result[0]['pass']);
        return $valid;
    }

    public function passchange($oldpass, $newpass) {
        if ($this->auth($oldpass)) {
            $password = $newpass;
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $statement_update=$this->conn->prepare('UPDATE admin SET pass = :newpass WHERE user = :username');
            $statement_update->bindValue(':newpass',$hash);
            $statement_update->bindValue(':username',$this->username);
            $result=$statement_update->execute();
            if ($result) return true;
            else return false;

        }

    }


}