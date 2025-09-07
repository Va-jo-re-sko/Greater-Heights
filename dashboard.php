<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Get user info from session
$fullname = $_SESSION['fullname'];
$category = ucfirst($_SESSION['category']);
$email = $_SESSION['email'];
$last_login = isset($_SESSION['last_login']) ? date('F j, Y, g:i a', $_SESSION['last_login']) : 'First login';
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
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body { 
        background: var(--gray-light); 
        color: var(--black);
        line-height: 1.6;
    }
    
    header { 
        background: linear-gradient(to right, var(--orange), var(--orange-dark)); 
        color: var(--white); 
        padding: 25px 20px; 
        text-align: center; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .user-info {
        text-align: right;
    }
    
    main { 
        padding: 30px 20px; 
        max-width: 1200px; 
        margin: 0 auto;
    }
    
    .welcome-section {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .card { 
        background: var(--white); 
        padding: 25px; 
        border-radius: 12px; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .card h3 {
        color: var(--orange-dark);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gray-light);
    }
    
    .stats {
        display: flex;
        justify-content: space-around;
        margin: 25px 0;
        text-align: center;
    }
    
    .stat-item {
        padding: 15px;
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: var(--orange);
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--gray-dark);
    }
    
    .btn-logout { 
        background: var(--orange-dark); 
        color: var(--white); 
        border: none; 
        padding: 12px 20px; 
        border-radius: 8px; 
        cursor: pointer; 
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }
    
    .btn-logout:hover { 
        background: var(--orange);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(230, 95, 0, 0.3);
    }
    
    .logout-container {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-light);
    }
    
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 15px;
        }
        
        .user-info {
            text-align: center;
        }
        
        .card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>
<body>
<header>
    <div class="header-content">
        <h1>Greater Heights Dashboard</h1>
        <div class="user-info">
            <p>Welcome, <strong><?php echo htmlspecialchars($fullname); ?></strong>!</p>
            <p>Category: <?php echo htmlspecialchars($category); ?></p>
        </div>
    </div>
</header>

<main>
    <div class="welcome-section">
        <h2>Welcome to Your Learning Portal</h2>
        <p>Last login: <?php echo $last_login; ?></p>
    </div>
    
    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">12</div>
            <div class="stat-label">Courses</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">5</div>
            <div class="stat-label">Assignments</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">3</div>
            <div class="stat-label">Messages</div>
        </div>
    </div>
    
    <div class="card-grid">
        <div class="card">
            <h3><i class="fas fa-book"></i> My Courses</h3>
            <p>Access your enrolled courses and learning materials.</p>
            <ul>
                <li>Mathematics 101</li>
                <li>Science Fundamentals</li>
                <li>Literature Appreciation</li>
            </ul>
        </div>
        
        <div class="card">
            <h3><i class="fas fa-tasks"></i> Assignments</h3>
            <p>View and submit your assignments.</p>
            <ul>
                <li>Math Problem Set - Due Tomorrow</li>
                <li>Science Report - Due in 3 days</li>
                <li>Essay Writing - Due next week</li>
            </ul>
        </div>
        
        <div class="card">
            <h3><i class="fas fa-chart-line"></i> Progress</h3>
            <p>Track your learning progress and achievements.</p>
            <div style="background: #f0f0f0; height: 10px; border-radius: 5px; margin: 15px 0;">
                <div style="background: var(--orange); width: 75%; height: 100%; border-radius: 5px;"></div>
            </div>
            <p>Overall progress: 75%</p>
        </div>
    </div>
    
    <div class="logout-container">
        <form method="POST" action="logout.php">
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</main>
</body>
</html>
