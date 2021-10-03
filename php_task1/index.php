<?php
session_start();

include('header.php');
if (!isset($_SESSION['current_user']))
    header("location: login.php");

$errmessage = [];
if ($_POST && $_POST['upload']) {


    //  let create images directory if not exist
    if (!file_exists("./images/users")) {
        mkdir("./images", 0766);
        mkdir("./images/users", 0766);
    }

    $dbpath = './database/users.json';

    $allow_extension = ['jpg', 'png', 'jpeg'];
    $photo_name = isset($_FILES['photo']) ? basename($_FILES['photo']['name']) : "";

    //if photo did not supplied
    if (!$_FILES['photo'] || !$_FILES['photo']['name']){
        $errmessage['photo'] = "Photo is required";
    }
    //if photo size is greater than 1MB
    else if($_FILES['photo']['size'] > 1000000){
        $errmessage['photo'] = "Photo must not greater than 1MB";
    }
    //if photo format is not allow
    else if(!in_array(pathinfo($photo_name, PATHINFO_EXTENSION), $allow_extension)){
        $errmessage['photo'] = "Only jpeg, png and jpg format are supported";
    }
     // if the photo uploaded is exist in the images/users folder 
     elseif (file_exists("./images/users/" . $photo_name)) {
        $errmessage['photo'] = 'This photo exist already';
      }   

    // if their is no error message
    if (empty($errmessage)) {
         // get all user from db 
         $users = json_decode(file_get_contents($dbpath), true);

        //  var_dump($users);die;

          //loop through each user and check for currently login user, then upload their photo
          foreach ($users as $key => &$this_user) {

            if ((trim($user->email) == trim($this_user['email']))) {
                // add photo to user data
                $this_user["photo"] = $photo_name;

                // update the users.json file
                file_put_contents($dbpath, json_encode($users), LOCK_EX);

                // update current login user session
                $_SESSION['current_user']['photo'] = $photo_name;
                $user = (object)$_SESSION['current_user'];
                header('refresh:1;url=index.php');
                if(move_uploaded_file($_FILES['photo']['tmp_name'], './images/users/'.$photo_name)){
                    $errmessage['general'] = "Profile photo upload successfully";
                }
                break;
            }
        }

       
    }
}
?>

<main>
    <h1 align="center">Home Page</h1>
    <h1>Your are welcome dear <?php echo $user->name ?></h1>

    <?php if (!isset($user->photo)) { ?>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
        <h4>
            <?php 
                isset($errmessage['general']) ?  $errmessage['general'] : "";
            ?>
        </h4>  
       
            <div>
                <label for="photo">Kindly upload your profile photo</label><br>
                <input type="file" name="photo" id="photo" accept=".jpg, .png, .jpeg">
                <h3><?php echo (count($errmessage) > 0) ? (isset($errmessage['photo']) ? $errmessage['photo'] : "") : "" ?></h3>
            </div>

            <div>
                <input type="submit" name="upload" value="Upload photo">
            </div>

        </form>
    <?php } ?>
</main>


</body>

</html>