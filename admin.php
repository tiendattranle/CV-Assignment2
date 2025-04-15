<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ?page=log-in");
    exit;
}

include_once("config.php");

// Fetch users and CVs from the database
$usersQuery = "SELECT id, username, email FROM login"; // Updated to use 'login' table
$usersResult = mysqli_query($conn, $usersQuery);

$cvsQuery = "SELECT id, name, username, template FROM cv_info";
$cvsResult = mysqli_query($conn, $cvsQuery);
?>


    <link rel="stylesheet" href="css/admin.css">

        <section>
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($usersResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="delete_user.php?id=<?php echo urlencode($user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Manage CVs</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Template</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cv = mysqli_fetch_assoc($cvsResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cv['id']); ?></td>
                            <td><?php echo htmlspecialchars($cv['name']); ?></td>
                            <td><?php echo htmlspecialchars($cv['username']); ?></td>
                            <td><?php echo htmlspecialchars($cv['template']); ?></td>
                            <td>
                                <a href="delete_cv.php?id=<?php echo urlencode($cv['id']); ?>" onclick="return confirm('Are you sure you want to delete this CV?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

