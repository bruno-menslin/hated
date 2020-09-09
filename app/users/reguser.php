<?php
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($username == '') {
            $msg = "Fill the username field.";
        } else if ($email == '') {
            $msg = "Fill the email field.";
        } else if ($password == '') {
            $msg = "Fill the password field.";
        } else {
            $sql = "SELECT username FROM users WHERE username = :username";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> bindParam(':username', $username);
            $stm_sql -> execute();

            if ($stm_sql -> rowCount() == 0) {
                $sql = "SELECT email FROM users WHERE email = :email";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':email', $email);
                $stm_sql -> execute();

                if ($stm_sql -> rowCount() == 0) {
                    $sql = "INSERT INTO users VALUES (:id, :username, :email, :password, :permission)";

                    $stm_sql = $db_connection -> prepare($sql);

                    $id = NULL;
                    $password = md5($password);
                    $permission = 1;

                    $stm_sql -> bindParam(':id', $id);
                    $stm_sql -> bindParam(':username', $username);
                    $stm_sql -> bindParam(':email', $email);
                    $stm_sql -> bindParam(':password', $password);
                    $stm_sql -> bindParam(':permission', $permission);

                    $result = $stm_sql -> execute();

                    if ($result) {
                        $msg = "User successfully registered.";
                    } else {
                        $msg = "Failed to register user.";
                    }
                } else {
                    $msg = "E-mail already registered.";
                }
            } else {
                $msg = "Username already registered.";
            }
        }
        echo "
            <script type='text/javascript'>
                alert('$msg');
                if ('$msg' == 'User successfully registered.') {
                    window.location = '../security/authentication/login.php';
                }
            </script>
        ";
    }
?>

<div id="page-register-user" class="page">
    <nav>
        <a href="../security/authentication/login.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Create account</h3>
    </nav>
    <form action="#" name="register-user" method="POST">
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
            <a href="../security/authentication/login.php">Login</a>
        </div>
    </form>
</div>