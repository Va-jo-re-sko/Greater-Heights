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
    error_log("Database connection failed: " . $e->getMessage());
    echo json_encode(['status'=>'error','message'=>'Database connection failed. Please try again later.']);
    exit;
}

// Retrieve POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) ? true : false;

// Validate input
if (!$email || !$password) {
    echo json_encode(['status'=>'error','message'=>'Please fill in all fields']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status'=>'error','message'=>'Please provide a valid email address']);
    exit;
}

try {
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

    // Login successful - start session
    session_start();
    
    // Regenerate session ID to prevent fixation attacks
    session_regenerate_id(true);
    
    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['category'] = $user['category'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['last_login'] = time();

    // Set longer session if "remember me" is checked
    if ($remember) {
        // Extend session cookie to 30 days
        $lifetime = 60 * 60 * 24 * 30; // 30 days
        session_set_cookie_params($lifetime);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful! Redirecting...',
        'category' => $user['category']
    ]);
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['status'=>'error','message'=>'An error occurred during login. Please try again.']);
}
?>
