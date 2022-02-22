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

// Getting data to complete the form
$sql = "SELECT id,iv,is_completed,user_profile_picture,user_first_name,user_last_name FROM users WHERE username = '{$_SESSION["username"]}'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $content_user_iv = hex2bin($row['iv']);
        $is_completed = $row['is_completed'];
        $user_profile_picture = openssl_decrypt(hex2bin($row['user_profile_picture']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_first_name = openssl_decrypt(hex2bin($row['user_first_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_last_name = openssl_decrypt(hex2bin($row['user_last_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .wrapper {
            width: 760px;
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
        <h1 class="my-5">Hi, <b><?php echo openssl_decrypt(hex2bin($_SESSION["username"]), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv); ?></b>. Welcome to Clubs & Societes.</h1>
        <p>
            <?php
            if ($is_completed == FALSE) {
                echo '<div class="alert alert-primary" role="alert"> It looks like you haven\'t completed your profil yet. </div>';
            }
            if ($is_completed == TRUE) {
                echo '<div class="alert alert-success" role="alert"> Great! You have completed your profile, you can now join clubs! </div>'; 
                echo '<a href="enroll.php" class="btn btn-success">Enroll for a club!</a>';
            }
            echo '<a href="profil.php" class="btn btn-info ml-3">Update your profile</a>';
            ?>
        </p>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
        <?php
        if ($is_completed == TRUE) {
            echo '<div class="card" style="width: 18rem; margin: 0 auto;">';
            echo '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($user_profile_picture) . '" class="card-img-top">';
            echo '<div class="card-body">';
            echo '<p class="card-text"><b>' . $content_user_first_name . " " . $content_user_last_name . '</b></p>';
            echo '</div>';
            $sql = "SELECT registrations.CLUB_ID,clubs.name FROM registrations INNER JOIN clubs ON registrations.CLUB_ID=clubs.id WHERE registrations.USER_ID=$user_id;";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                echo '<ul class="list-group list-group-flush">';
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="list-group-item">' . $row['name'] . '</li>';
                }
                echo '</ul>';
            }
            echo '</div>';
        }
        ?>

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

<?php
mysqli_close($db);
?>