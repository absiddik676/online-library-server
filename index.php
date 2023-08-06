<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
// Allow specific HTTP methods (e.g., GET, POST, OPTIONS, etc.).
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
// Allow specific HTTP headers in the request.
header("Access-Control-Allow-Headers: Content-Type");
include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();
var_dump($conn);



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if($_GET['url'] === '/allbook'){
        try {
            $table_name = "allbook"; // Replace with the desired table name
    
            $sql = "SELECT * FROM $table_name";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
    
            // Store the JSON data in a variable
            $json_data = json_encode($data);
    
            // Disable output buffering
            while (ob_get_level()) {
                ob_end_clean();
            }
    
            // Output the JSON data
            echo $json_data;
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error retrieving data from the database.'));
        }
    }
    elseif($_GET['url'] === '/alluser'){
        try {
            $table_name = "user"; // Replace with the desired table name
    
            $sql = "SELECT * FROM $table_name";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
    
            // Store the JSON data in a variable
            $json_data = json_encode($data);
    
            // Disable output buffering
            while (ob_get_level()) {
                ob_end_clean();
            }
    
            // Output the JSON data
            echo $json_data;
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error retrieving data from the database.'));
        }
    }
    elseif($_GET['url'] === '/allreqbook'){
        try {
            $table_name = "requestredbook"; // Replace with the desired table name
    
            $sql = "SELECT * FROM $table_name";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
    
            // Store the JSON data in a variable
            $json_data = json_encode($data);
    
            // Disable output buffering
            while (ob_get_level()) {
                ob_end_clean();
            }
    
            // Output the JSON data
            echo $json_data;
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error retrieving data from the database.'));
        }
    }
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if($_GET['url'] === '/addBook'){
         try {
            $book = json_decode(file_get_contents('php://input'));
            $sql = "INSERT INTO allbook(id, title, author, category, copies, description, img) VALUES(null, :title, :author, :category, :copies, :description, :img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $book->title);
            $stmt->bindParam(':author', $book->author);
            $stmt->bindParam(':category', $book->category);
            $stmt->bindParam(':copies', $book->copies);
            $stmt->bindParam(':description', $book->description);
            $stmt->bindParam(':img', $book->img);
        
            if ($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record created successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to create record.'];
            }
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
            // Output the JSON response
            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating record in the database.'));
        }
    }
    elseif($_GET['url'] === '/saveUser'){
        try {
            $user = json_decode(file_get_contents('php://input'));
            $sql = "INSERT INTO user(id, name, email, gender, role,  img) VALUES(null, :name, :email, :gender, :role, :img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $user->name);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':gender', $user->gender);
            $stmt->bindParam(':role', $user->role);
            $stmt->bindParam(':img', $user->img);
        
            if ($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record created successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to create record.'];
            }
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
            // Output the JSON response
            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating record in the database.'));
        }
    }
    elseif ($_GET['url'] === '/requestedBook') {
        try {
            $data = json_decode(file_get_contents('php://input'));
            $sql = "INSERT INTO requestredbook (id, bookID, bookImg, studentEmail, studentID, studentName, title, author) VALUES (null, :bookID, :bookImg, :studentEmail, :studentID, :studentName, :title, :author)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bookID', $data->bookID);
            $stmt->bindParam(':bookImg', $data->bookImg);
            $stmt->bindParam(':studentEmail', $data->studentEmail);
            $stmt->bindParam(':studentID', $data->studentID);
            $stmt->bindParam(':studentName', $data->studentName);
            $stmt->bindParam(':title', $data->title);
            $stmt->bindParam(':author', $data->author);
    
            if ($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record created successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to create record.'];
            }
    
            // Set the response content type to JSON
            header('Content-Type: application/json');
            // Output the JSON response
            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle any potential database errors gracefully
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating record in the database.'));
        }
    }
    
    
}
?>