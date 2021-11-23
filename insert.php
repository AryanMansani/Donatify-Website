<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['Name']) && isset($_POST['number']) &&
        isset($_POST['quantity']) && isset($_POST['gender']) &&
        isset($_POST['houseno']) && isset($_POST['street']) && isset($_POST['pin']) ) {

        $name = $_POST['Name'];
        $number1 = $_POST['number'];
        $quantity = $_POST['quantity'];
        $dob = $_POST['dobd']+"/"+$_POST['dobm']+"/"+$_POST['doby'];
        $gender = $_POST['gender'];
        $houseno = $_POST['houseno'];
        $street = $_POST['street'];
        $pin = $_POST['pin'];


        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "donatify";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT number1 FROM bookdonation WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO bookdonation(name, number1, quantity, dob, gender, houseno, street, pin) values(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $number1);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$name, $number1, $quantity, $dob, $gender, $houseno, $street, $pin);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>
