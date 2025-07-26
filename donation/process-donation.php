<?php


$serverName = "localhost";
$connectionOptions = array(
    "Database" => "donationTb",
    "Uid" => "student",
    "PWD" => "password"
);

$conn = new PDO('sqlite:database.sqlite');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connection successful to SQLite database!";

// Collect POST data or use default values
// NOW WE CAN CALL THE PHP SCRIPT FROM COMAMND LINE TO TEST
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : 'This is the new default name';
$address = isset($_POST['address']) ? $_POST['address'] : 'Default Address';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '0000000000';
$pan = isset($_POST['pan']) ? $_POST['pan'] : 'DEFAULTPAN';
$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '2000-01-01';
$email = isset($_POST['email']) ? $_POST['email'] : 'default@example.com';
$paymentScreenshot = isset($_POST['paymentScreenshot']) ? $_POST['paymentScreenshot'] : '';

// Check is table exists, if not create it
$sql = "CREATE TABLE IF NOT EXISTS donationTb (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    address TEXT NOT NULL,
    phone_number TEXT NOT NULL,
    pan_number TEXT NOT NULL,
    birthdate DATE NOT NULL,
    email_id TEXT NOT NULL,
    payment_Screenshot BLOB
    )";

// Check if table exists
$tableExists = $conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='donationTb'")->fetch();

if (!$tableExists) {
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute()) {
        echo "Error creating table: " . implode(", ", $stmt->errorInfo());
    } else {
        echo "Table donationTb created successfully.";
    }
} else {
    echo "Table donationTb already exists.";
}

// Insert query
$sql = "INSERT INTO donationTb 
        (full_name, address, phone_number, pan_number, birthdate, email_id, payment_Screenshot) 
        VALUES (:fullname, :address, :phone, :pan, :birthdate, :email, :paymentScreenshot)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':pan', $pan);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':paymentScreenshot', $paymentScreenshot);

if ($stmt->execute()) {
    echo "Donor data submitted successfully!";
} else {
    echo "Error submitting donor data.";
}
?>