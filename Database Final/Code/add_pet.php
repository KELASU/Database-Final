<?php
@include 'inc_con.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data when the form is submitted
    try {
        // Retrieve data from the form
        $speciesID = $_POST['SpeciesID']; // Adjust this based on your form field name
        $petName = $_POST['PetName']; // Adjust this based on your form field name
        $breed = $_POST['Breed']; // Adjust this based on your form field name
        $age = $_POST['Age']; // Adjust this based on your form field name
        $gender = $_POST['Gender']; // Adjust this based on your form field name
        $size = $_POST['Size']; // Adjust this based on your form field name
        $color = $_POST['Color']; // Adjust this based on your form field name
        $personality = $_POST['Personality']; // Adjust this based on your form field name
        $disabilities = $_POST['Disabilities']; // Adjust this based on your form field name

        // Retrieve ShelterID based on the currently logged-in EmployeeID (UserID)
        if (isset($_SESSION['UserID'])) {
            $employeeID = $_SESSION['UserID'];
            $shelterQuery = "SELECT ShelterID FROM shelters WHERE EmployeeID = '$employeeID'";
            $shelterResult = $connection->query($shelterQuery);

            if ($shelterResult->num_rows > 0) {
                $shelterRow = $shelterResult->fetch_assoc();
                $shelterID = $shelterRow['ShelterID'];

                // Insert the new pet into the database
                $insertQuery = "INSERT INTO pets (SpeciesID, ShelterID, PetName, Breed, Age, Gender, Size, Color, Personality, Disabilities, AdoptionStatus, ShelterID)
                                VALUES ('$speciesID', '$shelterID', '$petName', '$breed', '$age', '$gender', '$size', '$color', '$personality', '$disabilities', 'Not Adopted','$shelterQuery')";

                $result = $connection->query($insertQuery);

                if ($result === true) {
                    echo "Pet added successfully!";
                } else {
                    echo "Error adding pet: " . $connection->error;
                }
            } else {
                echo "Shelter not found for EmployeeID: $employeeID";
            }
        } else {
            echo "UserID not set in the session. Please log in.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $connection->close();
    }
} else {
    // Redirect to the main page if accessed without submitting the form
    header("Location: main_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Pet</title>
   <style>
      label {
         display: block;
         margin-top: 10px;
      }
   </style>
</head>
<body>
   <h2>Add Pet</h2>

   <form method="post" action="add_pet.php">
      <!-- Add your form fields for adding a pet -->
      <label for="speciesID">Species ID:</label>
      <input type="text" name="speciesID" required>

      <label for="petName">Pet Name:</label>
      <input type="text" name="petName" required>

      <label for="breed">Breed:</label>
      <input type="text" name="breed" required>

      <label for="age">Age:</label>
      <input type="text" name="age" required>

      <label for="gender">Gender:</label>
      <select name="gender" required>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
      </select>

      <label for="size">Size:</label>
      <input type="text" name="size" required>

      <label for="color">Color:</label>
      <input type="text" name="color" required>

      <label for="personality">Personality:</label>
      <input type="text" name="personality" required>

      <label for="disabilities">Disabilities:</label>
      <input type="text" name="disabilities">

      <button type="submit">Add Pet</button>
   </form>
</body>
</html>