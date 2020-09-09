<?php
    $redirect = "users/account.php";
    include "../security/authentication/validation.php";
?>
<div id="page-account" class="page">
    <nav>
        <a href="../index.php">
            <img src="../assets/images/back.svg" alt="back">
        </a>
        <h3>Account</h3>
    </nav>
    <a href="main.php?page=spots/managespots.php">Manage your spots</a>
    <a href="main.php?page=users/upduser.php">Update your account</a>
    <a href="../security/authentication/logout.php">Logout</a>
</div>