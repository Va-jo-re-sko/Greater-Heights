<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Get user info from session
$fullname = $_SESSION['fullname'];
$category = ucfirst($_SESSION['category']); // capitalize first letter
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Greater Heights - Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --orange: #FF7B25;
        --orange-dark: #E65F00;
        --black: #111;
        --white: #fff;
        --gray-light: #f5f5f5;
        --gray-dark: #444;
    }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:0; background: var(--gray-light); }
    header { background: var(--orange); color: var(--white); padding: 20px; text-align: center; }
    main { padding: 30px; max-width: 900px; margin: auto; }
    .card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); margin-bottom: 20px; }
    .btn-logout { background: var(--orange-dark); color: var(--white); border:none; padding:10px 18px; border-radius:8px; cursor:pointer; transition: all 0.3s; }
    .btn-logout:hover { background: var(--orange); }
</style>
</head>
<body>
<header>
    <h1>Welcome, <?php echo htmlspecialchars($fullname); ?>!</h1>
    <p>Category: <?php echo htmlspecialchars($category); ?></p>
</header>

<main>
    <div class="card">
        <h2>Dashboard</h2>
        <p>This is your personalized dashboard. You can add features like viewing courses, assignments, or managing users here.</p>
    </div>

    <form method="POST" action="logout.php">
        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</main>
</body>
</html>
