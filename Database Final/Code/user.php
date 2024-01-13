<?php

@include 'inc_con.php';
session_start();
if (isset($_SESSION['UserID'])) {
    var_dump($_SESSION);
    $loggedInUserId = $_SESSION['UserID'];
    $sqlSpecies = "SELECT DISTINCT SpeciesID FROM pets";
    $resultSpecies = $connection->query($sqlSpecies);
    
    // Fetch distinct breed values from the database
    $sqlBreed = "SELECT DISTINCT Breed FROM pets";
    $resultBreed = $connection->query($sqlBreed);
    
    // Fetch distinct age values from the database
    $sqlAge = "SELECT DISTINCT Age FROM pets";
    $resultAge = $connection->query($sqlAge);
    
    // Fetch distinct gender values from the database
    $sqlGender = "SELECT DISTINCT Gender FROM pets";
    $resultGender = $connection->query($sqlGender);
    
    // Fetch distinct size values from the database
    $sqlSize = "SELECT DISTINCT Size FROM pets";
    $resultSize = $connection->query($sqlSize);
    
    // Fetch distinct personality values from the database
    $sqlPersonality = "SELECT DISTINCT Personality FROM pets";
    $resultPersonality = $connection->query($sqlPersonality);
    
    // Fetch distinct disabilities values from the database
    $sqlDisabilities = "SELECT DISTINCT Disabilities FROM pets";
    $resultDisabilities = $connection->query($sqlDisabilities);
    
    // Fetch distinct adoption status values from the database
    $sqlAdoptionStatus = "SELECT DISTINCT AdoptionStatus FROM pets";
    $resultAdoptionStatus = $connection->query($sqlAdoptionStatus);
    
    // Filter logic
    $whereClause = "";
    
    if (isset($_GET['species']) && $_GET['species'] !== '') {
        $whereClause .= " AND pets.SpeciesID = '" . $connection->real_escape_string($_GET['species']) . "'";
    }
    
    if (isset($_GET['breed']) && $_GET['breed'] !== '') {
        $whereClause .= " AND pets.Breed = '" . $connection->real_escape_string($_GET['breed']) . "'";
    }
    
    if (isset($_GET['age']) && $_GET['age'] !== '') {
        $whereClause .= " AND pets.Age = '" . $connection->real_escape_string($_GET['age']) . "'";
    }
    
    if (isset($_GET['gender']) && $_GET['gender'] !== '') {
        $whereClause .= " AND pets.Gender = '" . $connection->real_escape_string($_GET['gender']) . "'";
    }
    
    if (isset($_GET['size']) && $_GET['size'] !== '') {
        $whereClause .= " AND pets.Size = '" . $connection->real_escape_string($_GET['size']) . "'";
    }
    
    if (isset($_GET['personality']) && $_GET['personality'] !== '') {
        $whereClause .= " AND pets.Personality = '" . $connection->real_escape_string($_GET['personality']) . "'";
    }
    
    if (isset($_GET['disabilities']) && $_GET['disabilities'] !== '') {
        $whereClause .= " AND pets.Disabilities = '" . $connection->real_escape_string($_GET['disabilities']) . "'";
    }
    
    if (isset($_GET['adoption_status']) && $_GET['adoption_status'] !== '') {
        $whereClause .= " AND pets.AdoptionStatus = '" . $connection->real_escape_string($_GET['adoption_status']) . "'";
    }
    
    // Fetch data from the database with filters
    $sql = "SELECT pets.PetID, pettype.Species, pets.PetName, pets.Breed, pets.Age, pets.Gender, pets.Size, pets.Color, pets.Personality, pets.Disabilities, pets.AdoptionStatus, shelters.ShelterName
            FROM pets
            LEFT JOIN pettype ON pets.SpeciesID = pettype.SpeciesID
            LEFT JOIN shelters ON pets.ShelterID = shelters.ShelterID
            WHERE 1 $whereClause";
    
    $result = $connection->query($sql);
    
    // Close the database connection
    $connection->close();

} else {
    // Redirect to the login page or display a message indicating that the user needs to log in
    header("Location: login.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    </style>
</head>
<body>
    <h2>Pets Table</h2>
<!-- Filters -->
<form method="get">
        <label for="speciesFilter">Species:</label>
        <select name="species" id="speciesFilter">
            <option value="">All</option>
            <?php
            // Display species filter options
            while ($rowSpecies = $resultSpecies->fetch_assoc()) {
                $selected = (isset($_GET['species']) && $_GET['species'] == $rowSpecies['SpeciesID']) ? 'selected' : '';
                echo "<option value='" . $rowSpecies['SpeciesID'] . "' $selected>" . $rowSpecies['SpeciesID'] . "</option>";
            }
            ?>
        </select>

        <label for="breedFilter">Breed:</label>
        <select name="breed" id="breedFilter">
            <option value="">All</option>
            <?php
            // Display breed filter options
            while ($rowBreed = $resultBreed->fetch_assoc()) {
                $selected = (isset($_GET['breed']) && $_GET['breed'] == $rowBreed['Breed']) ? 'selected' : '';
                echo "<option value='" . $rowBreed['Breed'] . "' $selected>" . $rowBreed['Breed'] . "</option>";
            }
            ?>
        </select>

        <label for="ageFilter">Age:</label>
        <select name="age" id="ageFilter">
            <option value="">All</option>
            <?php
            // Display age filter options
            while ($rowAge = $resultAge->fetch_assoc()) {
                $selected = (isset($_GET['age']) && $_GET['age'] == $rowAge['Age']) ? 'selected' : '';
                echo "<option value='" . $rowAge['Age'] . "' $selected>" . $rowAge['Age'] . "</option>";
            }
            ?>
        </select>

        <label for="genderFilter">Gender:</label>
        <select name="gender" id="genderFilter">
            <option value="">All</option>
            <?php
            // Display gender filter options
            while ($rowGender = $resultGender->fetch_assoc()) {
                $selected = (isset($_GET['gender']) && $_GET['gender'] == $rowGender['Gender']) ? 'selected' : '';
                echo "<option value='" . $rowGender['Gender'] . "' $selected>" . $rowGender['Gender'] . "</option>";
            }
            ?>
        </select>

        <label for="sizeFilter">Size:</label>
        <select name="size" id="sizeFilter">
            <option value="">All</option>
            <?php
            // Display size filter options
            while ($rowSize = $resultSize->fetch_assoc()) {
                $selected = (isset($_GET['size']) && $_GET['size'] == $rowSize['Size']) ? 'selected' : '';
                echo "<option value='" . $rowSize['Size'] . "' $selected>" . $rowSize['Size'] . "</option>";
            }
            ?>
        </select>

        <label for="personalityFilter">Personality:</label>
        <select name="personality" id="personalityFilter">
            <option value="">All</option>
            <?php
            // Display personality filter options
            while ($rowPersonality = $resultPersonality->fetch_assoc()) {
                $selected = (isset($_GET['personality']) && $_GET['personality'] == $rowPersonality['Personality']) ? 'selected' : '';
                echo "<option value='" . $rowPersonality['Personality'] . "' $selected>" . $rowPersonality['Personality'] . "</option>";
            }
            ?>
        </select>

        <label for="disabilitiesFilter">Disabilities:</label>
        <select name="disabilities" id="disabilitiesFilter">
            <option value="">All</option>
            <?php
            // Display disabilities filter options
            while ($rowDisabilities = $resultDisabilities->fetch_assoc()) {
                $selected = (isset($_GET['disabilities']) && $_GET['disabilities'] == $rowDisabilities['Disabilities']) ? 'selected' : '';
                echo "<option value='" . $rowDisabilities['Disabilities'] . "' $selected>" . $rowDisabilities['Disabilities'] . "</option>";
            }
            ?>
        </select>

        <label for="adoptionStatusFilter">Adoption Status:</label>
        <select name="adoption_status" id="adoptionStatusFilter">
            <option value="">All</option>
            <?php
            // Display adoption status filter options
            while ($rowAdoptionStatus = $resultAdoptionStatus->fetch_assoc()) {
                $selected = (isset($_GET['adoption_status']) && $_GET['adoption_status'] == $rowAdoptionStatus['AdoptionStatus']) ? 'selected' : '';
                echo "<option value='" . $rowAdoptionStatus['AdoptionStatus'] . "' $selected>" . $rowAdoptionStatus['AdoptionStatus'] . "</option>";
            }
            ?>
        </select>

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
            <th>AdoptionStatus</th>
            <th>ShelterName</th>
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
                
                // Display button for 'Not Adopted' status
                if ($row['AdoptionStatus'] == 'Not Adopted') {
                    echo "<td>";
                    echo "<button onclick=\"showPopup('".$row['PetID']."','".$row['Species']."','".$row['PetName']."','".$row['Breed']."','".$row['Age']."','".$row['Gender']."','".$row['Size']."','".$row['Color']."','".$row['Personality']."','".$row['Disabilities']."','".$row['ShelterName']."')\">Adopt</button>";
                    echo "</td>";
                } else {
                    echo "<td>" . $row['AdoptionStatus'] . "</td>";
                }

                echo "<td>" . $row['ShelterName'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- JavaScript for Popup -->
<script>
function showPopup(petID, species, petName, breed, age, gender, size, color, personality, disabilities, shelterName) {
    var details =
        "Species: " + species +
        "\nPet Name: " + petName +
        "\nBreed: " + breed +
        "\nAge: " + age +
        "\nGender: " + gender +
        "\nSize: " + size +
        "\nColor: " + color +
        "\nPersonality: " + personality +
        "\nDisabilities: " + disabilities +
        "\nShelter Name: " + shelterName;

    var confirmAdopt = confirm(details + "\n\nDo you want to adopt this pet?");

    if (confirmAdopt) {
        // Perform AJAX request to submit adoption application
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response, if needed
                alert(xhr.responseText); // Show the response from the server
            }
        };

        xhr.open("POST", "process_adoption.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Use encodeURIComponent for each parameter value
        var params = "petID=" + encodeURIComponent(petID);
        xhr.send(params);
    }
}
</script>
</body>
</html>