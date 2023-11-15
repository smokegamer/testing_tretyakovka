<?php

include './db_connection.php';

class Clients {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchClients() {
        $result = $this->conn->query("SELECT * FROM clients");
        $clients = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($clients);
    }
}

$clients = new Clients($conn);
$clients->fetchClients();
