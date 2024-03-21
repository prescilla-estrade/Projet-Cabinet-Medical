<?php
session_start();

require("connectionBD_App.php");

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $linkpdo->prepare('SELECT id_auth, mdp FROM Auth WHERE username = :username')) {
    
    $username = $_POST['username'];
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    // Fetch the result so we can check if the account exists in the database.
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $result['mdp']) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id_auth'] = $result['id_auth'];
            
            header('Location: accueil.php');
            exit;
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
            
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
        //header("Location: index.html");
    }

    $stmt->closeCursor(); // Close the cursor to free up resources.
}
?>
