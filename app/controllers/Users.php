<?php

/*
 * Users class
 * Register user
 * Login user
 * Control Users behavior and access
 */

class Users extends Controller
{
        private $userModel;
        private $validation;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->validation = new Validation();
    }

    public function register()
    {

        if ($this->validation->ifRequestIsPostAndSanitize()){

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'errors' => [
                    'usernameErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => ''
                ],
                'currentPage' => 'register'
            ];

            $data['errors']['usernameErr'] = $this->validation->validateName($data['username'], $this->userModel);
            $data['errors']['passwordErr'] = $this->validation->validatePassword($data['password'], 6, 15);
            $data['errors']['confirmPasswordErr'] = $this->validation->confirmPassword($data['confirmPassword']);

            if ($this->validation->ifEmptyArray($data['errors'])){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)){
                    flash('register_success', 'You have registered successfully');
                    redirect('/users/login');
                }else{
                    die('Something went wrong in adding user to DB');
                }
            }else {
                flash('register_fail', 'Please check the form', 'alert alert-danger');
                $this->view('users/register', $data);
            }

        }else {
            $data = [
                'username' => '',
                'password' => '',
                'confirmPassword' => '',
                'errors' => [
                    'usernameErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => ''
                ],
                'currentPage' => 'register'
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if ($this->validation->ifRequestIsPostAndSanitize()){

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'errors' => [
                    'usernameErr' => '',
                    'passwordErr' => '',
                ],
            ];

            $data['errors']['emailErr'] = $this->validation->validateLoginUsername($data['username'], $this->userModel);
            $data['errors']['passwordErr'] = $this->validation->validateEmpty($data['password'], 'Please enter your password');


            if ($this->validation->ifEmptyArray($data['errors'])){
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                if ($loggedInUser){
                    $this->createUserSession($loggedInUser);
                }else {
                    $data['errors']['passwordErr'] = "Wrong password";
                    $this->view('users/login', $data);
                }
            }else {
                $this->view('users/login', $data);
            }

        }else {

            $data = [
                'username' => '',
                'password' => '',
                'errors' => [
                    'usernameErr' => '',
                    'passwordErr' => '',
                ],
            ];

            $this->view('users/login', $data);
        }
    }

    public function createUserSession($userRow)
    {
        $_SESSION['user_id'] = $userRow->id;
        $_SESSION['username'] = $userRow->username;
        $_SESSION['balance'] = $userRow->balance;
        redirect('account/update');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['balance']);

        session_destroy();
        redirect('users/login');
    }

}