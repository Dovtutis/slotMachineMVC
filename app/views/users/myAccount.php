<?php require APPROOT . '/views/inc/header.php';

;?>
    <div class="container gameContainer my-5">
        <div class="my-2"><h2>Hello, <?php echo $data['username']?></h2></div>
        <div class="my-2"><h3 id="userBalance">Your balance is: <?php echo $data['balance']?></h3></div>
        <div class="depositCashOutBox">
            <form action="" method="post" autocomplete="off" id="game-form">
                <div class="form-group depositCashOutInputBox">
                    <label for="deposit">Input sum for cash out or deposit</label>
                    <input required type="text" class="form-control" name="depositCashOutInput" id="depositCashOutInput" value="" placeholder="Min. bet 50">
                    <p id="error-msg" class="error-msg"><?php echo $data['depositCashOutInputError'] ?? null?></p>
                    <button type="submit" name="depositCashOutBtn" value="deposit" class="depositCashOutButton">Deposit</button>
                    <button type="submit" name="depositCashOutBtn" value="cashout" class="depositCashOutButton">Cash Out</button>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php';