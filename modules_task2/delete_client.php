<?php

include './db_connection.php';

class Clients {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteClient($clientId) {
        $clientId = $this->conn->real_escape_string($clientId);

        $deleteQuery = "DELETE FROM clients WHERE id = $clientId";
        $deleteResult = $this->conn->query($deleteQuery);

        if ($deleteResult) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting client']);
        }
    }
}

$clients = new Clients($conn);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $clientId = $_GET['id'] ?? '';

    if (!empty($clientId)) {
        $clients->deleteClient($clientId);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client ID is required']);
    }
}
