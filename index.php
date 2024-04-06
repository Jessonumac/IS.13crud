<?php
include "configure.php";

// CREATE operation
if(isset($_POST['submit'])){
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthmonth = $_POST['birthmonth'];
    $address = $_POST['address'];

    $sql = "INSERT INTO instructor(lastname, firstname, age, gender, birthmonth, address) VALUES ('$lastname', '$firstname', '$age', '$gender', '$birthmonth', '$address')";

    $result = $conn->query($sql);

    if($result == TRUE){
        echo "New record created successfully!!!";
    }
    else{
        echo "ERROR!!!".$sql."<br>". $conn->error;
    }
}

// READ operation with search functionality
$search_condition = "";
if(isset($_POST['search'])){
    $search_query = $_POST['search'];
    $search_condition = "WHERE lastname LIKE '%$search_query%' OR firstname LIKE '%$search_query%' OR age LIKE '%$search_query%' OR gender LIKE '%$search_query%' OR birthmonth LIKE '%$search_query%' OR address LIKE '%$search_query%' OR id LIKE '%$search_query%'";
}
$sql_read = "SELECT * FROM instructor $search_condition";
$result_read = $conn->query($sql_read);


// UPDATE operation
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $birthmonth = isset($_POST['birthmonth']) ? $_POST['birthmonth'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    // Check if required fields are empty
    if(empty($lastname) || empty($firstname) || empty($age) || empty($gender) || empty($birthmonth) || empty($address)) {
        echo "ERROR: All fields are required.";
    } else {
        // Update data
        $sql_update = "UPDATE instructor SET lastname='$lastname', firstname='$firstname', age='$age', gender='$gender', birthmonth='$birthmonth', address='$address' WHERE id='$id'";
        $result_update = $conn->query($sql_update);

        if($result_update == TRUE){
            echo "Record updated successfully!!!";
        }
        else{
            echo "ERROR!!!".$sql_update."<br>". $conn->error;
        }
    }
}

// DELETE operation
if(isset($_POST['delete'])){
    $id = $_POST['id'];

    $sql_delete = "DELETE FROM instructor WHERE id='$id'";
    $result_delete = $conn->query($sql_delete);

    if($result_delete == TRUE){
        echo "Record deleted successfully!!!";
    }
    else{
        echo "ERROR!!!".$sql_delete."<br>". $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        input[type="text"] {
            width: 100%;
            padding: 6px;
        }
        input[type="submit"] {
            padding: 6px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function populateForm(id, lastname, firstname, age, gender, birthmonth, address) {
            document.getElementById('id').value = id;
            document.getElementById('lastname').value = lastname;
            document.getElementById('firstname').value = firstname;
            document.getElementById('age').value = age;
            document.getElementById('gender').value = gender;
            document.getElementById('birthmonth').value = birthmonth;
            document.getElementById('address').value = address;
        }
    </script>
</head>
<body>
<h2> User Create Form </h2>
<form action="" method="POST">
    <fieldset>
        <legend> Personal Information: </legend>
        <br></br>
        
        Last Name:<br>
        <input type="text" id="lastname" name="lastname">
        </br>
        First Name:<br>
        <input type="text" id="firstname" name="firstname">
        </br>
        Age:<br>
        <input type="text" id="age" name="age">
        </br> 
        Gender:<br>
        <select id="gender" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Others">Others</option>
        </select>
        </br>
        Birth Date:<br>
        <select id="day" name="day">
            <?php
            for ($day = 1; $day <= 31; $day++) {
                echo "<option value='$day'>$day</option>";
            }
            ?>
        </select>
        <select id="month" name="month">
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <select id="year" name="year">
            <?php
            $currentYear = date("Y");
            for ($year = $currentYear; $year >= 1900; $year--) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>
        </br>
        Address:<br>
        <input type="text" id="address" name="address">
        </br>
        <br></br>
        <input type="submit" name="submit" value="Submit">
    </fieldset>
</form>

<h2> User Information </h2>
<form action="" method="POST">
    <input type="text" name="search" placeholder="Search...">
    <input type="submit" value="Search">
</form>

<table border="1">
<tr>
<th>ID</th>
<th>Last Name</th>
<th>First Name</th>
<th>Age</th>
<th>Gender</th>
<th>Birth Month</th>
<th>Address</th>
<th>Action</th>
</tr>

<?php
// Display records
if ($result_read->num_rows > 0) {
    while($row = $result_read->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["lastname"]."</td>";
        echo "<td>".$row["firstname"]."</td>";
        echo "<td>".$row["age"]."</td>";
        echo "<td>".$row["gender"]."</td>";
        echo "<td>".$row["birthmonth"]."</td>";
        echo "<td>".$row["address"]."</td>";
        echo "<td>
                <button type='button' onclick=\"populateForm('".$row["id"]."', '".$row["lastname"]."', '".$row["firstname"]."', '".$row["age"]."', '".$row["gender"]."', '".$row["birthmonth"]."', '".$row["address"]."')\">Update</button>
                <form style='display: inline-block;' action='' method='POST'><input type='hidden' name='id' value='".$row["id"]."'><input type='submit' name='delete' value='Delete'></form>
            </td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
?>

</table>
</body>
</html>
