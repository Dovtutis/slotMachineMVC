<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findUserByUsername($username)
    {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        $row = $this->db->singleRow();
        if ($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function register($data)
    {
        $this->db->query("INSERT INTO users (`username`, `password`) VALUES (:username, :password)");
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $this->db->query("SELECT * FROM users WHERE `username` = :username");
        $this->db->bind(':username', $username);
        $row = $this->db->singleRow();

        if ($row){
            $hashedPassword = $row->password;
        }else{
            return false;
        }

        if (password_verify($password, $hashedPassword)){
            return $row;
        }else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = $id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRowArray();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }
}