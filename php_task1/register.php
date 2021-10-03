<?php
session_start();
$message = [];

if (!empty($_POST) && $_POST['authregister']) {
    validate_add();
}

function validate_add()
{
    global $message;
    $message = [];

    $data = [
        "name" => FILTER_SANITIZE_STRING,
        "phone" => FILTER_SANITIZE_NUMBER_FLOAT,
        "gender" => FILTER_SANITIZE_STRING,
        "email" => FILTER_VALIDATE_EMAIL,
        "password" => FILTER_SANITIZE_STRING
    ];

    // filter all input
    if ($s_data = filter_input_array(INPUT_POST, $data, false)) {
        $path = "database/users.json";
        // Testing each input
        foreach ($s_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Your $key is required";
        }
        // if their is no error message
        if (empty($message)) {

            // if database folder and user.json has been created
            if (file_exists($path)  && filesize($path) > 0) {

                // get all user from db 
                $db = file_get_contents($path);
                $users = json_decode($db, true);

                //loop and check if user exist in our database
                foreach ($users as $user) {
                    if ($user['email'] == $s_data['email'] || $user['phone'] == $s_data['phone']) {
                        $message['general'] = "User with this email or phone number Exist";
                        $_SESSION['message'] = $message;
                        session_write_close();
                        return;
                    }
                }
               
                // insert new User
                $users[] = $s_data;
                file_put_contents($path, json_encode($users),  LOCK_EX);
                $message['success'] =  "Your Registration was successfully, kindly login.";
            } else {

                file_exists('database') ? "" : mkdir("database", 0777);

                $handle = fopen($path, 'w+');

                fwrite($handle,  json_encode([$s_data]));
                $message['success'] =  "Your Registration was successfully, kindly login.";
                fclose($handle);
            }
            
        }
    } else {
        echo "<h1>Make sure you supplied all data!</h1>";
    }
    $_SESSION['message'] = $message;
}
include('header.php');

if(isset($_SESSION['current_user'])){
    header("location: index.php");
}
?>

<main>
    <h1 align="center">Registeration Page</h1>
    <h1>
        <?php

        if (isset($_SESSION['message'])) {
            echo (isset($_SESSION['message']['general']) ? $_SESSION['message']['general'] : (isset($_SESSION['message']['success']) ? $_SESSION['message']['success'] : ""));
        }

        ?>
    </h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" id="name" placeholder="Full name" required>
            <h3><?php
                echo isset($_SESSION['message']) ? (isset($_SESSION['message']['name']) ? $_SESSION['message']['name'] : "") : "";
                ?></h3>

        </div>

        <div>
            <label for="phone">Phone Number</label><br>
            <input type="tel" pattern="0[7-9]{1}[0,1]{1}[0-9]{8}" id="phone" name="phone" placeholder="E.g 08130447717" required>
            <h3><?php echo isset($_SESSION['message']) ? (isset($_SESSION['message']['phone']) ? $_SESSION['message']['phone'] : "") : "" ?></h3>
        </div>

        <div>
            <h2>Gender</h2>
            <input type="radio" name="gender" id="male" value="male" required>
            <label for="male">Male</label>

            <input type="radio" name="gender" id="female" value="female" required>
            <label for="female">Female</label>
            <h3><?php echo (isset($_SESSION['message']['gender']) ? $_SESSION['message']['gender'] : "") ?></h3>
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required>
            <h3><?php echo (isset($_SESSION['message']['email']) ? $_SESSION['message']['email'] : "") ?></h3>
        </div>

        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password">
            <h3><?php echo (isset($_SESSION['message']['password']) ? $_SESSION['message']['password'] : "") ?></h3>
        </div>

        <div>
            <input type="submit" name="authregister" value="Register"><br><br>
            <span>Already have an account? <a href="login.php">Login</a></span>
        </div>

    </form>
</main>
<?php

unset($_SESSION['message']);
$_SESSION['message'] = array();

?>

</body>

</html>