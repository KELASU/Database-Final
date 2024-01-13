<?php

@include 'inc_con.php';

session_start();

if(isset($_POST['submit'])) {
    $Email = mysqli_real_escape_string($connection, $_POST['Email']);
    $Password = md5($_POST['Password']);

    $select = "SELECT * FROM users WHERE Email = '$Email' AND Password = '$Password'";
    $result = mysqli_query($connection, $select);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Store the retrieved user ID in the session
        $_SESSION['UserID'] = $row['UserID'];

        // Check the user role and set session accordingly
        if($row['Role'] == 'Admin') {
            $_SESSION['admin_name'] = $row['Username'];
            header('location:admins.php');
        } elseif($row['Role'] == 'User') {
            $_SESSION['User_name'] = $row['Username'];
            header('location:user.php');
        } elseif($row['Role'] == 'Shelter') {
            $_SESSION['shelter_name'] = $row['Username'];
            header('location:shelter2.php');
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login Page</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="Email" name="Email" required placeholder="enter your email">
      <input type="Password" name="Password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</div>

</body>
</html>