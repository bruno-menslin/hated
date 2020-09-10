<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $sql = "SELECT username, email FROM users WHERE id = :id";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':id', $_SESSION['userid']);
    $stm_sql -> execute();
    $user = $stm_sql -> fetch(PDO::FETCH_ASSOC);
?>

<div id="page-update-user" class="page">
    <nav>
        <a href="?page=users/account.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Update account</h3>
    </nav>
    <form action="main.php?page=users/upd.php" name="update-user" method="POST">
        <h1>Update your account</h1>
        <fieldset>
            <div class="field">
                <label for="idusername">Username</label>
                <input type="text" name="username" id="idusername" value="<?php echo $user['username']; ?>">
            </div>
            <div class="field">
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail" value="<?php echo $user['email']; ?>">
            </div>
            <div class="field">
                <label for="idpassword">Password</label>
                <input type="password" name="password" id="idpassword">
            </div>
        </fieldset>
        <div class="form-buttons">
            <button type="submit" name="submit">Update</button>
        </div>        
    </form>
</div>