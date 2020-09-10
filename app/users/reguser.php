<div id="page-register-user" class="page">
    <nav>
        <a href="../security/authentication/login.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Create account</h3>
    </nav>
    <form action="main.php?page=users/ins.php" name="register-user" method="POST">
        <h1>Create your account</h1>
        <fieldset>
            <div class="field">
                <label for="idusername">Username</label>
                <input type="text" name="username" id="idusername">
            </div>
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
            <button type="submit" name="submit">Create</button>
            <a href="main.php?page=users/frmlogin.php">Login</a>
        </div>
    </form>
</div>