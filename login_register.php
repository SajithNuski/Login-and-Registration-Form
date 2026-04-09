<?php
session_start();
require_once "confiq.php";

function setFlashMessage(string $message, string $type, string $form): void {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_form'] = $form;
    $_SESSION['active_form'] = $form;
}

function redirectToIndex(): void {
    header("Location: index.php");
    exit();
}

function processLogin(mysqli $conn): void {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    if (!$stmt) {
        error_log("Login prepare failed: " . $conn->error);
        setFlashMessage("System error. Please try again.", 'error', 'login-form');
        redirectToIndex();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        }
    }

    setFlashMessage("Invalid email or password", 'error', 'login-form');
    redirectToIndex();
}

function processRegister(mysqli $conn): void {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    if (!$checkStmt) {
        error_log("Register email-check prepare failed: " . $conn->error);
        setFlashMessage("System error. Please try again.", 'error', 'register-form');
        redirectToIndex();
    }

    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkEmail = $checkStmt->get_result();

    if ($checkEmail->num_rows > 0) {
        setFlashMessage("Email already exists", 'error', 'register-form');
        redirectToIndex();
    }

    $insertStmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    if (!$insertStmt) {
        error_log("Register insert prepare failed: " . $conn->error);
        setFlashMessage("System error. Please try again.", 'error', 'register-form');
        redirectToIndex();
    }

    $insertStmt->bind_param("ssss", $name, $email, $password, $role);

    if ($insertStmt->execute()) {
        setFlashMessage("Registration successful. Please login.", 'success', 'login-form');
    } else {
        error_log("Register execute failed: " . $insertStmt->error);
        setFlashMessage("Registration failed. Please try again.", 'error', 'register-form');
    }

    redirectToIndex();
}

if (isset($_POST['login'])) {
    processLogin($conn);
}

if (isset($_POST['register'])) {
    processRegister($conn);
}
