<?php
// Start or resume a session
session_start();

// Include database connection file
@include 'inc_con.php';

// Check if the user is logged in
if(isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Retrieve ShelterID based on EmployeeID (assuming the EmployeeID is associated with ShelterID)
    $selectShelterID = "SELECT ShelterID FROM employees WHERE EmployeeID = '$userID'";
    $resultShelterID = mysqli_query($connection, $selectShelterID);

    if(mysqli_num_rows($resultShelterID) > 0) {
        $rowShelterID = mysqli_fetch_assoc($resultShelterID);
        $shelterID = $rowShelterID['ShelterID'];

        // Retrieve pets from the 'pets' table where ShelterID matches the logged-in shelter
        $selectPets = "SELECT * FROM pets WHERE ShelterID = '$shelterID'";
        $resultPets = mysqli_query($connection, $selectPets);
    } else {
        // Handle the case where ShelterID is not found for the EmployeeID
        echo "Error: ShelterID not found for the current user.";
        exit;
    }
} else {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets in Shelter</title>
    <!-- Add any additional stylesheets or scripts here -->
</head>
<body>
    <h2>Pets in Shelter</h2>

    <?php
    // Check if pets are found for the shelter
    if(isset($resultPets) && mysqli_num_rows($resultPets) > 0) {
        echo '<table border="1">
                <tr>
                    <th>Pet ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Breed</th>
                    <!-- Add more columns as needed -->
                </tr>';

        while($rowPets = mysqli_fetch_assoc($resultPets)) {
            echo '<tr>
                    <td>'.$rowPets['PetID'].'</td>
                    <td>'.$rowPets['Name'].'</td>
                    <td>'.$rowPets['Type'].'</td>
                    <td>'.$rowPets['Breed'].'</td>
                    <!-- Add more cells as needed -->
                </tr>';
        }

        echo '</table>';
    } else {
        // Handle the case where no pets are found for the shelter
        echo 'No pets found for the current shelter.';
    }
    ?>

    <!-- Add any additional HTML or scripts here -->
</body>
</html>