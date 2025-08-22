<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // agar login nahi hua to redirect
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "todo_app");
$user_id = $_SESSION['user_id'];

// Add Task
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    if ($task != "") {
        $sql = "INSERT INTO todos (user_id, task) VALUES ('$user_id', '$task')";
        mysqli_query($conn, $sql);
    }
}

// Mark Done
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $sql = "UPDATE todos SET done=1 WHERE id='$id' AND user_id='$user_id'";
    mysqli_query($conn, $sql);
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM todos WHERE id='$id' AND user_id='$user_id'";
    mysqli_query($conn, $sql);
}

// Get Todos
$todos = mysqli_query($conn, "SELECT * FROM todos WHERE user_id='$user_id'");
?>
<h2>Welcome <?= $_SESSION['username'] ?> 👋</h2>
<a href="logout.php">Logout</a>

<form method="post">
    <input type="text" name="task" placeholder="Add new task">
    <button type="submit" name="add">Add</button>
</form>

<ul>
<?php while($row = mysqli_fetch_assoc($todos)) { ?>
    <li>
        <?= $row['done'] ? "<s>".$row['task']."</s>" : $row['task'] ?>
        <?php if(!$row['done']) { ?>
            <a href="?done=<?= $row['id'] ?>">✔ Done</a>
        <?php } ?>
        <a href="?delete=<?= $row['id'] ?>">❌ Delete</a>
    </li>
<?php } ?>
</ul>
