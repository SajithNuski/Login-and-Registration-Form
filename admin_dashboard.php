<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="style.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to right, #eff4ff, #ffe5c4);">
    <div class="box">
        <h1>Welcome,<span><?php echo $_SESSION['name']; ?></span></h1>
        <p>This is the <span>admin</span> dashboard.</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>