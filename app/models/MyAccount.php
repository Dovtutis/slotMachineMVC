<?php

class MyAccount
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function updateBalance($data)
    {
        $this->db->query("UPDATE users SET balance = :balance WHERE id = :id LIMIT 1");
        $this->db->bind(':balance', $data['balance']);
        $this->db->bind(':id', $data['id']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }


}

//UPDATE test
//SET kita_id = kita_id + 1
//WHERE id = 1