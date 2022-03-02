<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "dbConfig.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
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
        $sql = "SELECT id, iv, username, password FROM users";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $iv = hex2bin($row['iv']);
                $content_username = hex2bin($row['username']);
                $unencrypted_content = openssl_decrypt(
                    $content_username,
                    $cipher,
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );
                if ($unencrypted_content == trim($_POST["username"])) {
                    if (password_verify($password, $row['password'])) {
                        // Password is correct, so start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $row['username'];

                        // Redirect user to welcome page
                        header("location: welcome.php");
                    } else {
                        // Password is not valid, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    $login_err = $unencrypted_content;
                }
            }
        }
    }
    // Close connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            font: 14px sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            margin: 0 auto;
            flex: 1;
        }
    </style>

    <!-- Cookie banner -->
    <script src="https://cdn.websitepolicies.io/lib/cookieconsent/1.0.3/cookieconsent.min.js" defer></script>
    <script>
        window.addEventListener("load", function() {
            window.wpcc.init({
                "border": "thin",
                "corners": "small",
                "colors": {
                    "popup": {
                        "background": "#f6f6f6",
                        "text": "#000000",
                        "border": "#555555"
                    },
                    "button": {
                        "background": "#555555",
                        "text": "#ffffff"
                    }
                },
                "position": "bottom",
                "content": {
                    "message": "This site uses only the cookies that are necessary for its operation, they are mandatory.",
                    "link": "Read more about our cookie",
                    "href": "policy.php"
                }
            })
        });
    </script>

</head>

<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Cryptography</a></li>
                            <li><a href="#">Cybercrime Legislation</a></li>
                            <li><a href="#">Software Engineering</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Resources</h3>
                        <ul>
                            <li><a href="legalmentions.php" target="_blank">Legal mentions</a></li>
                            <li><a href="policy.php" target="_blank">Privacy policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 item text">
                        <h3>Cyberproject</h3>
                        <p>IT Carlow clubs and societies online registration system for students and staff.</p>
                    </div>
                    <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                </div>
                <p class="copyright">Cyberproject © 2022 | Tristan CACCHIA</p>
            </div>
        </footer>
    </div>
</body>

</html>