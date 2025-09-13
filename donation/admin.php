<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Not logged in → redirect to login page
    header("Location: login.php");
    exit;
}

// Database connection
$db = new PDO('sqlite:./database.sqlite');
$tableName = 'donation';

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $db->prepare("DELETE FROM $tableName WHERE id = ?");
    $stmt->execute([$deleteId]);
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

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
        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
                
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
                    <th>Action</th>
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
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($donation['id']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    &#128465; <!-- Trash icon Unicode -->
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
