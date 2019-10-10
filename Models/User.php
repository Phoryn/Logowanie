<?php
class User
{
    private $conn;
    private $table = 'uzytkownicy';

    public $id;
    public $user;
    public $pass;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function read()
    {
        $query = 'SELECT 
        id,
        user,
        pass,
        email
        FROM
        ' . $this->table;

        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;
    }

    public function create($s_user, $s_pass, $s_email)
    {
        $pass_hash = password_hash($s_pass, PASSWORD_DEFAULT);

        $query = "INSERT INTO `". $this->table. "` (user, pass, email) VALUES('". $s_user . "','" . $pass_hash . "','". $s_email. "')";

        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;
    }

    public function update($s_id,$s_user, $s_email)
    {

        $query = "UPDATE
                " . $this->table . "
                SET
                user = '". $s_user . "',
                email = '". $s_email ."'
                WHERE
                id = ".$s_id;


        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;

    }

    public function delete($s_id)
    {

        $query = "DELETE FROM $this->table WHERE id=" . $s_id;
        echo $query;

        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;

    }


    
}