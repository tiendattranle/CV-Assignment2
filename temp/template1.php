<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once("../config.php");

// Check if $conn is defined and valid
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Error: Database connection is not properly initialized.");
}

// Check if connection is still open
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}
$isPreview = isset($_GET['preview']) && $_GET['preview'] == 1;

// Get the CV ID from the URL
$cvId = isset($_GET['id']) ? $_GET['id'] : null;
$isPreview = isset($_GET['preview']) && $_GET['preview'] == 1;

if (!$cvId) {
    die("Error: No CV ID provided.");
}

// Query to fetch full CV info (adjust columns as needed)
$query = "SELECT name, address, skill FROM cv_info WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cvId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: CV not found.");
}

$cv = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cv['name']); ?>'s CV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .cv-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <?php if ($isPreview): ?>
            <!-- Simplified preview content -->
            <h1><?php echo htmlspecialchars($cv['name']); ?></h1>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($cv['address']); ?></p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars($cv['skill']); ?></p>
        <?php else: ?>
            <!-- Full CV content -->
            <h1><?php echo htmlspecialchars($cv['name']); ?></h1>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($cv['address']); ?></p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars($cv['skill']); ?></p>
            <p>This is the full CV content for <?php echo htmlspecialchars($cv['name']); ?>. Add more details here as needed.</p>
        <?php endif; ?>
    </div>
</body>
</html>