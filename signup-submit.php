<?php
/*
 * signup-submit.php
 * NerdieLuv signup form handler.
 * Receives POST data from signup.php, validates all fields using
 * regular expressions, creates a new record line, and appends it
 * to singles.txt. Displays a thank-you message on success.
 *
 * Extra Feature #1: Robust form validation with regex.
 * Extra Feature #2: User photo upload.
 */
include("common.php");

/*
 * Reads the submitted POST data and returns an associative array
 * with the new user's profile information.
 */
function get_signup_data() {
    $data = [];
    $data["name"]    = isset($_POST["name"])    ? $_POST["name"]    : "";
    $data["gender"]  = isset($_POST["gender"])  ? $_POST["gender"]  : "";
    $data["age"]     = isset($_POST["age"])     ? $_POST["age"]     : "";
    $data["type"]    = isset($_POST["type"])    ? $_POST["type"]    : "";
    $data["os"]      = isset($_POST["os"])      ? $_POST["os"]      : "";
    $data["min_age"] = isset($_POST["min_age"]) ? $_POST["min_age"] : "";
    $data["max_age"] = isset($_POST["max_age"]) ? $_POST["max_age"] : "";
    return $data;
}

/*
 * Validates all signup form fields using regular expressions.
 * Checks for blank name, valid age, valid gender, valid personality
 * type, valid OS, valid seeking ages, and duplicate users.
 * Calls show_error and exits if any check fails.
 * $data - associative array of submitted form fields
 * 6
 */
function validate_signup($data) {
    /* Name must not be blank */
    if (!preg_match('/^.+$/', $data["name"])) {
        show_error("You submitted an empty name.");
    }

    /* Gender must be M or F */
    if (!preg_match('/^[MF]$/', $data["gender"])) {
        show_error("You submitted an invalid gender.");
    }

    /* Age must be an integer between 18 and 99 */
    if (!preg_match('/^\d{1,2}$/', $data["age"])) {
        show_error("You submitted an invalid age.");
    }
    if ((int) $data["age"] < 18) {
        show_error("You must be at least 18 years old to sign up.");
    }

    /* Personality type must be 4 letters from Keirsey dimensions */
    if (!preg_match('/^[IE][NS][FT][JP]$/i', $data["type"])) {
        show_error("You submitted an invalid personality type.");
    }

    /* OS must be one of the three valid choices */
    if (!preg_match('/^(Windows|Mac OS X|Linux)$/', $data["os"])) {
        show_error("You submitted an invalid operating system.");
    }

    /* Min seeking age must be integer 0-99 */
    if (!preg_match('/^\d{1,2}$/', $data["min_age"])) {
        show_error("You submitted an invalid minimum seeking age.");
    }

    /* Max seeking age must be integer 0-99 */
    if (!preg_match('/^\d{1,2}$/', $data["max_age"])) {
        show_error("You submitted an invalid maximum seeking age.");
    }

    /* Min must be <= max */
    if ((int) $data["min_age"] > (int) $data["max_age"]) {
        show_error("Minimum seeking age cannot be greater than maximum.");
    }

    /* User must not already exist in the file */
    if (find_single($data["name"]) !== null) {
        show_error("User \"{$data['name']}\" is already in the system.");
    }
}

/*
 * Takes the user data array and appends a comma-separated line
 * to singles.txt in the required format.
 * $data - associative array of user profile fields
 */
function save_user($data) {
    $line = $data["name"] . "," .
            $data["gender"] . "," .
            $data["age"] . "," .
            strtoupper($data["type"]) . "," .
            $data["os"] . "," .
            $data["min_age"] . "," .
            $data["max_age"] . "\n";
    file_put_contents("singles.txt", $line, FILE_APPEND);
}

/*
 * Saves the uploaded photo to the images/ directory.
 * File is named as lowercase name with spaces replaced by underscores.
 * Sets full permissions so the file can be managed later.
 * $name - the user's display name
 */
function save_photo($name) {
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        $filename = strtolower(str_replace(" ", "_", $name)) . ".jpg";
        $dest = "images/" . $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $dest);
        chmod($dest, 0777);
    }
}

/* Read and validate the submitted form data */
$user = get_signup_data();

generate_header("NerdieLuv - Sign Up");
validate_signup($user);

/* Validation passed — save user data and photo */
save_user($user);
save_photo($user["name"]);
?>

        <div class="success">
            <h2>Thank you!</h2>
            <p>Welcome to NerdLuv, <?= $user["name"] ?>!</p>
            <p>Now <a href="matches.php">log in to see your matches!</a></p>
        </div>

<?php generate_footer(); ?>