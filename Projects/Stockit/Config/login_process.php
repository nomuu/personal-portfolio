<?php
// Start the session
session_start();

// Include the database connection file
require_once 'db_config.php';

// Initialize variables
$username = $password = "";
$username_err = $password_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, userID, Userpass, Usernickname, userrole FROM Users WHERE userID = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Hash the input username using SHA-256
            $hashed_username = hash('sha256', $username);
            
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $hashed_username);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $stored_username, $stored_hash, $stored_nickname, $userrole);
                    if ($stmt->fetch()) {
                        // Hash the input password using SHA-256
                        $input_hash = hash('sha256', $password);
                        
                        // Verify password
                        if ($input_hash === $stored_hash) {
                            // Password is correct, so start a new session and
                            // save the username, nickname, and role to the session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["userID"] = $username;
                            $_SESSION["Usernickname"] = $stored_nickname; // Store user nickname in session
                            $_SESSION["userrole"] = $userrole; // Store user role in session
                            
                            // Redirect user to welcome page
                            header("location: ../Dashboard.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
    
    // Redirect back to login page with error messages
    header("location: ../login.php?username_err=" . urlencode($username_err) . "&password_err=" . urlencode($password_err));
    exit;

}
?>
