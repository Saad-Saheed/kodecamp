<?php
include('./controllers/TodolistController.php');

// use todolist\controllers\TodolistController;
$title = "Home page";
$message = "";
$upd = null;

$t_control = new TodolistController();

//My little Routing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['action'] == 'add') {

    $message = $t_control->c_create($_POST);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['action'] == 'update') {

    $message = $t_control->c_update($_POST, $_REQUEST['id']);
    $upd = null;
} else if (isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'delete') {

    $message = $t_control->c_delete($_REQUEST['id']);
} else if (isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'edit') {

    $upd = (object) $t_control->c_show($_REQUEST['id']);
}

$list_data = $t_control->index();

include_once('./header.php');
?>
<div class="container">
    <fieldset>
        <legend><?php echo $upd ? "Update" : "Add New" ?> Todo</legend>

        <section>
            <?php echo ($message) ? "<h2 class='msg'>" . $message . "</h2>" : ""; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <input type="hidden" name="action" value="<?php echo $upd ? "update" : "add" ?>">
                <?php

                if ($upd) { ?>
                    <input type="hidden" name="id" value="<?php echo $upd->id ?>">
                <?php
                }
                ?>

                <div class="form-input">
                    <label for="body">Todo Details</label>
                    <input type="text" name="body" id="body" value="<?php echo $upd ? $upd->body : '' ?>">
                    <input type="submit" id="submit" value="<?php echo $upd ? "Update" : "+" ?>">
                </div>

            </form>
        </section>


        <section>
            <!-- available task -->
            <h2>available Task</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <th>S/N</th>
                    <th>Task To Do</th>
                    <th>Created On</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    if (isset($list_data)) {

                        foreach ($list_data as $todo) {
                            // $todo = iterator_to_array(
                            //     new RecursiveIteratorIterator(new RecursiveArrayIterator($list_data)),
                            //     true
                            // );                          
                            $todo = (object)$todo;
                    ?>
                            <tr>
                                <td> <?php echo $i ?></td>
                                <td> <?php echo substr($todo->body, 0, 40);
                                        echo (strlen($todo->body) > 40) ? "..." : "" ?></td>
                                <td> <?php echo $todo->created_at ?></td>
                                <td nowrap>
                                    <a class="btn view" href="./show.php?action=show&id=<?php echo $todo->id ?>">view</a>
                                    <a class="btn edit" href="?action=edit&id=<?php echo $todo->id ?>">edit</a>
                                    <a class="btn delete" href="?action=delete&id=<?php echo $todo->id ?>">Delete</a>
                                </td>
                            </tr>
                    <?php
                            $i += 1;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </fieldset>

</div>
</main>
</body>

</html>