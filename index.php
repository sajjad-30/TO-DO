<?php
session_start();


if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}


if (isset($_POST['add'])) {
    $task = trim($_POST['input-box']);
    if ($task !== "") {
        $_SESSION['tasks'][] = ["text" => $task, "done" => false];
    }
}


if (isset($_POST['check'])) {
    $index = $_POST['check'];
    $_SESSION['tasks'][$index]['done'] = true; 
}


if (isset($_POST['delete'])) {
    $index = $_POST['delete'];
    array_splice($_SESSION['tasks'], $index, 1);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(88, 88, 88);
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: antiquewhite;
            margin-top: 20px;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-container {
            display: flex;
            margin: 20px;
            width: 100%;
        }

        #input-box {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 15px;
            padding: 10px;
            outline: none;
        }

        #ADD {
            margin-left: 10px;
            font-size: large;
            padding: 15px;
            border-radius: 10px;
            border: none;
            background-color: cadetblue;
            color: #fff;
            box-shadow: 2px 2px 10px 1px black;
            cursor: pointer;
        }

        .list {
            padding: 20px;
            list-style: none;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgb(133, 94, 102);
            padding: 15px;
            font-size: large;
            margin-bottom: 10px;
            color: #fff;
            border-radius: 8px;
        }

        .done {
            text-decoration: line-through;
            color: lightgray;
        }

        button {
            background: transparent;
            border: none;
            font-size: large;
            cursor: pointer;
            color: #fff;
        }

        hr {
            border: 1px solid #bbb;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <h1>TO DO LIST</h1>
    <div class="container">
        <form action="" method="post" style="width:70%;">
            <div class="input-container">
                <input type="text" name="input-box" id="input-box" placeholder="Enter a task">
                <button type="submit" name="add" id="ADD">ADD</button>
            </div>

            <ul class="list">
                <?php 
                $pending = [];
                $done = [];
                foreach ($_SESSION['tasks'] as $index => $task) {
                    if ($task['done']) {
                        $done[$index] = $task;
                    } else {
                        $pending[$index] = $task;
                    }
                }

              
                foreach ($pending as $index => $task): ?>
                <li class="item">
                    <p>
                        <?= htmlspecialchars($task['text']) ?>
                    </p>
                    <div class="icon-container">
                        <button type="submit" name="check" value="<?= $index ?>"><i
                                class="fa-solid fa-check"></i></button>
                        <button type="submit" name="delete" value="<?= $index ?>"><i
                                class="fa-solid fa-trash"></i></button>
                    </div>
                </li>
                <?php endforeach; ?>

                <?php if (!empty($pending) && !empty($done)): ?>
                <hr>
                <?php endif; ?>


                <?php foreach ($done as $index => $task): ?>
                <li class="item">
                    <p class="done">
                        <?= htmlspecialchars($task['text']) ?>
                    </p>
                    <div class="icon-container">

                        <button type="submit" name="delete" value="<?= $index ?>"><i
                                class="fa-solid fa-trash"></i></button>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </form>
    </div>
</body>

</html>