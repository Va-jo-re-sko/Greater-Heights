<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$db   = 'greater_heights';
$user = 'root';
$pass = 'Vajoresko2'; // put your MySQL password here
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['status'=>'error','message'=>'Database connection failed']);
    exit;
}

// Retrieve POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['status'=>'error','message'=>'Please fill in all fields']);
    exit;
}

// Check if the user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['status'=>'error','message'=>'Email not found']);
    exit;
}

// Verify password
if (!password_verify($password, $user['password'])) {
    echo json_encode(['status'=>'error','message'=>'Incorrect password']);
    exit;
}

// Login successful, return user info (can be used for session)
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['category'] = $user['category'];

echo json_encode([
    'status' => 'success',
    'message' => 'Login successful!',
    'category' => $user['category']
]);
?>
