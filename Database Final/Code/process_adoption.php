<?php

@include 'inc_con.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $Email;
    global $loggedInUserId;
    // Get the petID from the AJAX request
    $petID = $_POST['petID'];

    // Retrieve the ShelterID associated with the given PetID
    $sql = "SELECT ShelterID FROM pets WHERE PetID = '$petID'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $shelterIDs = $row['ShelterID'];
    }
    // Replace 'username' with the actual value you have (e.g., from session or form input)
    $emails = $Email;

    // Retrieve the UserID associated with the given username
    $sql = "SELECT UserID FROM users WHERE Email = '$emails'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];
    } else {
        // Handle the case where the user with the given username is not found
        echo "User not found!";
    }

    // Get other required data (replace with your logic to get UserID, ShelterID, etc.)
    $userIDs = $loggedInUserId;
    $shelterID = $shelterIDs;
    $applicationDate = date("Y-m-d");
    $status = 'Pending';
    $comments = 'Form Sent';

    // Insert data into the "adoption" table
    echo "UserID to be inserted: $loggedInUserId";
    error_log("UserID to be inserted: $loggedInUserId");
    $insertQuery = "INSERT INTO adoption (UserID, PetID, ShelterID, ApplicationDate, Status, Comments)
                    VALUES ('$loggedInUserId', '$petID', '$shelterIDs', '$applicationDate', '$status', '$comments')";

    if ($connection->query($insertQuery) === TRUE) {
        echo "Adoption application submitted successfully.";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $connection->error;
    }

    // Close the database connection
    $connection->close();
} else {
    echo "Invalid request method.";
}

?>