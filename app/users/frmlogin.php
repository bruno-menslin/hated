<div id="page-login" class="page">
    <nav>
        <a href="../index.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Login</h3>
    </nav>
    <form action="../security/authentication/login.php" name="login" method="POST">
        <input type="hidden" name="redirect" value="<?php echo $_GET['redirect']; ?>">
        <h1>Login</h1>
        <fieldset>
            <div class="field">
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail">
            </div>
            <div class="field">
                <label for="idpassword">Password</label>
                <input type="password" name="password" id="idpassword">
            </div>                              
        </fieldset>
        <div class="form-buttons">
            <button type="submit">Login</button>
            <a href="main.php?page=users/reguser.php">Sign up</a>
        </div> 
    </form>
</div>