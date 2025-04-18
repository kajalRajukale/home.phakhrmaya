<?php
// api.php
header("Content-Type: application/json");
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM users");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        if (!empty($input['name']) && !empty($input['email'])) {
            $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            try {
                $stmt->execute([$input['name'], $input['email']]);
                echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Email must be unique']);
            }
        } else {
            echo json_encode(['error' => 'Name and Email required']);
        }
        break;

    case 'PUT':
        if (!empty($input['id']) && !empty($input['name']) && !empty($input['email'])) {
            $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$input['name'], $input['email'], $input['id']]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'ID, Name, and Email required']);
        }
        break;

    case 'DELETE':
        if (!empty($input['id'])) {
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$input['id']]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'ID required']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported method']);
}
