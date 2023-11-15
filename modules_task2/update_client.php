<?php
// Инициализируем переменные, чтобы избежать предупреждений
$clientId = $lastName = $firstName = $middleName = null;

// Выводим переменные для отладки
var_dump($clientId, $lastName, $firstName, $middleName);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once 'db_connection.php';

class Clients {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateClient($clientId, $lastName, $firstName, $middleName) {

        $clientId = $this->conn->real_escape_string($clientId);
        $lastName = $this->conn->real_escape_string($lastName);
        $firstName = $this->conn->real_escape_string($firstName);
        $middleName = $this->conn->real_escape_string($middleName);

        $checkExistenceQuery = "SELECT id FROM clients WHERE id = ?";
        $stmtCheck = $this->conn->prepare($checkExistenceQuery);
        $stmtCheck->bind_param("i", $clientId);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $updateQuery = "UPDATE clients SET last_name = ?, first_name = ?, middle_name = ? WHERE id = ?";
            $stmt = $this->conn->prepare($updateQuery);

            if ($stmt) {
                $stmt->bind_param("sssi", $lastName, $firstName, $middleName, $clientId);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No rows updated. MySQL error: ' . $stmt->error]);
                }

                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error preparing statement']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Row with specified id does not exist']);
        }

        $stmtCheck->close();
    }
}

$clientsHandler = new Clients($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Переносим инициализацию внутрь условия
    $clientId = $_POST['id'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $middleName = $_POST['middle_name'] ?? '';

    // Добавляем проверку на существование переменных
    if (isset($clientId, $lastName, $firstName)) {
        $clientsHandler->updateClient($clientId, $lastName, $firstName, $middleName);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client ID, Last Name, and First Name are required']);
    }
}
?>
