<?php
include "configure.php";

// Function to retrieve a single record by its ID
function getRecordById($conn, $id) {
    $sql = "SELECT * FROM instructor WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// If editing, fetch the record to pre-fill the form fields
if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    $record = getRecordById($conn, $edit_id);
}

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
?>

<!DOCTYPE html>
<html>
<body>
<h2> User Create Form </h2>
<form action="" method="POST">
    <fieldset>
        <legend> Personal Information: </legend>
        <br></br>
        
        Last Name:<br>
        <input type="text" name="lastname" value="<?php echo isset($record['lastname']) ? $record['lastname'] : ''; ?>">
        </br>
        First Name:<br>
        <input type="text" name="firstname" value="<?php echo isset($record['firstname']) ? $record['firstname'] : ''; ?>">
        </br>
        Age:<br>
        <input type="text" name="age" value="<?php echo isset($record['age']) ? $record['age'] : ''; ?>">
        </br> 
        Gender:<br>
        <input type="text" name="gender" value="<?php echo isset($record['gender']) ? $record['gender'] : ''; ?>">
        </br>
        Birth Month:<br>
        <input type="text" name="birthmonth" value="<?php echo isset($record['birthmonth']) ? $record['birthmonth'] : ''; ?>">
        </br>
        Address:<br>
        <input type="text" name="address" value="<?php echo isset($record['address']) ? $record['address'] : ''; ?>">
        </br>
        <?php if(isset($record['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
        <?php endif; ?>
        <br></br>
        <input type="submit" name="update" value="Update">
    </fieldset>
</form>
</body>
</html>
