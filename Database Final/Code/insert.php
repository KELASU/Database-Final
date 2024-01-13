<?php
include 'inc_con.php';
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

    $Birth = date('Y-m-d', strtotime($_POST['birthdate']));
    $Role = $_POST['Role'];

      $insertquery =  "INSERT INTO `users` (`UserID`,`Username`, `First Name`, `Last Name`, `Email`, `Password`, `Country`, `Province`, `City`, `Address`, `Birth Date`, `Role`) VALUES (NULL,'$Name','$Fname','$Lname','$Email','$Password','$Country','$Province','$City','$Address','$Birth','$Role')";
        $mysqliquery = mysqli_query($connection, $insertquery);
    if($insertquery){
        ?>
    <script>
        window.location.replace("admins.php");
    </script>

<?php 

    }else{
        echo 'Not Inserted';
    }



}



?>