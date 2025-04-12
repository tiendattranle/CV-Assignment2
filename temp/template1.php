<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once("../config.php");

// Validate database connection
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Error: Database connection is not properly initialized.");
}
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

$isPreview = isset($_GET['preview']) && $_GET['preview'] == 1;
$cvId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$cvId) {
    die("Error: No CV ID provided.");
}

// Fetch CV data
$query = "SELECT * FROM cv_info WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cvId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: CV not found.");
}

$cv = $result->fetch_assoc();
$stmt->close();

// Generate shareable URL
$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$currentPath = strtok($_SERVER["REQUEST_URI"], '?');
$shareLink = $baseURL . $currentPath . '?id=' . urlencode($cvId);

// Sanitize filename
$cvFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cv['name']) . '_cv.pdf';

function getImagePath($image) {
    $image_path = '../images/users/';
    if (!empty($image) && file_exists($image_path.$image)) {
        return $image_path.$image;
    }
    return $image_path.'default.jpg'; // Path to your default image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cv['name']); ?>'s CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .cv-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }

        #container {
            display: flex;
            background-color: white;
            min-height: 700px;
        }

        #left-div {
            width: 35%;
            background-color: #ecf0f1;
            padding: 25px 20px;
            text-align: center;
        }

        .profile-image {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 25px;
            border: 3px solid #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .profile-image-placeholder {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background-color: #ddd;
            margin: 0 auto 25px;
        }

        #left-middle-div, 
        #left-bottom-div, 
        #left-bottom-languages-div {
            margin-top: 25px;
            text-align: left;
        }

        #left-middle-div h2, 
        #left-bottom-div h2, 
        #left-bottom-languages-div h2 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 12px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            text-align: left;
        }

        .left-logo {
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 8px;
        }

        #left-middle-div p {
            margin-bottom: 10px;
            word-break: break-word;
        }

        #right-div {
            width: 65%;
            padding: 30px;
            background-color: white;
        }

        #right-div h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 8px;
        }

        .name-institute {
            font-size: 20px;
            font-weight: bold;
            color: #34495e;
        }

        .description {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .right-logo {
            width: 24px;
            height: 24px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .share-link-container {
            margin: 30px auto;
            text-align: center;
        }

        .share-link-container input {
            width: 80%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .share-link-container button {
            margin-top: 10px;
            padding: 8px 12px;
            font-size: 14px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .download-button-container {
            margin: 20px auto;
            text-align: center;
        }

        .download-button-container button {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            #container {
                flex-direction: column;
            }

            #left-div,
            #right-div {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="cv-container" id="cv-content">
        <div id="container">
            <div id="left-div">
                <div class="profile-image-placeholder" style="<?php echo !empty($cv['image']) ? 'background-image: url(' . htmlspecialchars(getImagePath($cv['image'])) . '); background-size: cover; background-position: center;' : ''; ?>"></div>
                <div id="left-middle-div">
                    <h2 class="name"><?php echo htmlspecialchars($cv['name']); ?></h2>
                    <p><i class="bx bx-home left-logo"></i> <?php echo htmlspecialchars($cv['address']); ?></p>
                    <p><i class="bx bx-phone left-logo"></i> <?php echo htmlspecialchars($cv['phone']); ?></p>
                    <p><i class="bx bx-envelope left-logo"></i> <?php echo htmlspecialchars($cv['email']); ?></p>
                </div><br>

                <div id="left-bottom-div">
                    <h2><i class="bx bx-bulb left-logo"></i> Skills</h2>
                    <p><?php echo htmlspecialchars($cv['skill']); ?></p>
                </div>

                <div id="left-bottom-languages-div">
                    <h2><i class="bx bx-book left-logo"></i> Languages</h2>
                    <p><?php echo htmlspecialchars($cv['language']); ?></p>
                </div>
            </div>

            <div id="right-div">
                <div id="right-top-div">
                    <h1><i class="bx bx-briefcase right-logo"></i> Work Experience</h1>
                    <h2 class="name-institute"><?php echo htmlspecialchars($cv['companyname']); ?></h2>
                    <h5 class="description"><?php echo htmlspecialchars($cv['cposition']); ?></h5>
                    <p class="description"><?php echo htmlspecialchars($cv['cstartdate']); ?></p>
                </div><br>

                <div id="right-bottom-div">
                    <h1><i class="bx bxs-graduation right-logo"></i> Education</h1>

                    <div id="varsity-div">
                        <h2 class="name-institute"><?php echo htmlspecialchars($cv['varsityname']); ?></h2>
                        <h4 class="description">CGPA: <?php echo htmlspecialchars($cv['cgpa']); ?></h4>
                        <h5 class="description">Graduated: <?php echo htmlspecialchars($cv['varsitypyear']); ?></h5>
                    </div><br>

                    <div id="college-div">
                        <h2 class="name-institute"><?php echo htmlspecialchars($cv['collegename']); ?></h2>
                        <h4 class="description">GPA: <?php echo htmlspecialchars($cv['hscgpa']); ?></h4>
                        <h5 class="description">Graduated: <?php echo htmlspecialchars($cv['clgpyear']); ?></h5>
                    </div><br>

                    <div id="school-div">
                        <h2 class="name-institute"><?php echo htmlspecialchars($cv['schoolname']); ?></h2>
                        <h4 class="description">GPA: <?php echo htmlspecialchars($cv['sscgpa']); ?></h4>
                        <h5 class="description">Graduated: <?php echo htmlspecialchars($cv['sclpyear']); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Button Section (Moved outside cv-content) -->
    <div class="download-button-container">
        <button onclick="downloadPDF()">Download as PDF</button>
    </div>

    <!-- Shareable Link Section -->
    <div class="share-link-container" id="share-section">
        <label for="share-link"><strong>Share this CV:</strong></label><br>
        <input id="share-link" type="text" value="<?php echo htmlspecialchars($shareLink); ?>" readonly>
        <br>
        <button onclick="copyLink()">Copy Link</button>
    </div>

    <script>
        function copyLink() {
            const input = document.getElementById("share-link");
            input.select();
            input.setSelectionRange(0, 99999); // For mobile
            document.execCommand("copy");
            alert("Link copied to clipboard!");
        }

        function downloadPDF() {
            const shareSection = document.getElementById("share-section");
            shareSection.style.display = "none"; // Hide share link during PDF generation

            const cvContent = document.getElementById("cv-content");
            const opt = {
                margin: 0.3,
                filename: "<?php echo $cvFileName; ?>",
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(cvContent).save().then(() => {
                shareSection.style.display = "block"; // Show share link again after PDF generation
            });
        }
    </script>
</body>
</html>