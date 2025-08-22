<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "todo_app");

// login form submit check
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: todo.php"); // login success
            exit;
        } else {
            echo "❌ Wrong Password";
        }
    } else {
        echo "❌ User not found";
    }
}
?>
<form method="post">
    <input type="text" name="username" placeholder="Enter Username" required><br>
    <input type="password" name="password" placeholder="Enter Password" required><br>
    <button type="submit" name="login">Login</button>
</form>
