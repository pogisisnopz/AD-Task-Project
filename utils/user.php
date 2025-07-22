<?php
require_once 'database.php'; // Ensure you include your DB connection

class User {

    // Register a new user
    public static function register($firstName, $lastName, $username, $password) {
        global $conn;

        // Check if the username is already taken
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Username already taken!";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $username, $hashedPassword);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "Account created successfully!";
        } else {
            return "Error creating account. Please try again.";
        }
    }

    // Login user
    public static function login($username, $password) {
        global $conn;

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $storedPassword);

        if ($stmt->num_rows == 1) {
            $stmt->fetch();
            if (password_verify($password, $storedPassword)) {
                $_SESSION['user_id'] = $id;
                return true;
            } else {
                return false; // Incorrect password
            }
        }

        return false; // User not found
    }

    // Check if the user is logged in
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    // Logout user
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
