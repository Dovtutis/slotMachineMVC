<?php


class Game extends Controller
{
    private $myAccountModel;
    private $userModel;
    private $validation;

    public function __construct()
    {
        if (!isLoggedIn()) redirect('users/login');
        $this->myAccountModel = $this->model('MyAccount');
        $this->userModel = $this->model('User');
        $this->validation = new Validation();
    }

    public function startTheGame()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $data = [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'balance' => $user['balance'],
            'currentPage' => 'game',
            'imageArray' => ['https://previews.123rf.com/images/lineartestpilot/lineartestpilot1909/lineartestpilot190907636/129368971-cartoon-question-mark-with-speech-bubble-in-retro-texture-style.jpg'],
            'resultsArray' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
            'winnings' => []
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["play"])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $minimalBet = 5;
            $userBalance = $data['balance'];

            $sumFromInput = $_POST['betSum'];
            $minimalSum = $this->validation->checkMinimalSum($sumFromInput, $minimalBet);
            $betValidation = $this->validation->checkIfBalanceIsEnough($sumFromInput, $userBalance);

            if ($minimalSum === true) {
                if ($betValidation) {
                    for ($x = 0; $x < 9; $x++) {
                        $resultsArray[] = rand(0, 2);
                    }
                    $data['imageArray'] = [
                        'https://media1.giphy.com/media/w7IOh6J3W6Vd34o22r/giphy.gif',
                        'https://media2.giphy.com/media/l41JPeFUmYnY31Sfu/giphy.gif',
                        'https://media3.giphy.com/media/3oFzlVEIlQtEuoHebS/giphy.gif'
                    ];
                    $data['resultsArray'] = $resultsArray;
                    $winnings = $this->validation->checkWinnings($resultsArray);

                    if (!empty($winnings)) {
                        $multiplayerResults = $winnings["multiplayer"];

                        foreach ($multiplayerResults as $result) {
                            $totalSum = $userBalance + ($sumFromInput * $result);
                            $data['balance'] = $totalSum;
                            $this->myAccountModel->updateBalance($data);
                        }
                        $data['winnings'] = $winnings['messages'];
                        $this->view('pages/game', $data);
                    } else {
                        $data['winnings'][] = "Try again!";
                        $totalSum = $userBalance - $sumFromInput;
                        $data['balance'] = $totalSum;
                        $this->myAccountModel->updateBalance($data);
                        $this->view('pages/game', $data);
                    }
                } else {
                    $data['betError'] = $betValidation;
                    $this->view('pages/game', $data);
                }
            } else {
                $data['betError'] = $minimalSum;
                $this->view('pages/game', $data);
            }
        } else {
            $data['imageArray'] = ['https://previews.123rf.com/images/lineartestpilot/lineartestpilot1909/lineartestpilot190907636/129368971-cartoon-question-mark-with-speech-bubble-in-retro-texture-style.jpg'];
            $data['resultsArray'] = [0, 0, 0, 0, 0, 0, 0, 0, 0];
            $this->view('pages/game', $data);
        }
    }
}