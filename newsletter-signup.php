<?php


// Connect to database
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=databaseName', 'User', 'Pasword');
} catch (PDOException $e) {
    echo '<p>Bro, what did you do?</p>';
    echo '<br>';
    echo '<a href="PageURL">Back to homepage</a>';
    exit();
}

$customer = [
    'name' => isset($_POST['name']) ? $_POST['name'] : NULL,
    'email' => isset($_POST['email']) ? $_POST['email'] : NULL,
    'created_at' => date("Y-m-d"), 
];

// SECURITY
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
    }
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
  }
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$db->prepare("
    INSERT INTO newsletter (name, email, created_at) VALUES (:name, :email, :created_at)
")->execute($customer);

// Redirect browser
header("Location: idex.html"); 
exit();