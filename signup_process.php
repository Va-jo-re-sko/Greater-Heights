<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$db   = 'greater_heights';
$user = 'root'; // Changed from 'Smart Curriculum' to avoid potential issues
$pass = 'Vajoresko2'; // your MySQL password
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
    error_log("Database connection failed: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Retrieve and sanitize POST data
$category = trim($_POST['category'] ?? '');
$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$extra_field = null;

// Validate required fields
if (empty($category) || empty($fullname) || empty($email) || empty($password)) {
    echo json_encode(['status'=>'error','message'=>'Please fill in all required fields']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status'=>'error','message'=>'Please provide a valid email address']);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Handle category-specific fields
switch ($category) {
    case 'admin':
        $extra_field = trim($_POST['admincode'] ?? '');
        break;
    case 'teacher':
        $extra_field = trim($_POST['subject'] ?? '');
        break;
    case 'student':
        $extra_field = trim($_POST['class'] ?? '');
        break;
    case 'parent':
        $extra_field = trim($_POST['childname'] ?? '');
        break;
    case 'nonstaff':
        $extra_field = '';
        break;
    default:
        $extra_field = '';
}

// Check if email already exists
try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status'=>'error','message'=>'Email already registered']);
        exit;
    }

    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (category, fullname, email, password, extra_field) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$category, $fullname, $email, $hashedPassword, $extra_field])) {
        echo json_encode(['status'=>'success','message'=>'Account created successfully']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Failed to create account']);
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['status'=>'error','message'=>'A system error occurred. Please try again later.']);
}
?>
