<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database connection file


if (!isset($_SESSION['username'])) {
    header("Location: ?page=log-in");
    exit;
}

include_once("config.php");

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
<link rel="stylesheet" href="css/show-cv.css">
<div class="menu-container">
    <?php if (!empty($cvs)): ?>
        <?php foreach ($cvs as $cv): ?>
            <?php
                $template = $cv['template'];
                $cvId = $cv['id'];
                $isIncomplete = is_null($template);
                $templateFile = $isIncomplete ? '#' : "?page=view&template={$template}";
            ?>
            <div class="cv-item">
                <a href="<?php echo htmlspecialchars($templateFile . '&id=' . urlencode($cvId)); ?>">
                    <div class="cv-card <?php echo $isIncomplete ? 'incomplete' : ''; ?>">
                        <div class="cv-preview-wrapper">
                            <?php if (!$isIncomplete): ?>
                                <iframe 
                                    src="<?php echo htmlspecialchars($templateFile . '&preview=1&id=' . urlencode($cvId)); ?>" 
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