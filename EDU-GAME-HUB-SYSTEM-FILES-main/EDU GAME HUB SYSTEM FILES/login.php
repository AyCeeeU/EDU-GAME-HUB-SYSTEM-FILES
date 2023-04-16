<?php
session_start();
include("db_conn.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location: Login.html?error=Username is required");
        exit();
    } else if (empty($password)) {
        header("Location: Login.html?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                header("Location: admin.html"); 
                exit();
            } else {
                header("Location: Login.html?error=Incorrect username or password");
                exit();
            }
        } else {
            header("Location: Login.html?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header("Location: Login.html");
    exit();


    
}
?>
