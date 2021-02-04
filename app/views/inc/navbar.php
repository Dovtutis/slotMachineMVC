<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT?>"><?php echo SITENANE?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?php echo (isset($currentPage) && $currentPage === 'index') ? 'active' : ''?>" href="<?php echo URLROOT?>">Home</a>
            </div>
            <div class="navbar-nav ml-auto">
                <?php if(!isLoggedIn()) :?>
                    <a class="nav-link" href="<?php echo URLROOT?>users/register#">Register</a>
                    <a class="nav-link" href="<?php echo URLROOT?>users/login">Login</a>
                <?php else :?>
                    <a class="disabled nav-link active" href="#">Vilkommen <?php echo $_SESSION['username']?></a>
                    <a class="nav-link" href="<?php echo URLROOT?>account/update">My Account</a>
                    <a class="nav-link" href="<?php echo URLROOT?>game/startTheGame">Game</a>
                    <a class="nav-link" href="<?php echo URLROOT?>users/logout">Logout</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</nav>
