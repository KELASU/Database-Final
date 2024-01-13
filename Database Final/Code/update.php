<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	color: rgb(156,131,33);
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
   
}
	
</style>

</head>
<body>
<?php
include 'inc_con.php';
$id = $_GET['id'];
$update = "SELECT * FROM users WHERE UserID = $id";
$updatequery = mysqli_query($connection, $update);
$result = mysqli_fetch_assoc($updatequery);


if(isset($_POST['submit'])){
    $id = $_GET['id'];
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
	$Role = $_POST['user_type'];

      $insertquery =  "UPDATE `users` SET `Username`='$Name',`First Name`='$Fname',`Last Name`='$lname',`Email`='$Email',`Password`='$Password',`Country`='$Country',`Province`='$Province',`City`='$City',`Address`='$Address',`Birth Date`='$Birth',`Role`='$Role' WHERE UserID = '$id'";
        $mysqliquery = mysqli_query($connection, $insertquery);
    if($insertquery){
        ?>
    <script>
        window.location.replace("admins.php");
    </script>

<?php 

    }else{
        echo 'Not Updated';
    }



}




?>


<div style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; text-align: center; font-size: 30px; position: relative; top: 150px;">
<a href="#editEmployeeModal" class="edit" data-toggle="modal">Click Here to Update<i class="material-icons" data-toggle="tooltip" title="Update">&#xE254;</i></a>
</div>							



<!-- Update Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="">
				<div class="modal-header">						
					<h4 class="modal-title">Update Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="uname" class="form-control" value="<?php echo $result['Username']; ?>" required>
					</div>
					<div class="form-group">
						<label>First name</label>
						<input type="text" name="fname" class="form-control" value="<?php echo $result['First Name']; ?>" required>
					</div>
					<div class="form-group">
						<label>Last name</label>
						<input type="text" name="sname" class="form-control" value="<?php echo $result['Last Name']; ?>" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" value="<?php echo $result['Email']; ?>" required>
					</div>
					<div class="form-group">
						<label>Country</label>
						<input type="text" name="country" class="form-control" value="<?php echo $result['Country']; ?>" required>
					</div>
					<div class="form-group">
						<label>Province</label>
						<input type="text" name="province" class="form-control" value="<?php echo $result['Province']; ?>" required>
					</div>
					<div class="form-group">
						<label>City</label>
						<input type="text" name="city" class="form-control" value="<?php echo $result['City']; ?>" required>
					</div>
					<div class="form-group">
						<label>Address</label>
						<input type="text" name="address" class="form-control" value="<?php echo $result['Address']; ?>" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="text" name="password" class="form-control" value="<?php echo $result['Password']; ?>" required>
					</div>			
					<div class="form-group">
						<label>Birthdate</label>
						<input type="date" name="birthdate" class="form-control" value="<?php echo $result['Birth Date']; ?>" required>
					</div>		
					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" name="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- delete modele -->
<div id="deleteEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>