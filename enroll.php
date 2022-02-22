<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once "dbConfig.php";

// Getting user_ID
$sql = "SELECT id FROM users WHERE username = '{$_SESSION["username"]}'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Getting club_ID
    $selected_club = trim($_POST["selected_club"]);    
    $sql = "SELECT id FROM clubs WHERE name = '$selected_club'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $club_id = $row['id'];
        }
    }
    
    $sql = "INSERT INTO registrations (USER_ID, CLUB_ID) VALUES ('$user_id','$club_id')";

    if ($db->query($sql) === TRUE) {
        // Redirect to welcome page
        header("location: welcome.php");
    } else {
        echo "Error linking club: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Club/Society Registration</title>
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
            width: 400px;
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
                    "href": "http://localhost/cyber_project/policy.php"
                }
            })
        });
    </script>

</head>

<body>

    <div class="wrapper">
        <h2>Club/Society Registration</h2>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Great!</h4>
            <p>You have completed your profil, you are now able to join a club!</p>
            <hr>
            <p class="mb-0">Please select a club you want to join.</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Select a club to join</label>
                <select name="selected_club" class="form-control selectpicker" data-live-search="true">
                    <?php
                    $sql = "SELECT id, name from clubs WHERE NOT id IN (SELECT registrations.CLUB_ID FROM registrations INNER JOIN clubs ON registrations.CLUB_ID=clubs.id WHERE registrations.USER_ID=$user_id);";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo $row['name'];
                            echo '<option data-tokens="' . strtolower($row['name']) . '">' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Join">
                <a href="welcome.php" class="btn btn-danger float-right">Cancel</a>
            </div>
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