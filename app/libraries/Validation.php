<?php


class Validation
{
    private $password;

    public function ifRequestIsPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST")return true;
        return false;
    }

    public function sanitizePost ()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public function ifEmptyArray($arr)
    {
        foreach ($arr as $value){
            if (!empty($value)) return false;
        }
        return true;
    }

    public function validateEmpty($field, string $msg)
    {
        return empty($field) ? $msg : '';
    }

    public function validateName($field, &$userModel)
    {
        if (empty($field)) return "Please enter your Username";
        if (!preg_match("/^[a-z ,.'-]+$/i", $field)) return "Username must only contain letters";
        if ($userModel->findUserByUsername($field)) return "Username already taken";
        return '';
    }

    public function validateLoginUsername($field, &$userModel)
    {
        if (empty($field)) return "Please enter Your Username";
        if (!$userModel->findUserByUsername($field)) return "Username is not found";
        return "";
    }

    public function validatePassword($passField, $min, $max)
    {
        if (empty($passField)) return "Please enter Your Password";
        $this->password = $passField;
        if (strlen($passField) < $min) return "Password must be minimum $min characters long";
        if (strlen($passField) > $max) return "Password must be maximum $max characters long";
        if(!preg_match("#[0-9]+#", $passField)) return "Password must include at least one number!";
        if(!preg_match("#[a-z]+#", $passField)) return "Password must include at least one letter!";
        if(!preg_match("#[A-Z]+#", $passField)) return "Password must include at least one capital letter!";
        return '';
    }

    public function confirmPassword($repeatField)
    {
        if (empty($repeatField)) return "Please repeat your password";
        if (!$this->password) return "No password found";
        if ($repeatField !== $this->password) return "Password must match";
        return '';
    }

    public function ifRequestIsPostAndSanitize()
    {
        if ($this->ifRequestIsPost()){
            $this->sanitizePost();
            return true;
        }
        return false;
    }


    public function checkIfBalanceIsEnough($balance, $sum)
    {
        if ($balance - $sum >=0){
            return true;
        }else{
            return "There is not enough money in your balance";
        }

    }

    public function checkMinimalSum($bet, $minimalBet)
    {
        if ($bet >= $minimalBet){
            return true;
        }else{
            return "The minimal bet is 5";
        }
    }

    public function checkWinnings($arr){
        $winningsArr = [];

        if ($arr[0] === $arr[1] && $arr[0] === $arr[2]){
            $winningsArr["multiplayer"][] =  3;
            $winningsArr["messages"][] = "First Row! x3 Multiplayer";
        }
        if ($arr[3] === $arr[4] && $arr[3] === $arr[5]){
            $winningsArr["multiplayer"][] =  4;
            $winningsArr["messages"][] = "Second Row! x4 Multiplayer";
        }
        if ($arr[6] === $arr[7] && $arr[6] === $arr[8]){
            $winningsArr["multiplayer"][] =  5;
            $winningsArr["messages"][] = "Third Row! x5 Multiplayer";
        }
        if ($arr[0] === $arr[4] && $arr[0] === $arr[8] || $arr[2] === $arr[4] && $arr[2] === $arr[6]){
            $winningsArr["multiplayer"][] =  5;
            $winningsArr["messages"][] = "Diagonal Row! x5 Multiplayer";
        }
        if ($arr[0] === $arr[4] && $arr[0] === $arr[8] && $arr[2] === $arr[4] && $arr[0] === $arr[6]){
            $winningsArr["multiplayer"][] =  10;
            $winningsArr["messages"][] = "Diagonal X Row! x10 Multiplayer";
        }

        return $winningsArr;
    }


}