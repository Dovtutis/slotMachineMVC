<?php
require APPROOT . '/views/inc/header.php';
?>

    <div class="container gameContainer my-1">
        <div class="my-2"><h2>3x3 Slot Machine</h2></div>
        <div class="my-2"><h3 id="userBalance">Your balance is: <?php echo $data['balance']?></h3></div>
        <div class="depositCashOutBox">
            <?php foreach ($data['winnings'] as $message):?>
                <h2><?php echo $message?></h2>
            <?php endforeach;?>
            <form action="" method="post" autocomplete="off" id="game-form">
                <div class="form-group depositCashOutInputBox">
                    <input required type="text" class="form-control" name="betSum" id="betSum" value="" placeholder="Enter your bet">
                    <p class="error-msg"><?php echo $data['betError'] ?? null?></p>
                    <button type="submit" name="play" class="depositCashOutButton">Play</button>
                </div>
            </form>
        </div>
        <div class="my-5 slotMachineContainer">
            <?php foreach ($data['resultsArray'] as $result):?>
                <img class="gameImg" src="<?php echo $data['imageArray'][$result]?>" alt="">
            <?php endforeach;?>
        </div>
    </div>

<?php
require APPROOT . '/views/inc/footer.php';
?>
