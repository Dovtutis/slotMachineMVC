<?php

class Account extends Controller
{
    private $myAccountModel;
    private $userModel;

    public function __construct()
    {
        if (!isLoggedIn()) redirect('users/login');
        $this->myAccountModel = $this->model('MyAccount');
        $this->userModel = $this->model('User');
    }

    public function update()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $minimalSum = 50;

        $data = [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'balance' => $user['balance'],
            'currentPage' => 'myAccount'
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $sumFromInput = $_POST['depositCashOutInput'];

            if (empty($sumFromInput)){
                $data['depositCashOutInputError'] = 'Please enter the sum';
            }

            if ($sumFromInput<$minimalSum){
                $data['depositCashOutInputError'] = "Minimal sum is $minimalSum";
            }

            if (empty($data['depositCashOutInputError']) && $_POST['depositCashOutBtn'] === 'deposit'){
                $data['sumFromInput'] = $sumFromInput;
                $data['balance'] =  $user['balance'] + $sumFromInput;

                if ($this->myAccountModel->updateBalance($data)){
                    $this->view('users/myAccount', $data);
                }else{
//                    die('depositas sugriuvo');
                }
            }elseif (empty($data['depositCashOutInputError']) && $_POST['depositCashOutBtn'] === 'cashout'){
                if ($data['balance']-$sumFromInput >= 0){
                    $data['sumFromInput'] = $sumFromInput;
                    $data['balance'] =  $user['balance'] - $sumFromInput;

                    if ($this->myAccountModel->updateBalance($data)){
                        $this->view('users/myAccount', $data);
                    }else{
//                        die('depositas sugriuvo');
                    }
                }else {
                    $data['depositCashOutInputError'] = "There are not enough money in your account to cash out";
                    $this->view('users/myAccount', $data);
                }
            }
            $this->view('users/myAccount', $data);
        }else {
            $this->view('users/myAccount', $data);
        }
    }
}