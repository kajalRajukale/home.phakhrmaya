<?php
session_start();

// Set your password here
$adminPassword = 'only-for-sb';

if (!isset($_SESSION['authenticated'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $adminPassword) {
            $_SESSION['authenticated'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "Incorrect password!";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login Required</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Admin Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
// ...existing code...
// Database connection
$db = new PDO('sqlite:./database.sqlite');
$tableName = 'donation';
// Fetch all donations
$stmt = $db->query("SELECT * FROM $tableName");
$donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donation List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">All Donations</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>PAN Number</th>
                    <th>Birthdate</th>
                    <th>Email</th>
                    <th>Donation Amount</th>

                    <th>Donation Date</th>
                    <th>Payment Screenshot</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?= htmlspecialchars($donation['fullName']) ?></td>
                        <td><?= htmlspecialchars($donation['address']) ?></td>
                        <td><?= htmlspecialchars($donation['phoneNumber']) ?></td>
                        <td><?= htmlspecialchars($donation['PANNumber']) ?></td>
                        <td><?= htmlspecialchars($donation['birthdate']) ?></td>
                        <td><?= htmlspecialchars($donation['email']) ?></td>
                        <td><?= htmlspecialchars($donation['donationAmount']) ?></td>
                        <td><?= htmlspecialchars($donation['donationDate']) ?></td>

                        <td>
                            <?php if (!empty($donation['payment_Screenshot'])): ?>
                                <img src="data:image/png;base64,<?= base64_encode($donation['payment_Screenshot']) ?>" alt="Payment Screenshot" style="max-width:100px; max-height:100px;">
                                <br>
                                <a href="data:image/png;base64,<?= base64_encode($donation['payment_Screenshot']) ?>" download="payment_screenshot.png" class="btn btn-sm btn-primary mt-2">Download</a>
                            <?php else: ?>
                                Not provided
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>