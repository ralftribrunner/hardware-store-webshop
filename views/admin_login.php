<?php if (isset($_SESSION['admin']) && $_SESSION['admin']==false) echo "SIKERTELEN BEJELENTKEZÉS!"?>
<form method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password">
    <input type="submit" value="Login">
</form>
