<?php
// include('inc_con.php');

// function getAllUsers() {
//     global $connection;
//     $result = $connection->query("SELECT * FROM users");
//     return $result->fetch_all(MYSQLI_ASSOC);
// }

// function addUser($uname,$Fname, $Lname, $Email, $Password, $Country, $Province, $City, $Address, $Birth, $Role) {
//     global $connection;
//     $stmt = $connection->prepare("INSERT INTO `users` (`UserID`,`Username`, `First Name`, `Last Name`, `Email`, `Password`, `Country`, `Province`, `City`, `Address`, `Birth Date`, `Role`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?)");
//     $stmt->bind_param("sss", null,$uname,$Fname, $Lname, $Email, $Password, $Country, $Province, $City, $Address, $Birth, $Role);
//     $stmt->execute();
//     $stmt->close();
// }

// function updateUser($id,$uname,$Fname, $Lname, $Email, $Password, $Country, $Province, $City, $Address, $Birth, $Role) {
//     global $connection;
//     $stmt = $connection->prepare("UPDATE `users` SET `Username`=?,`First Name`=?,`Last Name`=?,`Email`=?,`Password`=?,`Country`=?,`Province`=?,`City`=?,`Address`=?,`Birth Date`=?,`Role`=? WHERE UserID = ?");
//     $stmt->bind_param("sssi", $uname,$Fname, $Lname, $Email, $Password, $Country, $Province, $City, $Address, $Birth, $Role, $id);
//     $stmt->execute();
//     $stmt->close();
// }

// function deleteUser($id) {
//     global $connection;
//     $stmt = $connection->prepare("DELETE FROM users WHERE UserId=?");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $stmt->close();
// }


// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
@include 'inc_con.php';

// Start the session
session_start();

// Debug: Output the session UserID
echo 'Session UserID: ';
var_dump(isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 'Not Set');

// Check if the session UserID is set
if (isset($_SESSION['UserID'])) {
    $current_user_id = $_SESSION['UserID'];
} else {
    echo "User not logged in.";
    exit; // Exit the script if no user is logged in
}

// Function to insert an adoption record
function insertAdoptionRecord($petID, $shelterID, $userID) {
    global $connection; 

    // Debug: Output parameters inside the function
    echo 'Inside insertAdoptionRecord - UserID: ' . $userID . ', PetID: ' . $petID . ', ShelterID: ' . $shelterID . "<br>";

    $applicationDate = date("Y-m-d");
    $status = "Pending";
    $comments = "Application submitted";

    $sqlInsert = "INSERT INTO adoption (UserID, PetID, ShelterID, ApplicationDate, Status, Comments) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sqlInsert);
    $stmt->bind_param("iissss", $userID, $petID, $shelterID, $applicationDate, $status, $comments);

    if ($stmt->execute()) {
        echo "Adoption application submitted successfully!";
    } else {
        echo "Error in SQL execution: " . $stmt->error;
    }

    $stmt->close();
}

// Process the adoption application if the form is submitted
if (isset($_POST['adoptButton'])) {
    // Debug: Output form values
    $petID = $_POST['petID'];
    $shelterID = $_POST['shelterID'];
    echo 'Form values - PetID: ' . $petID . ', ShelterID: ' . $shelterID . ', UserID: ' . $current_user_id . "<br>";

    insertAdoptionRecord($petID, $shelterID, $current_user_id);
}

// Close the database connection
$connection->close();
?>
