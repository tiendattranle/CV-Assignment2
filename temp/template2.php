<?php
session_start();
include_once("../config.php");
include_once("../login_db.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE username = '$_SESSION[username]'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);

$cvFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['name']) . '_cv.pdf';

$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$currentPath = strtok($_SERVER["REQUEST_URI"], '?');
$shareLink = $baseURL . $currentPath;

// Convert relative image path to absolute for PDF rendering
$imagePath = $baseURL . "/uploads/" . ($data['image'] ?: 'default-image.jpg');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f9ff;
            color: #333;
        }
        .wrapper {
            max-width: 1100px;
            margin: 20px auto; /* Reduced margin */
            background-color: #ffffff;
            border-radius: 8px; /* Reduced border-radius */
            overflow: hidden;
        }
        .cv-container {
            display: flex;
            min-height: auto; /* Removed min-height to avoid forcing extra height */
        }
        .sidebar {
            width: 220px; /* Reduced width */
            background-color: #1e3a5f;
            color: white;
            padding: 20px 15px; /* Reduced padding */
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar .profile-pic img {
            width: 100px; /* Reduced image size */
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px; /* Reduced margin */
        }
        .sidebar .full-name {
            font-size: 1.2rem; /* Reduced font size */
            margin-bottom: 3px;
        }
        .sidebar .job-title {
            font-size: 0.9rem; /* Reduced font size */
            font-weight: 300;
            margin-bottom: 15px; /* Reduced margin */
        }
        .contact-info {
            list-style: none;
            font-size: 0.8rem; /* Reduced font size */
            margin-bottom: 15px; /* Reduced margin */
            text-align: center;
        }
        .contact-info li {
            margin-bottom: 5px; /* Reduced spacing between items */
        }
        .skills-section, .languages-section {
            margin-bottom: 15px; /* Reduced margin */
        }
        .skills-section h3, .languages-section h3 {
            font-size: 0.9rem; /* Reduced font size */
            margin-bottom: 3px;
            border-bottom: 1px solid #ffffff50;
        }
        .skills-section p, .languages-section p {
            font-size: 0.8rem; /* Reduced font size */
        }
        .main-content {
            flex: 1;
            padding: 20px; /* Reduced padding */
        }
        .section-card {
            background: white;
            border-radius: 8px; /* Reduced border-radius */
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 15px; /* Reduced margin */
            padding: 15px 20px; /* Reduced padding */
        }
        .section-card h2 {
            color: #1e3a5f;
            margin-bottom: 10px; /* Reduced margin */
            font-size: 1.2rem; /* Reduced font size */
        }
        .section-card .item {
            margin-bottom: 10px; /* Reduced margin */
        }
        .section-card .item h3 {
            font-size: 1rem; /* Reduced font size */
            color: #0f2745;
        }
        .section-card .item .date {
            font-size: 0.8rem; /* Reduced font size */
            color: #555;
            display: block;
            margin: 2px 0 3px;
        }
        .section-card .item p {
            font-size: 0.85rem; /* Reduced font size */
            color: #444;
        }
        .actions {
            text-align: center;
            margin: 15px 0; /* Reduced margin */
        }
        .actions button {
            padding: 8px 12px; /* Reduced padding */
            font-size: 13px; /* Reduced font size */
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 4px; /* Reduced border-radius */
            cursor: pointer;
            margin-right: 8px;
        }
        .actions input {
            width: 60%;
            padding: 6px; /* Reduced padding */
            font-size: 13px; /* Reduced font size */
            margin-top: 8px;
        }
    </style>
</head>
<body>
<div id="cv-content" class="wrapper">
    <div class="cv-container">
        <aside class="sidebar">
            <div class="profile-pic">
                <img src="<?php echo $imagePath; ?>" alt="Profile Picture">
            </div>
            <h2 class="full-name"><?php echo htmlspecialchars($data['name'] ?: 'N/A'); ?></h2>
            <p class="job-title"><?php echo htmlspecialchars($data['cposition'] ?: 'N/A'); ?></p>
            <ul class="contact-info">
                <li><strong>Address:</strong> <?php echo htmlspecialchars($data['address'] ?: 'N/A'); ?></li>
                <li><strong>Phone:</strong> <?php echo htmlspecialchars($data['phone'] ?: 'N/A'); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($data['email'] ?: 'N/A'); ?></li>
            </ul>
            <div class="skills-section">
                <h3>Tech Stack</h3>
                <p><?php echo htmlspecialchars($data['skill'] ?: 'N/A'); ?></p>
            </div>
            <div class="languages-section">
                <h3>Languages</h3>
                <p><?php echo htmlspecialchars($data['language'] ?: 'N/A'); ?></p>
            </div>
        </aside>
        <main class="main-content">
            <section class="section-card">
                <h2>Work History</h2>
                <div class="item">
                    <h3><?php echo htmlspecialchars($data['cposition'] . " - " . $data['companyname'] ?: 'N/A'); ?></h3>
                    <span class="date"><?php echo htmlspecialchars($data['cstartdate'] ?: 'N/A'); ?></span>
                </div>
            </section>
            <section class="section-card">
                <h2>Education</h2>
                <div class="item">
                    <h3><?php echo htmlspecialchars($data['varsityname'] ?: 'N/A'); ?></h3>
                    <span class="date">Graduated: <?php echo htmlspecialchars($data['varsitypyear'] ?: 'N/A'); ?></span>
                    <p>CGPA: <?php echo htmlspecialchars($data['cgpa'] ?: 'N/A'); ?></p>
                </div>
                <div class="item">
                    <h3><?php echo htmlspecialchars($data['collegename'] ?: 'N/A'); ?></h3>
                    <span class="date">Graduated: <?php echo htmlspecialchars($data['clgpyear'] ?: 'N/A'); ?></span>
                    <p>GPA: <?php echo htmlspecialchars($data['hscgpa'] ?: 'N/A'); ?></p>
                </div>
                <div class="item">
                    <h3><?php echo htmlspecialchars($data['schoolname'] ?: 'N/A'); ?></h3>
                    <span class="date">Graduated: <?php echo htmlspecialchars($data['sclpyear'] ?: 'N/A'); ?></span>
                    <p>GPA: <?php echo htmlspecialchars($data['sscgpa'] ?: 'N/A'); ?></p>
                </div>
            </section>
        </main>
    </div>
</div>

<div class="actions">
    <button onclick="downloadPDF()">Download as PDF</button><br>
    <label><strong>Share this CV:</strong></label><br>
    <input type="text" id="share-link" value="<?php echo htmlspecialchars($shareLink); ?>" readonly><br>
    <button onclick="copyLink()">Copy Link</button>
</div>

<script>
    // Preload the image to ensure it loads in the PDF
    function preloadImage(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.src = url;
            img.onload = resolve;
            img.onerror = reject;
        });
    }

    async function downloadPDF() {
        const element = document.getElementById('cv-content');
        const imageUrl = '<?php echo $imagePath; ?>';

        // Preload the image before generating the PDF
        try {
            await preloadImage(imageUrl);
        } catch (error) {
            console.error('Failed to load image:', error);
        }

        const opt = {
            margin: 0.2, // Reduced margin to maximize space
            filename: '<?php echo $cvFileName; ?>',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 1.5, // Reduced scale to fit content
                useCORS: true,
                logging: true
            },
            jsPDF: { 
                unit: 'in', 
                format: 'letter', 
                orientation: 'landscape' // Changed to landscape to fit side-by-side layout
            },
            pagebreak: { 
                mode: ['avoid-all'], // Prevent page breaks
                avoid: ['.section-card', '.item', '.cv-container'] // Avoid breaking these elements
            }
        };
        html2pdf().set(opt).from(element).save();
    }

    function copyLink() {
        const input = document.getElementById("share-link");
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Link copied to clipboard!");
    }
</script>
</body>
</html>