<?php
session_start();

$flashData = [
    'message' => $_SESSION['flash_message'] ?? '',
    'type' => $_SESSION['flash_type'] ?? 'error',
    'form' => $_SESSION['flash_form'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login-form';

// Remove flash values after reading them.
unset($_SESSION['flash_message'], $_SESSION['flash_type'], $_SESSION['flash_form'], $_SESSION['active_form']);

function displayMessage(string $formName, array $flashData): string {
    if (empty($flashData['message']) || $flashData['form'] !== $formName) {
        return '';
    }

    $type = strtolower(trim((string) $flashData['type']));
    $class = in_array($type, ['success', 'successful', 'successfull'], true) ? 'success' : 'error';
    $message = htmlspecialchars((string) $flashData['message'], ENT_QUOTES, 'UTF-8');

    return "<p class='flash-message {$class}'>{$message}</p>";
}

function isActive(string $formName, string $activeForm): string {
    return $activeForm === $formName ? 'active' : '';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="form-box <?php echo isActive('login-form', $activeForm); ?>" id="login-form">
        <form autocomplete="off" action="login_register.php" method="post">
            <h2>Login</h2>
                <?php echo displayMessage('login-form', $flashData); ?>
            <input type="email" autocomplete="fakeemail" name="email" placeholder="Email" required>
            <input type="password" autocomplete="fakepassword" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a> </p>
        </form>
        </div>
    
        <div class="form-box <?php echo isActive('register-form', $activeForm); ?>"  id="register-form">
        <form autocomplete="off" action="login_register.php" method="post">
            <h2>Register</h2>
                <?php echo displayMessage('register-form', $flashData); ?>
            <input type="text" autocomplete="fakename" name="name" placeholder="User Name" required>
            <input type="email" autocomplete="fakemail" name="email" placeholder="Email" required>
            <input type="password" autocomplete="fakepassword" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a> </p>
        </form> 
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>