<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Include the database configuration file  
require_once 'dbConfig.php';

// Define variables and initialize with empty values
$user_first_name = $user_last_name = $user_student_id = $user_phone_number = $user_email = $user_dob = $user_profile_picture = $user_medical_declaration = $user_medical_conditions = "";
$user_first_name_err = $user_last_name_err = $user_student_id_err = $user_form_err = $user_phone_number_err = $user_email_err = $user_dob_err = $user_profile_picture_err = $user_medical_declaration_err = $user_medical_conditions_err = "";

$doctor_first_name = $doctor_last_name = $doctor_phone_number = $doctor_email = $doctor_address_street = $doctor_address_city = $doctor_address_state = $doctor_address_country = "";
$doctor_first_name_err = $doctor_last_name_err = $doctor_phone_number_err = $doctor_email_err = $doctor_address_street_err = $doctor_address_city_err = $doctor_address_state_err = $doctor_address_country_err = "";

$kin_first_name = $kin_last_name = $kin_phone_number = $kin_email = $kin_address_street = $kin_address_city = $kin_address_state = $kin_address_country = "";
$kin_first_name_err = $kin_last_name_err = $kin_phone_number_err = $kin_email_err = $kin_address_street_err = $kin_address_city_err = $kin_address_state_err = $kin_address_country_err = "";

$user_first_name_enc = $user_last_name_enc = $user_student_id_enc = $user_phone_number_enc = $user_email_enc = $user_dob_enc = $user_medical_conditions_enc = "";

// Define validation varibles
$phone = '0000000000';
$allowTypes_Profile_Picture = array('jpg', 'png', 'jpeg', 'gif');
$allowTypes_Medical_Declaration = array('pdf');

// Getting data to complete the form
$sql = "SELECT id,iv,user_first_name,user_last_name,user_student_id,user_phone_number,user_email,user_dob,user_medical_conditions,doctor_first_name,doctor_last_name,doctor_phone_number,doctor_email,doctor_address_street,doctor_address_city,doctor_address_state,doctor_address_country,kin_first_name,kin_last_name,kin_phone_number,kin_email,kin_address_street,kin_address_city,kin_address_state,kin_address_country FROM users WHERE username = '{$_SESSION["username"]}'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $content_user_id = $row['id'];
        $content_user_iv = hex2bin($row['iv']);
        $content_user_first_name = openssl_decrypt(hex2bin($row['user_first_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_last_name = openssl_decrypt(hex2bin($row['user_last_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_student_id = openssl_decrypt(hex2bin($row['user_student_id']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_phone_number = openssl_decrypt(hex2bin($row['user_phone_number']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_email = openssl_decrypt(hex2bin($row['user_email']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_dob = openssl_decrypt(hex2bin($row['user_dob']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_user_medical_conditions = openssl_decrypt(hex2bin($row['user_medical_conditions']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_first_name = openssl_decrypt(hex2bin($row['doctor_first_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_last_name = openssl_decrypt(hex2bin($row['doctor_last_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_phone_number = openssl_decrypt(hex2bin($row['doctor_phone_number']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_email = openssl_decrypt(hex2bin($row['doctor_email']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_address_street = openssl_decrypt(hex2bin($row['doctor_address_street']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_address_city = openssl_decrypt(hex2bin($row['doctor_address_city']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_address_state = openssl_decrypt(hex2bin($row['doctor_address_state']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_doctor_address_country = openssl_decrypt(hex2bin($row['doctor_address_country']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_first_name = openssl_decrypt(hex2bin($row['kin_first_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_last_name = openssl_decrypt(hex2bin($row['kin_last_name']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_phone_number = openssl_decrypt(hex2bin($row['kin_phone_number']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_email = openssl_decrypt(hex2bin($row['kin_email']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_address_street = openssl_decrypt(hex2bin($row['kin_address_street']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_address_city = openssl_decrypt(hex2bin($row['kin_address_city']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_address_state = openssl_decrypt(hex2bin($row['kin_address_state']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
        $content_kin_address_country = openssl_decrypt(hex2bin($row['kin_address_country']), $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate User Fisrt name
    if (empty(trim($_POST["user_first_name"]))) {
        $user_first_name_err = "Please enter your fisrt name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["user_first_name"]))) { // Mitigate XSS Stored
        $user_first_name_err = "First name could only contains letters";
    } else {
        $user_first_name = trim($_POST["user_first_name"]);
        $user_first_name_enc = bin2hex(openssl_encrypt($user_first_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Last name
    if (empty(trim($_POST["user_last_name"]))) {
        $user_last_name_err = "Please enter your last name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["user_last_name"]))) { // Mitigate XSS Stored
        $user_last_name_err = "Last name could only contains letters";
    } else {
        $user_last_name = trim($_POST["user_last_name"]);
        $user_last_name_enc = bin2hex(openssl_encrypt($user_last_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Student ID
    if (empty(trim($_POST["user_student_id"]))) {
        $user_student_id_err = "Please enter your student ID.";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["user_student_id"]))) { // Mitigate XSS Stored
        $user_student_id_err = "Student ID could only contains letters and numbers";
    } else {
        $user_student_id = trim($_POST["user_student_id"]);
        $user_student_id_enc = bin2hex(openssl_encrypt($user_student_id, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Phone Number
    if (empty(trim($_POST["user_phone_number"]))) {
        $user_phone_number_err = "Please enter a valid phone number.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $user_phone_number_err = "Please enter a valid phone number.";
    } else {
        $user_phone_number = trim($_POST["user_phone_number"]);
        $user_phone_number_enc = bin2hex(openssl_encrypt($user_phone_number, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Email
    if (empty(trim($_POST["user_email"]))) {
        $user_email_err = "Please enter a valid email address.";
    } elseif (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
        $user_email_err = "Please enter a valid email address.";
    } else {
        $user_email = trim($_POST["user_email"]);
        $user_email_enc = bin2hex(openssl_encrypt($user_email, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Student ID
    if (empty(trim($_POST["user_dob"]))) {
        $user_dob_err = "Please enter a valid date of birth.";
    } else {
        $user_dob = trim($_POST["user_dob"]);
        $user_dob_enc = bin2hex(openssl_encrypt($user_dob, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Profile Picture
    $fileName_User_Profile_Picture = basename($_FILES["user_profile_picture"]["name"]);
    $fileType_User_Profile_Picture = pathinfo($fileName_User_Profile_Picture, PATHINFO_EXTENSION);
    if (empty($_FILES["user_profile_picture"]["name"]) && (!in_array($fileType_User_Profile_Picture, $allowTypes_Profile_Picture))) {
        $user_profile_picture_err = "Please enter a valid profil picture (jpg, png, jpeg, gif).";
    } else {
        $user_profile_picture = $_FILES['user_profile_picture']['tmp_name'];
        $user_profile_picture_content = file_get_contents($user_profile_picture);
        $user_profile_picture_enc = bin2hex(openssl_encrypt($user_profile_picture_content, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Medical Declaration
    $fileName_User_Medical_Declaration = basename($_FILES["user_medical_declaration"]["name"]);
    $fileType_User_Medical_Declaration = pathinfo($fileName_User_Medical_Declaration, PATHINFO_EXTENSION);
    if (empty($_FILES["user_profile_picture"]["name"]) && (!in_array($fileType_User_Medical_Declaration, $allowTypes_Medical_Declaration))) {
        $user_medical_declaration_err = "Please enter a valid medical declaration (pdf).";
    } else {
        $user_medical_declaration = $_FILES['user_medical_declaration']['tmp_name'];
        $user_medical_declaration_content = file_get_contents($user_medical_declaration);
        $user_medical_declaration_enc = bin2hex(openssl_encrypt($user_medical_declaration_content, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate User Medical Conditions
    if (empty(trim($_POST["user_medical_conditions"]))) {
        $user_medical_conditions_err = "Please enter your medical conditions.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["user_medical_conditions"]))) { // Mitigate XSS Stored
        $user_medical_conditions_err = "Medical conditions could only contains letters";
    } else {
        $user_medical_conditions = trim($_POST["user_medical_conditions"]);
        $user_medical_conditions_enc = bin2hex(openssl_encrypt($user_medical_conditions, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Fisrt name
    if (empty(trim($_POST["doctor_first_name"]))) {
        $doctor_first_name_err = "Please enter your fisrt name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_first_name"]))) { // Mitigate XSS Stored
        $doctor_first_name_err = "First name could only contains letters";
    } else {
        $doctor_first_name = trim($_POST["doctor_first_name"]);
        $doctor_first_name_enc = bin2hex(openssl_encrypt($doctor_first_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Last name
    if (empty(trim($_POST["doctor_last_name"]))) {
        $doctor_last_name_err = "Please enter your last name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_last_name"]))) { // Mitigate XSS Stored
        $doctor_last_name_err = "Last name could only contains letters";
    } else {
        $doctor_last_name = trim($_POST["doctor_last_name"]);
        $doctor_last_name_enc = bin2hex(openssl_encrypt($doctor_last_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Phone Number
    if (empty(trim($_POST["doctor_phone_number"]))) {
        $doctor_phone_number_err = "Please enter a valid phone number.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $doctor_phone_number_err = "Please enter a valid phone number.";
    } else {
        $doctor_phone_number = trim($_POST["doctor_phone_number"]);
        $doctor_phone_number_enc = bin2hex(openssl_encrypt($doctor_phone_number, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Email
    if (empty(trim($_POST["doctor_email"]))) {
        $doctor_email_err = "Please enter a valid email address.";
    } elseif (!filter_var($_POST["doctor_email"], FILTER_VALIDATE_EMAIL)) {
        $doctor_email_err = "Please enter a valid email address.";
    } else {
        $doctor_email = trim($_POST["doctor_email"]);
        $doctor_email_enc = bin2hex(openssl_encrypt($doctor_email, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Address Street
    if (empty(trim($_POST["doctor_address_street"]))) {
        $doctor_address_street_err = "Please enter a valid street name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_address_street"]))) { // Mitigate XSS Stored
        $doctor_address_street_err = "Street could only contains letters";
    } else {
        $doctor_address_street = trim($_POST["doctor_address_street"]);
        $doctor_address_street_enc = bin2hex(openssl_encrypt($doctor_address_street, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Address City
    if (empty(trim($_POST["doctor_address_city"]))) {
        $doctor_address_city_err = "Please enter a valid city name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_address_city"]))) { // Mitigate XSS Stored
        $doctor_address_city_err = "City could only contains letters";
    } else {
        $doctor_address_city = trim($_POST["doctor_address_city"]);
        $doctor_address_city_enc = bin2hex(openssl_encrypt($doctor_address_city, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Address State
    if (empty(trim($_POST["doctor_address_state"]))) {
        $doctor_address_state_err = "Please enter a valid state name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_address_state"]))) { // Mitigate XSS Stored
        $doctor_address_state_err = "State could only contains letters";
    } else {
        $doctor_address_state = trim($_POST["doctor_address_state"]);
        $doctor_address_state_enc = bin2hex(openssl_encrypt($doctor_address_state, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Doctor Address Country
    if (empty(trim($_POST["doctor_address_country"]))) {
        $doctor_address_country_err = "Please enter a valid country name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["doctor_address_country"]))) { // Mitigate XSS Stored
        $doctor_address_country_err = "Country could only contains letters";
    } else {
        $doctor_address_country = trim($_POST["doctor_address_country"]);
        $doctor_address_country_enc = bin2hex(openssl_encrypt($doctor_address_country, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Fisrt name
    if (empty(trim($_POST["kin_first_name"]))) {
        $kin_first_name_err = "Please enter your fisrt name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_first_name"]))) { // Mitigate XSS Stored
        $kin_first_name_err = "First name could only contains letters";
    } else {
        $kin_first_name = trim($_POST["kin_first_name"]);
        $kin_first_name_enc = bin2hex(openssl_encrypt($kin_first_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Last name
    if (empty(trim($_POST["kin_last_name"]))) {
        $kin_last_name_err = "Please enter your last name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_last_name"]))) { // Mitigate XSS Stored
        $kin_last_name_err = "Last name could only contains letters";
    } else {
        $kin_last_name = trim($_POST["kin_last_name"]);
        $kin_last_name_enc = bin2hex(openssl_encrypt($kin_last_name, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Phone Number
    if (empty(trim($_POST["kin_phone_number"]))) {
        $kin_phone_number_err = "Please enter a valid phone number.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $kin_phone_number_err = "Please enter a valid phone number.";
    } else {
        $kin_phone_number = trim($_POST["kin_phone_number"]);
        $kin_phone_number_enc = bin2hex(openssl_encrypt($kin_phone_number, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Email
    if (empty(trim($_POST["kin_email"]))) {
        $kin_email_err = "Please enter a valid email address.";
    } elseif (!filter_var($_POST["kin_email"], FILTER_VALIDATE_EMAIL)) {
        $kin_email_err = "Please enter a valid email address.";
    } else {
        $kin_email = trim($_POST["kin_email"]);
        $kin_email_enc = bin2hex(openssl_encrypt($kin_email, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Address Street
    if (empty(trim($_POST["kin_address_street"]))) {
        $kin_address_street_err = "Please enter a valid street name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_address_street"]))) { // Mitigate XSS Stored
        $kin_address_street_err = "Street could only contains letters";
    } else {
        $kin_address_street = trim($_POST["kin_address_street"]);
        $kin_address_street_enc = bin2hex(openssl_encrypt($kin_address_street, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Address City
    if (empty(trim($_POST["kin_address_city"]))) {
        $kin_address_city_err = "Please enter a valid city name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_address_city"]))) { // Mitigate XSS Stored
        $kin_address_city_err = "City could only contains letters";
    } else {
        $kin_address_city = trim($_POST["kin_address_city"]);
        $kin_address_city_enc = bin2hex(openssl_encrypt($kin_address_city, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Address State
    if (empty(trim($_POST["kin_address_state"]))) {
        $kin_address_state_err = "Please enter a valid state name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_address_state"]))) { // Mitigate XSS Stored
        $kin_address_state_err = "State could only contains letters";
    } else {
        $kin_address_state = trim($_POST["kin_address_state"]);
        $kin_address_state_enc = bin2hex(openssl_encrypt($kin_address_state, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    // Validate Kin Address Country
    if (empty(trim($_POST["kin_address_country"]))) {
        $kin_address_country_err = "Please enter a valid country name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["kin_address_country"]))) { // Mitigate XSS Stored
        $kin_address_country_err = "Country could only contains letters";
    } else {
        $kin_address_country = trim($_POST["kin_address_country"]);
        $kin_address_country_enc = bin2hex(openssl_encrypt($kin_address_country, $cipher, $key, OPENSSL_RAW_DATA, $content_user_iv));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (empty($user_first_name_err) && empty($user_last_name_err) && empty($user_student_id_err) && empty($user_form_err) && empty($user_phone_number_err) && empty($user_email_err) && empty($user_dob_err) && empty($user_profile_picture_err) && empty($user_medical_declaration_err) && empty($user_medical_conditions_err) && empty($doctor_first_name_err) && empty($doctor_last_name_err) && empty($doctor_phone_number_err) && empty($doctor_email_err) && empty($doctor_address_street_err) && empty($doctor_address_city_err) && empty($doctor_address_state_err) && empty($doctor_address_country_err) && empty($kin_first_name_err) && empty($kin_last_name_err) && empty($kin_phone_number_err) && empty($kin_email_err) && empty($kin_address_street_err) && empty($kin_address_city_err) && empty($kin_address_state_err) && empty($kin_address_country_err)) {

        $sql_user = "UPDATE users SET user_first_name='$user_first_name_enc', user_last_name='$user_last_name_enc', user_student_id='$user_student_id_enc', user_phone_number='$user_phone_number_enc', user_email='$user_email_enc', user_dob='$user_dob_enc', user_profile_picture='$user_profile_picture_enc', user_medical_declaration='$user_medical_declaration_enc', user_medical_conditions='$user_medical_conditions_enc',	doctor_first_name='$doctor_first_name_enc', doctor_last_name='$doctor_last_name_enc', doctor_address_street='$doctor_address_street_enc', doctor_address_city='$doctor_address_city_enc', doctor_address_state='$doctor_address_state_enc', doctor_address_country='$doctor_address_country_enc', doctor_phone_number='$doctor_phone_number_enc', doctor_email='$doctor_email_enc', kin_first_name='$kin_first_name_enc', kin_last_name='$kin_last_name_enc', kin_address_street='$kin_address_street_enc', kin_address_city='$kin_address_city_enc', kin_address_state='$kin_address_state_enc', kin_address_country='$kin_address_country_enc', kin_phone_number='$kin_phone_number_enc', kin_email='$kin_email_enc' WHERE id=$content_user_id";

        $sql_validation = "UPDATE users SET is_completed='1' WHERE id=$content_user_id";

        if ($db->query($sql_user) === TRUE) {
            if ($db->query($sql_validation) === TRUE) {
                // Redirect to welcome page
                header("location: welcome.php");
            }
        } else {
            echo "Error updating record: " . $db->error;
        }
    } else {
        echo 'errors...';
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
            width: 1080px;
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
        <h1 class="display-4">Profile</h1>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Another little effort!</h4>
            <p>In order for you to join a club, we need to know a bit more about you.</p>
            <hr>
            <p class="mb-0">Please fill up your profile with the following informations.</p>
        </div>

        <?php
        if (!empty($form_err)) {
            echo '<div class="alert alert-danger">' . $form_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col">
                    <h2 class="pt-3">Step 1 - Informations</h2>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="user_first_name" <?php echo 'value="' . $content_user_first_name . '"' ?> class="form-control <?php echo (!empty($user_first_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_first_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="user_last_name" <?php echo 'value="' . $content_user_last_name . '"' ?> class="form-control <?php echo (!empty($user_last_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_last_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Student ID</label>
                        <input type="text" name="user_student_id" <?php echo 'value="' . $content_user_student_id . '"' ?> class="form-control <?php echo (!empty($user_student_id_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_student_id_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="user_phone_number" <?php echo 'value="' . $content_user_phone_number . '"' ?> pattern="[0-9]{10}" class="form-control <?php echo (!empty($user_phone_number_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_phone_number_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="user_email" <?php echo 'value="' . $content_user_email . '"' ?> class="form-control <?php echo (!empty($user_email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Date of birth</label>
                        <input type="date" name="user_dob" <?php echo 'value="' . $content_user_dob . '"' ?> class="form-control <?php echo (!empty($user_dob_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $user_dob_err; ?></span>
                    </div>
                    <label>Profile picture</label>
                    <div class="custom-file mb-3">
                        <input type="file" name="user_profile_picture" class="custom-file-input <?php echo (!empty($user_profile_picture_err)) ? 'is-invalid' : ''; ?>" id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback"><?php echo $user_profile_picture_err; ?></div>
                    </div>
                    <label>Medical declaration</label>
                    <div class="custom-file mb-3">
                        <input type="file" name="user_medical_declaration" class="custom-file-input <?php echo (!empty($user_medical_declaration_err)) ? 'is-invalid' : ''; ?>" id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback"><?php echo $user_medical_declaration_err; ?></div>
                    </div>
                </div>

                <div class="col">
                    <h2 class="pt-3">Step 2 - Doctor</h2>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="doctor_first_name" <?php echo 'value="' . $content_doctor_first_name . '"' ?> class="form-control <?php echo (!empty($doctor_first_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_first_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="doctor_last_name" <?php echo 'value="' . $content_doctor_last_name . '"' ?> class="form-control <?php echo (!empty($doctor_last_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_last_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="doctor_phone_number" <?php echo 'value="' . $content_doctor_phone_number . '"' ?> pattern="[0-9]{10}" class="form-control <?php echo (!empty($doctor_phone_number_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_phone_number_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="doctor_email" <?php echo 'value="' . $content_doctor_email . '"' ?> class="form-control <?php echo (!empty($doctor_email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Street</label>
                        <input type="text" name="doctor_address_street" <?php echo 'value="' . $content_doctor_address_street . '"' ?> class="form-control <?php echo (!empty($doctor_address_street_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_address_street_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="doctor_address_city" <?php echo 'value="' . $content_doctor_address_city . '"' ?> class="form-control <?php echo (!empty($doctor_address_city_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_address_city_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="doctor_address_state" <?php echo 'value="' . $content_doctor_address_state . '"' ?> class="form-control <?php echo (!empty($doctor_address_state_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_address_state_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="doctor_address_country" <?php echo 'value="' . $content_doctor_address_country . '"' ?> class="form-control <?php echo (!empty($doctor_address_country_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $doctor_address_country_err; ?></span>
                    </div>
                </div>
                <div class="col">
                    <h2 class="pt-3">Step 3 - Kin</h2>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="kin_first_name" <?php echo 'value="' . $content_kin_first_name . '"' ?> class="form-control <?php echo (!empty($kin_first_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_first_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="kin_last_name" <?php echo 'value="' . $content_kin_last_name . '"' ?> class="form-control <?php echo (!empty($kin_last_name_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_last_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="kin_phone_number" <?php echo 'value="' . $content_kin_phone_number . '"' ?> pattern="[0-9]{10}" class="form-control <?php echo (!empty($kin_phone_number_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_phone_number_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="kin_email" <?php echo 'value="' . $content_kin_email . '"' ?> class="form-control <?php echo (!empty($kin_email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Street</label>
                        <input type="text" name="kin_address_street" <?php echo 'value="' . $content_kin_address_street . '"' ?> class="form-control <?php echo (!empty($kin_address_street_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_address_street_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="kin_address_city" <?php echo 'value="' . $content_kin_address_city . '"' ?> class="form-control <?php echo (!empty($kin_address_city_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_address_city_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="kin_address_state" <?php echo 'value="' . $content_kin_address_state . '"' ?> class="form-control <?php echo (!empty($kin_address_state_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_address_state_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="kin_address_country" <?php echo 'value="' . $content_kin_address_country . '"' ?> class="form-control <?php echo (!empty($kin_address_country_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $kin_address_country_err; ?></span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="validationTextarea">Medical conditions</label>
                <textarea name="user_medical_conditions" class="form-control <?php echo (!empty($user_medical_conditions_err)) ? 'is-invalid' : ''; ?>" id="validationTextarea" placeholder="Insert your medical conditions"><?php echo htmlspecialchars($content_user_medical_conditions); ?></textarea>
                <span class="invalid-feedback"><?php echo $user_medical_conditions_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
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