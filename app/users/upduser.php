<?php
    include "/opt/lampp/htdocs/hated/security/authentication/validation.php";

    $id = $_SESSION['userid'];

    $sql = "SELECT username, email FROM users WHERE id = :id";
    $stm_sql = $db_connection -> prepare($sql);
    $stm_sql -> bindParam(':id', $id);
    $stm_sql -> execute();
    $user = $stm_sql -> fetch(PDO::FETCH_ASSOC);

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
            $sql = "SELECT username FROM users WHERE username = :username AND id <> :id";
            $stm_sql = $db_connection -> prepare($sql);
            $stm_sql -> bindParam(':username', $username);
            $stm_sql -> bindParam(':id', $id);
            $stm_sql -> execute();

            if ($stm_sql -> rowCount() == 0) {
                $sql = "SELECT email FROM users WHERE email = :email AND id <> :id";
                $stm_sql = $db_connection -> prepare($sql);
                $stm_sql -> bindParam(':email', $email);
                $stm_sql -> bindParam(':id', $id);
                $stm_sql -> execute();

                if ($stm_sql -> rowCount() == 0) {
                    $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
                    $stm_sql = $db_connection -> prepare($sql);

                    $password = md5($password);

                    $stm_sql -> bindParam(':username', $username);
                    $stm_sql -> bindParam(':email', $email);
                    $stm_sql -> bindParam(':password', $password);
                    $stm_sql -> bindParam(':id', $id);

                    $result = $stm_sql -> execute();

                    if ($result) {
                        $msg = "User successfully updated.";
                        // header("Location: main.php?page=users/account.php");
                    } else {
                        $msg = "Failed to update user.";
                    }
                } else {
                    $msg = "E-mail already registered.";
                }
            } else {
                $msg = "Username already registered.";
            }
        }
        echo $msg;
    }
?>

<div id="page-update-user" class="page">
    <form action="#" name="update-user" method="POST">
        <h1>Update registration</h1>
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