<?php

$conn = new PDO('sqlite:database.sqlite');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connection successful to SQLite database!";

$tableName = 'donation';

// Collect POST data or use default values
// NOW WE CAN CALL THE PHP SCRIPT FROM COMAMND LINE TO TEST
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : 'This is the new default name';
$address = isset($_POST['address']) ? $_POST['address'] : 'Default Address';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '0000000000';
$pan = isset($_POST['pan']) ? $_POST['pan'] : 'DEFAULTPAN';
$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '2000-01-01';
$email = isset($_POST['email']) ? $_POST['email'] : 'default@example.com';
$donationAmount = isset($_POST['donationAmount']) ? $_POST['donationAmount'] : 0.0;
$donationDate = date('Y-m-d H:i:s'); // Current date and time

$paymentScreenshot = '';
if (isset($_FILES['paymentScreenshot']) && $_FILES['paymentScreenshot']['error'] === UPLOAD_ERR_OK) {
    $paymentScreenshot = file_get_contents($_FILES['paymentScreenshot']['tmp_name']);
}

echo "Received data: <br>";
echo "Full Name: $fullname <br>";   
echo "Address: $address <br>";
echo "Phone: $phone <br>";
echo "PAN: $pan <br>";
echo "Birthdate: $birthdate <br>";
echo "Email: $email <br>";
echo "Donation Amount: $donationAmount <br>";
echo "Donation Date: $donationDate <br>";
echo "Payment Screenshot: " . (!empty($paymentScreenshot) ? 'Received' : 'Not provided') . "<br>";

// Check is table exists, if not create it
$sql = "CREATE TABLE IF NOT EXISTS " . $tableName . " (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fullName TEXT NOT NULL,
    address TEXT NOT NULL,
    phoneNumber TEXT NOT NULL,
    PANNumber TEXT NOT NULL,
    birthdate DATE NOT NULL,
    email TEXT NOT NULL,
    donationAmount REAL NOT NULL DEFAULT 0.0,
    donationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_Screenshot BLOB
    )";



// Check if table exists
$tableExists = $conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $tableName . "'")->fetch();

if (!$tableExists) {
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute()) {
        echo "Error creating table: " . implode(", ", $stmt->errorInfo());
    } else {
        error_log("Table donationTb created successfully.");
    }
} else {
    error_log("Table donationTb already exists.");
}

// Insert query
$sql = "INSERT INTO " . $tableName . " 
        (fullName, address, phoneNumber, PANNumber, birthdate, email, payment_Screenshot, donationAmount, donationDate) 
        VALUES (:fullname, :address, :phone, :pan, :birthdate, :email, :paymentScreenshot, :donationAmount, :donationDate)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':pan', $pan);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':paymentScreenshot', $paymentScreenshot, PDO::PARAM_LOB);
$stmt->bindParam(':donationAmount', $donationAmount);
$stmt->bindParam(':donationDate', $donationDate);

if ($stmt->execute()) {
    echo "Donor data submitted successfully!";
} else {
    echo "Error submitting donor data.";
}
?>