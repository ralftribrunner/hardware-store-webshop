<?php
require_once '../models/db.php';

class Subscribers
{
    private $conn;


    public function __construct() {
        $db = DB::getInstance();
        $this->conn = $db->getConnection();
    }

    public function unsubscribe($token) {
        $statement_delete=$this->conn->prepare('DELETE FROM newsletter_users WHERE token = :token');
        $statement_delete->bindValue(':token',$token);
        $success=$statement_delete->execute();
        if ($success) return true;
        else return false;
    }

}