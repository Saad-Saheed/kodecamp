<?php
include('./controllers/TodolistController.php');

// use todolist\controllers\TodolistController;
$title="View Task Details";
$message = "";

$todo_control = new TodolistController();

if (isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'show') {

    $this_todo = (object) $todo_control->c_show($_REQUEST['id']);
} else {
    header('location: index.php');
}

include_once('./header.php');
?>

<div class="s-container">
    <div class="row" style="width: 60%; margin: 0 auto;">
        <div class="col" style="text-align: center; margin: 60px 0;">
            <h2>Created on: <?php echo $this_todo ? $this_todo->created_at : '' ?></h2>
            <h2>Last Update on: <?php echo $this_todo ? $this_todo->updated_at : '' ?></h2>
            <p><?php echo $this_todo ? $this_todo->body : '' ?></p>
        </div>
    </div>
</div>
</main>
</body>

</html>