<?php

$name = $age = $gender = $address = $email = "";
echo $name;

$erorrs = [];

$staus = false;

function input_test($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---- Name Validation ---- //
    // Check If Name is Empty
    if (empty($_POST["name"])) {
        array_push($erorrs, "* Name is required");
    }
    else {
        $name = input_test($_POST["name"]);

        // Check If There Is Any Numbers Or Symbols
        if (!preg_match("/^[a-zA-Z' ']+$/",$name)) {
            array_push($erorrs, "* Name Only letters and white space allowed");
        }
    }


    // ---- Age Validation ---- //
    // Check If Age Is Empty
    if (empty($_POST["age"])) {
        array_push($erorrs, "* Age is required");
    }
    else {
        $age = input_test($_POST["age"]);

        // Check if it contains letters or symbols
        if(!preg_match("/^[0-9]+$/", $age)){
            array_push($erorrs, "* Age consists only of numbers");
        }
        // Check If It Between 10,30
        elseif ($_POST["age"] < 10 || $_POST["age"] > 30) {
            array_push($erorrs, "* Age  must be between 10 and 30");
        }
    }


    // ---- Email Validation ---- //
    // Check If Email Is Empty
    if (empty($_POST["email"])) {
        array_push($erorrs, "* Email is required");
    }
    else {
        $email = input_test($_POST["email"]);

        // Check If Email Format Is True Or Not
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($erorrs, "* Invalid email");
        }
    }


    // Address
    $address = $_POST['address'];

    // Gender
    $gender = $_POST['gender'];

    if (empty($erorrs)) {
        $staus = true;
    } else {
        $staus = false;
    }
}

// Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "assignment_database";

// Connect To Database
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("connection failed: " . $connection->connect_error);
}


// Database Name => [assignment_database]

// Create Statement
/*
CREATE TABLE students (
	id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(20) NOT NULL,
    age int NOT NUll,
    gender varchar(10) NOT NULL,
    address varchar(255),
    email varchar(255) NOT NULL
)
*/

$insert = "INSERT INTO students (name, age, gender, address, email) VALUES('$name', '$age', '$gender', '$address', '$email')";

if ($staus) {
    if ($connection->query($insert) === true) {
        echo "<div class='send'>Your data has been sent successfully.</div>";
    } else {
        echo "Erorr: " . $insert . "<br>" . $connection->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 02</title>

    <style>
        body {
            font-family: sans-serif;
        }
        h2 {
            text-align: center;
        }
        .container {
            width: 600px;
            margin: 70px auto;
        }
        input[type="text"] {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            margin-top: 5px;
            border: none;
            outline: none;
            border-radius: 6px;
            border: 1px solid #e9e9e9;
            background-color: #f7f7f7;
        }
        input[type="submit"] {
            padding: 14px 30px;
            cursor: pointer;
            border: none;
            background-color: #009688;
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #037066;
        }
        h3 {
            text-align: center;
            color: #009688;
        }
        .erorr-box {
            width: 100%;
            border-radius: 6px;
            margin-top: 20px;
        }
        .erorr-box span {
            display: block;
            background-color: #ffbcbc;
            padding: 5px;
            width: 100%;
            color: black;
            border-radius: 6px;
            margin-bottom: 10px;
            border: 1px solid red;
        }
        div.send {
            position: fixed;
            left: 20px;
            top: 20px;
            padding: 22px;
            background: #009688;
            color: #fff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            opacity: 0;
            visibility: hidden;
            animation: done 8s;
        }
        @keyframes done {
            from {
                opacity: 1;
                visibility: visible;
            }
            to {
                opacity: 0;
                visibility: hidden;
            }
        }
    </style>
</head>

<body>
    <h2>Nasr Aldaya | 120200463</h2>
    
    
    <div class="container">
        <h3>Assignment 02</h3>

        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter Your Name">

            <label for="age">Age:</label>
            <input type="text" name="age" id="age" placeholder="Enter Your Age">

            <div class="gender">
                <p>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" value="male" id="male" checked>
                </p>
                <p>
                    <label for="female">Female</label>
                    <input type="radio" name="gender" value="female" id="female">
                </p>
            </div>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" placeholder="Enter Your Address">
            
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Enter Your Email">

            <input type="submit" value="Send"> 
        </form>

        <div class="erorr-box">
            <?php
                foreach ($erorrs as $erorr) {
                    echo "<span>";
                    echo $erorr;
                    echo "</span>";
                }
            ?>
        </div>
    </div>
</body>
</html>