<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "todo_app");


if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
     
        if ($password == $row['password']) {
            // ✅ login success
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: tasks.php");
            exit;
        } else {
            $error = "❌ Wrong Password";
        }
    } else {
        $error = "❌ User not found";
    }
}
?>
<h2>Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <input type="text" name="username" placeholder="Enter Username" required><br>
    <input type="password" name="password" placeholder="Enter Password" required><br>
    <button type="submit" name="login">Login</button>
</form>
