<?php

@include 'inc_con.php';
session_start();

// Initialize $whereClause
$whereClause = "";

try {
    // Retrieve ShelterID based on the currently logged-in EmployeeID (UserID)
    if (isset($_SESSION['UserID'])) {
        $employeeID = $_SESSION['UserID'];
        $shelterQuery = "SELECT ShelterID FROM shelters WHERE EmployeeID = '$employeeID'";
        $shelterResult = $connection->query($shelterQuery);

        if ($shelterResult->num_rows > 0) {
            $shelterRow = $shelterResult->fetch_assoc();
            $shelterID = $shelterRow['ShelterID'];

            // Fetch data from the database with filters
            $sql = "SELECT pets.PetID, pettype.Species, pets.PetName, pets.Breed, pets.Age, pets.Gender, pets.Size, pets.Color, pets.Personality, pets.Disabilities, pets.AdoptionStatus, shelters.ShelterName
                    FROM pets
                    LEFT JOIN pettype ON pets.SpeciesID = pettype.SpeciesID
                    LEFT JOIN shelters ON pets.ShelterID = shelters.ShelterID
                    WHERE pets.ShelterID = '$shelterID' $whereClause";

            // Debugging line: Echo the SQL query
            #echo "SQL Query: $sql<br>";

            $result = $connection->query($sql);

            // Debugging lines: Check query execution and number of rows
            if ($result === false) {
                echo "Query execution failed: " . $connection->error;
            } else {
                echo "Number of rows: " . $result->num_rows;
            }

            // Display data in the table...
        } else {
            // Shelter not found for the logged-in EmployeeID
            echo "Shelter not found for EmployeeID: $employeeID";
        }
    } else {
        // UserID not set in the session
        echo "UserID not set in the session. Please log in.";
    }
} catch (Exception $e) {
    // Handle exceptions (e.g., log or display an error message)
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pets Table</title>
   <style>
      table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
      }

      table, th, td {
         border: 1px solid #ddd;
      }

      th, td {
         padding: 15px;
         text-align: left;
      }

      th {
         background-color: #f2f2f2;
      }
      .modal {
         display: none;
         position: fixed;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         padding: 20px;
         background-color: #fff;
         z-index: 1;
         border: 1px solid #ddd;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         max-width: 80%;
      }
   </style>
</head>
<body>
<h2>Pets Table</h2>

   <!-- Your Filters Form -->
   <form method="get">
      <!-- Add your filter options here based on the available data -->
      <button type="submit">Filter</button>
   </form>

   <!-- Table -->
   <table>
      <thead>
         <tr>
            <th>PetID</th>
            <th>Species</th>
            <th>PetName</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Size</th>
            <th>Color</th>
            <th>Personality</th>
            <th>Disabilities</th>
            <th>ShelterName</th>
            <th>Action</th> <!-- New column for actions -->
         </tr>
      </thead>
      <tbody>
      <?php
        // Display data in the table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['PetID'] . "</td>";
                echo "<td>" . $row['Species'] . "</td>";
                echo "<td>" . $row['PetName'] . "</td>";
                echo "<td>" . $row['Breed'] . "</td>";
                echo "<td>" . $row['Age'] . "</td>";
                echo "<td>" . $row['Gender'] . "</td>";
                echo "<td>" . $row['Size'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Personality'] . "</td>";
                echo "<td>" . $row['Disabilities'] . "</td>";            
                echo "<td>" . $row['ShelterName'] . "</td>";
                echo "<td>
                        <button onclick='editPet(" . $row['PetID'] . ")'>Edit</button>
                        <button onclick='deletePet(" . $row['PetID'] . ")'>Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No records found</td></tr>";
        }
        ?>
      </tbody>
   </table>

   <button type="button" onclick="openAddPetModal()">Add Pet</button>

   <!-- Add Pet Modal -->
   <div id="addPetModal" class="modal">
      <span onclick="closeAddPetModal()" style="cursor: pointer; float: right;">&times;</span>
      <h2>Add Pet</h2>

      <form method="post" action="add_pet.php">
         <!-- Your form fields for adding a pet -->
         <label for="speciesID">Species ID:</label>
         <input type="text" name="speciesID" required>

         <label for="petName">Pet Name:</label>
         <input type="text" name="petName" required>


         <button type="submit">Add Pet</button>
      </form>
   </div>

   <script>
      function openAddPetModal() {
         // Display the add pet modal
         document.getElementById("addPetModal").style.display = "block";
      }

      function closeAddPetModal() {
         // Hide the add pet modal
         document.getElementById("addPetModal").style.display = "none";
      }
      function editPet(petID) {
         // Redirect to the edit script with the petID
         window.location.href = "edit_pet.php?petID=" + petID;
      }

      function deletePet(petID) {
         var confirmDelete = confirm("Are you sure you want to delete this pet?");
         if (confirmDelete) {
            // Perform AJAX request to delete script
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response, if needed
                    alert(xhr.responseText);
                    // Reload the page or update the table after deletion
                    window.location.reload();
                }
            };

            xhr.open("POST", "delete_pet.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Use encodeURIComponent for each parameter value
            var params = "petID=" + encodeURIComponent(petID);
            xhr.send(params);
         }
      }

      function addPet() {
      // Display the add pet form
      document.getElementById("addPetForm").style.display = "block";
   }

   function closeAddPetForm() {
      // Hide the add pet form
      document.getElementById("addPetForm").style.display = "none";
   }
   </script>
</body>
</html>