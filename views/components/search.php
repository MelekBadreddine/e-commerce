<?php
// Include your database connection code (e.g., connect.php)
include 'connect.php';

try {
    // Establish a database connection

    if (isset($_POST['search'])) {
        $searchValue = '%' . $_POST['search'] . '%';

        $query = "SELECT id,name FROM products WHERE name LIKE ?";
        $statement = $conn->prepare($query);
        $statement->execute([$searchValue]);

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        echo json_encode([]); // Return an empty array if no search term is provided
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    die("Database error: " . $e->getMessage());
} finally {
    $conn = null; // Close the connection
}
?>