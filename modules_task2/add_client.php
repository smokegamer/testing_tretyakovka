<?php

include './db_connection.php';

class Clients {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addClient($lastName, $firstName, $middleName) {
        $lastName = $this->conn->real_escape_string($lastName);
        $firstName = $this->conn->real_escape_string($firstName);
        $middleName = $this->conn->real_escape_string($middleName);

        // Проверка наличия клиента с такими данными
        $checkQuery = "SELECT * FROM clients WHERE last_name = '$lastName' AND first_name = '$firstName' AND middle_name = '$middleName'";
        $checkResult = $this->conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Client with these details already exists']);
        } else {
            $insertQuery = "INSERT INTO clients (last_name, first_name, middle_name) VALUES ('$lastName', '$firstName', '$middleName')";
            $insertResult = $this->conn->query($insertQuery);

            if ($insertResult) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding client']);
            }
        }
    }
}

$clients = new Clients($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = $_POST['lastName'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $middleName = $_POST['middleName'] ?? '';

    if (!empty($lastName) && !empty($firstName)) {
        $clients->addClient($lastName, $firstName, $middleName);
    } else {
        echo json_encode(['success' => false, 'message' => 'Фамилия и имя не могут быть пустыми']);
    }
}
