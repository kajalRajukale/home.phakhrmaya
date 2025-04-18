<?php
// index.php
require_once 'config.php';
$stmt = $db->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>User Management</h2>

    <form id="addUserForm" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <button class="btn btn-primary" type="submit">Add User</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="editUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['name']) ?>', '<?= htmlspecialchars($user['email']) ?>')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('addUserForm').onsubmit = function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    fetch('api.php', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData))
    }).then(res => res.json()).then(() => location.reload());
};

function editUser(id, name, email) {
    const newName = prompt("Edit name:", name);
    const newEmail = prompt("Edit email:", email);
    if (newName && newEmail) {
        fetch('api.php', {
            method: 'PUT',
            body: JSON.stringify({id, name: newName, email: newEmail})
        }).then(res => res.json()).then(() => location
