<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "todo_app");
$user_id = $_SESSION['user_id'];

if (isset($_POST['add'])) {
    $task = trim($_POST['task']);
    if ($task != "") {
        $task = mysqli_real_escape_string($conn, $task);
        $sql = "INSERT INTO todos (user_id, task) VALUES ('$user_id', '$task')";
        mysqli_query($conn, $sql);
    }
}


if (isset($_GET['done'])) {
    $id = (int)$_GET['done'];
    mysqli_query($conn, "UPDATE todos SET done=1 WHERE id='$id' AND user_id='$user_id'");
}


if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM todos WHERE id='$id' AND user_id='$user_id'");
}


$todos = mysqli_query($conn, "SELECT * FROM todos WHERE user_id='$user_id'");
?>


<form method="post">
    <input type="text" name="task" placeholder="Add new task" required>
    <button type="submit" name="add">Add</button>
</form>

<ul>
<?php while($row = mysqli_fetch_assoc($todos)) { ?>
    <li>
        <?= $row['done'] ? "<s>".htmlspecialchars($row['task'])."</s>" : htmlspecialchars($row['task']) ?>
        <?php if(!$row['done']) { ?>
            <a href="?done=<?= $row['id'] ?>"> Done</a>
        <?php } ?>
        <a href="?delete=<?= $row['id'] ?>"> Delete</a>
    </li>
<?php } ?>
</ul>
