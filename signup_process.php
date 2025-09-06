<?php
header('Content-Type: application/json');
include 'config.php'; // Connects to MySQL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get POST data and sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $category = $_POST['category'];
    $extra_field = isset($_POST['extra_field']) ? trim($_POST['extra_field']) : '';

    // Basic validation
    if (!$name || !$email || !$password || !$category) {
        echo json_encode(['status'=>'error','message'=>'Please fill all required fields']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status'=>'error','message'=>'Invalid email address']);
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status'=>'error','message'=>'Email already registered']);
        exit;
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,category,extra_field) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $category, $extra_field);

    if ($stmt->execute()) {
        echo json_encode(['status'=>'success','message'=>'Account created successfully!']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Database error: '.$stmt->error]);
    }
    $stmt->close();
    $conn->close();

} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request method']);
}
?>
