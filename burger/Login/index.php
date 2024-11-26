
?><?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="loginTab()">Login</button>
                <button type="button" class="toggle-btn" onclick="signupTab()">Signup</button>
            </div>
            
            <form id="login" class="input-group">
                <h2>Welcome Back</h2>
                <input type="email" name="email" class="input-field" placeholder="Email Address" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <button type="submit" class="submit-btn">Login</button>
            </form>

            <form id="signup" class="input-group">
                <h2>Create Account</h2>
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <input type="email" name="email" class="input-field" placeholder="Email Address" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <button type="submit" class="submit-btn">Sign up</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if all fields are not empty
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Query to check if email already exists
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = $conn->query($query);

        // Check if email already exists
        if ($result->num_rows == 0) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query to insert new customer data
            $query = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            $conn->query($query);

            // Registration successful, display success message
            $success_message = "Registration successful";
        } else {
            // Email already exists, display error message
            $error_message = "Email already exists";
        }
    } else {
        // One or more fields are empty, display error message
        $error_message = "Please fill in all fields";
    }
}
?><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Query to check if email exists in the database
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = $conn->query($query);

        // Check if email exists
        if ($result->num_rows > 0) {
            // Fetch the user data
            $user_data = $result->fetch_assoc();

            // Check if password matches
            if (password_verify($password, $user_data["password"])) {
                // Login successful, store user data in session
                session_start();
                $_SESSION["customer_id"] = $user_data["customer_id"];
                $_SESSION["name"] = $user_data["name"];
                $_SESSION["email"] = $user_data["email"];

                // Redirect to dashboard or home page
                header("Location: dashboard.php");
                exit;
            } else {
                // Password incorrect, display error message
                $error_message = "Invalid password";
            }
        } else {
            // Email does not exist, display error message
            $error_message = "Email does not exist";
        }
    } else {
        // Email or password is empty, display error message
        $error_message = "Please fill in all fields";
    }
}
