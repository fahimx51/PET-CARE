<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['email'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to make an adoption request.']);
        exit();
    }

    $requesterEmail = $_SESSION['email'];
    $petId = $input['petId'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petcare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlCheck = "SELECT id FROM adoption_requests WHERE pet_id = ? AND status = 'pending'";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param('i', $petId);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'There is already a pending adoption request for this pet.']);
        $stmtCheck->close();
        $conn->close();
        exit();
    }

    $stmtCheck->close();

    $sql = "INSERT INTO adoption_requests (pet_id, requester_email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $petId, $requesterEmail);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'petName' => $petId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send adoption request.']);
    }

    $stmt->close();
    $conn->close();
}
?>
