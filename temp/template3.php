<?php
session_start();
include_once("../config.php");
include_once("../login_db.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE username = '$_SESSION[username]'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);

// Generate the shareable link
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');
$shareLink = $protocol . $host . $uri;

// Convert relative image path to absolute for PDF rendering
$imagePath = $protocol . $host . "/uploads/" . ($data['image'] ?: 'default-image.jpg');

// File name for PDF download
$cvFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['name']) . '_cv.pdf';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Colorful CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0faff;
            color: #333;
            padding: 20px;
        }

        .wrapper {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .top-section {
            background: linear-gradient(135deg, #58b4ae, #a4d4ae);
            padding: 30px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 30px;
            border-bottom: 5px solid #53a3ff;
        }

        .top-section .profile-pic img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
        }

        .top-section .info {
            flex: 1;
            color: #fff;
            text-align: left;
        }

        .top-section .info h1 {
            font-size: 2.2rem;
            margin-bottom: 5px;
        }

        .top-section .info h3 {
            font-weight: 400;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .contact-info p {
            margin-top: 10px;
            font-size: 0.95rem;
            color: #fff;
            line-height: 1.4;
            text-align: left;
        }

        .skills-languages {
            display: flex;
            gap: 30px;
            margin-top: 15px;
        }

        .skills-languages h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .skills-languages p {
            font-size: 0.9rem;
        }

        .main-content {
            padding: 15px; /* Reduced padding */
        }

        .section-card {
            background-color: #e7f1ff;
            border-radius: 8px; /* Reduced border-radius */
            padding: 15px; /* Reduced padding */
            margin-bottom: 15px; /* Reduced margin */
        }

        .section-card h2 {
            font-size: 1.3rem; /* Reduced font size */
            margin-bottom: 10px; /* Reduced margin */
            color: #275778;
            border-left: 4px solid #53a3ff; /* Reduced border thickness */
            padding-left: 8px; /* Reduced padding */
        }

        .item {
            margin-bottom: 10px; /* Reduced margin */
        }

        .item h3 {
            font-size: 1rem; /* Reduced font size */
            color: #333;
        }

        .date {
            font-size: 0.8rem; /* Reduced font size */
            color: #666;
            margin: 3px 0; /* Reduced margin */
            display: block;
        }

        .item p {
            font-size: 0.85rem; /* Reduced font size */
            color: #444;
        }

        .share-link-container {
            margin: 15px auto; /* Reduced margin */
            text-align: center;
            max-width: 1000px;
        }

        .share-link-container input {
            width: 80%;
            padding: 8px; /* Reduced padding */
            border: 1px solid #ccc;
            border-radius: 6px; /* Reduced border-radius */
            margin: 5px 0; /* Reduced margin */
            font-size: 0.9rem; /* Reduced font size */
        }

        .share-link-container button {
            padding: 8px 15px; /* Reduced padding */
            background-color: #53a3ff;
            color: #fff;
            border: none;
            border-radius: 6px; /* Reduced border-radius */
            cursor: pointer;
            font-size: 0.9rem; /* Reduced font size */
            margin: 3px; /* Reduced margin */
        }

        .share-link-container button:hover {
            background-color: #3b8aff;
        }
    </style>
</head>
<body>

<!-- START: PDF Content Wrapper -->
<div id="cv-content" class="wrapper">
    <!-- Top Header Section -->
    <header class="top-section">
        <div class="profile-pic">
            <img src="<?php echo $imagePath; ?>" alt="Profile Picture">
        </div>
        <div class="info">
            <h1><?php echo htmlspecialchars($data['name'] ?: 'N/A'); ?></h1>
            <h3><?php echo htmlspecialchars($data['cposition'] ?: 'N/A'); ?></h3>
            <div class="contact-info">
                <p><strong>📍</strong> <?php echo htmlspecialchars($data['address'] ?: 'N/A'); ?></p>
                <p><strong>📞</strong> <?php echo htmlspecialchars($data['phone'] ?: 'N/A'); ?></p>
                <p><strong>✉️</strong> <?php echo htmlspecialchars($data['email'] ?: 'N/A'); ?></p>
            </div>
            <div class="skills-languages">
                <div>
                    <h4>Tech Stack</h4>
                    <p><?php echo htmlspecialchars($data['skill'] ?: 'N/A'); ?></p>
                </div>
                <div>
                    <h4>Languages</h4>
                    <p><?php echo htmlspecialchars($data['language'] ?: 'N/A'); ?></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="section-card">
            <h2>Work Experience</h2>
            <div class="item">
                <h3><?php echo htmlspecialchars($data['cposition'] . " - " . $data['companyname'] ?: 'N/A'); ?></h3>
                <span class="date"><?php echo htmlspecialchars($data['cstartdate'] ?: 'N/A'); ?></span>
                <p><!-- Optional job description here --></p>
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
<!-- END: PDF Content Wrapper -->

<!-- Share + Download Section -->
<div class="share-link-container">
    <label for="share-link"><strong>Share this CV:</strong></label><br>
    <input id="share-link" type="text" value="<?php echo htmlspecialchars($shareLink); ?>" readonly><br>
    <button onclick="copyLink()">Copy Link</button>
    <button onclick="downloadPDF()">Download as PDF</button>
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
            margin: 5, // Reduced margin to fit more content
            filename: '<?php echo $cvFileName; ?>',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 1.5, // Reduced scale to fit content on one page
                useCORS: true,
                logging: true
            },
            jsPDF: { 
                unit: 'mm', 
                format: 'a4', 
                orientation: 'portrait' 
            },
            pagebreak: { 
                mode: ['avoid-all'], // Prevent page breaks within sections
                avoid: ['.section-card', '.item'] // Avoid breaking these elements
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