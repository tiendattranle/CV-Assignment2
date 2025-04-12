<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Include the database connection file
include_once("config.php");


if (!isset($_SESSION['username'])) {
    echo "You are not logged in. Please log in to access this page.";
    // header("Location: login.php");
    exit;
}



// Check if $conn is defined and valid
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Error: Database connection is not properly initialized.");
}

// Check if connection is still open
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Query to fetch brief CV info
$query = "SELECT id, name, address, skill, template FROM cv_info WHERE username = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all CVs into an array
$cvs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cvs[] = $row;
}
mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .cv-item {
            display: flex;
            flex-direction: column;
            width: 300px;
        }
        .cv-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
            width: 300px;
            height: 300px;
            padding: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            overflow: hidden;
            cursor: pointer; /* Indicates clickable area */
        }
        .cv-card:hover {
            transform: scale(1.05);
        }
        .cv-preview-wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .cv-preview-wrapper iframe {
            width: 200%;
            height: 200%;
            border: none;
            transform: scale(0.5);
            transform-origin: top left;
            pointer-events: none; /* Prevents iframe from blocking clicks */
        }
        .cv-card.incomplete {
            border: 2px dashed #e74c3c;
            background-color: #fceae9;
        }
        .incomplete .cv-preview-wrapper {
            padding: 20px;
        }
        .incomplete h3 {
            margin-top: 0;
            color: #c0392b;
        }
        .incomplete p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .incomplete .note {
            color: #999;
        }
        a {
            text-decoration: none; /* Removes underline from links */
            color: inherit; /* Inherits text color */
        }
        .button-bar {
            display: flex;
            width: 100%;
            border-radius: 0 0 8px 8px;
            overflow: hidden;
        }
        .button-bar a {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            background-color: #3498db;
            color: white;
            transition: background-color 0.3s;
            font-weight: bold;
        }
        .button-bar a:hover {
            background-color: #2980b9;
        }
        .button-bar a.delete {
            background-color: #e74c3c;
        }
        .button-bar a.delete:hover {
            background-color: #c0392b;
        }
        .button-bar a:first-child {
            border-right: 1px solid rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>
    <!-- <h1>CV Menu</h1> -->
    <div class="menu-container">
        <?php if (!empty($cvs)): ?>
            <?php foreach ($cvs as $cv): ?>
                <?php
                    $template = $cv['template'];
                    $cvId = $cv['id'];
                    $isIncomplete = is_null($template);
                    $templateFile = $isIncomplete ? '#' : "temp/template{$template}.php";
                ?>
                <div class="cv-item">
                    <a href="<?php echo htmlspecialchars($templateFile . '?id=' . urlencode($cvId)); ?>">
                        <div class="cv-card <?php echo $isIncomplete ? 'incomplete' : ''; ?>">
                            <div class="cv-preview-wrapper">
                                <?php if (!$isIncomplete): ?>
                                    <iframe 
                                        src="<?php echo htmlspecialchars($templateFile . '?preview=1&id=' . urlencode($cvId)); ?>" 
                                        title="CV Preview"
                                        style="width: 200%; height: 200%; border: none; transform: scale(0.5); transform-origin: top left; pointer-events: none;">
                                    </iframe>
                                <?php else: ?>
                                    <h3>Incomplete CV</h3>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($cv['name']); ?></p>
                                    <p><strong>Address:</strong> <?php echo htmlspecialchars($cv['address']); ?></p>
                                    <p><strong>Skills:</strong> <?php echo htmlspecialchars($cv['skill']); ?></p>
                                    <p class="note">No template selected.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                    <div class="button-bar">
                        <a href="?page=update-cv&id=<?php echo urlencode($cvId); ?>" class="edit">Edit</a>
                        <a href="delete_cv.php?id=<?php echo urlencode($cvId); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this CV?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: #666;">No CVs found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>