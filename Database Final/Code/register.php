<?php

@include 'inc_con.php';

if(isset($_POST['submit'])){

   $Name = mysqli_real_escape_string($connection, $_POST['uname']);
   $Fname = mysqli_real_escape_string($connection, $_POST['fname']);
   $Lname = mysqli_real_escape_string($connection, $_POST['sname']);
   $Email = mysqli_real_escape_string($connection, $_POST['email']);
   $Country = mysqli_real_escape_string($connection, $_POST['country']);
   $Province = mysqli_real_escape_string($connection, $_POST['province']);
   $City = mysqli_real_escape_string($connection, $_POST['city']);
   $Address = mysqli_real_escape_string($connection, $_POST['address']);
   $Password = md5($_POST['password']);
   $CPassword = md5($_POST['cpassword']);
   $Birth = date('Y-m-d', strtotime($_POST['birthdate']));
   $Role = $_POST['user_type'];

   $select = " SELECT * FROM users WHERE Email = '$Email' && password = '$Password' ";

   $result = mysqli_query($connection, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($Password != $CPassword){
         $error[] = 'password not matched!';
      }else{
         
         $insert = "INSERT INTO `users` (`UserID`,`Username`, `First Name`, `Last Name`, `Email`, `Password`, `Country`, `Province`, `City`, `Address`, `Birth Date`, `Role`) VALUES (NULL,'$Name','$Fname','$Lname','$Email','$Password','$Country','$Province','$City','$Address','$Birth','$Role')";
         mysqli_query($connection, $insert);
         header('location:login.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register Page</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="uname" required placeholder="enter your Username">
      <input type="text" name="fname" required placeholder="enter your First name">
      <input type="text" name="sname" required placeholder="enter your Last name">
      <input type="text" name="country" required placeholder="enter your Country">
      <input type="text" name="province" required placeholder="enter your Province">
      <input type="text" name="city" required placeholder="enter your City">
      <input type="text" name="address" required placeholder="enter your Address">
      <input type="date" name="birthdate" required placeholder="enter your Birthdate">
      <input type="email" name="email" required placeholder="enter your Email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="user_type">
         <option value="user">User</option>
         <option value="shelter">Shelter</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>